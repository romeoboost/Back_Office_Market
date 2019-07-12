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
    //verifie si tous les champs existent // name_element=Hectare&symbole=Ha
    if( !isset($name_element) || !isset($symbole) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($name_element) || empty($symbole) )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner correctement les champs obligatoires avant de valider le formulaire"; 
        }else{       
            
            $symbole = trim($symbole);
            $name_element = trim($name_element);

            $date = date("Y-m-d H:i:s");

            //insertion du produit en base
            $req_prepare['fields'] = array( 'date_modification', 'libelle', 'symbole' );
            $req_prepare['values'] = array(
                                'date_modification' => $date,
                                'libelle' => $name_element,
                                'symbole' => $symbole,
                            );
            $req_prepare['condition'] = 'token = :token';
            $req_prepare['values']['token'] = $token;
            update($pdo, $req_prepare, 'unites');

            // debugger($req_prepare);

            // $retour['cmd_id'] = $cmd_id;
            $error_text = ' Succes ! ';
            $error_text_second = "L'unité de mésure a été modifiée. " ;
            $retour['error_text'] = $error_text;
            $retour['error_text_second'] = $error_text_second;
            $retour['linkToList'] = SITE_BASE_URL.'unitesMesure/liste';
            
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
