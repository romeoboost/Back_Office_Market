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
    //debugger($_POST);
    //verifie si tous les champs existent
    //

    if( !isset($start_date) || !isset($start_hour) || !isset($end_date) || !isset($end_hour) || !isset($name_product) || !isset($category_product) 
        || !isset($stock_product) || !isset($unit_mesure) || !isset($status_product) || !isset($promo_product) || !isset($amount_product) 
        || !isset($number_page_running) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
        //debugger($_POST);

    }else{
        // if( strlen($amount_product) == 0 ) { debugger($_POST); }
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($start_date) && empty($start_hour) && empty($end_date) && empty($end_hour) && empty($name_product) && strlen($category_product) == 0
            && strlen($stock_product) == 0 && strlen($unit_mesure) == 0 && strlen($status_product) == 0 && !isset($pagination) 
            && strlen($promo_product) == 0 && strlen($amount_product) == 0 )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner au moins l'un des champs avant de valider le formulaire"; 

        }else{

            $numero_page= empty( $number_page_running) ? 1 : intval($number_page_running);            
            $nombre_product=10;
            $offset = ($numero_page - 1 )*$nombre_product;

            $sql_liste="";

            $condition_sql_liste = " produits.date_creation BETWEEN :debut AND :fin ";

            //defini la date et heure de debut
            if( empty($start_date) ){
                $sql_syntaxe =" SELECT DATE(date_creation) as date_first, DATE_FORMAT(date_creation,'%H:%i:%s') hour_first
                    FROM produits 
                    ORDER BY id ASC 
                    LIMIT 0,1 ";
                $req_start_date = $pdo->prepare($sql_syntaxe); 
                $req_start_date->execute();
                $order_first = current( $req_start_date->fetchAll(PDO::FETCH_OBJ) );
                // debugger( $order_first );
                $start_date = $order_first->date_first;
                if( empty($start_hour) ){
                    $start_hour = $order_first->hour_first;
                }
            }else{
                $start_date = formatdate($start_date) ;
                if( empty($start_hour) ){
                    $start_hour = "00:00:00";
                }

            }

            // debugger($order_first);

            //defini la date et heure de fin
            $end_date= empty($end_date) ? date("Y-m-d") : formatdate($end_date);
            $end_hour= empty($end_hour) ? "23:59:59" : $end_hour;

            //rajoute les conditions pour la periode
            $conditions_prepare[':debut'] = $start_date.' '.$start_hour;
            $conditions_prepare[':fin'] = $end_date.' '.$end_hour;
            

            //rajoute condition pour le nom du produit
            if( !empty( $name_product ) ){
                $condition_sql_liste .= " AND produits.nom like :nom ";
                $conditions_prepare[':nom'] = '%'.strtolower( $name_product ).'%';
            }

            //rajoute condition pour categorie produits
            if( strlen($category_product) != 0 ){
                $condition_sql_liste .= " AND produits.id_categorie_produit =:id_categorie_produit ";
                $conditions_prepare[':id_categorie_produit'] = intval($category_product);
            }

            //rajoute condition pour stock
            if( strlen( $stock_product ) != 0 ){
                $condition_sql_liste .= " AND produits.stock =:stock ";
                $conditions_prepare[':stock'] = intval( $stock_product ) ;
            }

            //rajoute condition pour ID commande
            if( strlen( $unit_mesure ) != 0 ){
                $condition_sql_liste .= " AND produits.id_unite =:id_unite ";
                $conditions_prepare[':id_unite'] = intval ( $unit_mesure );
            }

            //rajoute condition pour status commande
            if( strlen($status_product) != 0 ){
                $condition_sql_liste .= " AND produits.statut =:status ";
                $conditions_prepare[':status'] = intval( $status_product ) ;
            }

            //rajoute condition pour promo 
            if( strlen($promo_product) != 0 ){
                $condition_sql_liste .= " AND produits.promo =:promo ";
                $conditions_prepare[':promo'] = intval( $promo_product );
            }

            //rajoute condition pour promo 
            if( strlen($amount_product) != 0 ){
                $condition_sql_liste .= " AND produits.prix_quantite_unitaire = :prix_quantite_unitaire ";
                $conditions_prepare[':prix_quantite_unitaire'] = intval( $amount_product );
            }

            //ordonner plus recent au plus ancien
            $order_sql = array('champs' => 'prix_quantite_unitaire', 'param' => 'ASC');

            //nombre de commande
            $limit = " $nombre_product OFFSET $offset ";

            $req = array();

            $req['condition'] = $condition_sql_liste;
            $req['limit'] = $limit;
            $req['order'] = $order_sql;
            $req['array_filter'] = $conditions_prepare;
            $req['fieldsmain'] = array('id AS id','nom AS nom_produit','token AS token_produit','quantite_unitaire as qtite_unit',
            'id_unite as unite','prix_quantite_unitaire as prix_qtite_unit','slug as slug','nouveau as isnew','promo as ispromo',
            'pourcentage_promo as percent_promo','image as image','statut AS produit_statut','stock AS stock','date_creation as date_creation');
            $req['fieldstwo'] = array('nom AS categorie','statut AS categorie_statut');
            $req['fieldsthree'] = array('nom AS taille');
            $req['fields'] = array( array('main' => 'id_categorie_produit','second' => 'id'),
                                    array('main' => 'id_taille','third' => 'id')
                                  );

            //debugger($req);
            //recuperation des produits
            $produits = sql_inner_join($pdo, $req, 'produits', 'categories_produits');
            // debugger($produits);

            $produits_stat['produits_non_cmd'] = 0;
            $produits_stat['produits_non_actif'] = 0;
            $produits_stat['produits_stock_off'] = 0;

            unset($req['limit']); //desactive la limite 
            $produits_stat['total'] = count( sql_inner_join($pdo, $req, 'produits', 'categories_produits') );

            //recuperation statistique produit jamais commandés
            $produits_non_cmd_sql_condition = " AND commandes_produits.id_produit IS NULL";
            $req_non_cmd['condition'] = $condition_sql_liste.$produits_non_cmd_sql_condition;
            $req_non_cmd['array_filter'] = $conditions_prepare;
            $req_non_cmd['fieldsmain'] = array( 'id AS id','nom AS nom_produit','token AS token_produit' );
            $req_non_cmd['fieldstwo'] = array( 'id_produit' );
            $req_non_cmd['fields'] = array( array('main' => 'id','second' => 'id_produit') );
            $produits_non_cmd = sql_left_join($pdo, $req_non_cmd, 'produits', 'commandes_produits');
            $produits_stat['produits_non_cmd'] = count ( $produits_non_cmd );
            

            if( strlen($stock_product) == 0 ){
                $req['condition'] = $condition_sql_liste.' AND produits.stock = 0';
                $produits_stockOff = sql_inner_join($pdo, $req, 'produits', 'categories_produits');
                $produits_stat['produits_stock_off'] = count ( $produits_stockOff );
            }else{
                $produits_stat['produits_stock_off'] = count( $produits );
            }

              // $condition_sql_liste .= " AND commandes.statut =:status ";

              if( strlen($status_product) == 0 ){               
                //total produits non actifs
                $req['condition'] = $condition_sql_liste.' AND produits.statut = 0';
                $produits_nonActif = sql_inner_join($pdo, $req, 'produits', 'categories_produits');
                $produits_stat['produits_non_actif'] = count ( $produits_nonActif );

              }else{

                if( intval( $status_product ) == 0 ){
                   //total produits non actifs
                    $produits_stat['produits_non_actif'] = count( $produits );
                }

              }
              
              //Recuperer les statistique
              $result['stat'] = $produits_stat;
            //RECUPERE LE HTML DE LA PAGINATION à laide dune fonction
              $nombre_pages = ceil( $produits_stat['total'] / $nombre_product );
              $result['html_pagination'] = html_pagination( $nombre_pages, $numero_page );


            //CREATION HTML liste de commandes
              $result['html_list_cmd'] = html_list_product($pdo, $produits, $produits_stat['total'], $offset );
              
            //debugger( $commandes );
               // start_date=&start_hour=&end_date=&end_hour=&name_product=&category_product=&stock_product=
               // &unit_mesure=&status_product=0&promo_product=&amount_product=&number_page_running=1
              $result['link_for_extract'] = SITE_BASE_URL.'produits/extraction/start_date&'.$start_date.'/start_hour&'.$start_hour.'/end_date&'.$end_date.
              '/end_hour&'.$end_hour.'/name_product&'.$name_product.'/category_product&'.$category_product.'/stock_product&'.$stock_product.
              '/unit_mesure&'.$unit_mesure.'/status_product&'.$status_product.'/promo_product&'.$promo_product.'/amount_product&'.$amount_product; 
              // debugger($result);
        }


    }
    
    
}

$retour['result']=$result;

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







