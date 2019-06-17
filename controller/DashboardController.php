<?php
class DashboardController extends Controller {
    
    public function index(){
      conf::redir();
      $this->loadmodel('Statistics');
      $_SESSION['bo_menu'] = 'Dashboard';

      //total commandes
      $d['total_cmd']['montant'] = $this->Statistics->findSumAll('montant_ht','commandes');
      $d['total_cmd']['nbre'] = $this->Statistics->findCountAll('commandes');

      //total commandes livrés
      $d['total_cmd_livrees']['montant'] = $this->Statistics->findSum( array('statut' => 1 ),'montant_ht','commandes' );
      $d['total_cmd_livrees']['nbre'] = $this->Statistics->findCount( array('statut' => 1 ),'commandes' );


      //total commandes en attente
      $d['total_cmd_pending']['montant'] = $this->Statistics->findSum( array( 'statut' => 0 ),'montant_ht','commandes' );
      $d['total_cmd_pending']['nbre'] = $this->Statistics->findCount( array( 'statut' => 0 ),'commandes' );

      //total commandes en cours de livraison
      $d['total_cmd_on_road']['montant'] = $this->Statistics->findSum( array('statut' => 3 ),'montant_ht','commandes' );
      $d['total_cmd_on_road']['nbre'] = $this->Statistics->findCount( array('statut' => 3 ),'commandes' );


      //statistique de la journée      
      $today = date('Y-m-d');
      $yesterday = date( 'Y-m-d', strtotime('today - 1 day') );

      //toutes les Commandes du jour
      $d['total_cmd_today']['montant'] = $this->Statistics->findSum(
                                                            " DATE(date_creation) > '$yesterday' ",
                                                            'montant_ht','commandes' );
      $d['total_cmd_today']['nbre'] = $this->Statistics->findCount( 
                                                            " DATE(date_creation) > '$yesterday' ",
                                                            'commandes' );
      $d['total_cmd_today']['percent'] = ( $d['total_cmd_today']['nbre'] != 0 ) ? 100 : 0;
      $d['total_cmd_today']['style'] = ( $d['total_cmd_today']['nbre'] != 0 ) ? 100 : 0;

      //commandes livrées du jour
      $d['total_cmd_livrees_today']['montant'] = $this->Statistics->findSum(
                                                            " DATE(date_creation) > '$yesterday' AND statut=1 ",
                                                            'montant_ht','commandes' );
      $d['total_cmd_livrees_today']['nbre'] = $this->Statistics->findCount( 
                                                            " DATE(date_creation) > '$yesterday' AND statut=1 ",
                                                            'commandes' );    
      if( $d['total_cmd_today']['nbre'] != 0 ){
            $d['total_cmd_livrees_today']['percent'] = ( $d['total_cmd_livrees_today']['nbre'] / $d['total_cmd_today']['nbre'])*100;
            $d['total_cmd_livrees_today']['percent'] = number_format($d['total_cmd_livrees_today']['percent'], 2);
            
      }else{
            $d['total_cmd_livrees_today']['percent'] = number_format(0, 2);
      }
      $d['total_cmd_livrees_today']['style'] = number_format($d['total_cmd_livrees_today']['percent'], 0);
       

      //commandes annulées du jour
      $d['total_cmd_cancelled_today']['montant'] = $this->Statistics->findSum(
                                                            " DATE(date_creation) > '$yesterday' AND statut IN(2,4) ",
                                                            'montant_ht','commandes' );
      $d['total_cmd_cancelled_today']['nbre'] = $this->Statistics->findCount( 
                                                            " DATE(date_creation) > '$yesterday' AND statut IN(2,4) ",
                                                            'commandes' );
      if( $d['total_cmd_today']['nbre'] != 0 ){
            $d['total_cmd_cancelled_today']['percent'] = ( $d['total_cmd_cancelled_today']['nbre'] / $d['total_cmd_today']['nbre'])*100;
            $d['total_cmd_cancelled_today']['percent'] = number_format($d['total_cmd_cancelled_today']['percent'], 2);
      }else{
            $d['total_cmd_cancelled_today']['percent'] = number_format(0, 2);
      }
      $d['total_cmd_cancelled_today']['style'] = number_format($d['total_cmd_cancelled_today']['percent'], 0); 

      

      //commandes en attente du jour
      $d['total_cmd_pending_today']['montant'] = $this->Statistics->findSum(
                                                            " DATE(date_creation) > '$yesterday' AND statut=0 ",
                                                            'montant_ht','commandes' );
      $d['total_cmd_pending_today']['nbre'] = $this->Statistics->findCount( 
                                                            " DATE(date_creation) > '$yesterday' AND statut=0 ",
                                                            'commandes' );
      if( $d['total_cmd_today']['nbre'] != 0 ){
            $d['total_cmd_pending_today']['percent'] = ( $d['total_cmd_pending_today']['nbre'] / $d['total_cmd_today']['nbre'])*100;
            $d['total_cmd_pending_today']['percent'] = number_format($d['total_cmd_pending_today']['percent'], 2);
      }else{
            $d['total_cmd_pending_today']['percent'] = number_format(0, 2);
      }
      $d['total_cmd_pending_today']['style'] = number_format($d['total_cmd_pending_today']['percent'], 0);
      //commandes en cours de livraison du jour
      $d['total_cmd_on_road_today']['montant'] = $this->Statistics->findSum(
                                                            " DATE(date_creation) > '$yesterday' AND statut=3 ",
                                                            'montant_ht','commandes' );
      $d['total_cmd_on_road_today']['nbre'] = $this->Statistics->findCount( 
                                                            " DATE(date_creation) > '$yesterday' AND statut=3 ",
                                                            'commandes' );
      $d['total_cmd_on_road_today']['percent'] = $d['total_cmd_today']['percent'] - ($d['total_cmd_pending_today']['percent'] + 
                                                                                    $d['total_cmd_livrees_today']['percent'] +
                                                                                    $d['total_cmd_cancelled_today']['percent']);
      $d['total_cmd_on_road_today']['percent'] = number_format($d['total_cmd_on_road_today']['percent'], 2);
      $d['total_cmd_on_road_today']['style'] = number_format($d['total_cmd_on_road_today']['percent'], 0);

      //debug($d); die();

      // $d['total_cmd_stat_details'] = $this->Statistics->find( array(
      //     'fields' => 'SUM(montant_ht) as montant, COUNT(id) as nbre, statut',
      //     'group' => 'statut'
      //   ),'commandes');
      // debug($d); die(); 
      $this->set($d);
    }  
   
    
}
