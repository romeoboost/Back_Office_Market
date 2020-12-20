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
     !isset($sexe) || !isset($type) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = 'Aucun Champs ne doit manquer';
    //debugger($_POST);
  }else{
    if( empty($nom_client) || empty($prenoms_client) || empty($tel) || strlen($sexe) == 0 || strlen($type) == 0 )
    {
      $error_statut = true;
      $error_text = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //Note : les inputs radio avec valeur = 0 sont considérer comme vide, mieux vaut mettre des lettres
      //debugger($sexe);
    }else{
      // debugger($_POST);
        
      /////////Verfier si le numero existe déjà
      $client_sql_cond = " tel = :tel ";
      $sql_array_execute = array(':tel' => $tel);
      if( !empty( $email ) ){
        $email = strtolower( trim( $email ) );
        $client_sql_cond .= " OR email = :email ";
        $sql_array_execute = array(':tel' => $tel, ':email' => $email);
      }

      //debugger($client_sql_cond, $sql_array_execute);
      //verifie si le numero tel et lemail n'est pas dejà utilisé en base
      $req_recup = $pdo->prepare('SELECT * FROM clients WHERE '.$client_sql_cond.' ORDER BY id DESC LIMIT 0,1'); 
      $req_recup->execute($sql_array_execute);
      $client = current($req_recup->fetchAll(PDO::FETCH_OBJ));
      // debugger($client);
      if (!empty($client)) {
        $error_statut = true;
        if($client->tel == $tel){ $error_text = 'Le numero de téléphone est déjà utilisé.'; $error_text_second  ='';}
        if($client->email == $email){ $error_text = "L'adresse email est déjà utilisée."; $error_text_second  ='';}
      }else{   
      // debugger($_POST);
      $req = $pdo->prepare('SELECT COUNT(id) as nbre FROM clients '); 
      $req->execute(array());
      $Mbre_actuel_Obj = current($req->fetchAll(PDO::FETCH_OBJ));
      $Nbre_Mbre_Actuel = $Mbre_actuel_Obj->nbre; // le nombe actuel des clients

      // $Identifiant .= $Abreviation_Pays;
      $Identifiant = getMemberNumber($Nbre_Mbre_Actuel, 'CS');
      //debugger($Identifiant);

      // $encrypt_password = md5($password);
      $statut = 1;
      $solde = 0;
      $date = date("Y-m-d H:i:s");
      $id_sexe = intval( trim($sexe) );
      $type = intval( trim($type) );
      // $id_sexe = ($sexe === 'M') ? 1 : 0;
      
      // debugger($Identifiant);
      $req_insert = $pdo->prepare('INSERT INTO clients (token, nom, prenoms, email, tel, type_client, solde_avant, solde_apres, date_creation, 
                                                  date_modification, sexe, statut)
                                  VALUES(:token, :nom, :prenoms, :email, :tel, :type_client, :solde_avant, :solde_apres, :date_creation, :date_modification,
                                    :sexe, :statut)');
      
      $req_insert->execute(array(
              'token' => $Identifiant,
              'nom' => $nom_client,
              'prenoms' => $prenoms_client,
              'email' => $email,
              'tel' => $tel,
              'type_client' => $type,
              'solde_avant' => $solde,
              'solde_apres' => $solde,
              'date_creation' => $date,
              'date_modification' => $date,
              'sexe' => $id_sexe,
              'statut' => $statut
          ));

      $retour['linkToList'] = SITE_BASE_URL.'clients/liste';
      $error_text = 'Le Client a été ajouté avec succès.';
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



