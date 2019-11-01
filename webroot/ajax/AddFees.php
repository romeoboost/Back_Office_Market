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
    //verifie si tous les champs existent // min_amount=100&max_amount=1000&fee=250
    if( !isset($min_amount) || !isset($max_amount) || !isset($fee) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( strlen($min_amount) == 0 || strlen($max_amount) == 0 || strlen($fee) == 0  )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner correctement les champs obligatoires avant de valider le formulaire."; 
        }else{

            $min_amount = intval($min_amount);
            $max_amount = intval($max_amount);
            $fee = intval($fee);

            //VERIFIER SI les éléments min et max de la ligne qu'on souhaite entrer en base, ne font pas déjà parti d'une liste     
            if( isSetAsFees($pdo, $min_amount) ){
                $error_statut = true;
                $error_text = "Oups, Erreur !";
                $error_text_second = "Le montant choisi comme montant minimum ($min_amount) est déjà lié à un pallier."; 
            }else{
                if( isSetAsFees($pdo, $max_amount) ){
                    $error_statut = true;
                    $error_text = "Oups, Erreur !";
                    $error_text_second = "Le montant choisi comme montant maximum ($max_amount) est déjà lié à un pallier.";
                }else{

                    $req = $pdo->prepare(" SHOW TABLE STATUS LIKE 'frais_livraison' ");
                    $req->execute( array() ); $Mbre_actuel_Obj = current( $req->fetchAll() );
                    $Nbre_Product_Actuel = isset($Mbre_actuel_Obj['Auto_increment']) ? intval( $Mbre_actuel_Obj['Auto_increment'] ) : 1;
                    //die($Auto_increment);

                    $token = getTokenNumber($Nbre_Product_Actuel, 'AM', 'FLV');

                    $date = date("Y-m-d H:i:s");

                    //insertion du produit en base
                    $req_prepare['fields'] = array( 'date_creation', 'date_modification', 'min', 'max', 'frais', 'token' );
                    $req_prepare['values'] = array(
                                        'date_creation' => $date,
                                        'date_modification' => $date,
                                        'min' => $min_amount,
                                        'max' => $max_amount,
                                        'frais' => $fee,
                                        'token' => $token
                                    );
                    insert($pdo, $req_prepare, 'frais_livraison');

                    // debugger($req_prepare);

                    // $retour['cmd_id'] = $cmd_id;
                    $error_text = ' Succes ! ';
                    $error_text_second = "La ligne de tarification de frais a été ajoutée. " ;
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
