<?php
class MailsController extends Controller {
    
    public function liste($token=null, $filter=null){
      conf::redir();
      $this->loadmodel('Messages');
      $_SESSION['bo_menu'] = 'Messages';  $_SESSION['bo_sub_menu'] = 'Messages';
      $d['numero_page_encours']=1;
      //Total produits
      // $total = $this->Produits->findCountAll('categories_produits'); messages
      $d['elements']['total']['nbre'] = $this->Messages->findCountAll('messages');

      ///total en attente
      $d['elements']['non_actifs'] = $this->Messages->findCount( array( 'statut' => 0 ),'messages' );

      //total repondu
      $d['elements']['actifs'] = $this->Messages->findCount( array( 'statut' => 1 ),'messages' ); 

      $d['nombre_pages']=ceil( $d['elements']['total']['nbre'] / 10 );      

      $req = [
              'fieldsmain' => ['id as id_messages','id_client as id_c','nom_prenoms as nom_prenoms_messages', 'token as token','email as email_messages',
              'contenu as contenu','statut as statut','date_creation as date_creation','date_modification as date_modification',
              'reponse_admin_contenu as reponse_admin_contenu', 'objet as objet','id_admin_reponse as id_admin_reponse','date_reponse as date_reponse'],
              'fieldstwo' => ['nom as nom_client','prenoms as prenoms_client','email as email_client'],
              'fields' =>   array(  array(  'main' => 'id_client',  'second' => 'id', 'type' => 'LEFT JOIN'  )  ),
              'order' => array('champs' => 'messages.id','param' => 'DESC'),
              'limit' => '0,10'
            ];

            ## METRRE COND FILTRE
      if( isset($filter) && strlen($filter) != 0){
        $filter = is_int( intval($filter) ) ? intval($filter) : 0;
        $req['condition'] = 'messages.statut ='.$filter;
      } 

       $d['elements']['liste'] = $this->Messages->findJoinType( $req, 'messages', 'clients') ;

       if( isset($token) && $token != 'all'){
          $token = trim($token);
          if( empty($token) ){
            header('Location: '.BASE_URL.DS.'mails/liste');
          }else{
            $focus_token = $token;
            $req['condition'] = 'messages.token = "'.$token.'"';
            if( isset($filter) && strlen($filter) !=0 ){
              $req['condition'] = ' and messages.statut ='.$filter;
            }
            $d['element_focus'] = current( $this->Messages->findJoinType( $req, 'messages', 'clients') );
            if( empty($d['element_focus']) ){
              header('Location: '.BASE_URL.DS.'mails/liste');
            }
          }
       }else{
          $d['element_focus'] = current($d['elements']['liste'] );
       }


      $d['users_bo'] = $this->getUserAdminList();

      // debug($d);
      $this->set($d);
    } 

    private function getUserAdminList(){
      $users_bo['liste'] = $this->Messages->find( array( 'order' => array('champs' => 'id','param' => 'DESC')  ), 'utilisateurs' );    
      
      $listeArray = array();
      foreach ($users_bo['liste'] as $c) {
        $listeArray[$c->id] = $c->nom.' '.$c->prenoms;
      }

      return [ 'liste' => $listeArray];
    }

    public function repondre( $token ){
      conf::redir();
      $this->liste($token);
      // debug($d);
    }
    
    public function details($token){
      conf::redir();
      $this->loadmodel('Messages');
      $_SESSION['bo_menu'] = 'Messages';  $_SESSION['bo_sub_menu'] = 'Messages';
      $d['token'] = $token;

      if( !isset($token) || empty($token) ){
        header('Location: '.BASE_URL.DS.'messages/liste');
      }else{
        $req = [
              'fieldsmain' => ['id as id_messages','id_client as id_c','nom as nom_messages', 'token as token',
              'prenoms as prenoms_messages','email as email_messages', 'contenu as contenu','localisation as localisation',
              'statut as statut','page_accueil as page_accueil','date_creation as date_creation','date_modification as date_modification','reponse_admin_contenu as reponse_admin_contenu',
              'id_admin_reponse as id_admin_reponse','date_reponse as date_reponse'],
              'fieldstwo' => ['nom as nom_client','prenoms as prenoms_client','email as email_client'],
              'fieldsthree' => ['nom as produit','image as image'],
              'fields' => 
                  array(  
                    array(  'main' => 'id_client',  'second' => 'id', 'type' => 'LEFT JOIN'  ),  
                    array(  'main' => 'id_produit',  'third' => 'id', 'type' => 'INNER JOIN'  )
                  ),
                'condition' => 'messages.token = "'.$token.'"',  
                'order' => array('champs' => 'messages.id','param' => 'DESC')
            ];    
       $d['element'] = current( $this->Messages->findJoinType( $req, 'messages', 'clients', 'produits') );
       $d['users_bo'] = $this->getUserAdminList();
       // debug($d);        //recupere les informations du livreur

        if( empty($d['element']) ){ //verifie que le livreur existe
          header('Location: '.BASE_URL.DS.'messages/liste'); // renvoi vers liste de categorie si la categorie n'existe pas
        }
        
      }

      // debug($d);
      $this->set($d);
    }

    public function ajouter(){
      conf::redir();
      $this->loadmodel('Messages');
      $_SESSION['bo_menu'] = 'Messages';  $_SESSION['bo_sub_menu'] = 'Messages';

      // $total = $this->Produits->findCountAll('categories_produits'); messages
      $d['elements']['total']['nbre'] = $this->Messages->findCountAll('messages');

      ///total en attente
      $d['elements']['non_actifs'] = $this->Messages->findCount( array( 'statut' => 0 ),'messages' );

      //total repondu
      $d['elements']['actifs'] = $this->Messages->findCount( array( 'statut' => 1 ),'messages' ); 

      $d['clients']['liste'] =  $this->Messages->find( array( 'order' => array('champs' => 'id','param' => 'DESC')  ), 'clients' );
      $this->set($d);
    }

    private function getClientsList(){
      $clients['liste'] = $this->Messages->find( array( 'order' => array('champs' => 'id','param' => 'DESC')  ), 'clients' );    
      
      $listeArray = array();
      foreach ($clients['liste'] as $c) {
        $listeArray[$c->id] = $c->nom.' '.$c->prenoms;
      }

      return [ 'liste' => $listeArray];
    }

    private function get_messages($condition=null){
      //recuperer les unité de mésure
          $requette['fields'] = array('id','nom');
          if(isset($condition)){
            $requette['condition'] = $condition;
          }
          // debug($requette);          
          // debug( $this->Produits->find( $requette ,'categories_produits' ) );          
          $category_from_bd = $this->Messages->find( $requette ,'messages' );
          

          return $category_from_bd;
    }


}
