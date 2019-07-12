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
    //start_date=&start_hour=&end_date=&end_hour=&name_delivrer=&tel=&number_page_running=1
    if( !isset($start_date) || !isset($start_hour) || !isset($end_date) || !isset($end_hour) || !isset($tel) || !isset($name_delivrer) 
        || !isset($number_page_running) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'ERROR! Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
        //debugger($_POST);

    }else{
        // if( strlen($amount_product) == 0 ) { debugger($_POST); }
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($start_date) && empty($start_hour) && empty($end_date) && empty($end_hour) && empty($tel) && empty($name_delivrer)
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

            $condition_sql_liste = " livreurs.date_creation BETWEEN :debut AND :fin ";

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
            //[name_delivrer] =>   [tel] =>
            $name_delivrer = trim($name_delivrer);
            if( !empty( $name_delivrer ) ){
                $condition_sql_liste .= " AND (nom like :nom or prenoms like :prenoms )"; //LOWER(`Value`)
                $conditions_prepare[':nom'] = '%'.strtolower( $name_delivrer ).'%';
                $conditions_prepare[':prenoms'] = '%'.strtolower( $name_delivrer ).'%';
            }

            //rajoute condition pour categorie produits
            if( strlen($tel) != 0 ){
                $condition_sql_liste .= " AND livreurs.tel like :tel ";
                $conditions_prepare[':tel'] = '%'.trim( $tel ).'%';
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
            $livreurs['liste'] = sql_select($pdo, $req, 'livreurs');            

            $livreurs['total']['nbre'] = 0;

            unset($req['limit']); //desactive la limite 
            $livreurs['total']['nbre'] = count( sql_select($pdo, $req, 'livreurs') );
            // debugger($livreurs);

              //Recuperer les statistique
              $result['stat']['total']['nbre'] = $livreurs['total']['nbre'];
            //RECUPERE LE HTML DE LA PAGINATION à laide dune fonction
              $nombre_pages = ceil( $livreurs['total']['nbre'] / $nombre_product );
              $result['html_pagination'] = html_pagination( $nombre_pages, $numero_page );


            //CREATION HTML liste de commandes
              $result['html_list_elements'] = html_list_livreurs($pdo, $livreurs['liste'], $livreurs['total']['nbre'], $offset );
              // debugger($result);
              
              $result['link_for_extract'] = SITE_BASE_URL.'livreurs/extraction/start_date&'.$start_date.'/start_hour&'.$start_hour.'/end_date&'.$end_date.
              '/end_hour&'.$end_hour.'/name_delivrer&'.$name_delivrer.'/tel&'.$tel; 
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







