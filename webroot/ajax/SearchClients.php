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
    // [start_date] => 26-05-2019, [start_hour] => , [end_date] =>, [end_hour] =>, [nom] => Kesso, [prenoms] => Romeo
    // [client_id] => CLI055525MTK, [tel] => 01010101, [status] => 1, [sexe] => 1
    //
    if( !isset($start_date) || !isset($start_hour) || !isset($end_date) || !isset($end_hour) || !isset($nom)
     || !isset($prenoms) || !isset($client_id) || !isset($tel) || !isset($status) || !isset($sexe)  || !isset($number_page_running) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
        //debugger($_POST);
    }else{
        // if( strlen($amount_product) == 0 ) { debugger($_POST); }
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($start_date) && empty($start_hour) && empty($end_date) && empty($end_hour) && empty($nom) && empty($prenoms) 
            && empty($client_id) && empty($tel) && strlen($sexe) == 0 && strlen($status) == 0 && !isset($pagination) )
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

            $condition_sql_liste = " clients.date_creation BETWEEN :debut AND :fin ";

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
            $nom = trim($nom);
            if( !empty( $nom ) ){
                $condition_sql_liste .= " AND clients.nom like :nom ";
                $conditions_prepare[':nom'] = '%'.strtolower( $nom ).'%';
            }

            //rajoute condition pour le nom du produit
            $prenoms = trim($prenoms);
            if( !empty( $prenoms ) ){
                $condition_sql_liste .= " AND clients.prenoms like :prenoms ";
                $conditions_prepare[':prenoms'] = '%'.strtolower( $prenoms ).'%';
            }

            //rajoute condition pour le nom du produit
            $client_id = trim($client_id);
            if( !empty( $client_id ) ){
                $condition_sql_liste .= " AND clients.token like :client_id ";
                $conditions_prepare[':client_id'] = '%'.strtolower( $client_id ).'%';
            }
            // [nom] => Kesso, [prenoms] => Romeo, [client_id] => CLI055525MTK, [tel] => 01010101, [status] => 1, [sexe] => 1
            //rajoute condition pour le nom du produit
            $tel = trim($tel);
            if( !empty( $tel ) ){
                $condition_sql_liste .= " AND clients.tel like :tel ";
                $conditions_prepare[':tel'] = '%'.strtolower( $tel ).'%';
            }

            //rajoute condition pour categorie produits
            if( strlen($status) != 0 ){
                $condition_sql_liste .= " AND clients.statut =:statut ";
                $conditions_prepare[':statut'] = intval($status);
            }

            //rajoute condition pour categorie produits
            if( strlen($sexe) != 0 ){
                $condition_sql_liste .= " AND clients.sexe =:sexe ";
                $conditions_prepare[':sexe'] = intval($sexe);
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
            $clients['listes'] = sql_select($pdo, $req, 'clients');
            
            $clients['non_actifs'] = 0;
            $clients['actifs'] = 0;

            unset($req['limit']); //desactive la limite 
            $clients['total'] = count( sql_select($pdo, $req, 'clients') );
              //  $d['clients']['non_actifs'] = $non_actifs;
                  // $d['clients']['actifs'] = $actifs;
                  // $d['clients']['total'] = $total;
            if( strlen($status) == 0 ){   //si le status ne fais pas partie du filtre            
                //total produits non actifs
                $req['condition'] = $condition_sql_liste.' AND clients.statut = 0';
                $clients_nonActif = sql_select($pdo, $req, 'clients');
                $clients['non_actifs'] = count ( $clients_nonActif );

                $req['condition'] = $condition_sql_liste.' AND clients.statut = 1';
                $clients_Actif = sql_select($pdo, $req, 'clients');
                $clients['actifs'] = count ( $clients_Actif );
            }else{
                if( intval( $status ) == 0 ){
                   //total categorie non actives
                    $clients['non_actifs'] = $clients['total'];
                }else{
                    //total categorie non actives
                    $clients['actifs'] = $clients['total'];
                }
            }
              
              //Recuperer les statistique
              $result['infos'] = $clients;
              unset($result['infos']['listes']);

            //RECUPERE LE HTML DE LA PAGINATION à laide dune fonction
              $nombre_pages = ceil( $clients['total'] / $nombre_product );
              $result['html_pagination'] = html_pagination( $nombre_pages, $numero_page );


            //CREATION HTML liste de commandes
              $result['html_list_clients'] = html_list_clients($pdo, $clients['listes'], $clients['total'], $offset );
              // debugger($result);
              
               // [nom] => Kesso, [prenoms] => Romeo, [client_id] => CLI055525MTK, [tel] => 01010101, [status] => 1, [sexe] => 1
              $result['link_for_extract'] = SITE_BASE_URL.'clients/extraction/start_date&'.$start_date.'/start_hour&'.$start_hour.'/end_date&'.$end_date.
              '/end_hour&'.$end_hour.'/nom&'.$nom.'/prenoms&'.$prenoms.'/client_id&'.$client_id.'/tel&'.$tel.'/status&'.$status.'/sexe&'.$sexe; 
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







