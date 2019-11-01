<?php
class PubsController extends Controller {
    
    public function liste(){
      conf::redir();
      $this->loadmodel('Pubs');
      $_SESSION['bo_menu'] = 'Pubs';  $_SESSION['bo_sub_menu'] = 'Pubs';
      $d['numero_page_encours']=1;
      //Total produits
      $d['elements']['total'] = $this->Pubs->findCountAll('publicites');

      ///total  non actives
      $d['elements']['non_actifs'] = $this->Pubs->findCount( array( 'statut' => 0 ),'publicites' );

      //total publicites actives
      $d['elements']['actifs'] = $this->Pubs->findCount( array( 'statut' => 1 ),'publicites' ); 

      $d['nombre_pages']=ceil( $d['elements']['total'] / 10 );
      
      //Liste des publicites produits
      $d['elements']['liste'] = $this->Pubs->find(array(
            'order' => array('champs' => 'id','param' => 'DESC'), //
            'limit' => '0,10'
            ),'publicites');
      
      // debug($d);
      $this->set($d);
    } 

    private function getNeverOrderPlace(){
      $req = [
          'fieldsmain' => ['id as idDest'],
          'fieldstwo' => ['id_livraison_destination'],
          'count' => [  'champs' => 'commandes.id_livraison_destination',  'alias' => 'nbre'  ]
          ,'fields' => array(  array(  'main' => 'id',  'second' => 'id_livraison_destination'  )  )
          ,'group' => 'id_livraison_destination'
          ,'condition' => "id_livraison_destination is null"
          ];    
      $nbre = count( $this->Pubs->findLeftJoin( $req,'publicites','commandes') );
      unset($req['condition']);

      $listeSql = $this->Pubs->findLeftJoin( $req,'publicites','commandes');
      $listeArray = array();
      foreach ($listeSql as $c) {
        $listeArray[$c->idDest] = $c->nbre;
      }

      return [ 'nbre' => $nbre, 'liste' => $listeArray];

    }


    public function extraction( $start_date, $start_hour, $end_date, $end_hour, $name_cotegory, $status_cotegory ){
      conf::redir();
      $this->loadmodel('Pubs');
      //formate les parametre envoyés afin quils soient utilisés pour la requete vers la base de données
      $filter_formated = $this->organize_filter( $start_date, $start_hour, $end_date, $end_hour, $name_cotegory, $status_cotegory );
      
      $publicites = $this->get_publicites($filter_formated);
      // debug($publicites);

      //charge les fichier de librairie de generation de fichier excell
      require_once(WEBROOT . '/phpExcell/Classes/PHPExcel.php');
      require_once(WEBROOT . '/phpExcell/Classes/PHPExcel/IOFactory.php');
      $objPHPExcel = new PHPExcel();
      $objPHPExcel->getProperties()->setCreator("By ".APPLI_NAME)
                ->setLastModifiedBy("By ".APPLI_NAME)
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");   
      //config entete tableau
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '#');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'NOM PRODUIT');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'TOKEN');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'STATUT ');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'DATE CREATION');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'DATE DERNIERE MODIFICATION');

      $i=1;
      //remplir le corps du tableau
      $nbre_cmd_plus = count ( $publicites );
      foreach ($publicites as $publicite) {
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $nbre_cmd_plus-- );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, ucfirst( $publicite->nom ) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, ucfirst( $publicite->token ) );
        $status = ($publicite->statut == 1) ? 'ACTIF' : 'NON ACTIF';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $status );
        // $page_accueil = ($produit->page_accueil == 1) ? 'OUI' : 'NON';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $publicite->date_creation );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $publicite->date_modification );

      }

      //parametre la taille des champs en automatique
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      
      //parametre le border du tableau a gras
      $styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
          ),
      );
      //$headRowString = PHPExcel_Cell::stringFromColumnIndex($headColumnNum - 1);
      $objPHPExcel->getActiveSheet()->getStyle('A1:F' . $i)->applyFromArray($styleArray);

      // Rename worksheet
      //        $objPHPExcel->getActiveSheet()->setTitle('Liste_des_moyennes_annuelles');
      $objPHPExcel->getActiveSheet()->setTitle('liste_publicites_produits');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel2007)
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      //        header('Content-Disposition: attachment;filename="Liste_des_moyennes_annuelles.xlsx"');
      header('Content-Disposition: attachment;filename="liste_publicites_produits_'.date('YdmHis').'.xlsx"');
      header('Cache-Control: max-age=0');
      // If you're serving to IE 9, then the following may be needed
      header('Cache-Control: max-age=1');
      // If you're serving to IE over SSL, then the following may be needed
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
      header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
      header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
      header('Pragma: public'); // HTTP/1.0
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      ob_end_clean();
      $objWriter->save('php://output');
      exit;


    }


    public function modifier( $token ){
      conf::redir();
      $this->loadmodel('Pubs');
      $_SESSION['bo_menu'] = 'Pubs';  $_SESSION['bo_sub_menu'] = 'Pubs';
      $d['token'] = $token;
      if( !isset($token) || empty($token) ){
        header('Location: '.BASE_URL.DS.'pubs/liste');
      }else{
        //recupere les informations de la publicite
        $d['element'] = current( $this->Pubs->find(array(
              'condition' => 'token = "'.$token.'"', //
              'limit' => '0,1'
            ),'publicites') );

        if( empty($d['element']) ){ //verifie que la pub existe
          header('Location: '.BASE_URL.DS.'pubs/liste'); // renvoi vers liste de publicite si la publicite n'existe pas
        }

      }

      $this->set($d);
    }

    public function ajouter(){
      conf::redir();
      $this->loadmodel('Pubs');
      $_SESSION['bo_menu'] = 'Pubs';  $_SESSION['bo_sub_menu'] = 'Categories';
      $d = array();
      $d['icons'] = ['chicken','fish','fruit','oil','potatoes','rice','seed-bag','vegetable'];
      // $d['publicites'] = $this->get_category();
      // debug($_SESSION['bo_sub_menu']);
      $this->set($d);
    }

    public function details($token){
      conf::redir();
      $this->loadmodel('Pubs');
      $_SESSION['bo_menu'] = 'Pubs';  $_SESSION['bo_sub_menu'] = 'Categories';
      $d['token'] = $token;

      if( !isset($token) || empty($token) ){
        header('Location: '.BASE_URL.DS.'publicites/liste');
      }else{
        //recupere les informations de al publicites
        $d['publicite'] = current( $this->Pubs->find(array(
              'order' => array('champs' => 'nom','param' => 'ASC'),
              'condition' => 'token = "'.$token.'"', //
              'limit' => '0,1'
            ),'publicites_produits') );

        $d['produits'] = $this->Pubs->findJoin(array(
           'fieldsmain' => array('id AS id','nom AS nom_produit','token AS token','quantite_unitaire as qtite_unit',
            'id_unite as unite','prix_quantite_unitaire as prix_qtite_unit','slug as slug','nouveau as isnew','promo as ispromo',
            'pourcentage_promo as percent_promo','image as image','statut AS produit_statut','stock AS stock','date_creation as date_creation'),
            'fieldstwo' => array('nom AS publicite','statut AS publicite_statut'),
            'fields' => array(
                          array(
                            'main' => 'id_publicite_produit',
                            'second' => 'id'
                            )
              ),
              'order' => array('champs' => 'prix_quantite_unitaire','param' => 'ASC'),
              'condition' => 'publicites_produits.token = "'.$token.'"'
            ),'produits','publicites_produits');

        $d['unit_mesure'] = $this->unit_mesure();
        
      }

      // debug($d);
      $this->set($d);
    }


    private function unit_mesure($condition=null){
      //recuperer les unité de mésure
          $unites_from_bd = $this->Pubs->find(array(
              'fields' => array('id','libelle','symbole')
            ),'unites');
          $unites = array();
          foreach ($unites_from_bd as $u) {
            $unites[$u->id] = ($u->symbole == 'NA') ? 'nombre' : $u->symbole;
          }

          return $unites;
    }

    private function get_category($condition=null){
      //recuperer les unité de mésure
          $requette['fields'] = array('id','nom','statut');
          if(isset($condition)){
            $requette['condition'] = $condition;
          }
          // debug($requette);          
          // debug( $this->Pubs->find( $requette ,'publicites_produits' ) );          
          $category_from_bd = $this->Pubs->find( $requette ,'publicites_produits' );
          

          return $category_from_bd;
    }

    //formater les varible venue de la vue afin d'enressortir les condition (filtre) a utiliser pour la requete SQL
    private function organize_filter( $start_date, $start_hour, $end_date, $end_hour, $name_cotegory, $status_cotegory ){      
      $list_function_params = func_get_args(); //recupere la liste de tous les paramètres envoyés dans la fonction
      foreach ( $list_function_params as $function_param ) {
        $spliter = explode( '&', $function_param);
        ${$spliter[0]} = isset( $spliter[1] ) ?  $spliter[1] : '';
      }  

      //rajoute les conditions pour la periode
      $conditions_prepare[':debut'] = $start_date.' '.$start_hour;
      $conditions_prepare[':fin'] = $end_date.' '.$end_hour;

      //
      $condition_sql_liste = " date_creation BETWEEN :debut AND :fin ";

     //rajoute condition pour le nom du produit
      $name_cotegory = trim($name_cotegory);
      if( !empty( $name_cotegory ) ){
          $condition_sql_liste .= " AND nom like :nom ";
          $conditions_prepare[':nom'] = '%'.strtolower( $name_cotegory ).'%';
      }

      //rajoute condition pour publicite produits
      if( strlen($status_cotegory) != 0 ){
          $condition_sql_liste .= " AND statut =:statut ";
          $conditions_prepare[':statut'] = intval($status_cotegory);
      }

      return array('condition_sql_liste' => $condition_sql_liste, 'conditions_prepare' => $conditions_prepare );

    }

    private function get_publicites($filter){
      $publicites = $this->Pubs->find(array(
            'condition' => $filter['condition_sql_liste'],
            'array_filter' => $filter['conditions_prepare'],
            'order' => array('champs' => 'nom','param' => 'ASC')
            ),'publicites_produits');

      return $publicites;
    }



}
