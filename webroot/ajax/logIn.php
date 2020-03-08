<?php
include 'connectDB.php';
include 'fonction.php';
if (empty(session_id())) {
    session_start();
}

$error_statut = false;
$error_text = '';
$error_html = '';
$retour = array();
$retour['connected'] = 'non';

sleep(1);

if ($_POST) {
    
    $post_element_normal = array('username', 'password');
    $post_element_orig = array();
    $post_element_orig = array_keys($_POST); //nom des inputs venant du form
    $result = array_diff($post_element_normal, $post_element_orig);
    $error_text = 'Erreur ! Prière ne pas modifier le document Web.';
    $error_html = '
<div class="col-sm-12 alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <span class="">' . $error_text . '</span>
                                </div>        
';
    if (empty($result)) {//si les noms des input sont corrects
        // var_dump($_POST);
        // die();
        foreach ($_POST as $n => $v) {
            if (empty($v)) {//verifie si les champs text ne sont pas vides
                $error_statut = true;
                $error_text = "Aucun champs ne doit être vide.";
            }
        }
        if (!$error_statut) {
            extract($_POST);
            //$encrypt_password = md5($user_password);
            $username = trim($username);
            $password = md5($password);
            $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE (tel =:tel OR email=:email) AND password =:password"); //
            $req->execute(array(':tel' => $username, ':email' => $username, ':password' => $password));
            // var_dump($req);
            // die();
            
            $client = current($req->fetchAll(PDO::FETCH_OBJ));
            if (empty($client)) {
                if(isset($_SESSION['user'])){ unset($_SESSION['user']); }
                $error_statut = true;
                $error_text = 'Login ou Mot de passe incorrect.'; //, réessayez avec les acces corrects
            } else {
                if($client->statut==1){ // verifie si le client est actif
                    $_SESSION['bo_user']['id'] = $client->id;
                    $_SESSION['bo_user']['token'] = $client->token;
                    $_SESSION['bo_user']['nom'] = htmlspecialchars ($client->nom);
                    $_SESSION['bo_user']['prenoms'] = htmlspecialchars ($client->prenoms);
                    $_SESSION['bo_user']['email'] = $client->email;
                    $_SESSION['bo_user']['tel'] = $client->tel;
                    $_SESSION['bo_user']['date_creation'] = $client->date_creation;
                    $_SESSION['bo_user']['statut'] = $client->statut;

                    $retour['connected'] = 'oui';
                }else{
                    $error_statut = true;
                    $error_text = "Ce compte n'est pas actif.<br> Contactez l'administrateur du site.";
                }
                
            }
        }
    } else {
        $error_statut = true;
        $error_text = 'Veuillez remplir correctement le formulaire ci-dessous';
    }
} else {
    $error_statut = true;
    $error_text = 'Votre requete ne peut aboutir';
}
if ($error_statut) {
    $error_html = '<div class="col-sm-12 alert alert-danger"><a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a><span class="">' . $error_text . '</span></div>';
    header('401 unauthorized', true, 401);
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
}
$retour_json = json_encode($retour);

echo $retour_json;
 //         echo 'OK';    
//echo ' <pre>';print_r($_POST);echo '</pre>';
//echo ' <pre>';print_r($matiere);echo '</pre>';




