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
    // debugger($_POST);
    //verifie si tous les champs existent
    if( !isset($name_category) || !isset($status_cotegory) || !isset($icon_cotegory) || !isset($image) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($name_category) || strlen($status_cotegory) == 0 || strlen($icon_cotegory) == 0 )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner les champs obligatoires avant de valider le formulaire."; 
        }else{       
            // debugger($_FILES);     
            //verifie si l'image est de bonne qualité
            $image_good = true;
            $image_name = '';
            //Verifie si une nouvelle image a été chargée
            if( empty($image['name']) ){ // si non
                $image_good = true; // dire que c'est ok pour les images
                $image_name = $old_image;
            }else{  // si oui
               $image_finale = upload( $image, 150, 150 ); 
               // verifie que l'image est au bon format
               if( !$image_finale ){ //si non 
                    $error_statut = true; //renvoi erreur 
                    $error_text = "Oups, Erreur !"; //renvoi erreur 
                    $error_text_second = "Veuillez entrer une image valable"; //renvoi erreur 
                    $image_good = false; //dire que c'est pas ok pour l'image
                }else{ //si oui
                    $time = time();
                    $image_name = md5( $time );
                    //image principale du produit
                    imagejpeg($image_finale, WEBROOT_FRONT_DIR. 'images/category/' . $image_name . '.png'); //copie les images sur le serveur
                }
            }


            //verifie si c'est ok pour l'image
            if( $image_good ){//si image ok
                //attribut les valeur par defaut au champs qui ne sont pas obligatoire
                $name_category = trim( $name_category );
                $status_cotegory = ( strlen( $status_cotegory ) == 0 ) ? 0 : intval( $status_cotegory ) ;
                $icon_cotegory = trim( $icon_cotegory );
                
                // debugger($slug);
                $date = date("Y-m-d H:i:s");

                //insertion du produit en base
                $req_prepare['fields'] = array( 'date_modification', 'image', 'nom', 'icon', 'statut' );
                $req_prepare['values'] = array(
                                    'date_modification' => $date,
                                    'image' => $image_name,
                                    'nom' => $name_category,
                                    'icon' => $icon_cotegory,
                                    'statut' => $status_cotegory
                                );
                $req_prepare['condition'] = 'token = :token';
                $req_prepare['values']['token'] = $token;

                update($pdo, $req_prepare, 'categories_produits');

                // insert($pdo, $req_prepare, 'categories_produits');

                // $retour['cmd_id'] = $cmd_id;
                $error_text = ' Succes ! ';
                $error_text_second = "La cotégorie $name_category a été modifiée. " ;
                $retour['error_text'] = $error_text;
                $retour['error_text_second'] = $error_text_second;
                $retour['linkToList'] = SITE_BASE_URL.'categories/liste';
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
