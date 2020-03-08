<?php
class ClientsController extends Controller {
    
    public function liste(){
      conf::redir();
      $this->loadmodel('Clients');
      $_SESSION['bo_menu'] = 'Clients';
      $_SESSION['bo_sub_menu'] = 'Clients';
      $d['numero_page_encours']=1;
      //Total clients
      $total = $this->Clients->findCountAll('clients');

      ///total clients non actifs
      $non_actifs = $this->Clients->findCount( array( 'statut' => 0 ),'clients' );

      //total clients actifs
      $actifs = $this->Clients->findCount( array( 'statut' => 1 ),'clients' );     

      $d['clients']['non_actifs'] = $non_actifs;
      $d['clients']['actifs'] = $actifs;
      $d['clients']['total'] = $total;

      $d['nombre_pages']=ceil( $total / 10 );
      
      //Liste des clients
      $d['clients']['liste'] = $this->Clients->find(array(
            'order' => array('champs' => 'id','param' => 'DESC'), //
            'limit' => '0,10'
            ),'clients');
      
      // debug($d);
      $this->set($d);
    } 


    public function extraction($start_date, $start_hour, $end_date, $end_hour, $nom, $prenoms, $client_id, $tel, $status, $sexe ){
      conf::redir();
      $this->loadmodel('Clients');

      $filter_formated = $this->organize_filter($start_date, $start_hour, $end_date, $end_hour, $nom, $prenoms, $client_id, $tel, $status, $sexe);
      // debug($filter_formated);

      // debug($filter_formated);

      $clients = $this->get_clients($filter_formated);
      // debug($clients);
      

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
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'NOM');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Prenoms');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'ID Client ');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Tel');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Email');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Sexe UNITAIRE VENDUE');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Statut');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'DATE DE CREATION');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'DATE DE DERNIERE MODIFICATION');

      $i=1;
      //remplir le corps du tableau
      $nbre_cmd_plus = count ( $clients );
      foreach ($clients as $client) {
        $i++;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $nbre_cmd_plus-- );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, ucfirst( htmlspecialchars ($client->nom) ) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, ucfirst( htmlspecialchars ($client->prenoms) ) );

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $client->token );
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, "'".$client->tel );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, htmlspecialchars ($client->email) );
        $sexe = ($client->sexe == 1) ? 'HOMME' : 'FEMME';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, $sexe );
        $statut = ($client->statut == 1) ? 'ACTIF' : 'NON ACTIF';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $i,  $statut );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $i, dateFormat($client->date_creation) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $i, dateFormat($client->date_modification) );

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
      
      //parametre le border du tableau a gras
      $styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
          ),
      );
      //$headRowString = PHPExcel_Cell::stringFromColumnIndex($headColumnNum - 1);
      $objPHPExcel->getActiveSheet()->getStyle('A1:J' . $i)->applyFromArray($styleArray);

      // Rename worksheet
      //        $objPHPExcel->getActiveSheet()->setTitle('Liste_des_moyennes_annuelles');
      $objPHPExcel->getActiveSheet()->setTitle('Liste_clients');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel2007)
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      //        header('Content-Disposition: attachment;filename="Liste_des_moyennes_annuelles.xlsx"');
      header('Content-Disposition: attachment;filename="liste_clients_'.date('YdmHis').'.xlsx"');
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


    public function details($token){
      conf::redir();
      $this->loadmodel('Clients');
      $_SESSION['bo_menu'] = 'Clients';  $_SESSION['bo_sub_menu'] = 'Clients';
      $d['token'] = $token;

      if( !isset($token) || empty($token) ){
        header('Location: '.BASE_URL.DS.'clients/liste');
      }else{
        //recupere les informations du produit

        $d['client'] = current( $this->Clients->find(array(
            'order' => array('champs' => 'id','param' => 'DESC'),
            'condition' => array( 'token' => $token )
            ),'clients') );

        if( empty($d['client']) ){
          header('Location: '.BASE_URL.DS.'clients/liste');
        }else{

          $d['commandes'] = $this->Clients->find( array(
            'fields' => array('montant_ht AS montant_ht','frais_livraison AS frais_livraison','montant_total AS montant_total',
                  'token as cmd_id', 'statut as cmd_statut', 'date_creation AS cmd_date_creation'),
              'order' => array('champs' => 'id','param' => 'DESC'),
              'condition' => 'id_client='.intval($d['client']->id)
            ),'commandes');

        }

      }

      // debug($d);
      $this->set($d);
    }

 
    //formater les varible venue de la vue afin d'enressortir les condition (filtre) a utiliser pour la requete SQL
    private function organize_filter($start_date, $start_hour, $end_date, $end_hour, $nom, $prenoms, $client_id, $tel, $status, $sexe){
      
      $list_function_params = func_get_args(); //recupere la liste de tous les paramètres envoyés dans la fonction
      // debug($list_function_params);
      foreach ( $list_function_params as $function_param ) {
          # code...
        $spliter = explode( '&', $function_param);
        ${$spliter[0]}= isset( $spliter[1] ) ?  $spliter[1] : '';
      }  

      $condition_sql_liste = " clients.date_creation BETWEEN :debut AND :fin ";

      // debugger($order_first);

      //rajoute les conditions pour la periode
      $conditions_prepare[':debut'] = $start_date.' '.$start_hour;
      $conditions_prepare[':fin'] = $end_date.' '.$end_hour;

      
      //rajoute condition pour le nom du produit
      $nom = trim($nom);
      if( !empty( $nom ) ){
          $condition_sql_liste .= " AND clients.nom like :nom ";
          $conditions_prepare[':nom'] = '%'.strtolower( $nom ).'%';
      }

      //rajoute condition pour le nom du produit
      $prenoms = trim($prenoms);
      if( !empty( $prenoms ) ){
          $condition_sql_liste .= " AND clients.prenoms like :prenoms ";
          $conditions_prepare[':prenoms'] = '%'.strtolower( $prenoms ).'%';
      }

      //rajoute condition pour le nom du produit
      $client_id = trim($client_id);
      if( !empty( $client_id ) ){
          $condition_sql_liste .= " AND clients.token like :client_id ";
          $conditions_prepare[':client_id'] = '%'.strtolower( $client_id ).'%';
      }
      // [nom] => Kesso, [prenoms] => Romeo, [client_id] => CLI055525MTK, [tel] => 01010101, [status] => 1, [sexe] => 1
      //rajoute condition pour le nom du produit
      $tel = trim($tel);
      if( !empty( $tel ) ){
          $condition_sql_liste .= " AND clients.tel like :tel ";
          $conditions_prepare[':tel'] = '%'.strtolower( $tel ).'%';
      }

      //rajoute condition pour categorie produits
      if( strlen($status) != 0 ){
          $condition_sql_liste .= " AND clients.statut =:statut ";
          $conditions_prepare[':statut'] = intval($status);
      }

      //rajoute condition pour categorie produits
      if( strlen($sexe) != 0 ){
          $condition_sql_liste .= " AND clients.sexe =:sexe ";
          $conditions_prepare[':sexe'] = intval($sexe);
      }

      return array('condition_sql_liste' => $condition_sql_liste, 'conditions_prepare' => $conditions_prepare );

    }

    private function get_clients($filter){
      $clients = $this->Clients->find(array(
              'condition' => $filter['condition_sql_liste'],
              'array_filter' => $filter['conditions_prepare'],
              'order' => array('champs' => 'id','param' => 'DESC')
            ),'clients');
      // debug($filter);
      return $clients;
    }



}
