<?php
include 'connectDB.php';
include 'fonction.php';
if (empty(session_id())) {
    session_start();
    //$_SESSION['menu'] = 'Nous_Rejoindre';
}

//debugger($_SESSION);
$error_statut = false;
$error_text = '';
$field_error ='none';
$retour = array();
$retour['enregistrement'] = 'non';
$error_text = "Oups, Erreur !";

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
}else{
  // debugger($_POST);
  extract($_POST);
  //verifier si les champs existe
  if( !isset($cmd_id) || !isset($livreur) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text_second = 'Aucun Champs ne doit manquer';
    // debugger($_POST);
  }else{
    //verifier si les champs obligatoires ne sont pas vides
    if( empty($cmd_id) || empty($livreur)  ) //verifie si les champs obligatoires sont pas vides
    {
      $error_statut = true;
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      
    }else{
        
        $cmd_id = trim($cmd_id);
        $livreur = intval($livreur);

        $req_recup = $pdo->prepare('SELECT * FROM rapide_commandes WHERE token = :token ORDER BY id DESC'); 
        $req_recup->execute( array( ':token' => $cmd_id ) );
        $commande = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

        //verifie si le statut de la commande est vraiment en attente
        if( $commande->statut != 3 ){
          $error_statut = true;
          $error_text_second = 'La commande doit avoir le statut " EN ATTENTE " ';

        }else{

          //debugger($commande);
          //Mise à jour du statut de la commande
          $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;
          $date = date("Y-m-d H:i:s");
          $statut = 0;
          //Modifie le statut de la commande
          $update_req = $pdo->prepare("UPDATE rapide_commandes SET statut = :statut, id_livreur = :id_livreur, date_modification = :date_modification, id_utilisateur = :id_utilisateur
                                                 WHERE token = :token "); 
          $update_req->execute( array( 
                                  ':statut' => $statut,
                                  ':id_livreur' => $livreur,
                                  ':id_utilisateur' => $id_bo_user,
                                  ':date_modification' => $date,
                                  ':token' => $cmd_id
                                  ) 
                                );
          $btn_rejected_html = '<button type="button" class="btn btn-icon-toggle set-shipping-btn" data-toggle="tooltip" 
                                data-placement="top" data-original-title="Livrer" cmd-id="'.$cmd_id.'">
                                                              <i class="md md-local-shipping"></i>
                                                          </button>';
          $retour['cmd_id'] = $cmd_id;
          $retour['btn_rejected_html'] = $btn_rejected_html;
          $error_text = ' Succes ! ';
          $error_text_second = "La mise à jour de la commande $cmd_id a été éffectuée. " ;
        }
    }
  }
  
}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

$retour['error_text'] = $error_text;
$retour['error_text_second'] = $error_text_second;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text . '</span><br> 
                        <span class="">' . $error_text_second . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;



