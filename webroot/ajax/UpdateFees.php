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
    //verifie si tous les champs existent // min_amount=10001&max_amount=20000&fee=1000&token=FLV2019070002AM
    if( !isset($min_amount) || !isset($max_amount) || !isset($fee) || !isset($token) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( strlen($min_amount) == 0 || strlen($max_amount) == 0 || strlen($fee) == 0 || strlen($token) == 0)
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner correctement les champs obligatoires avant de valider le formulaire."; 
        }else{

            $min_amount = intval($min_amount);
            $max_amount = intval($max_amount);
            $fee = intval($fee);

            //VERIFIER SI les éléments min et max ne pas deja pris en compte par une autre ligne de frais
            $selfElementToken = $token;    
            if( isSetAsFees($pdo, $min_amount, $selfElementToken) ){
                $error_statut = true;
                $error_text = "Oups, Erreur !";
                $error_text_second = "Le montant choisi comme montant minimum ($min_amount) est déjà lié à un autre pallier."; 
            }else{
                if( isSetAsFees($pdo, $max_amount, $selfElementToken) ){
                    $error_statut = true;
                    $error_text = "Oups, Erreur !";
                    $error_text_second = "Le montant choisi comme montant maximum ($max_amount) est déjà lié à un autre pallier.";
                }else{
                    // var_dump( isSetAsFees($pdo, $max_amount, $selfElementToken) );
                    // debugger( $_POST );
                    $date = date("Y-m-d H:i:s");
                    //insertion du produit en base
                    $req_prepare['fields'] = array( 'date_modification', 'min', 'max', 'frais' );
                    $req_prepare['values'] = array(
                                        'date_modification' => $date,
                                        'min' => $min_amount,
                                        'max' => $max_amount,
                                        'frais' => $fee
                                    );
                    $req_prepare['condition'] = 'token = :token';
                    $req_prepare['values']['token'] = $token;
                    update($pdo, $req_prepare, 'frais_livraison');

                    // debugger($req_prepare);

                    // $retour['cmd_id'] = $cmd_id;
                    $error_text = ' Succes ! ';
                    $error_text_second = "La ligne de tarification de frais a été modifiée. " ;
                    $retour['error_text'] = $error_text;
                    $retour['error_text_second'] = $error_text_second;
                    $retour['linkToList'] = SITE_BASE_URL.'fraisLivraison/liste';
                    
                }
            }  
                
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
