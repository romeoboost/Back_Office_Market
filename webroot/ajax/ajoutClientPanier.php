<?php
include 'connectDB.php';
include 'fonction.php';
if (empty(session_id())) {
    session_start();
    //$_SESSION['menu'] = 'Nous_Rejoindre';
}
//debugger($_POST);
$error_statut = false;
$error_text = '';
$error_text_second = '';
$field_error ='none';
$retour = array();
//$retour['enregistrement'] = 'non';
//if( !isset($_SESSION['cart']['products_list'][$token]) ){

if(!isset($_POST) || empty($_POST) || !isset($_POST['client']) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page.';
}else{
  // debugger($_POST);
  //cart.customer.name
  extract($_POST);
  if( isset($_SESSION['cart']['customer']['token']) && $actioner == 'ADD'){ //verifie s'il n'y a pas déja un client lié au panier
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Il y a déjà un client lié à ce panier.";
  }else{
    $token = $client;
    //vérifie si le client existe bien en base
    $req_recup = $pdo->prepare('SELECT * FROM clients WHERE token = :token ORDER BY id DESC'); 
    $req_recup->execute( array( ':token' => $token ) );
    $client_in_db = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );
    if( empty($client_in_db) ){
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec d'ajout de cet utilisateur au panier. Il existe pas dans le sytème.";
    }else{
      //Ajoute les infos du client au panier
      $retour['cart']['customer']['token'] = $client_in_db->token;
      $retour['cart']['customer']['name'] =  $client_in_db->nom.' '.$client_in_db->prenoms;

      $_SESSION['cart']['customer']['token'] = $client_in_db->token;
      $_SESSION['cart']['customer']['name'] =  $client_in_db->nom.' '.$client_in_db->prenoms;

      $retour['cart']['customer']['action_html'] = '<a class="header-cart-add-customer delete-pusher"
          title="retirer le client"> 
          <i class="fa fa-times-circle-o"></i>
      </a>
      <a class="header-cart-add-customer update-pusher"
          title="changer le client"> 
          <i class="fa fa-pencil"></i>
      </a>';

      $action = ( $actioner == 'ADD' ) ? ' ajouté au panier.' : ' modifié.';

      $error_text = "Le Client a été ".$action;
      $error_text_second = "";
    }

  }

}

$retour['error'] = 'non';
$retour['error_html'] = '';
$retour['error_text'] = $error_text;
$retour['error_text_second'] = $error_text_second;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    //$retour['field_error'] = $field_error;
    header('Operation echouée', true, 400);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;

