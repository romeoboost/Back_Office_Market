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

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page';
}else{
  //debugger($_POST);
  extract($_POST);
  if( !isset($cmd_id) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = "Oups, Erreur !";
    $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
    //debugger($_POST);
  }else{
    if( empty($cmd_id) )
    {
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //debugger($register_sexe);
    }else{
      // $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;
      
      //On recupere le livreur concerné
      $cmd_id = trim($cmd_id);
      $dest_sql_text="SELECT rapide_commandes.montant_ht AS montant_ht, 
                livreurs.id as id_livreur, livreurs.nom as nom, livreurs.prenoms as prenoms
              FROM rapide_commandes
              INNER JOIN livreurs ON rapide_commandes.id_livreur=livreurs.id WHERE rapide_commandes.token = :token ";

      $dest_sql = $pdo->prepare($dest_sql_text);
      $dest_sql->execute( array(':token' => $cmd_id) );
      $livreur = current($dest_sql->fetchAll(PDO::FETCH_OBJ));
      //debugger( $commande );
      //On defini dans la session la destination de livraison
      $retour['nom_livreur'] = strtoupper( $livreur->nom ).' ('.ucfirst( explode( ' ',$livreur->prenoms )[0] ).')' ;
      $retour['id_livreur'] = intval( $livreur->id_livreur );
      
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





