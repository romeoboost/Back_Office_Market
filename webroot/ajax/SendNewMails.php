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
  // debugger($_POST); //to=test%40test.com&Subject=GGG&message=TYKFXZYJULIMNUIK
  extract($_POST);
  if(!isset($to) || !isset($Subject) || !isset($message) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = 'Aucun Champs ne doit manquer';
    $field_error ='none';
    //debugger($_POST);
  }else{
    if( empty($to) || empty($Subject) || empty($message) )
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

      $date = date("Y-m-d H:i:s");
      // debugger($_POST);
      $isSent = send_mail($to, $Subject, $message);
      if( $isSent === true ){
        $retour['enregistrement'] = 'oui';
        $retour['error_text'] = 'Votre mail a été envoyé avec succès.';
        $retour['error_text_second'] = 'Nous vous repondrons dans peu de temps. Merci de nous faire confiance.';
        $retour['linkToList'] = SITE_BASE_URL.'mails/liste';
      }else{
        $error_statut = true;
        $error_text = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
        // debugger($isSent);
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

