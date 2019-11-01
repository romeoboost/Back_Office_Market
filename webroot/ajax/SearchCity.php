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
    //start_date=&start_hour=&end_date=&end_hour=&filter_name=&filter_status=&number_page_running=1
    if( !isset($start_date) || !isset($start_hour) || !isset($end_date) || !isset($end_hour) || !isset($filter_name) || !isset($filter_status) 
        || !isset($number_page_running) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'ERROR! Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
        //debugger($_POST);

    }else{
        // if( strlen($amount_product) == 0 ) { debugger($_POST); }
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($start_date) && empty($start_hour) && empty($end_date) && empty($end_hour) && empty($filter_name) && strlen($filter_status) == 0
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

            $condition_sql_liste = " livraison_destinations.date_creation BETWEEN :debut AND :fin ";

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
            //start_date=&start_hour=&end_date=&end_hour=&filter_name=&filter_status=&number_page_running=1
            $filter_name = trim($filter_name);
            if( !empty( $filter_name ) ){
                $condition_sql_liste .= " AND (livraison_destinations.commune like :commune )"; //LOWER(`Value`)
                $conditions_prepare[':commune'] = '%'.strtolower( $filter_name ).'%';
            }

            //rajoute condition pour categorie produits
            if( strlen($filter_status) != 0 ){
                $condition_sql_liste .= " AND livraison_destinations.statut =:statut ";
                $conditions_prepare[':statut'] = intval($filter_status);
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

            // debugger($req);
            //recuperation des produits
            $communes['liste'] = sql_select($pdo, $req, 'livraison_destinations');            

            $communes['stat']['total']['nbre'] = 0;

            unset($req['limit']); //desactive la limite 
            $communes['stat']['total']['nbre'] = count( sql_select($pdo, $req, 'livraison_destinations') );

            //communes liées à aucune livraison
            $communes['stat']['no_order'] = getNeverOrderPlace( $pdo, $req )['nbre'];

              //liste de nombre de commande par id destination
            $communes['liste_order'] = getNeverOrderPlace( $pdo, $req )['liste'];
            // debugger($communes);

            $communes['stat']['non_actifs'] =  0;
            $communes['stat']['actifs'] = 0;

            if( strlen($filter_status) == 0 ){   //si le status ne fais pas partie du filtre            
                //total produits non actifs
                $req['condition'] = $condition_sql_liste.' AND livraison_destinations.statut = 0';
                $communes['stat']['non_actifs'] = count ( sql_select($pdo, $req, 'livraison_destinations') );

                $req['condition'] = $condition_sql_liste.' AND livraison_destinations.statut = 1';
                $communes['stat']['actifs'] = count ( sql_select($pdo, $req, 'livraison_destinations') );
            }else{
                if( intval( $filter_status ) == 0 ){
                   //total categorie non actives
                    $communes['stat']['non_actifs'] = $communes['stat']['total']['nbre'];
                }else{
                    //total categorie non actives
                    $communes['stat']['actifs'] = $communes['stat']['total']['nbre'];
                }
            }

            // debugger($communes);

            //Recuperer les statistique
            $result['stat'] = $communes['stat'];


            //RECUPERE LE HTML DE LA PAGINATION à laide dune fonction
              $nombre_pages = ceil( $communes['stat']['total']['nbre'] / $nombre_product );
              $result['html_pagination'] = html_pagination( $nombre_pages, $numero_page );
              // debugger($result['html_pagination']);

            //CREATION HTML liste de commandes
              $result['html_list_elements'] = html_list_communes($communes, $offset );
              // debugger($result);
              
              //start_date=&start_hour=&end_date=&end_hour=&filter_name=&filter_status=&number_page_running=1
              $result['link_for_extract'] = SITE_BASE_URL.'communesLivraison/extraction/start_date&'.$start_date.'/start_hour&'.$start_hour.'/end_date&'.$end_date.
              '/end_hour&'.$end_hour.'/filter_name&'.$filter_name.'/filter_status&'.$filter_status; 
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







