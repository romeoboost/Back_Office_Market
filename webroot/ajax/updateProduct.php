<?php
include 'connectDB.php';
include 'fonction.php';
setlocale(LC_TIME, "fr_FR", "French");

$error_statut = false;
$error_text = '';
$error_html = '';
$retour = array();
$result = array();
$error_text_second = '';
$error_text = '';

$conditions_prepare=array();

// sleep(5);
if ($_POST) {
    
    extract($_POST);
    extract($_FILES);
    
    //verifie si tous les champs existent
    //

    if( !isset($name_product) || !isset($category_product) || !isset($page_home) || !isset($amount_product) || !isset($status_product) || !isset($unit_qtt_sold) 
        || !isset($unit_mesure) || !isset($promo_product) || !isset($percent_promo_product) || !isset($descript_product) || !isset($image) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
        //debugger($_POST);

    }else{
        // if( strlen($amount_product) == 0 ) { debugger($_POST); }
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($name_product) || strlen($category_product) == 0 || empty($amount_product) || 
            strlen($unit_qtt_sold) == 0 || strlen($unit_mesure) == 0 || empty($descript_product)
          )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner les champs obligatoires avant de valider le formulaire"; 

        }else{
            $image_good = true;
            //Verifie si une nouvelle image a été chargée
            if( empty($image['name']) ){ // si non
                $image_good = true; // dire que c'est ok pour les images
            }else{  // si oui
               // debugger($_FILES); 
               $image_finale = upload( $image, 300, 300 ); 
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
                    imagejpeg($image_finale, WEBROOT_FRONT_DIR. 'images/shop/' . $image_name . '.jpg'); //copie les images sur le serveur

                    //image thumbs du produit
                    $image_finale_thumbs = upload( $image, 180, 180 );
                    imagejpeg($image_finale_thumbs, WEBROOT_FRONT_DIR. 'images/shop/thumb/' . $image_name . '.jpg'); //copie les images sur le serveur

                    //image Large du produit
                    $image_finale_large = upload( $image, 570, 570 );
                    imagejpeg($image_finale_large, WEBROOT_FRONT_DIR. 'images/shop/large/' . $image_name . '.jpg'); //copie les images sur le serveur
                    $image_good = true; // dire que c'est ok pour l'image 
                }

            }

            //verifie si c'est ok pour l'image
            if( $image_good ){//si image ok
                
                //attribut les valeur par defaut au champs qui ne sont pas obligatoire
                $name_product = trim( $name_product );
                $category_product = intval( $category_product );
                $page_home = ( strlen( $page_home ) == 0 ) ? 0 : intval( $page_home ) ;
                $amount_product = intval( $amount_product );
                $status_product = ( strlen( $status_product ) == 0 ) ? 0 : intval( $status_product ) ;
                $unit_qtt_sold = intval( $unit_qtt_sold );
                $unit_mesure = ( strlen( $unit_mesure ) == 0 ) ? 0 : intval( $unit_mesure ) ;
                $promo_product = ( strlen( $promo_product ) == 0 ) ? 0 : intval( $promo_product ) ;
                $percent_promo_product = intval( $percent_promo_product );
                $descript_product = trim( $descript_product );

                $req = $pdo->prepare('SELECT COUNT(id) as nbre FROM produits '); 
                $req->execute(array());
                $Mbre_actuel_Obj = current($req->fetchAll(PDO::FETCH_OBJ));
                $Nbre_Product_Actuel = $Mbre_actuel_Obj->nbre; // le nombe actuel des clients

               // $Identifiant .= $Abreviation_Pays;
                // $token = getProductNumber($Nbre_Product_Actuel, 'AM');
                
                $stock = 0;

                $slug = str_replace('/', '', $name_product);                
                $slug = str_replace('\\', '', $slug);
                $slug = str_replace('%', '', $slug);
                $slug = str_replace(' ', '-', $slug);
                $req = $pdo->prepare('SELECT id,nom FROM categories_produits where id = :id '); 
                $req->execute( array('id' => $category_product ) );
                $cat_info = current($req->fetchAll(PDO::FETCH_OBJ));
                $slug .= '-'.$cat_info->nom;
                $slug .= '-'.$token_produit;
                $slug = str_replace(' ', '-', $slug);

                // debugger($slug);
                $date = date("Y-m-d H:i:s");

                //verifie si image a été chargé
                if( empty($image['name']) ){//si image pas chargé 
                    //prepare le tableau de la requete sans le champs 'image'
                    $req_prepare['fields'] = array('date_modification', 'description', 'id_categorie_produit', 'id_unite',
                        'nom', 'page_accueil', 'pourcentage_promo', 'prix_quantite_unitaire', 'promo', 'quantite_unitaire', 'slug',
                         'statut');
                    $req_prepare['values'] = array(
                                        'date_modification' => $date,
                                        'description' => $descript_product,
                                        'id_categorie_produit' => $category_product,
                                        'id_unite' => $unit_mesure,
                                        'nom' => $name_product,
                                        'page_accueil' => $page_home,
                                        'pourcentage_promo' => $percent_promo_product,
                                        'prix_quantite_unitaire' => $amount_product,
                                        'promo' => $promo_product,
                                        'quantite_unitaire' => $unit_qtt_sold,
                                        'slug' => $slug,
                                        'statut' => $status_product
                                    );
                }else{//si image chargé
                    //prepare le tableau de la requete avec le champs 'image' 
                    $req_prepare['fields'] = array('date_modification', 'description', 'id_categorie_produit', 'id_unite', 'image',
                        'nom', 'page_accueil', 'pourcentage_promo', 'prix_quantite_unitaire', 'promo', 'quantite_unitaire', 'slug',
                         'statut');
                    $req_prepare['values'] = array(
                                        'date_modification' => $date,
                                        'description' => $descript_product,
                                        'id_categorie_produit' => $category_product,
                                        'id_unite' => $unit_mesure,
                                        'image' => $image_name,
                                        'nom' => $name_product,
                                        'page_accueil' => $page_home,
                                        'pourcentage_promo' => $percent_promo_product,
                                        'prix_quantite_unitaire' => $amount_product,
                                        'promo' => $promo_product,
                                        'quantite_unitaire' => $unit_qtt_sold,
                                        'slug' => $slug,
                                        'statut' => $status_product
                                    );
                }
                $req_prepare['condition'] = 'token = :token';
                $req_prepare['values']['token'] = $token_produit;

                update($pdo, $req_prepare, 'produits');

                // $retour['cmd_id'] = $cmd_id;
                $error_text = ' Succes ! ';
                $error_text_second = "Le produit $name_product a été Modifiée. " ;
                $retour['error_text'] = $error_text;
                $retour['error_text_second'] = $error_text_second;
                $retour['linkToProductList'] = SITE_BASE_URL.'produits/liste';

            }          

            // debugger($order_first);
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
    header("Une erreur s'est produite", true, 503);
}
$retour_json = json_encode($retour);

echo $retour_json;








