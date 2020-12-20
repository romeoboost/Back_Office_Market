<?php
class MagasinsController extends Controller {
    
    public function liste_test(){
      conf::redir();
      $this->loadmodel('Magasins');
      $_SESSION['bo_menu'] = 'Magasins';  $_SESSION['bo_sub_menu'] = 'Magasins';
      $d['numero_page_encours']=1;
      //Total produits
      // $total = $this->Produits->findCountAll('categories_produits');
      $d['fournisseurs']['total']['nbre'] = $this->Fournisseurs->findCountAll('fournisseurs');

      $d['nombre_pages']=ceil( $d['fournisseurs']['total']['nbre'] / 10 );
      
      //Liste des categories produits
      $d['fournisseurs']['liste'] = $this->Fournisseurs->find(array(
            'order' => array('champs' => 'id','param' => 'DESC'), //
            'limit' => '0,10'
            ),'fournisseurs');

      // debug($d);
      $this->set($d);
    } 



    // start_date&2018-01-01/start_hour&00:00:00/end_date&2019-07-01/end_hour&23:59:59/name_supplier&/tel&57525654"

    public function extraction( $start_date, $start_hour, $end_date, $end_hour, $name_supplier, $tel ){
      conf::redir();
      $this->loadmodel('Fournisseurs');
      //formate les parametre envoyés afin quils soient utilisés pour la requete vers la base de données
      $filter_formated = $this->organize_filter( $start_date, $start_hour, $end_date, $end_hour, $name_supplier, $tel );
      
      $fournisseurs = $this->get_elements_for_extract($filter_formated);
      // debug($fournisseurs);

      //
      $unit_mesure = $this->unit_mesure();

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
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'ID Fournisseur');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Nom');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Téléphone');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Email');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'DATE DE CREATION');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'DATE DE DERNIERE MODIFICATION');

      $i=1;
      //remplir le corps du tableau
      $nbre_plus = count ( $fournisseurs );
      foreach ($fournisseurs as $fournisseur) {
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $nbre_plus-- );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $fournisseur->token );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, ucfirst( $fournisseur->nom ) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, "'".$fournisseur->tel );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $fournisseur->email );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $fournisseur->date_creation );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, $fournisseur->date_modification );

      }

      //parametre la taille des champs en automatique
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      
      //parametre le border du tableau a gras
      $styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
          ),
      );
      //$headRowString = PHPExcel_Cell::stringFromColumnIndex($headColumnNum - 1);
      $objPHPExcel->getActiveSheet()->getStyle('A1:G' . $i)->applyFromArray($styleArray);

      // Rename worksheet
      //        $objPHPExcel->getActiveSheet()->setTitle('Liste_des_moyennes_annuelles');
      $objPHPExcel->getActiveSheet()->setTitle('liste_fournisseurs');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel2007)
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      //        header('Content-Disposition: attachment;filename="Liste_des_moyennes_annuelles.xlsx"');
      header('Content-Disposition: attachment;filename="liste_fournisseurs'.date('YdmHis').'.xlsx"');
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
      $this->loadmodel('Fournisseurs');
      $_SESSION['bo_menu'] = 'Fournisseurs';  $_SESSION['bo_sub_menu'] = 'Fournisseurs';
      $d['token'] = $token;
      if( !isset($token) || empty($token) ){
        header('Location: '.BASE_URL.DS.'fournisseurs/liste');
      }else{
        //recupere les informations de la categorie

        $d['fournisseur'] = current( $this->Fournisseurs->find( array( 'condition' => 'token = "'.$token.'"' ),'fournisseurs') );

        if( empty($d['fournisseur']) ){ //verifie que la categorie existe
          header('Location: '.BASE_URL.DS.'fournisseurs/liste'); // renvoi vers liste de categorie si la categorie n'existe pas
        }

      }
      // debug($d);
      $this->set($d);
    }

    public function ajouter(){
      conf::redir();
      $this->loadmodel('Fournisseurs');
      $_SESSION['bo_menu'] = 'Fournisseurs';  $_SESSION['bo_sub_menu'] = 'Fournisseurs';
      $d = array();
      // debug($d);
      $this->set($d);
    }

    public function details($token){
      conf::redir();
      $this->loadmodel('Fournisseurs');
      $_SESSION['bo_menu'] = 'Fournisseurs';  $_SESSION['bo_sub_menu'] = 'Fournisseurs';
      $d['token'] = $token;

      if( !isset($token) || empty($token) ){
        header('Location: '.BASE_URL.DS.'fournisseurs/liste');
      }else{
        //recupere les informations du fournisseur
        $d['fournisseur'] = current( $this->Fournisseurs->find( array( 'condition' => 'token = "'.$token.'"' ),'fournisseurs') );

        if( empty($d['fournisseur']) ){ //verifie que le fournisseur existe
          header('Location: '.BASE_URL.DS.'fournisseurs/liste'); // renvoi vers liste de categorie si la categorie n'existe pas
        }

        $d['stocks']['liste'] = $this->Fournisseurs->findJoin( array(
            'fieldsmain' => array('montant AS montant_ht','frais_livraison AS frais_livraison','montant_ttc AS montant_total',
                  'token as stock_id', 'quantite_initiale as qtte', 'date_creation AS date_creation', 'date_modification AS date_modification'),
            'fieldstwo' => array(' nom as produit ','stock as stock_restant','id_unite as unite','id as id_produit'),
            'fieldsthree' => array(' nom as fournisseur_nom ','id as id_fournisseur'),
            'fields' => array(  
                            array( 'main' => 'id_produit', 'second' => 'id' ),
                            array( 'main' => 'id_fournisseur', 'third' => 'id' )
                           ),
              'order' => array('champs' => 'stocks.id','param' => 'DESC'),
              'condition' => 'fournisseurs.token = "'.$token.'"'
            ),'stocks','produits','fournisseurs');

        $d['unit_mesure'] = $this->unit_mesure();
        
      }

      // debug($d);
      $this->set($d);
    }


    private function unit_mesure($condition=null){
      //recuperer les unité de mésure
          $unites_from_bd = $this->Fournisseurs->find(array(
              'fields' => array('id','libelle','symbole')
            ),'unites');
          $unites = array();
          foreach ($unites_from_bd as $u) {
            $unites[$u->id] = ($u->symbole == 'NA') ? 'nombre' : $u->symbole;
          }

          return $unites;
    }

    private function get_fournisseurs($condition=null){
      //recuperer les unité de mésure
          $requette['fields'] = array('id','nom');
          if(isset($condition)){
            $requette['condition'] = $condition;
          }
          // debug($requette);          
          // debug( $this->Produits->find( $requette ,'categories_produits' ) );          
          $category_from_bd = $this->Fournisseurs->find( $requette ,'fournisseurs' );
          

          return $category_from_bd;
    }

    private function get_products($condition=null){
      //recuperer les unité de mésure
          $requette['fields'] = array('id','nom','id_unite as unite');
          if(isset($condition)){
            $requette['condition'] = $condition;
          }
          // debug($requette);          
          // debug( $this->Produits->find( $requette ,'categories_produits' ) );          
          $category_from_bd = $this->Fournisseurs->find( $requette ,'produits' );
          

          return $category_from_bd;
    }

    //formater les varible venue de la vue afin d'enressortir les condition (filtre) a utiliser pour la requete SQL
    private function organize_filter( $start_date, $start_hour, $end_date, $end_hour, $name_supplier, $tel ){      
      $list_function_params = func_get_args(); //recupere la liste de tous les paramètres envoyés dans la fonction
      foreach ( $list_function_params as $function_param ) {
        $spliter = explode( '&', $function_param);
        ${$spliter[0]} = isset( $spliter[1] ) ?  $spliter[1] : '';
      }  

      //rajoute les conditions pour la periode
      $conditions_prepare[':debut'] = $start_date.' '.$start_hour;
      $conditions_prepare[':fin'] = $end_date.' '.$end_hour;

      //
      $condition_sql_liste = " fournisseurs.date_creation BETWEEN :debut AND :fin ";

     //rajoute condition pour le nom du produit
      $name_supplier = trim($name_supplier);
      if( !empty( $name_supplier ) ){
          $condition_sql_liste .= " AND nom like :nom "; //LOWER(`Value`)
          $conditions_prepare[':nom'] = '%'.strtolower( $name_supplier ).'%';
      }

      //rajoute condition pour categorie produits
      if( strlen($tel) != 0 ){
          $condition_sql_liste .= " AND fournisseurs.tel like :tel ";
          $conditions_prepare[':tel'] = '%'.trim( $tel ).'%';
      }

      return array('condition_sql_liste' => $condition_sql_liste, 'conditions_prepare' => $conditions_prepare );

    }

    private function get_elements_for_extract($filter){
      $fournisseurs = $this->Fournisseurs->find( array(
              'condition' => $filter['condition_sql_liste'],
              'array_filter' => $filter['conditions_prepare'],
              'order' => array('champs' => 'fournisseurs.id','param' => 'DESC')
            ),'fournisseurs');

      return $fournisseurs;
    }



}
