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
  // debugger($_POST);
  extract($_POST);
  if(!isset($userT) || !isset($your_name) || !isset($your_email) || !isset($your_subject) || !isset($your_message) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = 'Aucun Champs ne doit manquer';
    $field_error ='none';
    //debugger($_POST);
  }else{
    if( empty($userT) || empty($your_name) || empty($your_email)  || empty($your_message) )
    {
      $error_statut = true;
      $error_text = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //Note : les inputs radio avec valeur = 0 sont considérer comme vide, mieux vaut mettre des lettres
      //debugger($register_sexe);
    }else{
      //debugger($_POST);
      /*on retire les espaces en trop*/
      $userT = trim($userT);
      $your_name = trim($your_name);
      $your_email = trim($your_email);
      $your_message = trim($your_message);
      $your_subject = empty($your_subject) ? ' ' : trim($your_subject);

      $user_id=0; //on donne l'ide par defaut pour les non utilisateurs
      $req_recup = $pdo->prepare('SELECT id FROM clients WHERE token = :token'); 
      $req_recup->execute(array(':token' => $userT));
      $client = current($req_recup->fetchAll(PDO::FETCH_OBJ)); // on recupere l'id du user en cours
      if(!empty($client)){ // verifie si le user existe
        $user_id = $client->id; 
      }

      $date = date("Y-m-d H:i:s");

      $req_insert = $pdo->prepare( 'INSERT INTO messages (id_client, nom_prenoms, email, objet, contenu, date_creation, date_modification)
                                    VALUES(:id_client, :nom_prenoms, :email, :objet, :contenu, :date_creation, :date_modification)' );
       
      $req_insert->execute(array(
                'id_client' => $user_id,
                'nom_prenoms' => $your_name,
                'email' => $your_email,
                'objet' => $your_subject,
                'contenu' => $your_message,
                'date_creation' => $date,
                'date_modification' => $date
           ));

      $retour['enregistrement'] = 'oui';
      $retour['error_text'] = 'Votre message a été envoyé avec succès.';
      $retour['error_text_second'] = 'Nous vous repondrons dans peu de temps. Merci de nous faire confiance.';
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

