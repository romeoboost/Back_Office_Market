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
  //old_password ; new_password et confirm_new_password
  //verifier si les champs existe
  if( !isset($old_password) || !isset($new_password) || !isset($confirm_new_password) || !isset($_SESSION['user']['token']) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text_second = 'Aucun Champs ne doit manquer';
    //debugger($_POST);
  }else{
    //verifier si les champs obligatoires ne sont pas vides
    if( empty($old_password) || empty($new_password) || empty($confirm_new_password) || empty($_SESSION['user']['token']) ) //verifie si les champs obligatoires sont pas vides
    {
      $error_statut = true;
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      
    }else{
        
        $old_password = trim($old_password);
        $new_password = trim($new_password);
        $confirm_new_password = trim($confirm_new_password);

        //Verifier si les champs new_password et confirm_new_password contiennent les mêmes valeurs
        if( $new_password !== $confirm_new_password ){
          $error_statut = true;
          $error_text_second = 'Le nouveau mot de passe et la confirmation doivent être identiques.';
        }else{
          $md5_old_password = md5($old_password);
          $req_recup = $pdo->prepare('SELECT * FROM clients WHERE token = :token ORDER BY id DESC'); 
          $req_recup->execute( array( ':token' => $_SESSION['user']['token'] ) );
          $clients = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

          //verifier si l'ancien mot de passe est correct
          //debugger($clients->password, $md5_old_password);
          if($clients->password !== $md5_old_password){
            $error_statut = true;
            $error_text_second = "L'ancien mot de passe que vous avez saisi n'est pas correct.";
          }else{
            $date = date("Y-m-d H:i:s");
            $md5_new_password = md5($new_password);
            $update_req = $pdo->prepare("UPDATE clients SET password = :password, date_modification = :date_modification
                                                   WHERE token = :token "); 
            $update_req->execute( array( 
                                    ':password' => $md5_new_password,
                                    ':date_modification' => $date,
                                    ':token' => $_SESSION['user']['token']
                                    ) 
                                  );  

            $enregistrement = 'oui';
            $retour['enregistrement'] = $enregistrement;

            $error_text = ' Succes ! ';
            $error_text_second = ' Mise à jour effectuée. ';

          }
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



