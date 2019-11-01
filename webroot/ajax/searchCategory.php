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
    // debugger($_POST);
    //verifie si tous les champs existent
    //
    if( !isset($start_date) || !isset($start_hour) || !isset($end_date) || !isset($end_hour) || !isset($name_cotegory) || !isset($status_cotegory) 
        || !isset($number_page_running) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'ERROR! Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
        //debugger($_POST);

    }else{
        // if( strlen($amount_product) == 0 ) { debugger($_POST); }
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($start_date) && empty($start_hour) && empty($end_date) && empty($end_hour) && empty($name_cotegory) && strlen($status_cotegory) == 0
            && !isset($pagination) )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner au moins l'un des champs avant de valider le formulaire"; 

        }else{
            // debugger($_POST);
            $numero_page= empty( $number_page_running) ? 1 : intval($number_page_running);            
            $nombre_product=10;
            $offset = ($numero_page - 1 )*$nombre_product;

            $sql_liste="";

            $condition_sql_liste = " categories_produits.date_creation BETWEEN :debut AND :fin ";

            // debugger($order_first);

            //defini la date et heure de fin
            $start_date= empty($start_date) ? '2018-01-01' : formatdate($start_date);
            $start_hour= empty($start_hour) ? "00:00:00" : $start_hour;

            //defini la date et heure de fin
            $end_date= empty($end_date) ? date("Y-m-d") : formatdate($end_date);
            $end_hour= empty($end_hour) ? "23:59:59" : $end_hour;

            //rajoute les conditions pour la periode
            $conditions_prepare[':debut'] = $start_date.' '.$start_hour;
            $conditions_prepare[':fin'] = $end_date.' '.$end_hour;
            
            //rajoute condition pour le nom du produit
            $name_cotegory = trim($name_cotegory);
            if( !empty( $name_cotegory ) ){
                $condition_sql_liste .= " AND categories_produits.nom like :nom ";
                $conditions_prepare[':nom'] = '%'.strtolower( $name_cotegory ).'%';
            }

            //rajoute condition pour categorie produits
            if( strlen($status_cotegory) != 0 ){
                $condition_sql_liste .= " AND categories_produits.statut =:statut ";
                $conditions_prepare[':statut'] = intval($status_cotegory);
            }

            //ordonner plus recent au plus ancien
            $order_sql = array('champs' => 'id', 'param' => 'DESC');

            //nombre de commande
            $limit = " $nombre_product OFFSET $offset ";

            $req = array();

            $req['condition'] = $condition_sql_liste;
            $req['limit'] = $limit;
            $req['order'] = $order_sql;
            $req['array_filter'] = $conditions_prepare;

            //debugger($req);
            //recuperation des produits
            $categories = sql_select($pdo, $req, 'categories_produits');
            

            $categorie_stat['categorie_non_actifs'] = 0;
            $categorie_stat['categorie_actifs'] = 0;

            unset($req['limit']); //desactive la limite 
            $categorie_stat['total'] = count( sql_select($pdo, $req, 'categories_produits') );
              // 
            if( strlen($status_cotegory) == 0 ){   //si le status ne fais pas partie du filtre            
                //total produits non actifs
                $req['condition'] = $condition_sql_liste.' AND categories_produits.statut = 0';
                $categories_nonActif = sql_select($pdo, $req, 'categories_produits');
                $categorie_stat['categorie_non_actifs'] = count ( $categories_nonActif );

                $req['condition'] = $condition_sql_liste.' AND categories_produits.statut = 1';
                $categories_Actif = sql_select($pdo, $req, 'categories_produits');
                $categorie_stat['categorie_actifs'] = count ( $categories_Actif );
            }else{
                if( intval( $status_cotegory ) == 0 ){
                   //total categorie non actives
                    $categorie_stat['categorie_non_actifs'] = $categorie_stat['total'];
                }else{
                    //total categorie non actives
                    $categorie_stat['categorie_actifs'] = $categorie_stat['total'];
                }
            }
              
              //Recuperer les statistique
              $result['stat'] = $categorie_stat;
            //RECUPERE LE HTML DE LA PAGINATION à laide dune fonction
              $nombre_pages = ceil( $categorie_stat['total'] / $nombre_product );
              $result['html_pagination'] = html_pagination( $nombre_pages, $numero_page );


            //CREATION HTML liste de commandes
              $result['html_list_categories'] = html_list_categories($pdo, $categories, $categorie_stat['total'], $offset );
              // debugger($result);
              
              $result['link_for_extract'] = SITE_BASE_URL.'categories/extraction/start_date&'.$start_date.'/start_hour&'.$start_hour.'/end_date&'.$end_date.
              '/end_hour&'.$end_hour.'/name_cotegory&'.$name_cotegory.'/status_cotegory&'.$status_cotegory; 
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







