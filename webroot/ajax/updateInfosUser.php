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
  if( !isset($sexe) || !isset($name) || !isset($lastname) || !isset($tel) || !isset($email) || !isset($_SESSION['user']['token']) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text_second = 'Aucun Champs ne doit manquer';
    if(!isset($sexe)){ $error_text_second = 'Veuillez choisir votre sexe'; $field_error ='none'; }
    //debugger($_POST);
  }else{
    if( empty($sexe) || empty($name) || empty($lastname)  || empty($tel) || empty($_SESSION['user']['token']) ) //verifie si les champs obligatoires sont pas vides
    {
      $error_statut = true;
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //Note : les inputs radio avec valeur = 0 sont considérer comme vide, mieux vaut mettre des lettres
      //debugger($register_sexe);
    }else{
        
        /////////Verfier si le numero existe déjà
        //verifie si le numero tel et lemail n'est pas dejà utilisé en base
        $tel = trim($tel);
        $email = trim($email);

        if( empty($email) ){
          $req_recup = $pdo->prepare('SELECT * FROM clients WHERE tel = :tel AND token != :token ORDER BY id DESC'); 
          $req_recup->execute(array(':tel' => $tel, ':token' => $_SESSION['user']['token']));
        }else{
          $req_recup = $pdo->prepare('SELECT * FROM clients WHERE (tel = :tel or email=:email) AND token != :token ORDER BY id DESC'); 
          $req_recup->execute(array(':tel' => $tel, ':email' => $email, ':token' => $_SESSION['user']['token']) );
        }
        $clients = $req_recup->fetchAll(PDO::FETCH_OBJ);
        //debugger($client);
        if (!empty($clients)) {
          $error_statut = true;
          foreach ($clients as $client) {            
            if($client->tel == $tel){ $error_text_second = 'Le numero de téléphone est déjà utilisé.'; $field_error ='tel';}
            if($client->email == $email){ $error_text_second = "L'adresse email est déjà utilisé."; $field_error ='email';}
          }

        }else{  

          $date = date("Y-m-d H:i:s");
          $email = ( empty($email) ) ? ' ' : $email;
          $id_sexe = ($sexe === 'M') ? 1 : 0;

          // //mise à a jour des données de lutilisateur
          $update_req = $pdo->prepare("UPDATE clients SET sexe = :sexe, nom = :nom, prenoms = :prenoms, email = :email,
                                        tel = :tel, date_modification = :date_modification
                                       WHERE token = :token "); 
          $update_req->execute( array( 
                                  ':sexe' => $id_sexe,
                                  ':nom' => trim($name),
                                  ':prenoms' => trim($lastname),
                                  ':email' => trim($email),
                                  ':tel' => trim($tel),
                                  ':date_modification' => $date,
                                  ':token' => $_SESSION['user']['token']
                                  ) 
                                );

          $enregistrement = 'oui';
          $retour['enregistrement'] = $enregistrement;
          //debugger($enregistrement);
          //recupere la ligne qu'on vient d'insérée
          $req_recup = $pdo->prepare('SELECT * FROM clients WHERE token = :token ORDER BY id DESC LIMIT 0,1'); 
          $req_recup->execute( array( ':token' => $_SESSION['user']['token'] ) );
          $user = current($req_recup->fetchAll(PDO::FETCH_OBJ));

          //debugger($client);

          $_SESSION['user']['id'] = $user->id;
          $_SESSION['user']['token'] = $user->token;
          $_SESSION['user']['nom'] = $user->nom;
          $_SESSION['user']['prenoms'] = $user->prenoms;
          $_SESSION['user']['email'] = $user->email;
          $_SESSION['user']['tel'] = $user->tel;
          $_SESSION['user']['date_creation'] = $user->date_creation;
          $_SESSION['user']['statut'] = $user->statut;

          $retour['connected'] = 'oui';

          $error_text = ' Succes ! ';
          $error_text_second = ' Mise à jour effectuée. ';     

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
                        <span class="">' . $error_text . '</span>
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



