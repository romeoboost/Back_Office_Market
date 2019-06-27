<?php
class CategoriesController extends Controller {
    
    public function liste(){
      conf::redir();
      $this->loadmodel('Produits');
      $_SESSION['bo_menu'] = 'Produits';  $_SESSION['bo_sub_menu'] = 'Categories';
      $d['numero_page_encours']=1;
      //Total produits
      $total = $this->Produits->findCountAll('categories_produits');

      ///total categories non actives
      $categorie_non_actifs = $this->Produits->findCount( array( 'statut' => 0 ),'categories_produits' );

      //total categories actives
      $categorie_actifs = $this->Produits->findCount( array( 'statut' => 1 ),'categories_produits' );     

      $d['categorie_stat']['categorie_non_actifs'] = $categorie_non_actifs;
      $d['categorie_stat']['categorie_actifs'] = $categorie_actifs;
      $d['categorie_stat']['total'] = $total;

      $d['nombre_pages']=ceil( $total / 10 );
      
      //Liste des categories produits
      $d['categories'] = $this->Produits->find(array(
            'order' => array('champs' => 'nom','param' => 'ASC'), //
            'limit' => '0,10'
            ),'categories_produits');
      
      $d['unit_mesure'] = $this->unit_mesure();
      // $d['categories'] = $this->get_category();
      // debug($d);
      $this->set($d);
    } 


    public function extraction( $start_date, $start_hour, $end_date, $end_hour, $name_cotegory, $status_cotegory ){
      conf::redir();
      $this->loadmodel('Produits');
      //formate les parametre envoyés afin quils soient utilisés pour la requete vers la base de données
      $filter_formated = $this->organize_filter( $start_date, $start_hour, $end_date, $end_hour, $name_cotegory, $status_cotegory );
      
      $categories = $this->get_categories($filter_formated);
      // debug($categories);

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
      $nbre_cmd_plus = count ( $categories );
      foreach ($categories as $categorie) {
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $nbre_cmd_plus-- );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, ucfirst( $categorie->nom ) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, ucfirst( $categorie->token ) );
        $status = ($categorie->statut == 1) ? 'ACTIF' : 'NON ACTIF';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $status );
        // $page_accueil = ($produit->page_accueil == 1) ? 'OUI' : 'NON';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $categorie->date_creation );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $categorie->date_modification );

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
      $objPHPExcel->getActiveSheet()->setTitle('liste_categories_produits');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel2007)
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      //        header('Content-Disposition: attachment;filename="Liste_des_moyennes_annuelles.xlsx"');
      header('Content-Disposition: attachment;filename="liste_categories_produits_'.date('YdmHis').'.xlsx"');
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
      $this->loadmodel('Produits');
      $_SESSION['bo_menu'] = 'Produits';  $_SESSION['bo_sub_menu'] = 'Categories';
      $d['token'] = $token;
      if( !isset($token) || empty($token) ){
        header('Location: '.BASE_URL.DS.'categories/liste');
      }else{
        //recupere les informations de la categorie
        $d['categorie'] = current( $this->Produits->find(array(
              'order' => array('champs' => 'nom','param' => 'ASC'),
              'condition' => 'token = "'.$token.'"', //
              'limit' => '0,1'
            ),'categories_produits') );

        if( empty($d['categorie']) ){ //verifie que la categorie existe
          header('Location: '.BASE_URL.DS.'categories/liste'); // renvoi vers liste de categorie si la categorie n'existe pas
        }

      }

      // debug($d);
      $d['icons'] = ['chicken','fish','fruit','oil','potatoes','rice','seed-bag','vegetable'];
      $this->set($d);
    }

    public function ajouter(){
      conf::redir();
      $this->loadmodel('Produits');
      $_SESSION['bo_menu'] = 'Produits';  $_SESSION['bo_sub_menu'] = 'Categories';
      $d = array();
      $d['icons'] = ['chicken','fish','fruit','oil','potatoes','rice','seed-bag','vegetable'];
      // $d['categories'] = $this->get_category();
      // debug($_SESSION['bo_sub_menu']);
      $this->set($d);
    }

    public function details($token){
      conf::redir();
      $this->loadmodel('Produits');
      $_SESSION['bo_menu'] = 'Produits';  $_SESSION['bo_sub_menu'] = 'Categories';
      $d['token'] = $token;

      if( !isset($token) || empty($token) ){
        header('Location: '.BASE_URL.DS.'categories/liste');
      }else{
        //recupere les informations de al categories
        $d['categorie'] = current( $this->Produits->find(array(
              'order' => array('champs' => 'nom','param' => 'ASC'),
              'condition' => 'token = "'.$token.'"', //
              'limit' => '0,1'
            ),'categories_produits') );

        $d['produits'] = $this->Produits->findJoin(array(
           'fieldsmain' => array('id AS id','nom AS nom_produit','token AS token','quantite_unitaire as qtite_unit',
            'id_unite as unite','prix_quantite_unitaire as prix_qtite_unit','slug as slug','nouveau as isnew','promo as ispromo',
            'pourcentage_promo as percent_promo','image as image','statut AS produit_statut','stock AS stock','date_creation as date_creation'),
            'fieldstwo' => array('nom AS categorie','statut AS categorie_statut'),
            'fields' => array(
                          array(
                            'main' => 'id_categorie_produit',
                            'second' => 'id'
                            )
              ),
              'order' => array('champs' => 'prix_quantite_unitaire','param' => 'ASC'),
              'condition' => 'categories_produits.token = "'.$token.'"'
            ),'produits','categories_produits');

        $d['unit_mesure'] = $this->unit_mesure();
        
      }

      // debug($d);
      $this->set($d);
    }


    private function unit_mesure($condition=null){
      //recuperer les unité de mésure
          $unites_from_bd = $this->Produits->find(array(
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
          // debug( $this->Produits->find( $requette ,'categories_produits' ) );          
          $category_from_bd = $this->Produits->find( $requette ,'categories_produits' );
          

          return $category_from_bd;
    }

    //formater les varible venue de la vue afin d'enressortir les condition (filtre) a utiliser pour la requete SQL
    private function organize_filter( $start_date, $start_hour, $end_date, $end_hour, $name_cotegory, $status_cotegory ){      
      $list_function_params = func_get_args(); //recupere la liste de tous les paramètres envoyés dans la fonction
      foreach ( $list_function_params as $function_param ) {
        $spliter = explode( '&', $function_param);
        $$spliter[0] = isset( $spliter[1] ) ?  $spliter[1] : '';
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

      //rajoute condition pour categorie produits
      if( strlen($status_cotegory) != 0 ){
          $condition_sql_liste .= " AND statut =:statut ";
          $conditions_prepare[':statut'] = intval($status_cotegory);
      }

      return array('condition_sql_liste' => $condition_sql_liste, 'conditions_prepare' => $conditions_prepare );

    }

    private function get_categories($filter){
      $categories = $this->Produits->find(array(
            'condition' => $filter['condition_sql_liste'],
            'array_filter' => $filter['conditions_prepare'],
            'order' => array('champs' => 'nom','param' => 'ASC')
            ),'categories_produits');

      return $categories;
    }



}
