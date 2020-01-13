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
if( !isset($_POST) || empty($_POST) || !isset($_POST['cmd_id']) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page.';
}else{
  // debugger($_POST);
  extract($_POST);

  //verifier si tous les parametres obligatoires ne sont pas vides
  if( empty($cmd_id) ){ //verifie si le produit existe dans le panier
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec de la confirmation de livraison de la commande.";
  }else{

    //recuperation de la commande en base
    $cmd_id = trim($cmd_id);
    $req_recup = $pdo->prepare('SELECT * FROM rapide_commandes WHERE token = :token ORDER BY id DESC'); 
    $req_recup->execute( array( ':token' => $cmd_id ) );
    $commande = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

    // Verifie si la commande existe bien en base
    if( empty($commande) ){ 
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec de la confirmation de livraison de la commande. Commande inexistante.";
    }else{

      //Verifie que le statut de la commande est bien à en attente (0 )
      if( $commande->statut != 3 ){
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "Cette commande ne peut être modifiée. Statut incorrect.";
      }else{

          $date = date("Y-m-d H:i:s");
          $statut = 1;
          $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;

          //Modifie le statut de la commande
          $update_req = $pdo->prepare("UPDATE rapide_commandes SET statut = :statut, id_utilisateur = :id_utilisateur, date_modification = :date_modification, date_livraison = :date_livraison
                                                 WHERE token = :token "); 
          $update_req->execute( array( 
                                  ':statut' => $statut,
                                  ':id_utilisateur' => $id_bo_user,
                                  ':date_modification' => $date,
                                  ':date_livraison' => $date,
                                  ':token' => $cmd_id
                                  ) 
                                );

          $retour['cmd_id'] = $cmd_id;

          $enregistrement = 'oui';
          $retour['enregistrement'] = $enregistrement;

          $error_text = ' Succes ! ';
          $error_text_second = "La commande $cmd_id a été livrée.";

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




