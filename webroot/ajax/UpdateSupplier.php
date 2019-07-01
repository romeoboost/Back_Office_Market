<?php
include 'connectDB.php';
include 'fonction.php';
setlocale(LC_TIME, "fr_FR", "French");

$error_statut = false;
$error_text = '';
$error_html = '';
$retour = array();
$result = array();

$conditions_prepare=array();

// sleep(5);
if ($_POST) {
    
    extract($_POST);
    // extract($_FILES);
    // debugger($_POST);
    //verifie si tous les champs existent
    //name_supplier=Vi%C3%A9+Coulibaly&tel=04523685&email=test%40fournisseur.som&token=FNS2019060004AM
    if( !isset($name_supplier) || !isset($tel) || !isset($email) || !isset($token) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);
    }else{
        //verifie si au moins un champs de filtre est renseigné
        if( empty($name_supplier) || empty($tel) || empty($token) )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner les champs obligatoires avant de valider le formulaire."; 
        }else{       
            // debugger($_FILES);     
            //verifie si l'image est de bonne qualité
            $fournisseur_is_good = true;

            //recupere les infos actuelles du fournisseur
            $req = $pdo->prepare('SELECT * FROM fournisseurs where token = :token '); 
            $req->execute( array('token' => $token ) ); $fournisseur = current( $req->fetchAll(PDO::FETCH_OBJ) );

            // debugger($fournisseur);
            if( empty($fournisseur) )
            {
                $error_statut = true;
                $error_text = "Oups, Erreur !";
                $error_text_second = "Vous ne pouvez effectuer cette action.";
            }else{
                $tel = trim($tel);
                $name_supplier = trim($name_supplier);
                $email = isset( $email )  ? trim($email) : '' ;

                $date = date("Y-m-d H:i:s");

                //insertion du produit en base
                $req_prepare['fields'] = array( 'date_modification', 'nom', 'tel', 'email' );
                $req_prepare['values'] = array(
                                    'date_modification' => $date,
                                    'nom' => $name_supplier,
                                    'tel' => $tel,
                                    'email' => $email
                                );
                $req_prepare['condition'] = 'token = :token';
                $req_prepare['values']['token'] = $token;
                update($pdo, $req_prepare, 'fournisseurs');

                // $retour['cmd_id'] = $cmd_id;
                $error_text = ' Succes ! ';
                $error_text_second = "Les informations du Fournisseur ont été modifiées. " ;
                $retour['error_text'] = $error_text;
                $retour['error_text_second'] = $error_text_second;
                $retour['linkToList'] = SITE_BASE_URL.'fournisseurs/liste';

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
