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
    // [token] => azedsgb5815czsd   [isAccueil] => 1
    //verifie si tous les champs existent // min_amount=10001&max_amount=20000&fee=1000&token=FLV2019070002AM
    if( !isset($isAccueil) || !isset($token) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( strlen($isAccueil) == 0 || strlen($token) == 0 )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner correctement les champs obligatoires avant de  confirmer."; 
        }else{
            
            //verifie si le comment existe
            $req_recup = $pdo->prepare('SELECT * FROM avis WHERE token = :token ORDER BY id DESC'); 
            $req_recup->execute( array( ':token' => $token ) );
            $element = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

                if( empty($element) ){ 
                    $error_statut = true;
                    $error_text = "Oups, Erreur !";
                    $error_text_second = "Echec de suppression du commentaire. Ce commentaire n'existe pas en base. ";
                }else{
                    $isAccueil = intval($isAccueil);
                    $page_accueil = ($isAccueil == 1) ? 0 : 1;
                    $status_libelle = ($page_accueil == 1) ? "OUI" : "NON";
                    $status_action = ($page_accueil == 1) ?  "Rétirer de la page d'acceuil" : "Afficher sur la page d'acceuil";
                    $status_value = ($page_accueil == 1) ? 1 : 0;
                    $status_action_icon_html = ($page_accueil == 1) ? '<i class="md md-check-box-outline-blank"></i>' : '<i class="md md-home"></i>';
                    $date = date("Y-m-d H:i:s");
                    //insertion du produit en base
                    $req_prepare['fields'] = array( 'date_modification', 'page_accueil');
                    $req_prepare['values'] = array( 'date_modification' => $date,    'page_accueil' => $page_accueil );
                    $req_prepare['condition'] = 'token = :token';
                    $req_prepare['values']['token'] = $token;
                    update($pdo, $req_prepare, 'avis');
                    // debugger($req_prepare);

                    // $retour['cmd_id'] = $cmd_id;
                    $error_text = ' Succes ! ';
                    $error_text_second = "L'avis apparaîtra sur la page d'accueil." ;
                    $retour['error_text'] = $error_text;
                    $retour['error_text_second'] = $error_text_second;
                    $retour['status_libelle'] = $status_libelle;
                    $retour['status_action'] = $status_action;
                    $retour['status_value'] = $status_value;
                    $retour['status_action_icon_html'] = $status_action_icon_html;
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
