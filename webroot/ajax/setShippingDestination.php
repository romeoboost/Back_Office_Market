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

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page';
}else{
  //debugger($_POST);
  extract($_POST);
  if( !isset($tokenDestination) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = "Oups, Erreur !";
    $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
    //debugger($_POST);
  }else{
    if( empty($tokenDestination) )
    {
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //debugger($register_sexe);
    }else{
      //On recupere la destination par defaut
      $dest_sql_text="SELECT token,commune,frais FROM livraison_destinations WHERE token =:token ";
      $dest_sql = $pdo->prepare($dest_sql_text);
      $dest_sql->execute( array(':token' => $tokenDestination) );
      $destination = current($dest_sql->fetchAll(PDO::FETCH_OBJ));

      //On defini dans la session la destination de livraison
      $_SESSION['cart']['shipping_dest']['token'] = $destination->token;
      $_SESSION['cart']['shipping_dest']['commune'] = $destination->commune;
      $_SESSION['cart']['shipping_dest']['frais'] = $destination->frais;
      
    }
  }
  
}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

$retour['error_text'] = $error_text;
$retour['error_text_second'] = $error_text_second;

$retour['error'] = 'non';
$retour['error_html'] = '';

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    //$retour['error_html'] = $error_html;
    $retour['field_error'] = $field_error;
    header('Operation echouée', true, 400);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;


// <div class="alert alert-warning alert-dismissible fade show" role="alert">
//   <strong>Holy guacamole!</strong> You should check in on some of those fields below.
//   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
// </div>

// CL20180300033
  // structure numero de membre
  // AM AAAA MM NUMERO CI
  //EX : AM20180300001CI


/*
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
#membre#

id
nom
prenom
date_naissance
id_pays
id_metier
email
tel
password
date_creation
date_modification
statut
id_user
carte_membre
photo
numero_membre
id_poste

------------------------------------------------

#paiement#
id
id_membre
order_id
jwt
currency
transaction_amount
statut_id
transaction_id
paid_transaction_amount
paid_currency
change_rate
onflictual_transaction_amount
conflictual_currency
wallet
*/



/*
[operation_token] => hgdsttdf-b845-78c9-4hg7-74mpoef114ui
    [order] => 
    [jwt] => 
    [currency] => XOF
    [transaction_amount] =>

*/




