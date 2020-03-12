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
        if( empty($name_product) || empty($image['name']) || strlen($category_product) == 0 || empty($amount_product) || 
            strlen($unit_qtt_sold) == 0 || strlen($unit_mesure) == 0 || empty($descript_product)
          )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner les champs obligatoires avant de valider le formulaire"; 

        }else{
            
            //verifie si l'image est de bonne qualité
            $image_finale = upload( $image, 300, 300 );
            if( !$image_finale ){
                $error_statut = true;
                $error_text = "Oups, Erreur !";
                $error_text_second = "Veuillez entrer une image valable";
            }else{
                // debugger($image_finale);
                // copie l'image  dans le repertoire de l'application front office                
                $time = time();
                $image_name = md5( $time );

                //image principale du produit
                imagejpeg($image_finale, WEBROOT_FRONT_DIR. 'images/shop/' . $image_name . '.jpg');

                //image thumbs du produit
                $image_finale_thumbs = upload( $image, 180, 180 );
                imagejpeg($image_finale_thumbs, WEBROOT_FRONT_DIR. 'images/shop/thumb/' . $image_name . '.jpg');

                //image Large du produit
                $image_finale_large = upload( $image, 570, 570 );
                imagejpeg($image_finale_large, WEBROOT_FRONT_DIR. 'images/shop/large/' . $image_name . '.jpg');

                // debugger($image_finale);

                //attribut les valeur par defaut au champs qui ne sont pas obligatoire

                $name_product = trim( $name_product );
                $category_product = intval( $category_product );
                $page_home = ( strlen( $page_home ) == 0 ) ? 0 : intval( $page_home ) ;
                $amount_product = intval( $amount_product );
                $status_product = ( strlen( $status_product ) == 0 ) ? 0 : intval( $status_product ) ;
                $unit_qtt_sold = str_replace(',', '.', trim($unit_qtt_sold)); 
                $unit_qtt_sold = floatval( $unit_qtt_sold );
                $unit_mesure = ( strlen( $unit_mesure ) == 0 ) ? 0 : intval( $unit_mesure ) ;
                $promo_product = ( strlen( $promo_product ) == 0 ) ? 0 : intval( $promo_product ) ;
                $percent_promo_product = intval( $percent_promo_product );
                $descript_product = trim( $descript_product );


                // $req = $pdo->prepare('SELECT id as nbre FROM produits order by id desc limit 0,1 '); 
                // $req->execute(array());
                // $Mbre_actuel_Obj = current($req->fetchAll(PDO::FETCH_OBJ));
                // $Nbre_Product_Actuel = isset($Mbre_actuel_Obj->nbre) ? $Mbre_actuel_Obj->nbre : 1 ; // le nombe actuel des clients

                $req = $pdo->prepare(" SHOW TABLE STATUS LIKE 'produits' ");
                $req->execute( array() ); $Mbre_actuel_Obj = current( $req->fetchAll() );
                $Nbre_Product_Actuel = isset($Mbre_actuel_Obj['Auto_increment']) ? intval( $Mbre_actuel_Obj['Auto_increment'] ) : 1;

               // $Identifiant .= $Abreviation_Pays;
                $token = getProductNumber($Nbre_Product_Actuel, 'AM');
                
                $stock = 0;

                $slug = str_replace('/', '', $name_product);                
                $slug = str_replace('\\', '', $slug);
                $slug = str_replace('%', '', $slug);
                $slug = str_replace(' ', '-', $slug);
                $req = $pdo->prepare('SELECT id,nom FROM categories_produits where id = :id '); 
                $req->execute( array('id' => $category_product ) );
                $cat_info = current($req->fetchAll(PDO::FETCH_OBJ));
                $slug .= '-'.$cat_info->nom;
                $slug .= '-'.$token;
                $slug = str_replace(' ', '-', $slug);
                // debugger($slug);

                $date = date("Y-m-d H:i:s");


                //insertion du produit en base
                $req_prepare['fields'] = array('date_creation', 'date_modification', 'description', 'id_categorie_produit', 'id_unite', 'image',
                        'nom', 'page_accueil', 'pourcentage_promo', 'prix_quantite_unitaire', 'promo', 'quantite_unitaire', 'slug',
                         'statut', 'stock', 'token');
                $req_prepare['values'] = array(
                                    'date_creation' => $date,
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
                                    'statut' => $status_product,
                                    'stock' => $stock,
                                    'token' => $token
                                );
                insert($pdo, $req_prepare, 'produits');

                // $retour['cmd_id'] = $cmd_id;
                $error_text = ' Succes ! ';
                $error_text_second = "Le produit $name_product a été ajoutée. " ;
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
    // $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;
//echo 'OK';    
//echo ' <pre>'.print_r($_POST).'</pre>';
//echo ' <pre>';print_r($matiere);echo '</pre>';







