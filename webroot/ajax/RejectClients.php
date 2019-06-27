<?php
include 'connectDB.php';
include 'fonction.php';

if (empty(session_id())) {
    session_start();
    //$_SESSION['menu'] = 'Nous_Rejoindre';
}
// debugger($_POST);
$error_statut = false;
$error_text = '';
$error_text_second = '';
$field_error ='none';
$retour = array();

//verifier si tous les parametres existent
if( !isset($_POST) || empty($_POST) || !isset($_POST['client_id']) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page.';
}else{
  //debugger($_POST);
  extract($_POST);

  //verifier si tous les parametres obligatoires ne sont pas vides
  if( empty($client_id) ){ //verifie si le produit existe dans le panier
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec du rejet du client.";
  }else{

    //recuperation du client en base
    $client_id = trim($client_id);
    $req_recup = $pdo->prepare('SELECT * FROM clients WHERE token = :token ORDER BY id DESC'); 
    $req_recup->execute( array( ':token' => $client_id ) );
    $client = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

    // Verifie si la client existe bien en base
    if( empty($client) ){ 
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec de desactivation du client.";
    }else{

      //Verifie que le statut du client est bien actif
      if( $client->statut != 1 ){
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "Ce client ne peut être annulée.";
      }else{
        //debugger($client);
        $date = date("Y-m-d H:i:s");
        $statut = 0;
        $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;

        //Modifie le statut du client
        $update_req = $pdo->prepare("UPDATE clients SET statut = :statut,
                                     date_modification = :date_modification WHERE token = :token "); 
        $update_req->execute( array( 
                                ':statut' => $statut,
                                ':date_modification' => $date,
                                ':token' => $client_id
                                ) 
                              );  

        $retour['client_id'] = $client_id;

        $enregistrement = 'oui';
        $retour['enregistrement'] = $enregistrement;

        $error_text = ' Succes ! ';
        $error_text_second = "Le client $client_id a été desactivé. ";

      }            
    }
  }
  //debugger($_SESSION['cart']['products_list']);

}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

$retour['error'] = 'non';

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





