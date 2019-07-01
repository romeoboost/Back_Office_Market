<?php
class ProduitsController extends Controller {
    
    public function liste(){
      conf::redir();
      $this->loadmodel('Produits');
      $_SESSION['bo_menu'] = 'Produits';
      $_SESSION['bo_sub_menu'] = 'Produits';
      $d['numero_page_encours']=1;
      //Total produits
      $total = $this->Produits->findCountAll('produits');

      //Total stocke epuisé
       $produits_stock_off = $this->Produits->findCount( array( 'stock' => 0 ),'produits' );     

      //Total non commandé
      $produits_non_cmd = $this->Produits->findLeftJoin(array(
        'fieldsmain' => array('id AS id_p','nom AS nom_produit','token AS token_produit','quantite_unitaire as qtite_unit', 'id_unite as unite',
            'prix_quantite_unitaire as prix_qtite_unit','slug as slug','nouveau as isnew','promo as ispromo','pourcentage_promo as percent_promo',
            'image as image'),
        'fieldstwo' => array('id_produit'),
        'fields' => array(array('main' => 'id','second' => 'id_produit')),
        'condition' => 'commandes_produits.id_produit IS NULL',
        'order' => array('champs' => 'produits.id' , 'param' => 'desc')
      ),'produits','commandes_produits');

      //total non actifs
      $produits_non_actif = $this->Produits->findCount( array( 'statut' => 0 ),'produits' );

      $d['produits_stat']['produits_non_cmd'] = count($produits_non_cmd);
      $d['produits_stat']['produits_non_actif'] = $produits_non_actif;
      $d['produits_stat']['produits_stock_off'] = $produits_stock_off;
      $d['produits_stat']['total'] = $total;

      $d['nombre_pages']=ceil($total / 10);
      // $d['nombre_pages']=1;
      // $d['numero_page_encours']=1;
      
      //Liste des produits
      $d['produits'] = $this->Produits->findJoin(array(
           'fieldsmain' => array('id AS id','nom AS nom_produit','token AS token_produit','quantite_unitaire as qtite_unit',
            'id_unite as unite','prix_quantite_unitaire as prix_qtite_unit','slug as slug','nouveau as isnew','promo as ispromo',
            'pourcentage_promo as percent_promo','image as image','statut AS produit_statut','stock AS stock','date_creation as date_creation'),
            'fieldstwo' => array('nom AS categorie','statut AS categorie_statut'),
            'fieldsthree' => array('nom AS taille'),
            'fields' => array(
                          array(
                            'main' => 'id_categorie_produit',
                            'second' => 'id'
                            )
              ),
              'order' => array('champs' => 'prix_quantite_unitaire','param' => 'ASC'), //
              'limit' => '0,10'
            ),'produits','categories_produits');
      
      $d['unit_mesure'] = $this->unit_mesure();
      $d['categories'] = $this->get_category();
      // debug($d);
      $this->set($d);
    } 
// start_date&2018-11-01/start_hour&00:00:00/end_date&2019-06-21/end_hour&23:59:59/name_product&/category_product&/
// stock_product&/unit_mesure&/status_product&/promo_product&/amount_product&

    public function extraction($start_date, $start_hour, $end_date, $end_hour, $name_product, $category_product, $stock_product,
      $unit_mesure, $status_product, $promo_product, $amount_product ){
      conf::redir();
      $this->loadmodel('Produits');

      $filter_formated = $this->organize_filter($start_date, $start_hour, $end_date, $end_hour, $name_product, $category_product, $stock_product,
                                $unit_mesure, $status_product, $promo_product, $amount_product);

      $produits = $this->get_products($filter_formated);

      $unit_mesure = $this->unit_mesure();

      // debug($produits);

      //chage les fichier de librairie de generation de fichier excell
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
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'CATEGORIE');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'STATUT ');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'PAGE D\'ACCUEIL');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'STOCK RESTANT');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'QUANTITE UNITAIRE VENDUE');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'UNITE MESURE');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'PRIX QUANTITE UNITAIRE');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'PROMOTION');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'POURCENTAGE PROMOTION');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'DATE DE CREATION');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'DATE DE DERNIERE MODIFICATION');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'DESCRIPTION');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'TOKEN');

      $i=1;
      //remplir le corps du tableau
      $nbre_cmd_plus = count ( $produits );
      foreach ($produits as $produit) {
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $nbre_cmd_plus-- );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, ucfirst( $produit->nom_produit ) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, ucfirst( $produit->categorie ) );
        $status = ($produit->produit_statut == 1) ? 'ACTIF' : 'NON ACTIF';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $status );
        $page_accueil = ($produit->page_accueil == 1) ? 'OUI' : 'NON';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $page_accueil );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $produit->stock );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, $produit->qtite_unit );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $i, ucfirst( $unit_mesure[$produit->unite] ) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $i, $produit->prix_qtite_unit );
        $promo = ($produit->ispromo == 1) ? 'OUI' : 'NON';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $i, $promo );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $i, $produit->percent_promo );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $i, dateFormat($produit->date_creation) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $i, dateFormat($produit->date_modification) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $i, $produit->description );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $i, $produit->token_produit );

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
      $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
      
      //parametre le border du tableau a gras
      $styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
          ),
      );
      //$headRowString = PHPExcel_Cell::stringFromColumnIndex($headColumnNum - 1);
      $objPHPExcel->getActiveSheet()->getStyle('A1:O' . $i)->applyFromArray($styleArray);

      // Rename worksheet
      //        $objPHPExcel->getActiveSheet()->setTitle('Liste_des_moyennes_annuelles');
      $objPHPExcel->getActiveSheet()->setTitle('Liste_produits');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel2007)
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      //        header('Content-Disposition: attachment;filename="Liste_des_moyennes_annuelles.xlsx"');
      header('Content-Disposition: attachment;filename="liste_produits_'.date('YdmHis').'.xlsx"');
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


    public function modifier( $token_produit ){
      conf::redir();
      $this->loadmodel('Produits');
      $_SESSION['bo_menu'] = 'Produits';
      $_SESSION['bo_sub_menu'] = 'Produits';
      $d['token_produit'] = $token_produit;
      if( !isset($token_produit) || empty($token_produit) ){
        header('Location: '.BASE_URL.DS.'produits/liste');
      }else{
        //recupere les informations du produit
        $d['produit'] = current( $this->Produits->findJoin(array(
           'fieldsmain' => array('id AS id','nom AS nom_produit','token AS token_produit','quantite_unitaire as qtite_unit',
            'id_unite as unite','prix_quantite_unitaire as prix_qtite_unit','slug as slug','nouveau as isnew','promo as ispromo',
            'pourcentage_promo as percent_promo','image as image','statut AS produit_statut','stock AS stock','date_creation as date_creation',
            'page_accueil as page_accueil','description as description'),
            'fieldstwo' => array(' id as id_categorie ','nom AS categorie','statut AS categorie_statut'),
            // 'fieldsthree' => array('nom AS taille'),
            'fields' => array(
                          array(
                            'main' => 'id_categorie_produit',
                            'second' => 'id'
                            )
              ),
              'order' => array('champs' => 'prix_quantite_unitaire','param' => 'ASC'),
              'condition' => 'produits.token = "'.$token_produit.'"', //
              'limit' => '0,1'
            ),'produits','categories_produits') );
        if( empty($d['produit']) ){
          header('Location: '.BASE_URL.DS.'produits/liste');
        }else{

          $d['unit_mesure'] = $this->unit_mesure();
          $d['categories'] = $this->get_category();

        }

      }

      // debug($d);
      $this->set($d);
    }

    public function ajouter(){
      conf::redir();
      $this->loadmodel('Produits');
      $_SESSION['bo_menu'] = 'Produits';
      $_SESSION['bo_sub_menu'] = 'Produits';
      $d['unit_mesure'] = $this->unit_mesure();
      $d['categories'] = $this->get_category();
      // debug($d);
      $this->set($d);
    }

    public function details($token_produit){
      conf::redir();
      $this->loadmodel('Produits');
      $_SESSION['bo_menu'] = 'Produits';
      $_SESSION['bo_sub_menu'] = 'Produits';
      $d['token_produit'] = $token_produit;

      if( !isset($token_produit) || empty($token_produit) ){
        header('Location: '.BASE_URL.DS.'produits/liste');
      }else{
        //recupere les informations du produit
        $d['produit'] = current( $this->Produits->findJoin(array(
           'fieldsmain' => array('id AS id','nom AS nom_produit','token AS token_produit','quantite_unitaire as qtite_unit',
            'id_unite as unite','prix_quantite_unitaire as prix_qtite_unit','slug as slug','nouveau as isnew','promo as ispromo',
            'pourcentage_promo as percent_promo','image as image','statut AS produit_statut','stock AS stock','date_creation as date_creation',
            'date_modification as date_modification',
            'page_accueil as page_accueil','description as description'),
            'fieldstwo' => array(' id as id_categorie ','nom AS categorie','statut AS categorie_statut'),
            // 'fieldsthree' => array('nom AS taille'),
            'fields' => array(
                          array(
                            'main' => 'id_categorie_produit',
                            'second' => 'id'
                            )
              ),
              'order' => array('champs' => 'prix_quantite_unitaire','param' => 'ASC'),
              'condition' => 'produits.token = "'.$token_produit.'"', //
              'limit' => '0,1'
            ),'produits','categories_produits') );
        if( empty($d['produit']) ){
          header('Location: '.BASE_URL.DS.'produits/liste');
        }else{

          $d['unit_mesure'] = $this->unit_mesure();
          $d['categories'] = current( $this->get_category('id='.$d['produit']->id_categorie) );

          $d['commandes'] = $this->Produits->findJoin(array(
            'fieldsmain' => array('id_commande AS id_cmd','quantite AS nbre_cmd','qtte_unitaire AS qtte_unitaire_cmd',
              'prix_qtte_unitaire AS prix_qtte_unitaire_cmd'),
            'fieldstwo' => array( 'montant_ht AS montant_ht','frais_livraison AS frais_livraison','montant_total AS montant_total',
                  'token as cmd_id', 'statut as cmd_statut', 'date_creation AS cmd_date_creation'),
            'fields' => array( array('main' => 'id_commande','second' => 'id') ),
            'order' => array('champs' => 'commandes_produits.id' , 'param' => 'desc'),
            'condition' => 'commandes_produits.id_produit='.$d['produit']->id
          ),'commandes_produits','commandes');

        }

      }

      // debug($d);
      $this->set($d);
    }

    private function get_livreur($id_livreur){
      $livreur = current ( $this->Commandes->find( array( 'fields' => 'id,nom,prenoms', 'condition' => 'id = '.$id_livreur )
                                ,'livreurs' ) );
      return $livreur;

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
    private function organize_filter($start_date, $start_hour, $end_date, $end_hour, $name_product, $category_product, $stock_product,
                                $unit_mesure, $status_product, $promo_product, $amount_product){
      
      $list_function_params = func_get_args(); //recupere la liste de tous les paramètres envoyés dans la fonction
      foreach ( $list_function_params as $function_param ) {
          # code...
        $spliter = explode( '&', $function_param);
        ${$spliter[0]} = isset( $spliter[1] ) ?  $spliter[1] : '';
        // $$spliter[0] = isset( $spliter[1] ) ?  $spliter[1] : '';
      }  

      //rajoute les conditions pour la periode
      $conditions_prepare[':debut'] = $start_date.' '.$start_hour;
      $conditions_prepare[':fin'] = $end_date.' '.$end_hour;

      //
      $condition_sql_liste = " produits.date_creation BETWEEN :debut AND :fin ";

      //rajoute condition pour le nom du produit
      if( !empty( $name_product ) ){
          $condition_sql_liste .= " AND produits.nom like :nom ";
          $conditions_prepare[':nom'] = '%'.strtolower( $name_product ).'%';
      }

      //rajoute condition pour categorie produits
      if( strlen($category_product) != 0 ){
          $condition_sql_liste .= " AND produits.id_categorie_produit =:id_categorie_produit ";
          $conditions_prepare[':id_categorie_produit'] = intval($category_product);
      }

      //rajoute condition pour stock
      if( strlen( $stock_product ) != 0 ){
          $condition_sql_liste .= " AND produits.stock =:stock ";
          $conditions_prepare[':stock'] = intval( $stock_product ) ;
      }

      //rajoute condition pour ID commande
      if( strlen( $unit_mesure ) != 0 ){
          $condition_sql_liste .= " AND produits.id_unite =:id_unite ";
          $conditions_prepare[':id_unite'] = intval ( $unit_mesure );
      }

      //rajoute condition pour status commande
      if( strlen($status_product) != 0 ){
          $condition_sql_liste .= " AND produits.statut =:status ";
          $conditions_prepare[':status'] = intval( $status_product ) ;
      }

      //rajoute condition pour promo 
      if( strlen($promo_product) != 0 ){
          $condition_sql_liste .= " AND produits.promo =:promo ";
          $conditions_prepare[':promo'] = intval( $promo_product );
      }

      //rajoute condition pour promo 
      if( strlen($amount_product) != 0 ){
          $condition_sql_liste .= " AND produits.prix_quantite_unitaire = :prix_quantite_unitaire ";
          $conditions_prepare[':prix_quantite_unitaire'] = intval( $amount_product );
      }

      return array('condition_sql_liste' => $condition_sql_liste, 'conditions_prepare' => $conditions_prepare );

    }

    private function get_products($filter){
      $produits = $this->Produits->findJoin(array(
           'fieldsmain' => array('id AS id','nom AS nom_produit','token AS token_produit','quantite_unitaire as qtite_unit',
            'id_unite as unite','prix_quantite_unitaire as prix_qtite_unit','slug as slug','nouveau as isnew','promo as ispromo',
            'pourcentage_promo as percent_promo','image as image','statut AS produit_statut','stock AS stock','date_creation as date_creation',
            'date_modification as date_modification','page_accueil as page_accueil','description as description'),
            'fieldstwo' => array('nom AS categorie','statut AS categorie_statut'),
            'fieldsthree' => array('nom AS taille'),
            'fields' => array( array( 'main' => 'id_categorie_produit', 'second' => 'id' ) ),
              'condition' => $filter['condition_sql_liste'],
              'array_filter' => $filter['conditions_prepare'],
              'order' => array('champs' => 'prix_quantite_unitaire','param' => 'ASC')
            ),'produits','categories_produits');

      return $produits;
    }



}
