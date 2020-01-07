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

//cmd_id=CMD2019050031MKT&password=dgtgtf

//verifier si tous les parametres existent
if( !isset($_POST) || empty($_POST) || !isset($_POST['cmd_id']) || !isset($_POST['password']) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page.';
}else{
  //debugger($_SESSION['bo_user']['tel']);
  extract($_POST);

  //verifier si tous les parametres obligatoires ne sont pas vides
  if( empty($cmd_id) || empty($password) ){ //verifie si le produit existe dans le panier
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec de suppression de la commande. Aucun champs ne doit être vide.";
  }else{

    $cmd_id = trim($cmd_id);
    $password = md5($password);
    $username = trim($_SESSION['bo_user']['tel']);

    //recuperation des info du user back office
    $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE tel =:tel AND password =:password"); //
    $req->execute(array(':tel' => $username, ':password' => $password));
    $client = current($req->fetchAll(PDO::FETCH_OBJ));
    //Verifie si mot de passe correct.
    if (empty($client)) {
        if(isset($_SESSION['user'])){ unset($_SESSION['user']); }
        $error_statut = true;
        $error_text = 'Le mot de passe est incorrect. Veuillez reessayer.'; //, réessayez avec les acces corrects
    } else {

      //debugger($_SESSION['bo_user']['tel']);
      $req_recup = $pdo->prepare('SELECT * FROM rapide_commandes WHERE token = :token ORDER BY id DESC'); 
      $req_recup->execute( array( ':token' => $cmd_id ) );
      $commande = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

      // Verifie si la commande existe bien en base
      if( empty($commande) ){ 
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "Echec de suppression de la commande.";
      }else{

        //Verifie si le statut de la commande est en cours de livraison ou en attente
        if( $commande->statut == 0 || $commande->statut == 3 ){

          $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;

          //Supprime le statut de la commande
          $update_req = $pdo->prepare("DELETE FROM rapide_commandes WHERE token = :token "); 
          $update_req->execute( array( ':token' => $cmd_id ) );  
          
          $retour['cmd_id'] = $cmd_id;

          $enregistrement = 'oui';
          $retour['enregistrement'] = $enregistrement;

          $error_text = ' Succes ! ';
          $error_text_second = "La commande $cmd_id a été supprimée. ";

        }else{
          $error_statut = true;
          $error_text = "Oups, Erreur !";
          $error_text_second = "Echec de suppression de la commande. Statut non conforme.";
        }
                        
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


// <div class="alert alert-warning alert-dismissible fade show" role="alert">
//   <strong>Holy guacamole!</strong> You should check in on some of those fields below.
//   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
// </div>




