<?php
class CommandesController extends Controller {
    
    public function liste(){
      conf::redir();
      $this->loadmodel('Commandes');
      $_SESSION['bo_menu'] = 'Commandes';

      //Total commades
      $d['total_cmd']['montant'] = $this->Commandes->findSumAll('montant_ht','commandes');
      $d['total_cmd']['nbre'] = $this->Commandes->findCountAll('commandes');

      //total commandes livrées
      $d['total_cmd_livrees']['montant'] = $this->Commandes->findSum( array('statut' => 1 ),'montant_ht','commandes' );
      $d['total_cmd_livrees']['nbre'] = $this->Commandes->findCount( array('statut' => 1 ),'commandes' );

      //EN ATTENTE
      $d['total_cmd_pending']['montant'] = $this->Commandes->findSum( array( 'statut' => 0 ),'montant_ht','commandes' );
      $d['total_cmd_pending']['nbre'] = $this->Commandes->findCount( array( 'statut' => 0 ),'commandes' );

      //EN LIVRAISON
      $d['total_cmd_on_road']['montant'] = $this->Commandes->findSum( array('statut' => 3 ),'montant_ht','commandes' );
      $d['total_cmd_on_road']['nbre'] = $this->Commandes->findCount( array('statut' => 3 ),'commandes' );

      //REJETEES
      $d['total_cmd_rejected']['montant'] = $this->Commandes->findSum( array('statut' => 4 ),'montant_ht','commandes' );
      $d['total_cmd_rejected']['nbre'] = $this->Commandes->findCount( array('statut' => 4 ),'commandes' );

      //ANNULEES
      $d['total_cmd_cancelled']['montant'] = $this->Commandes->findSum( array('statut' => 2 ),'montant_ht','commandes' );
      $d['total_cmd_cancelled']['nbre'] = $this->Commandes->findCount( array('statut' => 2 ),'commandes' );

      //Commandes list
      
      $d['commandes'] = $this->Commandes->findJoin( array(
            'fieldsmain' => array('montant_ht AS montant_ht','frais_livraison AS frais_livraison','montant_total AS montant_total',
                  'token as cmd_id', 'statut as cmd_statut', 'date_creation AS cmd_date_creation'),
            'fieldstwo' => array('token AS client_id',' nom as client_nom ',' prenoms as client_prenoms '),
            'fields' => array(  array( 'main' => 'id_client', 'second' => 'id' ) ),
              'order' => array('champs' => 'commandes.id','param' => 'DESC'),
              'limit' => '0,10'
            ),'commandes','clients');

      $d['nombre_pages']=ceil($d['total_cmd']['nbre'] / 10);
      $d['numero_page_encours']=1;

      $d['livreurs'] = $this->Commandes->find( array( 'fields' => 'id,nom,prenoms', 'order' => array('champs' => 'nom', 'param' => 'ASC') 
                                             ) ,'livreurs' );

      $d['order_first'] = current ( $this->Commandes->find( 
                          array( 'fields' => "DATE(date_creation) as date_first, DATE_FORMAT(date_creation,'%H:%i:%s') hour_first",
                                  'order' => array('champs' => 'id', 'param' => 'ASC') 
                                ),'commandes' ) );      

      // debug($d['commandes']); die();
      
      $this->set($d);
    }

    public function details($token_commande){
      conf::redir();
      $this->loadmodel('Commandes');
      $d= array();
      $_SESSION['bo_menu'] = 'Commandes';

      //verifie que le token de la commande a bien été envoyé
      if( !isset($token_commande) || empty($token_commande) ){
        header('Location: '.BASE_URL.DS.'commandes/liste');
      }else{
        $token_commande = trim($token_commande);

        // recuperation de la commande
        $d['commande'] = current( $this->Commandes->find( array( 
            'condition' => array( 'token' => $token_commande ),
            'order' => array( 'champs' => 'id', 'param' => 'DESC')
          ),'commandes') );

        //verifie si la comande existe bien en base
        if( empty($d['commande']) ){
          header('Location: '.BASE_URL.DS.'commandes/liste');
        }else{
          //recuperation du statut
          // $d['command_status'] = $this->getStatusCommand($d['command']->statut);

          //Recuperation des infos du clients
          $d['client'] = current ( $this->Commandes->find( 
              array( 
                'fields' => 'id,nom,prenoms,token,tel,email',
                'condition' => 'id = '.$d['commande']->id_client
              )
            ,'clients' ) );

          //recuperation des infos sur le livreur, si cmde en cours de livraison
          if( $d['commande']->statut == 3 || $d['commande']->statut == 1 ){
            $d['livreur'] = current ( $this->Commandes->find( 
              array( 
                'fields' => 'id,nom,prenoms',
                'condition' => 'id = '.$d['commande']->id_livreur 
              )
            ,'livreurs' ) );
          }

          //recuperation des infos sur le user back office ayant traité la transaction
          if( intval( $d['commande']->id_utilisateur ) > 0 ){
            $d['user_bo'] = current ( $this->Commandes->find( 
              array( 
                'fields' => 'id,nom,prenoms',
                'condition' => 'id = '.$d['commande']->id_utilisateur 
              )
            ,'utilisateurs' ) );
          }          

          //recuperation des information de la livraison
          $d['shipping'] = current( $this->Commandes->findJoin(array(
            'fieldsmain' => array(' id AS receiver_id','nom AS receiver_name','prenoms AS receiver_lastname',
              'tel AS receiver_tel','email AS receiver_email',' quartier AS receiver_quartier','lagitude as lagitude',
              'longitude as longitude','description AS receiver_description'),
            'fieldstwo' => array('token AS dest_token','commune AS dest_commune','frais AS frais_commune'),
            'fields' => array( array('main' => 'id_destination','second' => 'id') ),
            'order' => array('champs' => 'shipping_infos.id' , 'param' => 'desc'),
            'condition' => 'shipping_infos.id_commande='.$d['commande']->id,
            'limit' => '0,1'
          ),'shipping_infos','livraison_destinations') );

          //recupération list de produits
          $d['produits'] = $this->Commandes->findJoin(array(
            'fieldsmain' => array('id_commande AS id_cmd','quantite AS nbre_cmd','qtte_unitaire AS qtte_unitaire_cmd',
              'prix_qtte_unitaire AS prix_qtte_unitaire_cmd'),
            'fieldstwo' => array( 'id AS id_produit','nom AS nom_produit','token AS token','id_unite as id_unite',
              'quantite_unitaire AS quantite_unitaire_produit','prix_quantite_unitaire AS prix_quantite_unitaire',
              'image AS image','promo AS promo','pourcentage_promo AS pourcentage_promo'),
            'fields' => array( array('main' => 'id_produit','second' => 'id') ),
            'order' => array('champs' => 'commandes_produits.quantite' , 'param' => 'desc'),
            'condition' => 'commandes_produits.id_commande='.$d['commande']->id
          ),'commandes_produits','produits');

          //recuperer les unité de mésure
          $unites_from_bd = $this->Commandes->find(array(
              'fields' => array('id','libelle','symbole')
            ),'unites');
          $d['unites'] = array();
          foreach ($unites_from_bd as $u) {
            $d['unites'][$u->id] = ($u->symbole == 'NA') ? 'nombre' : $u->symbole;
          }

        }


      }
      // debug($d);
      $this->set($d);

      }

    // }  
   
    public function extraction($start_date, $start_hour, $end_date, $end_hour, $tel_user, $client_id, $cmd_amount, $cmd_id, $status){
      conf::redir();
      $this->loadmodel('Commandes');

      //formate les options de filtrage
      $filter_formated = $this->organize_filter($start_date, $start_hour, $end_date, $end_hour, $tel_user, $client_id, $cmd_amount, $cmd_id, $status);
      
      //recupere la liste des commandes
      $commandes = $this->get_orders($filter_formated);
      //debug($commandes);
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
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Client');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Tel Client');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'ID Client');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Montant HT');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Frais Livraison');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Montant TTC');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'ID Commande');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Statut');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Date creation');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Date dernier');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Livreur');

      $i=1;
      //remplir le corps du tableau
      $nbre_cmd_plus = count ( $commandes );
      foreach ($commandes as $commande) {
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $nbre_cmd_plus-- );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, ucfirst( $commande->client_nom ).' '.ucfirst( $commande->client_prenoms ) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, "'".$commande->client_tel );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $commande->client_id );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $commande->montant_ht );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $commande->frais_livraison );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, $commande->montant_total );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $i, $commande->cmd_id );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $i, strtoupper( accentdel( status_displayed($commande->cmd_statut)['libele'] ) ) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $i, dateFormat($commande->cmd_date_creation) );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $i, dateFormat($commande->cmd_date_modif) );
        
        if( $commande->cmd_statut == 3 || $commande->cmd_statut == 1 ){
          $livreur = $this->get_livreur($commande->id_livreur);
          $livreur_info = strtoupper( $livreur->nom ).' ('.ucfirst( $livreur->prenoms ).')' ;
        }else{
          $livreur_info = '';
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $i, $livreur_info );

      }

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
      $styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
          ),
      );
      //$headRowString = PHPExcel_Cell::stringFromColumnIndex($headColumnNum - 1);
      $objPHPExcel->getActiveSheet()->getStyle('A1:L' . $i)->applyFromArray($styleArray);

      // Rename worksheet
      //        $objPHPExcel->getActiveSheet()->setTitle('Liste_des_moyennes_annuelles');
      $objPHPExcel->getActiveSheet()->setTitle('Liste_commandes');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel2007)
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      //        header('Content-Disposition: attachment;filename="Liste_des_moyennes_annuelles.xlsx"');
      header('Content-Disposition: attachment;filename="liste_commande_'.date('YdmHis').'.xlsx"');
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

    //formater les varible venue de la vue afin d'enressortir les condition (filtre) a utiliser pour la requete SQL
    private function organize_filter($start_date, $start_hour, $end_date, $end_hour, $tel_user, $client_id, $cmd_amount, $cmd_id, $status){
      
      $list_function_params = func_get_args();
      foreach ( $list_function_params as $function_param ) {
          # code...
        $spliter = explode( '&', $function_param);
        ${$spliter[0]} = isset( $spliter[1] ) ?  $spliter[1] : '';
      }  
      //debug($start_hour);

      //rajoute les conditions pour la periode
      $conditions_prepare[':debut'] = $start_date.' '.$start_hour;
      $conditions_prepare[':fin'] = $end_date.' '.$end_hour;

      //
      $condition_sql_liste = " commandes.date_creation BETWEEN :debut AND :fin ";

      //rajoute condition pour le telephone du client
      if( !empty( $tel_user ) ){
          $condition_sql_liste .= " AND clients.tel =:user_tel ";
          $conditions_prepare[':user_tel'] = $tel_user;
      }

      //rajoute condition pour ID client
      if( !empty( $client_id ) ){
          $condition_sql_liste .= " AND clients.token =:user_id ";
          $conditions_prepare[':user_id'] = $client_id;
      }

      //rajoute condition pour montant commande
      if( !empty( $cmd_amount ) ){
          $condition_sql_liste .= " AND commandes.montant_ht =:cmd_amount ";
          $conditions_prepare[':cmd_amount'] = $cmd_amount;
      }

      //rajoute condition pour ID commande
      if( !empty( $cmd_id ) ){
          $condition_sql_liste .= " AND commandes.token =:cmd_id ";
          $conditions_prepare[':cmd_id'] = $cmd_id;
      }

      //rajoute condition pour status commande
      if( strlen($status) != 0 ){
          $condition_sql_liste .= " AND commandes.statut =:status ";
          $conditions_prepare[':status'] = intval( $status ) ;
      }

      return array('condition_sql_liste' => $condition_sql_liste, 'conditions_prepare' => $conditions_prepare );

    }

    private function get_orders($filter){
      $commandes = $this->Commandes->findJoin( array(
            'fieldsmain' => array('montant_ht AS montant_ht','frais_livraison AS frais_livraison','montant_total AS montant_total',
                'id_livreur AS id_livreur', 'token as cmd_id', 'statut as cmd_statut', 'date_creation AS cmd_date_creation', 'date_modification AS cmd_date_modif'),
            'fieldstwo' => array('token AS client_id',' nom as client_nom ',' prenoms as client_prenoms ',' tel as client_tel '),
            'fields' => array(  array( 'main' => 'id_client', 'second' => 'id' ) ),
            'condition' => $filter['condition_sql_liste'],
            'array_filter' => $filter['conditions_prepare'],
            'order' => array('champs' => 'commandes.id','param' => 'DESC')
            ),'commandes','clients');

      return $commandes;
    }

    private function get_livreur($id_livreur){
      $livreur = current ( $this->Commandes->find( array( 'fields' => 'id,nom,prenoms', 'condition' => 'id = '.$id_livreur )
                                ,'livreurs' ) );
      return $livreur;

    }

}
