<?php
include 'connectDB.php';
include 'fonction.php';
define('WEBROOT_URL', 'http://localhost/Market/webroot/');
define('SITE_BASE_URL', 'http://localhost/Market/');
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
  //debugger($_POST);
  extract($_POST);
  if( !isset($_SESSION['cart']['products_list'][$tokenProduit]) ){ //verifie si le produit existe dans le panier
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec de suppression du produit du panier.";
  }else{
    if( !isset($_SESSION['cart']['products_list'][$tokenProduit]) || 
        !isset($_SESSION['cart']['products_list'][$tokenProduit]['qtite_cart']) || 
        !isset($_SESSION['cart']['products_list'][$tokenProduit]['price_cart']) || 
        !isset($_SESSION['cart']['total_amount']) || 
        !isset($_SESSION['cart']['total_nbre']) ){ // verifie si tous les elements st dans la session panier

      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "ECHEC de suppression du produit du panier.";

    }else{
      if( intval($_SESSION['cart']['products_list'][$tokenProduit]['qtite_cart']) <= 0 || 
          intval($_SESSION['cart']['products_list'][$tokenProduit]['price_cart']) <= 0 || 
          intval($_SESSION['cart']['total_amount']) <= 0 || 
          intval($_SESSION['cart']['total_nbre']) <= 0 ){

        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "ECHEC de suppression du produit du panier.";
      }else{
        $Iscartempty=false;
        // modifier le nombre total de produits dans le panier
        // modifier le total du montant du panier
        $_SESSION['cart']['total_nbre'] -= $_SESSION['cart']['products_list'][$tokenProduit]['qtite_cart'];
        $_SESSION['cart']['total_amount'] -= $_SESSION['cart']['products_list'][$tokenProduit]['price_cart'];

        //$error_statut = false;
        $error_text = "Le Produit ".$_SESSION['cart']['products_list'][$tokenProduit]['nom']." a été supprimé du panier.";
        $error_text_second = "";

        unset( $_SESSION['cart']['products_list'][$tokenProduit] ); // suppresion du produit du panier

        $retour['cart']['total_amount'] = $_SESSION['cart']['total_amount'];
        $retour['cart']['total_nbre'] = $_SESSION['cart']['total_nbre']; 

        if( intval($_SESSION['cart']['total_amount']) <= 0 || 
            intval($_SESSION['cart']['total_nbre']) <= 0 ){ // le montant ou le nombre total du panier est 0

          $Iscartempty=true;
          unset( $_SESSION['cart'] ); // on vide le panier
        }

        $retour['cart']['IsEmpty'] = $Iscartempty;
      }
      
    }
  }
  //debugger($_SESSION['cart']['products_list']);

}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

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


// <div class="alert alert-warning alert-dismissible fade show" role="alert">
//   <strong>Holy guacamole!</strong> You should check in on some of those fields below.
//   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
// </div>




