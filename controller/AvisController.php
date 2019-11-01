<?php
class AvisController extends Controller {
    
    public function liste(){
      conf::redir();
      $this->loadmodel('Avis');
      $_SESSION['bo_menu'] = 'Avis';  $_SESSION['bo_sub_menu'] = 'Avis';
      $d['numero_page_encours']=1;
      //Total produits
      // $total = $this->Produits->findCountAll('categories_produits'); avis
      $d['elements']['total']['nbre'] = $this->Avis->findCountAll('avis');

      ///total en attente
      $d['elements']['non_actifs'] = $this->Avis->findCount( array( 'statut' => 0 ),'avis' );

      //total repondu
      $d['elements']['actifs'] = $this->Avis->findCount( array( 'statut' => 1 ),'avis' ); 

      $d['nombre_pages']=ceil( $d['elements']['total']['nbre'] / 10 );      

      $req = [
              'fieldsmain' => ['id as id_avis','id_client as id_c','nom as nom_avis', 'token as token',
              'prenoms as prenoms_avis','email as email_avis', 'contenu as contenu','localisation as localisation',
              'statut as statut','page_accueil as page_accueil','date_creation as date_creation','date_modification as date_modification','reponse_admin_contenu as reponse_admin_contenu'],
              'fieldstwo' => ['nom as nom_client','prenoms as prenoms_client','email as email_client'],
              'fieldsthree' => ['nom as produit'],
              'fields' => 
                  array(  
                    array(  'main' => 'id_client',  'second' => 'id', 'type' => 'LEFT JOIN'  ),  
                    array(  'main' => 'id_produit',  'third' => 'id', 'type' => 'INNER JOIN'  )
                  ),
                'order' => array('champs' => 'avis.id','param' => 'DESC'),
                'limit' => '0,10'
            ];    
       $d['elements']['liste'] = $this->Avis->findJoinType( $req, 'avis', 'clients', 'produits') ;

      $d['users_bo'] = $this->getUserAdminList();

      // debug($d);
      $this->set($d);
    } 

    private function getUserAdminList(){
      $users_bo['liste'] = $this->Avis->find( array( 'order' => array('champs' => 'id','param' => 'DESC')  ), 'utilisateurs' );    
      
      $listeArray = array();
      foreach ($users_bo['liste'] as $c) {
        $listeArray[$c->id] = $c->nom.' '.$c->prenoms;
      }

      return [ 'liste' => $listeArray];
    }


    public function extraction( $start_date, $start_hour, $end_date, $end_hour, $name_delivrer, $tel ){
      conf::redir();
      $this->loadmodel('Avis');
      //formate les parametre envoyés afin quils soient utilisés pour la requete vers la base de données
      $filter_formated = $this->organize_filter( $start_date, $start_hour, $end_date, $end_hour, $name_delivrer, $tel );
      
      $avis = $this->get_elements_for_extract($filter_formated);
      // debug($avis);

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
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'ID LIVREUR');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Nom');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Téléphone');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Email');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'DATE DE CREATION');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'DATE DE DERNIERE MODIFICATION');

      $i=1;
      //remplir le corps du tableau
      $nbre_plus = count ( $avis );
      foreach ($avis as $livreur) {
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $nbre_plus-- );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $livreur->token );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, ucfirst( $livreur->nom ).' '.ucfirst( $livreur->prenoms ) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $livreur->tel );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $livreur->email );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $livreur->date_creation );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, $livreur->date_modification );

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
      $objPHPExcel->getActiveSheet()->setTitle('liste_avis');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel2007)
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      //        header('Content-Disposition: attachment;filename="Liste_des_moyennes_annuelles.xlsx"');
      header('Content-Disposition: attachment;filename="liste_avis'.date('YdmHis').'.xlsx"');
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
      // $this->loadmodel('Avis');
      $this->details($token);
      // debug($d);
    }

    public function repondre( $token ){
      conf::redir();
      // $this->loadmodel('Avis');
      $this->details($token);
      // debug($d);
    }
    
    public function details($token){
      conf::redir();
      $this->loadmodel('Avis');
      $_SESSION['bo_menu'] = 'Avis';  $_SESSION['bo_sub_menu'] = 'Avis';
      $d['token'] = $token;

      if( !isset($token) || empty($token) ){
        header('Location: '.BASE_URL.DS.'avis/liste');
      }else{
        $req = [
              'fieldsmain' => ['id as id_avis','id_client as id_c','nom as nom_avis', 'token as token',
              'prenoms as prenoms_avis','email as email_avis', 'contenu as contenu','localisation as localisation',
              'statut as statut','page_accueil as page_accueil','date_creation as date_creation','date_modification as date_modification','reponse_admin_contenu as reponse_admin_contenu',
              'id_admin_reponse as id_admin_reponse','date_reponse as date_reponse'],
              'fieldstwo' => ['nom as nom_client','prenoms as prenoms_client','email as email_client'],
              'fieldsthree' => ['nom as produit','image as image'],
              'fields' => 
                  array(  
                    array(  'main' => 'id_client',  'second' => 'id', 'type' => 'LEFT JOIN'  ),  
                    array(  'main' => 'id_produit',  'third' => 'id', 'type' => 'INNER JOIN'  )
                  ),
                'condition' => 'avis.token = "'.$token.'"',  
                'order' => array('champs' => 'avis.id','param' => 'DESC')
            ];    
       $d['element'] = current( $this->Avis->findJoinType( $req, 'avis', 'clients', 'produits') );
       $d['users_bo'] = $this->getUserAdminList();
       // debug($d);        //recupere les informations du livreur

        if( empty($d['element']) ){ //verifie que le livreur existe
          header('Location: '.BASE_URL.DS.'avis/liste'); // renvoi vers liste de categorie si la categorie n'existe pas
        }
        
      }

      // debug($d);
      $this->set($d);
    }


    private function unit_mesure($condition=null){
      //recuperer les unité de mésure
          $unites_from_bd = $this->Avis->find(array(
              'fields' => array('id','libelle','symbole')
            ),'unites');
          $unites = array();
          foreach ($unites_from_bd as $u) {
            $unites[$u->id] = ($u->symbole == 'NA') ? 'nombre' : $u->symbole;
          }

          return $unites;
    }

    private function get_avis($condition=null){
      //recuperer les unité de mésure
          $requette['fields'] = array('id','nom');
          if(isset($condition)){
            $requette['condition'] = $condition;
          }
          // debug($requette);          
          // debug( $this->Produits->find( $requette ,'categories_produits' ) );          
          $category_from_bd = $this->Avis->find( $requette ,'avis' );
          

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
          $category_from_bd = $this->Avis->find( $requette ,'produits' );
          

          return $category_from_bd;
    }

    //formater les varible venue de la vue afin d'enressortir les condition (filtre) a utiliser pour la requete SQL
    private function organize_filter($start_date, $start_hour, $end_date, $end_hour, $name_delivrer, $tel ){      
      $list_function_params = func_get_args(); //recupere la liste de tous les paramètres envoyés dans la fonction
      foreach ( $list_function_params as $function_param ) {
        $spliter = explode( '&', $function_param);
        ${$spliter[0]} = isset( $spliter[1] ) ?  $spliter[1] : '';
      }  

      //rajoute les conditions pour la periode
      $conditions_prepare[':debut'] = $start_date.' '.$start_hour;
      $conditions_prepare[':fin'] = $end_date.' '.$end_hour;

      //
      $condition_sql_liste = " avis.date_creation BETWEEN :debut AND :fin ";

     //rajoute condition pour le nom du produit
      $name_delivrer = trim($name_delivrer);
      if( !empty( $name_delivrer ) ){
          $condition_sql_liste .= " AND (nom like :nom or prenoms like :prenoms )"; //LOWER(`Value`)
          $conditions_prepare[':nom'] = '%'.strtolower( $name_delivrer ).'%';
          $conditions_prepare[':prenoms'] = '%'.strtolower( $name_delivrer ).'%';
      }

      //rajoute condition pour categorie produits
      if( strlen($tel) != 0 ){
          $condition_sql_liste .= " AND avis.tel like :tel ";
          $conditions_prepare[':tel'] = '%'.trim( $tel ).'%';
      }

      return array('condition_sql_liste' => $condition_sql_liste, 'conditions_prepare' => $conditions_prepare );

    }

    private function get_elements_for_extract($filter){
      $avis = $this->Avis->find( array(
              'condition' => $filter['condition_sql_liste'],
              'array_filter' => $filter['conditions_prepare'],
              'order' => array('champs' => 'avis.id','param' => 'DESC')
            ),'avis');

      return $avis;
    }



}
