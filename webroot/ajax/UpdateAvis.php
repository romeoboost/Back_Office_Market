<?php
include 'connectDB.php';
include 'fonction.php';
setlocale(LC_TIME, "fr_FR", "French");

if (empty(session_id())) {
    session_start();
    //$_SESSION['menu'] = 'Nous_Rejoindre';
}

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
    // [token] => loagxfqx4xh;     [descript_product] => edrfvjdrs
    //verifie si tous les champs existent // min_amount=10001&max_amount=20000&fee=1000&token=FLV2019070002AM
    if( !isset($descript_product) || !isset($token) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( strlen($descript_product) == 0 || strlen($token) == 0 )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner correctement les champs obligatoires avant de valider le formulaire."; 
        }else{

            //verifie si le comment existe
            $req_recup = $pdo->prepare('SELECT * FROM avis WHERE token = :token ORDER BY id DESC'); 
            $req_recup->execute( array( ':token' => $token ) );
            $element = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

                if( empty($element) ){ 
                    $error_statut = true;
                    $error_text = "Oups, Erreur !";
                    $error_text_second = "Echec de modification du commentaire. Ce commentaire n'existe pas en base. ";
                }else{
                    //verifie si le user back office est connecté ou existe
                    $username = trim($_SESSION['bo_user']['tel']);
                    $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE tel =:tel "); //
                    $req->execute( array(':tel' => $username ) );
                    $user = current($req->fetchAll(PDO::FETCH_OBJ));
                    if( empty($user) ){
                        $error_statut = true;
                        $error_text = "Oups, Erreur !";
                        $error_text_second = 'Prière vous reconnecter avant de continuer.'; //, réessayez avec les acces corrects
                    }else{
                        $date = date("Y-m-d H:i:s");
                        //insertion du produit en base
                        $req_prepare['fields'] = array( 'date_modification', 'id_admin_reponse', 'reponse_admin_contenu', 'date_reponse', 'statut' );
                        $req_prepare['values'] = array(
                                            'date_modification' => $date,
                                            'id_admin_reponse' => $user->id,
                                            'reponse_admin_contenu' => $descript_product,
                                            'date_reponse' => $date,
                                            'statut' => 1
                                        );
                        $req_prepare['condition'] = 'token = :token';
                        $req_prepare['values']['token'] = $token;
                        update($pdo, $req_prepare, 'avis');
                        // debugger($req_prepare);

                        // $retour['cmd_id'] = $cmd_id;
                        $error_text = ' Succes ! ';
                        $error_text_second = "Votre mésaage a été enregistré. " ;
                        $retour['error_text'] = $error_text;
                        $retour['error_text_second'] = $error_text_second;
                        $retour['linkToList'] = SITE_BASE_URL.'avis/liste';

                    }
                }

                    //modifie le commentaire
                
        }


    }
    
    
}

// debugger($error_statut);
// die();

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
