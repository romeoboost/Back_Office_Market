<?php
include 'connectDB.php';
include 'fonction.php';
setlocale(LC_TIME, "fr_FR", "French");

$error_statut = false;
$error_text = '';
$error_text_second = '';
$error_html = '';
$retour = array();
$result = array();

$conditions_prepare=array();

// sleep(5);
if ($_POST) {
    
    extract($_POST);
    // extract($_FILES);
    // debugger($_POST);
    //verifie si tous les champs existent // old_password=hjj&new_password=jjj&confirm_new_password=jj&token=1
    if( !isset($old_password) || !isset($new_password) || !isset($confirm_new_password) || !isset($token)) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
    }else{
        //verifie si au moins un champs de filtre est renseigné
        if( strlen($old_password) == 0 || strlen($new_password) == 0 || strlen($confirm_new_password) == 0 ||
        strlen($token) == 0)
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner correctement les champs obligatoires avant de valider le formulaire."; 
        }else{

            $old_password = trim($old_password);
            $new_password = trim($new_password);
            $confirm_new_password = trim($confirm_new_password);
            $token = trim($token);

            //Verifier si les champs new_password et confirm_new_password contiennent les mêmes valeurs
            if( $new_password !== $confirm_new_password ){
                $error_statut = true;
                $error_text_second = 'Le nouveau mot de passe et la confirmation doivent être identiques.';
            }else{
                $md5_old_password = md5($old_password);
                $req_recup = $pdo->prepare('SELECT * FROM utilisateurs WHERE token = :token ORDER BY id DESC'); 
                $req_recup->execute( array( ':token' => $token ) );
                $clients = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );
    
                //verifier si l'ancien mot de passe est correct
                //debugger($clients->password, $md5_old_password);
                if($clients->password !== $md5_old_password){
                    $error_statut = true;
                    $error_text_second = "L'ancien mot de passe que vous avez saisi n'est pas correct.";
                }else{
                    $date = date("Y-m-d H:i:s");
                    $md5_new_password = md5($new_password);
                    $update_req = $pdo->prepare("UPDATE utilisateurs SET password = :password, date_modification = :date_modification
                                                            WHERE token = :token "); 
                    $update_req->execute( array( 
                                                ':password' => $md5_new_password,
                                                ':date_modification' => $date,
                                                ':token' => $token
                                            ) 
                                        );  
                    // debugger($clients);    
                    $error_text = ' Succès ! ';
                    $error_text_second = "Le mot de passe a été modifiée. " ;
                    $retour['error_text'] = $error_text;
                    $retour['error_text_second'] = $error_text_second;
                    $retour['linkToList'] = SITE_BASE_URL.'accueil/index';
    
                }
            }

        }
    }    
}

$retour['error_text'] = $error_text;
$retour['error_text_second'] = $error_text_second;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible text-align-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text_second . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    // $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;
