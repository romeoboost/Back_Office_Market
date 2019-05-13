<?php
include 'connectDB.php';
include 'fonction.php';

if (empty(session_id())) {
    session_start();
    $_SESSION['menu'] = 'Nous_Rejoindre';
}

$error_statut = false;
$error_text = '';
$retour = array();
$retour['enregistrement'] = 'non';

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = 'Veuillez remplir correctement le formulaire';
}else{
  extract($_POST);
  if(!isset($first_name) || !isset($last_name) || !isset($tel) || !isset($email) || !isset($country) || 
     !isset($town) || !isset($work) || !isset($password) || !isset($confirm_password) || !isset($sexe)) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = 'Veuillez remplir correctement le formulaire';
  }else{
    if(empty($first_name) || empty($last_name) || empty($tel) || empty($country) || 
       empty($town) || empty($work) || empty($password) || empty($confirm_password) || empty($sexe))
    {
      $error_statut = true;
      $error_text = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
    }else{
      if($password !== $confirm_password){ // Est ce que le password et sa confirmation sont identiques
        $error_statut = true;
        $error_text = 'La confirmation du mot de passe est incorrecte.';

      }else{
        //echo ' <pre>';print_r($_POST);echo '</pre>';
        
        /////////Verfier si le numero existe déjà
        //verifie si le numero tel n'est pas dejà utilisé en base
        $req_recup = $pdo->prepare('SELECT * FROM membres WHERE tel = :tel ORDER BY id DESC LIMIT 0,1'); 
        $req_recup->execute(array(':tel' => $tel));
        $membre = current($req_recup->fetchAll(PDO::FETCH_OBJ));
        if (!empty($membre)) {
          $error_statut = true;
          $error_text = 'Le numero de téléphone est déjà utilisé.';
        }else{   

        $req = $pdo->prepare('SELECT COUNT(numero_membre) as nbre FROM membres '); 
        $req->execute(array());
        $Mbre_actuel_Obj = current($req->fetchAll(PDO::FETCH_OBJ));
        $Nbre_Mbre_Actuel = $Mbre_actuel_Obj->nbre; // le nombe actuel des membres

       // $Identifiant .= $Abreviation_Pays;
        $Identifiant = getMemberNumber($Nbre_Mbre_Actuel, 'CI');

        $id_user = 0;
        $carte_membre = 0;
        $photo = '';
        $encrypt_password = md5($password);
        $statut = 0;
        $id_poste = 6;
        $date = date("Y-m-d H:i:s");
        $country = intval($country);
        $work = intval($work);
        $email = (empty($email)) ? ' ' : $email;
        $id_sexe = ($sexe == 'M') ? 1 : 0;

        $req_insert = $pdo->prepare('INSERT INTO membres (nom, prenom, id_pays, ville, id_metier, email, tel, password, date_creation, 
                                                   date_modification, sexe, statut, id_profil, id_user, carte_membre, photo, numero_membre, id_poste)
                              VALUES(:nom, :prenoms, :id_pays, :ville, :id_metier, :email, :tel, :password, :date_creation, :date_modification,
                                     :sexe, :statut, :id_profil, :id_user, :carte_membre, :photo, :numero_membre, :id_poste)');
       
        $req_insert->execute(array(
                'nom' => $first_name,
                'prenoms' => $last_name,
                'id_pays' => $country,
                'ville' => $town,
                'id_metier' => $work,
                'email' => $email,
                'tel' => $tel,
                'password' => $encrypt_password,
                'date_creation' => $date,
                'date_modification' => $date,
                'sexe' => $id_sexe,
                'statut' => $statut,
                'id_profil' => 3,
                'id_user' => $id_user,
                'carte_membre' => $carte_membre,
                'photo' => $photo,
                'numero_membre' => $Identifiant,
                'id_poste' => $id_poste
            ));

        $enregistrement = 'oui';
        $retour['enregistrement'] = $enregistrement;
        //recupere la dernier ligne insérée
        $req_recup = $pdo->prepare('SELECT * FROM membres WHERE numero_membre = :numero_membre ORDER BY id DESC LIMIT 0,1'); 
        $req_recup->execute(array(':numero_membre' => $Identifiant));
        $membre = current($req_recup->fetchAll(PDO::FETCH_OBJ));

        
        $_SESSION['user']['id'] = $membre->id;
        $_SESSION['user']['numero_membre'] = $membre->numero_membre;
        $_SESSION['user']['nom'] = $membre->nom;
        $_SESSION['user']['prenom'] = $membre->prenom;
        $_SESSION['user']['id_pays'] = $membre->id_pays;
        $_SESSION['user']['ville'] = $membre->ville;
        $_SESSION['user']['id_metier'] = $membre->id_metier;
        $_SESSION['user']['email'] = $membre->email;
        $_SESSION['user']['tel'] = $membre->tel;
        $_SESSION['user']['date_creation'] = $membre->date_creation;
        $_SESSION['user']['statut'] = $membre->statut;
        $_SESSION['user']['id_profil'] = $membre->id_profil;
        $_SESSION['user']['carte_membre'] = $membre->carte_membre;
        $_SESSION['user']['id_poste'] = $membre->id_poste;

        //## NEW ##
        $req_recup = $pdo->prepare('SELECT * FROM parametres'); 
        $req_recup->execute(array());
        $params = current($req_recup->fetchAll(PDO::FETCH_OBJ));
        $params_auth = getPaymentParams($params->nom_marchand, $params->token_service_marchand); //renvoi le order, jwt, statut de la dispo gtw payment
        $statut_transac = ($params_auth['gtw_payment_available'] == 'oui') ? 10 : 0;
          //insert en bd tb paiements          
          $date = date("Y-m-d H:i:s");
          $req_insert = $pdo->prepare('INSERT INTO paiements (id_membre, order_id, transaction_amount, jwt, currency, statut_id, type, date_creation,
                                       date_modification)
                              VALUES(:id_membre, :order_id, :transaction_amount, :jwt, :currency, :statut_id, :type, :date_creation, :date_modification)');
       
          $req_insert->execute(array(
                'id_membre' => $membre->id,
                'order_id' => $params_auth['order'],
                'transaction_amount' => 6500,
                'jwt' => $params_auth['jwt'],
                'currency' => 'XOF',
                'statut_id' => $statut_transac,
                'type' => 1,
                'date_creation' => $date,
                'date_modification' => $date
          ));

          $date = date("Y-m-d H:i:s");
          $req_insert = $pdo->prepare('INSERT INTO logs_paiement (id_membre, corps, methode, date_creation)
                              VALUES(:id_membre, :corps, :methode, :date_creation)');       
          $req_insert->execute(array(
                'id_membre' => $membre->id,
                'corps' => $params_auth['response_error'],
                'methode' => $params_auth['order'],
                'date_creation' => $date
          ));

        if($params_auth['gtw_payment_available'] == 'oui'){
          //ajout du token operation au tablo @ 
          $params_auth['currency'] = 'XOF';
          $params_auth['operation_token'] = $params->token_operation_marchand;
          $params_auth['transaction_amount'] = 6500;
          $params_auth['html_body'] = getHtmlPaymentBody($params->token_operation_marchand, $params_auth['jwt'], $params_auth['order']);

        }else{
          
          $params_auth['html_body'] = getHtmlPaymentBodyError();

        }

        $params_init_pmt = $params_auth;
        $retour['params_init_pmt'] = $params_init_pmt;

        //echo 'OK INSERT <pre>';print_r($params_init_pmt);echo '</pre>';


          
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
                    <div class="col-sm-12 alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <span class="">' . $error_text . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    header('500 Internal server error', true, 500);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;



// CL20180300033
  // structure numero de membre
  // AM AAAA MM NUMERO CI
  //EX : AM20180300001CI
/*
#membre#

id
nom
prenom
date_naissance
id_pays
id_metier
email
tel
password
date_creation
date_modification
statut
id_user
carte_membre
photo
numero_membre
id_poste

------------------------------------------------

#paiement#
id
id_membre
order_id
jwt
currency
transaction_amount
statut_id
transaction_id
paid_transaction_amount
paid_currency
change_rate
onflictual_transaction_amount
conflictual_currency
wallet
*/



/*
[operation_token] => hgdsttdf-b845-78c9-4hg7-74mpoef114ui
    [order] => 
    [jwt] => 
    [currency] => XOF
    [transaction_amount] =>

*/




