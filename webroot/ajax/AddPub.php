<?php
include 'connectDB.php';
include 'fonction.php';
setlocale(LC_TIME, "fr_FR", "French");

$error_statut = false;
$error_text = '';
$error_html = '';
$error_text_second = '';
$retour = array();
$result = array();

$conditions_prepare=array();
// debugger($_FILES);
// sleep(5);
if ($_POST) {
    
    extract($_POST);
    extract($_FILES);
    // debugger($_FILES);
    // start_date=04-09-2019&end_date=04-09-2019&name_compagny=TES&status=0&position=1
    //verifie si tous les champs existent
    if( !isset($start_date) || !isset($end_date) || !isset($image) || !isset($name_compagny) || !isset($status) || !isset($position) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
        //debugger($_POST);
    }else{        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($start_date) || empty($end_date) || empty($name_compagny) || empty($image['name']) || strlen($status) == 0 || strlen($position) == 0 )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner les champs obligatoires avant de valider le formulaire"; 
        }else{       
            // debugger($_POST);     
            //verifie si l'image est de bonne qualité
            $image_finale = upload( $image, 173, 750);
            if( !$image_finale ){
                $error_statut = true;
                $error_text = "Oups, Erreur !";
                $error_text_second = "Veuillez entrer une image valide.";
            }else{
                // copie l'image  dans le repertoire de l'application front office                
                $time = time();
                $image_name = md5( $time );
                //image principale du produit
                imagejpeg($image_finale, WEBROOT_FRONT_DIR. 'images/pub/' . $image_name . '.png');
                // debugger($image_finale);

                //Formater les dates
                $start_date= formatdate($start_date).' 00:00:00';
                $end_date= formatdate($end_date).' 23:59:59';
                //attribut les valeur par defaut au champs qui ne sont pas obligatoire
                $name_compagny = trim( $name_compagny );
                $status = ( strlen( $status ) == 0 ) ? 0 : intval( $status ) ;
                $position = ( strlen( $position ) == 0 ) ? 0 : intval( $position ) ;

                $req = $pdo->prepare(" SHOW TABLE STATUS LIKE 'publicites' ");
                $req->execute( array() ); $Mbre_actuel_Obj = current( $req->fetchAll() );
                $Nbre_Product_Actuel = isset($Mbre_actuel_Obj['Auto_increment']) ? intval( $Mbre_actuel_Obj['Auto_increment'] ) : 1;

                $token = getTokenNumber($Nbre_Product_Actuel, 'AM', 'PUB'); // génère un token
                
                // debugger($slug);
                $date = date("Y-m-d H:i:s");

                //insertion du produit en base
                $req_prepare['fields'] = array( 'date_creation', 'date_modification', 'date_debut', 'date_fin', 'position', 'image', 'entreprise', 'statut', 'token' );
                $req_prepare['values'] = array(
                                    'date_creation' => $date,
                                    'date_modification' => $date,
                                    'date_debut' => $start_date,
                                    'date_fin' => $end_date,
                                    'position' => $position,
                                    'image' => $image_name,
                                    'entreprise' => $name_compagny,
                                    'statut' => $status,
                                    'token' => $token
                                );
                insert($pdo, $req_prepare, 'publicites');

                // $retour['cmd_id'] = $cmd_id;
                $error_text = ' Succes ! ';
                $error_text_second = "La compagne publicitaire de $name_compagny a été ajoutée. " ;
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
