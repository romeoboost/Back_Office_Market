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

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = 'Veuillez remplir correctement le formulaire';
}else{
  // debugger($_POST);
  extract($_POST);
  if(!isset($register_cond) || !isset($register_nom) || !isset($register_prenom) || !isset($register_tel) || !isset($register_email) || 
     !isset($register_password) || !isset($register_confirm_password) || !isset($register_sexe)) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = 'Aucun Champs ne doit manquer';
    if(!isset($register_cond)){ $error_text = 'Veuillez accepter les conditions générales'; $field_error ='none';}
    if(!isset($register_sexe)){ $error_text = 'Veuillez choisir votre sexe'; $field_error ='none'; }
    //debugger($_POST);
  }else{
    if( empty($register_cond) || empty($register_nom) || empty($register_prenom)  || empty($register_tel) || 
       empty($register_password) || empty($register_confirm_password) || empty($register_sexe) )
    {
      $error_statut = true;
      $error_text = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //Note : les inputs radio avec valeur = 0 sont considérer comme vide, mieux vaut mettre des lettres
      //debugger($register_sexe);
    }else{
      //debugger($_POST);
      $register_password = strtolower($register_password);
      $register_confirm_password = strtolower($register_confirm_password);

      if($register_password !== $register_confirm_password){ // Est ce que le password et sa confirmation sont identiques
        $error_statut = true;
        $error_text = 'La confirmation du mot de passe est incorrecte.';
        $field_error ='register_password';
      }else{
        //echo ' <pre>';print_r($_POST);echo '</pre>';
        
        /////////Verfier si le numero existe déjà
        //verifie si le numero tel et lemail n'est pas dejà utilisé en base
        $register_email = strtolower($register_email);
        $req_recup = $pdo->prepare('SELECT * FROM clients WHERE tel = :tel or email=:email ORDER BY id DESC LIMIT 0,1'); 
        $req_recup->execute(array(':tel' => $register_tel, ':email' => $register_email));
        $client = current($req_recup->fetchAll(PDO::FETCH_OBJ));
        //debugger($client);
        if (!empty($client)) {
          $error_statut = true;
          if($client->tel == $register_tel){ $error_text = 'Le numero de téléphone est déjà utilisé.'; $field_error ='register_tel';}
          if($client->email == $register_email){ $error_text = "L'adresse email est déjà utilisé."; $field_error ='register_email';}
        }else{   

        $req = $pdo->prepare('SELECT COUNT(id) as nbre FROM clients '); 
        $req->execute(array());
        $Mbre_actuel_Obj = current($req->fetchAll(PDO::FETCH_OBJ));
        $Nbre_Mbre_Actuel = $Mbre_actuel_Obj->nbre; // le nombe actuel des clients

       // $Identifiant .= $Abreviation_Pays;
        $Identifiant = getMemberNumber($Nbre_Mbre_Actuel, 'MKT');
        //debugger($Identifiant);

        $encrypt_password = md5($register_password);
        $statut = 1;
        $date = date("Y-m-d H:i:s");
        $email = (empty($register_email)) ? ' ' : $register_email;
        $id_sexe = ($register_sexe === 'M') ? 1 : 0;

        $req_insert = $pdo->prepare('INSERT INTO clients (token, nom, prenoms, email, tel, password, date_creation, 
                                                   date_modification, sexe, statut)
                                    VALUES(:token, :nom, :prenoms, :email, :tel, :password, :date_creation, :date_modification,
                                     :sexe, :statut)');
       
        $req_insert->execute(array(
                'token' => $Identifiant,
                'nom' => $register_nom,
                'prenoms' => $register_prenom,
                'email' => $email,
                'tel' => $register_tel,
                'password' => $encrypt_password,
                'date_creation' => $date,
                'date_modification' => $date,
                'sexe' => $id_sexe,
                'statut' => $statut
            ));

        $enregistrement = 'oui';
        $retour['enregistrement'] = $enregistrement;
        //debugger($enregistrement);
        //recupere la ligne qu'on vient d'insérée
        $req_recup = $pdo->prepare('SELECT * FROM clients WHERE token = :token ORDER BY id DESC LIMIT 0,1'); 
        $req_recup->execute(array(':token' => $Identifiant));
        $client = current($req_recup->fetchAll(PDO::FETCH_OBJ));

        //debugger($client);

        $_SESSION['user']['id'] = $client->id;
        $_SESSION['user']['token'] = $client->token;
        $_SESSION['user']['nom'] = $client->nom;
        $_SESSION['user']['prenoms'] = $client->prenoms;
        $_SESSION['user']['email'] = $client->email;
        $_SESSION['user']['tel'] = $client->tel;
        $_SESSION['user']['date_creation'] = $client->date_creation;
        $_SESSION['user']['statut'] = $client->statut;

        $retour['connected'] = 'oui';        

          
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
                    <div class="col-sm-12 alert alert-danger alert-dismissible " role="alert">
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



