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
$field_error ='none';
$retour = array();
$retour['enregistrement'] = 'non';

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = 'Veuillez remplir correctement le formulaire';
  $field_error ='none';
}else{
  // debugger($_POST); //to=test%40test.com&Subject=GGG&message=TYKFXZYJULIMNUIK&token=MSG201901002MKT&admin_id=1
  extract($_POST);
  if(!isset($to) || !isset($Subject) || !isset($message) || !isset($token) || !isset($admin_id) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = 'Aucun Champs ne doit manquer';
    $field_error ='none';
    //debugger($_POST);
  }else{
    if( empty($to) || empty($Subject) || empty($message) || empty($token) || empty($admin_id) )
    {
      $error_statut = true;
      $error_text = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //Note : les inputs radio avec valeur = 0 sont considérer comme vide, mieux vaut mettre des lettres
      //debugger($register_sexe);
    }else{
      // debugger($_POST);
      /*on retire les espaces en trop*/
      $to = trim($to);
      $Subject = trim($Subject);
      $message = trim($message);
      $token = trim($token);
      $admin_id = intval($admin_id);

      //verifie si le mail existe
      $req_recup = $pdo->prepare('SELECT * FROM messages WHERE token = :token ORDER BY id DESC'); 
      $req_recup->execute( array( ':token' => $token ) );
      $element = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

      if( empty($element) ){
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "Echec de reponse au mail. Ce mail n'existe pas en base. ";
      }else{

        //pousse le mail
        $isSent = send_mail($to, $Subject, $message);
        if( $isSent !== true ){
          $error_statut = true;
          $error_text = "Echec de reponse au mail. Ce mail n'existe pas en base.";
          $error_text_second = "Echec de reponse au mail. Ce mail n'existe pas en base. ";
        }else{
          $date = date("Y-m-d H:i:s");

          //Update en base
          $req_prepare['fields'] = array( 'date_modification', 'id_admin_reponse', 'reponse_admin_contenu', 'date_reponse', 'statut', 'email',
          'objet' );
          $req_prepare['values'] = array(
                              'date_modification' => $date,
                              'id_admin_reponse' => $admin_id,
                              'reponse_admin_contenu' => $message,
                              'date_reponse' => $date,
                              'statut' => 1,
                              'email' => $to,
                              'objet' => $Subject
                          );
          $req_prepare['condition'] = 'token = :token';
          $req_prepare['values']['token'] = $token;
          update($pdo, $req_prepare, 'messages');

          $retour['enregistrement'] = 'oui';
          $retour['error_text'] = 'Votre mail a été envoyé avec succès.';
          $retour['linkToList'] = SITE_BASE_URL.'mails/liste/'.$token;
          // debugger($isSent);

          //met a jour la ligne en base

        }
      }
 
    }
  }
  
}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

$retour['error'] = 'non';
$retour['error_html'] = '';

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

