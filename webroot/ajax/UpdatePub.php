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
    extract($_FILES);
    // debugger($_FILES);
    //verifie si tous les champs existent
    if( !isset($start_date) || !isset($end_date) || !isset($image) || !isset($name_compagny) || !isset($status) || !isset($position) || !isset($token) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($start_date) || empty($end_date) || empty($name_compagny) || strlen($status) == 0 || strlen($position) == 0 || empty($token) )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner les champs obligatoires avant de valider le formulaire."; 
        }else{       
            // debugger($_POST);     
            //verifie si l'image est de bonne qualité
            $image_good = true;
            $image_name = '';
            //Verifie si une nouvelle image a été chargée
            if( empty($image['name']) ){ // si non
                $image_good = true; // dire que c'est ok pour les images
                $image_name = $old_image;
            }else{  // si oui
               $image_finale = upload( $image, 173, 750);
               // verifie que l'image est au bon format
               if( !$image_finale ){ //si non 
                    $error_statut = true; //renvoi erreur 
                    $error_text = "Oups, Erreur !"; //renvoi erreur 
                    $error_text_second = "Veuillez entrer une image valide."; //renvoi erreur 
                    $image_good = false; //dire que c'est pas ok pour l'image
                }else{ //si oui
                    $time = time();
                    $image_name = md5( $time );
                    //image principale du produit
                    imagejpeg($image_finale, WEBROOT_FRONT_DIR. 'images/pub/' . $image_name . '.png'); //copie les images sur le serveur
                }
            }


            //verifie si c'est ok pour l'image
            if( $image_good ){//si image ok
                //Formater les dates
                $start_date= formatdate($start_date).' 00:00:00';
                $end_date= formatdate($end_date).' 23:59:59';
                //attribut les valeur par defaut au champs qui ne sont pas obligatoire
                $name_compagny = trim( $name_compagny );
                $status = ( strlen( $status ) == 0 ) ? 0 : intval( $status ) ;
                $position = ( strlen( $position ) == 0 ) ? 0 : intval( $position ) ;
                $token = trim($token); // génère un token
                
                // debugger($slug);
                $date = date("Y-m-d H:i:s");

                //modification du produit en base
                $req_prepare['fields'] = array( 'date_modification', 'date_debut', 'date_fin', 'position', 'image', 'entreprise', 'statut' );
                $req_prepare['values'] = array(
                                    'date_modification' => $date,
                                    'date_debut' => $start_date,
                                    'date_fin' => $end_date,
                                    'position' => $position,
                                    'image' => $image_name,
                                    'entreprise' => $name_compagny,
                                    'statut' => $status
                                );
                $req_prepare['condition'] = 'token = :token';
                $req_prepare['values']['token'] = $token;

                update($pdo, $req_prepare, 'publicites');

                // insert($pdo, $req_prepare, 'publicites');

                // $retour['cmd_id'] = $cmd_id;
                $error_text = ' Succes ! ';
                $error_text_second = "La compagne publicitaire de $name_compagny a été modifiée. " ;
                $retour['error_text'] = $error_text;
                $retour['error_text_second'] = $error_text_second;
                $retour['linkToList'] = SITE_BASE_URL.'pubs/liste';
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
