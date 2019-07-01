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
    if( !isset($name_category) || !isset($status_cotegory) || !isset($icon_cotegory) || !isset($image) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($name_category) || empty($image['name']) || strlen($status_cotegory) == 0 || strlen($icon_cotegory) == 0 )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner les champs obligatoires avant de valider le formulaire"; 
        }else{       
            // debugger($_FILES);     
            //verifie si l'image est de bonne qualité
            $image_finale = upload( $image, 150, 150);
            if( !$image_finale ){
                $error_statut = true;
                $error_text = "Oups, Erreur !";
                $error_text_second = "Veuillez entrer une image valable";
            }else{
                // copie l'image  dans le repertoire de l'application front office                
                $time = time();
                $image_name = md5( $time );
                //image principale du produit
                imagejpeg($image_finale, WEBROOT_FRONT_DIR. 'images/category/' . $image_name . '.png');
                // debugger($image_finale);

                //attribut les valeur par defaut au champs qui ne sont pas obligatoire
                $name_category = trim( $name_category );
                $status_cotegory = ( strlen( $status_cotegory ) == 0 ) ? 0 : intval( $status_cotegory ) ;
                $icon_cotegory = trim( $icon_cotegory );

                //recupere le nombre de categories
                // $req = $pdo->prepare('SELECT id as nbre FROM categories_produits order by id desc limit 0,1 '); 
                // $req->execute(array()); $Mbre_actuel_Obj = current($req->fetchAll(PDO::FETCH_OBJ));
                // $Nbre_Product_Actuel = isset($Mbre_actuel_Obj->nbre) ? $Mbre_actuel_Obj->nbre : 1 ; // le nombe actuel des clients

                $req = $pdo->prepare(" SHOW TABLE STATUS LIKE 'categories_produits' ");
                $req->execute( array() ); $Mbre_actuel_Obj = current( $req->fetchAll() );
                $Nbre_Product_Actuel = isset($Mbre_actuel_Obj['Auto_increment']) ? intval( $Mbre_actuel_Obj['Auto_increment'] ) : 1;


                $token = getTokenNumber($Nbre_Product_Actuel, 'AM', 'CTP'); // génère un token
                
                // debugger($slug);
                $date = date("Y-m-d H:i:s");

                //insertion du produit en base
                $req_prepare['fields'] = array( 'date_creation', 'date_modification', 'image', 'nom', 'icon', 'statut', 'token' );
                $req_prepare['values'] = array(
                                    'date_creation' => $date,
                                    'date_modification' => $date,
                                    'image' => $image_name,
                                    'nom' => $name_category,
                                    'icon' => $icon_cotegory,
                                    'statut' => $status_cotegory,
                                    'token' => $token
                                );
                insert($pdo, $req_prepare, 'categories_produits');

                // $retour['cmd_id'] = $cmd_id;
                $error_text = ' Succes ! ';
                $error_text_second = "La cotégorie $name_category a été ajoutée. " ;
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
