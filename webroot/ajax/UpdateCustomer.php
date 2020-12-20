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
$error_text_second  ='';

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = 'Veuillez remplir correctement le formulaire';
}else{
  //debugger($_POST);
  extract($_POST);
  //nom_client=jjjjj&prenoms_client=jjjj&tel=jjjjj&email=jjjjj&sexe=1&type=1

  if(!isset($nom_client) || !isset($prenoms_client) || !isset($tel) || !isset($email) || 
     !isset($sexe) || !isset($type) || !isset($token) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = 'Aucun Champs ne doit manquer';
    //debugger($_POST);
  }else{
    if( empty($token) || empty($nom_client) || empty($prenoms_client) || empty($tel) || strlen($sexe) == 0 || strlen($type) == 0 )
    {
      $error_statut = true;
      $error_text = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //Note : les inputs radio avec valeur = 0 sont considérer comme vide, mieux vaut mettre des lettres
      //debugger($sexe);
    }else{
      // debugger($_POST);
      $email = strtolower( trim( $email ) );
      $token = strtolower( trim( $token ) );
      if( empty($email) ){
        $req_recup = $pdo->prepare('SELECT * FROM clients WHERE tel = :tel AND token != :token ORDER BY id DESC LIMIT 0,1'); 
        $req_recup->execute( array(':tel' => $tel, ':token' => $token ) );
      }else{
        $req_recup = $pdo->prepare('SELECT * FROM clients WHERE (tel = :tel or email=:email) AND token != :token ORDER BY id DESC LIMIT 0,1'); 
        $req_recup->execute( array(':tel' => $tel, ':email' => $email, ':token' => $token ) );
      }
      $client = current($req_recup->fetchAll(PDO::FETCH_OBJ));
      // debugger($_POST);

      if (!empty($client)) {
        $error_statut = true;
        if($client->tel == $tel){ $error_text = 'Le numero de téléphone est déjà utilisé.'; $error_text_second  ='';}
        if($client->email == $email){ $error_text = "L'adresse email est déjà utilisée."; $error_text_second  ='';}
      }else{   
        // debugger($_POST);
        //debugger($Identifiant);

        // $encrypt_password = md5($password);
        $statut = 1;
        $solde = 0;
        $date = date("Y-m-d H:i:s");
        $id_sexe = intval( trim($sexe) );
        $type = intval( trim($type) );
        // $id_sexe = ($sexe === 'M') ? 1 : 0;
        
        $update_req = $pdo->prepare("UPDATE clients SET sexe = :sexe, nom = :nom, prenoms = :prenoms, email = :email,
            tel = :tel, type_client = :type_client, date_modification = :date_modification
            WHERE token = :token ");

        $update_req->execute( array( 
              'token' => $token,
              'nom' => $nom_client,
              'prenoms' => $prenoms_client,
              'email' => $email,
              'tel' => $tel,
              'type_client' => $type,
              'date_modification' => $date,
              'sexe' => $id_sexe
            ) 
          );
        
        $retour['linkToList'] = SITE_BASE_URL.'clients/liste';
        $error_text = 'Les informations du Client ont été modifiées avec succès.';
        $error_text_second = '';        

        
      }

      
    }
  }
  
}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

$retour['error'] = 'non';
$retour['error_html'] = '';

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
    $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;



