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
    //verifie si tous les champs existent // name_city=NOhh&status_city=0&long_city=0&lag_city=0
    if( !isset($name_city) || !isset($status_city) || !isset($long_city) || !isset($lag_city) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
    }else{
        //verifie si au moins un champs de filtre est renseigné
        if( strlen($name_city) == 0 || strlen($status_city) == 0 || strlen($long_city) == 0 || strlen($lag_city) == 0 )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner correctement les champs obligatoires avant de valider le formulaire."; 
        }else{
            $long_city = trim($long_city);
            $lag_city = trim($lag_city);
            $status_city = intval($status_city);

            $req = $pdo->prepare(" SHOW TABLE STATUS LIKE 'livraison_destinations' ");
            $req->execute( array() ); $Mbre_actuel_Obj = current( $req->fetchAll() );
            $Nbre_Product_Actuel = isset($Mbre_actuel_Obj['Auto_increment']) ? intval( $Mbre_actuel_Obj['Auto_increment'] ) : 1;

            $token = getTokenNumber($Nbre_Product_Actuel, 'AM', 'LC'); // génère un token

                    $date = date("Y-m-d H:i:s");

                    //insertion du produit en base
                    $req_prepare['fields'] = array( 'date_creation', 'date_modification', 'frais', 'commune', 'lagitude', 'longitude', 'statut', 'token' );
                    $req_prepare['values'] = array(
                                        'date_creation' => $date,
                                        'date_modification' => $date,
                                        'frais' => 0,
                                        'commune' => $name_city,
                                        'lagitude' => $lag_city,
                                        'longitude' => $long_city,
                                        'statut' => $status_city,
                                        'token' => $token
                                    );
                    insert($pdo, $req_prepare, 'livraison_destinations');

                    // debugger($req_prepare);

                    // $retour['cmd_id'] = $cmd_id;
                    $error_text = ' Succès ! ';
                    $error_text_second = "La commune a été ajoutée. " ;
                    $retour['error_text'] = $error_text;
                    $retour['error_text_second'] = $error_text_second;
                    $retour['linkToList'] = SITE_BASE_URL.'communesLivraison/liste';

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
