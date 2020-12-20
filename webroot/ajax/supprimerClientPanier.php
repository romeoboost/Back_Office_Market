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

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page.';
}else{
  // debugger($_POST);
  //cart.customer.name
  extract($_POST);
  if( !isset($_SESSION['cart']['customer']['token']) ){ //verifie s'il n'y a pas déja un client lié au panier
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Aucun client lié à ce panier.";
  }else{
    //Ajoute les infos du client au panier
    $retour['cart']['customer']['name'] =  "AUCUN CLIENT";

    unset( $_SESSION['cart']['customer'] );
    // unset( $_SESSION['cart']['name'] );

    if( !isset( $_SESSION['cart'] ) || empty($_SESSION['cart']) ){
      unset( $_SESSION['cart'] );
    }

    $retour['cart']['customer']['action_html'] = '<a class="header-cart-add-customer add-pusher" 
        title="ajouter un client"> 
        <i class="fa fa-user-plus"></i> 
    </a>';

    $error_text = "Le Client a été rétiré du panier.";
    $error_text_second = "";

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

