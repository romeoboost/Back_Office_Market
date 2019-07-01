<?php
class StocksController extends Controller {
    
    public function liste(){
      conf::redir();
      $this->loadmodel('Stocks');
      $_SESSION['bo_menu'] = 'Stocks';  $_SESSION['bo_sub_menu'] = 'Stocks';
      $d['numero_page_encours']=1;
      //Total produits
      // $total = $this->Produits->findCountAll('categories_produits');
      $d['stocks']['total']['montant'] = $this->Stocks->findSumAll('montant','stocks');
      $d['stocks']['total']['nbre'] = $this->Stocks->findCountAll('stocks');

      $d['nombre_pages']=ceil( $d['stocks']['total']['nbre'] / 10 );
      
      //Liste des categories produits
      $d['stocks']['liste'] = $this->Stocks->findJoin( array(
            'fieldsmain' => array('montant AS montant_ht','frais_livraison AS frais_livraison','montant_ttc AS montant_total',
                  'token as stock_id', 'quantite_initiale as qtte', 'date_creation AS date_creation', 'date_modification AS date_modification'),
            'fieldstwo' => array(' nom as produit ','stock as stock_restant','id_unite as unite'),
            'fieldsthree' => array(' nom as fournisseur_nom '),
            'fields' => array(  
                            array( 'main' => 'id_produit', 'second' => 'id' ),
                            array( 'main' => 'id_fournisseur', 'third' => 'id' )
                           ),
              'order' => array('champs' => 'stocks.id','param' => 'DESC'),
              'limit' => '0,10'
            ),'stocks','produits','fournisseurs');
      
      $d['unit_mesure'] = $this->unit_mesure();
      // $d['categories'] = $this->get_category();
      // debug($d);
      $this->set($d);
    } 

    // montant&/name_product&/name_supplier

    public function extraction( $start_date, $start_hour, $end_date, $end_hour, $montant, $name_product, $name_supplier ){
      conf::redir();
      $this->loadmodel('Stocks');
      //formate les parametre envoyés afin quils soient utilisés pour la requete vers la base de données
      $filter_formated = $this->organize_filter( $start_date, $start_hour, $end_date, $end_hour, $montant, $name_product, $name_supplier );
      
      $stocks = $this->get_elements_for_extract($filter_formated);
      // debug($stocks);

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
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'ID Stock');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Montant');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Frais');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Montant TTC');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Produit');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Quantité');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Unité de Mésure');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Fournisseur');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'DATE DE CREATION');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'DATE DE DERNIERE MODIFICATION');

      $i=1;
      //remplir le corps du tableau
      $nbre_plus = count ( $stocks ) ;
      foreach ($stocks as $stock) {
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $nbre_plus-- );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $stock->stock_id );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, $stock->montant_ht );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $stock->frais_livraison );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $stock->montant_total );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $stock->produit );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, $stock->qtte );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $i, $unit_mesure[$stock->unite] );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $i, $stock->fournisseur_nom );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $i, $stock->date_creation );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $i, $stock->date_modification );

      }

      //parametre la taille des champs en automatique
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      
      //parametre le border du tableau a gras
      $styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
          ),
      );
      //$headRowString = PHPExcel_Cell::stringFromColumnIndex($headColumnNum - 1);
      $objPHPExcel->getActiveSheet()->getStyle('A1:K' . $i)->applyFromArray($styleArray);

      // Rename worksheet
      //        $objPHPExcel->getActiveSheet()->setTitle('Liste_des_moyennes_annuelles');
      $objPHPExcel->getActiveSheet()->setTitle('liste_stocks');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel2007)
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      //        header('Content-Disposition: attachment;filename="Liste_des_moyennes_annuelles.xlsx"');
      header('Content-Disposition: attachment;filename="liste_stocks'.date('YdmHis').'.xlsx"');
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
      $this->loadmodel('Stocks');
      $_SESSION['bo_menu'] = 'Stocks';  $_SESSION['bo_sub_menu'] = 'Stocks';
      $d['token'] = $token;
      if( !isset($token) || empty($token) ){
        header('Location: '.BASE_URL.DS.'stocks/liste');
      }else{
        //recupere les informations de la categorie

        $d['stock'] = current( $this->Stocks->findJoin( array(
            'fieldsmain' => array('montant AS montant_ht','frais_livraison AS frais_livraison','montant_ttc AS montant_total',
                  'token as stock_id', 'quantite_initiale as qtte', 'date_creation AS date_creation'),
            'fieldstwo' => array(' nom as produit ','stock as stock_restant','id_unite as unite','id as id_produit'),
            'fieldsthree' => array(' nom as fournisseur_nom ','id as id_fournisseur'),
            'fields' => array(  
                            array( 'main' => 'id_produit', 'second' => 'id' ),
                            array( 'main' => 'id_fournisseur', 'third' => 'id' )
                           ),
              'order' => array('champs' => 'stocks.id','param' => 'DESC'),
              'condition' => 'stocks.token = "'.$token.'"'
            ),'stocks','produits','fournisseurs') );

        if( empty($d['stock']) ){ //verifie que la categorie existe
          header('Location: '.BASE_URL.DS.'stocks/liste'); // renvoi vers liste de categorie si la categorie n'existe pas
        }

      }
      // debug($d);
      $d['unit_mesure'] = $this->unit_mesure();
      $d['fournisseurs'] = $this->get_fournisseurs();
      $d['produits'] = $this->get_products();
      $this->set($d);
    }

    public function ajouter(){
      conf::redir();
      $this->loadmodel('Stocks');
      $_SESSION['bo_menu'] = 'Stocks';  $_SESSION['bo_sub_menu'] = 'Stocks';
      $d = array();
      $d['unit_mesure'] = $this->unit_mesure();
      $d['fournisseurs'] = $this->get_fournisseurs();
      $d['produits'] = $this->get_products();
      // debug($d);
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
          $unites_from_bd = $this->Stocks->find(array(
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
          $category_from_bd = $this->Stocks->find( $requette ,'fournisseurs' );
          

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
          $category_from_bd = $this->Stocks->find( $requette ,'produits' );
          

          return $category_from_bd;
    }

    //formater les varible venue de la vue afin d'enressortir les condition (filtre) a utiliser pour la requete SQL
    private function organize_filter( $start_date, $start_hour, $end_date, $end_hour, $montant, $name_product, $name_supplier ){      
      $list_function_params = func_get_args(); //recupere la liste de tous les paramètres envoyés dans la fonction
      foreach ( $list_function_params as $function_param ) {
        $spliter = explode( '&', $function_param);
        ${$spliter[0]} = isset( $spliter[1] ) ?  $spliter[1] : '';
      }  

      //rajoute les conditions pour la periode
      $conditions_prepare[':debut'] = $start_date.' '.$start_hour;
      $conditions_prepare[':fin'] = $end_date.' '.$end_hour;

      //
      $condition_sql_liste = " stocks.date_creation BETWEEN :debut AND :fin ";

     //rajoute condition pour le nom du produit
      $montant = intval($montant);
      if( !empty( $montant ) ){
          $condition_sql_liste .= " AND stocks.montant like :montant ";
          $conditions_prepare[':montant'] = $montant ;
      }

      $name_product = trim($name_product);
      if( !empty( $name_product ) ){
          $condition_sql_liste .= " AND lower(produits.nom) like :name_product ";
          $conditions_prepare[':name_product'] = '%'.strtolower( $name_product ).'%';
      }

      $name_supplier = trim($name_supplier);
      if( !empty( $name_supplier ) ){
          $condition_sql_liste .= " AND lower(fournisseurs.nom) like :name_supplier ";
          $conditions_prepare[':name_supplier'] = '%'.strtolower( $name_supplier ).'%';
      }

      return array('condition_sql_liste' => $condition_sql_liste, 'conditions_prepare' => $conditions_prepare );

    }

    private function get_elements_for_extract($filter){
      $stocks = $this->Stocks->findJoin( array(
            'fieldsmain' => array('montant AS montant_ht','frais_livraison AS frais_livraison','montant_ttc AS montant_total',
                  'token as stock_id', 'quantite_initiale as qtte', 'date_creation AS date_creation', 'date_modification AS date_modification'),
            'fieldstwo' => array(' nom as produit ','stock as stock_restant','id_unite as unite'),
            'fieldsthree' => array(' nom as fournisseur_nom '),
            'fields' => array(  
                            array( 'main' => 'id_produit', 'second' => 'id' ),
                            array( 'main' => 'id_fournisseur', 'third' => 'id' )
                           ),
              'condition' => $filter['condition_sql_liste'],
              'array_filter' => $filter['conditions_prepare'],
              'order' => array('champs' => 'stocks.id','param' => 'DESC')
            ),'stocks','produits','fournisseurs');

      return $stocks;
    }



}
