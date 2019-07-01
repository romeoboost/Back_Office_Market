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
    // [montant] =>  [name_product] =>   [name_supplier] => 
    //
    if( !isset($start_date) || !isset($start_hour) || !isset($end_date) || !isset($end_hour) || !isset($montant) || !isset($name_product) 
        || !isset($name_supplier) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'ERROR! Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);

    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($start_date) && empty($start_hour) && empty($end_date) && empty($end_hour) && empty($montant) && empty($name_product) && 
            empty($name_supplier) && !isset($pagination) )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner au moins l'un des champs avant de valider le formulaire."; 

        }else{
            // debugger($_POST);
            $numero_page= empty( $number_page_running) ? 1 : intval($number_page_running);            
            $nombre_product=10;
            $offset = ($numero_page - 1 )*$nombre_product;

            $sql_liste="";

            $condition_sql_liste = " stocks.date_creation BETWEEN :debut AND :fin ";

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
            // !isset($montant) || !isset($name_product)  || !isset($name_supplier)
            $montant = intval($montant);
            if( !empty( $montant ) ){
                $condition_sql_liste .= " AND stocks.montant like :montant ";
                $conditions_prepare[':montant'] = $montant ;
            }

            $name_product = trim($name_product);
            if( !empty( $name_product ) ){
                $condition_sql_liste .= " AND lower(produits.nom) like :name_product ";
                $conditions_prepare[':name_product'] = '%'.strtolower( $name_product ).'%';
            }

            $name_supplier = trim($name_supplier);
            if( !empty( $name_supplier ) ){
                $condition_sql_liste .= " AND lower(fournisseurs.nom) like :name_supplier ";
                $conditions_prepare[':name_supplier'] = '%'.strtolower( $name_supplier ).'%';
            }

            //ordonner plus recent au plus ancien
            $order_sql = array('champs' => 'stocks.id', 'param' => 'DESC');

            //nombre de commande
            $limit = " $nombre_product OFFSET $offset ";

            $req = array();

            $req['condition'] = $condition_sql_liste;
            $req['limit'] = $limit;
            $req['order'] = $order_sql;
            $req['fieldsmain'] = array('montant AS montant_ht','frais_livraison AS frais_livraison','montant_ttc AS montant_total',
                  'token as stock_id', 'quantite_initiale as qtte', 'date_creation AS date_creation', 'date_modification AS date_modification');
            $req['fieldstwo'] = array(' nom as produit ','stock as stock_restant','id_unite as unite');
            $req['fieldsthree'] = array(' nom as fournisseur_nom ');
            $req['fields'] = array(  
                                    array( 'main' => 'id_produit', 'second' => 'id' ),
                                    array( 'main' => 'id_fournisseur', 'third' => 'id' )
                                   );
            $req['array_filter'] = $conditions_prepare;

            //debugger($req);
            //recuperation des stocks
            $stocks['liste'] = sql_inner_join($pdo, $req, 'stocks', 'produits', 'fournisseurs');            

            $stocks['total']['montant'] = 0;
            $stocks['total']['nbre'] = 0;

            unset($req['limit']); //desactive la limite 
            $sql_liste_stat = " SELECT SUM(stocks.montant) as montant, COUNT(stocks.id) as nbre
                                FROM stocks 
                                INNER JOIN produits ON stocks.id_produit=produits.id 
                                INNER JOIN fournisseurs ON stocks.id_fournisseur=fournisseurs.id  ";
            // debugger($sql_liste_stat.' '.$condition_sql_liste);
            $req_total = $pdo->prepare( $sql_liste_stat.' WHERE '.$condition_sql_liste );
            $req_total->execute($conditions_prepare);
            $stat_total = current ( $req_total->fetchAll(PDO::FETCH_OBJ) );

            $stocks['total']['montant'] = number_format($stat_total->montant, 0, '', ' '); //$stat_total->montant_ht;
            $stocks['total']['nbre'] = $stat_total->nbre;
            
            // debugger($stocks);
              //Recuperer les statistique
              $result['stat'] = $stocks['total'];
            //RECUPERE LE HTML DE LA PAGINATION à laide dune fonction
              $nombre_pages = ceil( $stocks['total']['nbre'] / $nombre_product );
              $result['html_pagination'] = html_pagination( $nombre_pages, $numero_page );


            //CREATION HTML liste de commandes
              $result['html_list_stocks'] = html_list_stocks($pdo, $stocks['liste'], $stocks['total']['nbre'], $offset );
              // debugger($result);
              
              // !isset($montant) || !isset($name_product)  || !isset($name_supplier)
              $result['link_for_extract'] = SITE_BASE_URL.'stocks/extraction/start_date&'.$start_date.'/start_hour&'.$start_hour.'/end_date&'.$end_date.
              '/end_hour&'.$end_hour.'/montant&'.$montant.'/name_product&'.$name_product.'/name_supplier&'.$name_supplier; 
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







