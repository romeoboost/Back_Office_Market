<?php
include 'connectDB.php';
include 'fonction.php';
// if (empty(session_id())) {
//     session_start();
//     $_SESSION['menu'] = 'Marche';
// }
setlocale(LC_TIME, "fr_FR", "French");
$error_statut = false;
$error_text = '';
$error_html = '';
$retour = array();
$result = array();
$conditions_prepare=array();

//sleep(5);

if(!isset($_POST) || empty($_POST) ){ //verifie si post envoyé et non vide
  $error_statut = true;
  $error_text = 'Une erreur s\'est produite veuillez reessayer plus tard.' ;
  $field_error ='none';
}else{
    extract($_POST);
  if( !isset( $verif ) ) //verifie si variable envoyée
  {
    $error_statut = true;
    $error_text = 'Une erreur s\'est produite, veuillez reessayer plus tard sans modifier le Document HTML.';
    $field_error ='none';
    //debugger($_POST);
  }else{
    //recupère nombre de clients
    $req = $pdo->prepare(" SELECT COUNT(*) as nbre FROM clients "); //':email' => $user_login,
    $req->execute();
    $clients = current($req->fetchAll(PDO::FETCH_OBJ));
    $result['total_nbre_customers'] = (int)$clients->nbre;

    //recupère nombre de clients avec commandes
    $req_two = $pdo->prepare(" SELECT DISTINCT id_client FROM commandes ");
    $req_two->execute();
    $clients_with_order = count ( $req_two->fetchAll(PDO::FETCH_OBJ) ) ;
    $result['total_nbre_customers_with_order'] = (int)$clients_with_order;

    //determine nombre de clients sans comandes
    $result['total_nbre_customers_without_order'] = $result['total_nbre_customers'] - $result['total_nbre_customers_with_order'];

  }
}


$retour['result']=$result;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible text-align-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;

//echo 'OK';    
//echo ' <pre>'.print_r($_POST).'</pre>';
//echo ' <pre>';print_r($matiere);echo '</pre>';







