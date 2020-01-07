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
    if( !isset($start_date) || !isset($start_hour) || !isset($end_date) || !isset($end_hour) || !isset($tel_user) 
        || !isset($cmd_amount) || !isset($cmd_id) || !isset($status) || !isset($number_page_running) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);

    }else{

        //verifie si au moins un champs de filtre est renseigné
        if( empty($start_date) && empty($start_hour) && empty($end_date) && empty($end_hour) && empty($tel_user) 
            && empty($cmd_amount) && empty($cmd_id) && strlen($status) == 0 && !isset($pagination) )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner au moins l'un des champs avant de valider le formulaire."; 

        }else{

            $numero_page= empty( $number_page_running) ? 1 : intval($number_page_running);            
            $nombre_cmd=10;
            $offset = ($numero_page - 1 )*$nombre_cmd;

            // 'nom as client_nom ',' prenoms as client_prenoms ','tel as client_tel',
            // 'email as client_email'

            $sql_liste="SELECT rapide_commandes.montant_ht AS montant_ht, rapide_commandes.frais_livraison AS frais_livraison, 
                rapide_commandes.montant_total AS montant_total, rapide_commandes.token as cmd_id,
                rapide_commandes.statut as cmd_statut, rapide_commandes.date_creation as cmd_date_creation, 
                shipping_infos.nom as client_nom, shipping_infos.prenoms as client_prenoms, shipping_infos.tel as client_tel
              FROM rapide_commandes
              INNER JOIN shipping_infos ON rapide_commandes.id=shipping_infos.id_commande_rapide";

            $condition_sql_liste = " WHERE rapide_commandes.date_creation BETWEEN :debut AND :fin ";

            //defini la date et heure de debut
            if( empty($start_date) ){
                $sql_syntaxe =" SELECT DATE(date_creation) as date_first, DATE_FORMAT(date_creation,'%H:%i:%s') hour_first
                    FROM rapide_commandes 
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

            //defini la date et heure de debut
            $end_date= empty($end_date) ? date("Y-m-d") : formatdate($end_date);
            $end_hour= empty($end_hour) ? "23:59:59" : $end_hour;

            //rajoute les conditions pour la periode
            $conditions_prepare[':debut'] = $start_date.' '.$start_hour;
            $conditions_prepare[':fin'] = $end_date.' '.$end_hour;

            
            //rajoute condition pour le telephone du client
            if( !empty( $tel_user ) ){
                $condition_sql_liste .= " AND shipping_infos.tel =:user_tel ";
                $conditions_prepare[':user_tel'] = $tel_user;
            }

            //rajoute condition pour montant commande
            if( !empty( $cmd_amount ) ){
                $condition_sql_liste .= " AND rapide_commandes.montant_ht =:cmd_amount ";
                $conditions_prepare[':cmd_amount'] = $cmd_amount;
            }

            //rajoute condition pour ID commande
            if( !empty( $cmd_id ) ){
                $condition_sql_liste .= " AND rapide_commandes.token =:cmd_id ";
                $conditions_prepare[':cmd_id'] = $cmd_id;
            }

            //rajoute condition pour status commande
            if( strlen($status) != 0 ){
                $condition_sql_liste .= " AND rapide_commandes.statut =:status ";
                $conditions_prepare[':status'] = intval( $status ) ;
            }

            //ordonner plus recent au plus ancien
            $order_sql = " ORDER BY rapide_commandes.id DESC ";

            //nombre de commande
            $limit = " LIMIT $nombre_cmd OFFSET $offset ";

            //recuperation de la liste des rapide_commandes
            $req_cmd_list = $pdo->prepare($sql_liste.' '.$condition_sql_liste.' '.$order_sql.' '.$limit); //':email' => $user_login,
            $req_cmd_list->execute($conditions_prepare);
            $commandes = $req_cmd_list->fetchAll(PDO::FETCH_OBJ);
            // debugger($commandes);         

            //RECUPERTAION STATISTIQUE
            $sql_liste_stat = " SELECT SUM(rapide_commandes.montant_ht) as montant_ht, COUNT(rapide_commandes.id) as nbre
                                FROM rapide_commandes 
                                INNER JOIN shipping_infos ON rapide_commandes.id=shipping_infos.id_commande_rapide ";
            //Total commades
              $req_cmd_stat_total = $pdo->prepare( $sql_liste_stat.' '.$condition_sql_liste );
              $req_cmd_stat_total->execute($conditions_prepare);
              $stat_total = current ( $req_cmd_stat_total->fetchAll(PDO::FETCH_OBJ) );

              //$result['total_cmd']['montant'] = number_format($stat_total->montant_ht, 0, '', ' '); //$stat_total->montant_ht;
              $result['total_cmd']['nbre'] = $stat_total->nbre;

              $result['total_cmd_livrees']['montant'] =0;
              $result['total_cmd_livrees']['nbre'] = 0;
              $result['total_cmd_pending']['montant'] =0;
              $result['total_cmd_pending']['nbre'] = 0;
              $result['total_cmd_on_road']['montant'] =0;
              $result['total_cmd_on_road']['nbre'] = 0;
              $result['total_cmd_rejected']['montant'] = 0;
              $result['total_cmd_rejected']['nbre'] = 0;
              $result['total_cmd_cancelled']['montant'] = 0;
              $result['total_cmd_cancelled']['nbre'] = 0;

              $condition_sql_liste .= " AND rapide_commandes.statut =:status ";

              if( strlen($status) == 0 ){               

                //total commandes livrées
                $conditions_prepare[':status'] = 1 ;
                $req_cmd_stat_livrees = $pdo->prepare( $sql_liste_stat.' '.$condition_sql_liste );
                $req_cmd_stat_livrees->execute($conditions_prepare);
                $stat_livrees = current ( $req_cmd_stat_livrees->fetchAll(PDO::FETCH_OBJ) );
                $result['total_cmd_livrees']['montant'] = number_format($stat_livrees->montant_ht, 0, '', ' ');
                $result['total_cmd_livrees']['nbre'] = $stat_livrees->nbre;

                //EN ATTENTE
                $conditions_prepare[':status'] = 0 ;
                $req_cmd_stat_pending = $pdo->prepare( $sql_liste_stat.' '.$condition_sql_liste );
                $req_cmd_stat_pending->execute($conditions_prepare);
                $stat_pending = current ( $req_cmd_stat_pending->fetchAll(PDO::FETCH_OBJ) );
                $result['total_cmd_pending']['nbre'] = $stat_pending->nbre;

                //EN LIVRAISON
                $conditions_prepare[':status'] = 3 ;
                $req_cmd_stat_on_road = $pdo->prepare( $sql_liste_stat.' '.$condition_sql_liste );
                $req_cmd_stat_on_road->execute($conditions_prepare);
                $stat_on_road = current ( $req_cmd_stat_on_road->fetchAll(PDO::FETCH_OBJ) );
                $result['total_cmd_on_road']['montant'] = number_format($stat_on_road->montant_ht, 0, '', ' '); //$stat_on_road->montant_ht;
                $result['total_cmd_on_road']['nbre'] = $stat_on_road->nbre;

                //REJETEES
                $conditions_prepare[':status'] = 4 ;
                $req_cmd_stat_rejected = $pdo->prepare( $sql_liste_stat.' '.$condition_sql_liste );
                $req_cmd_stat_rejected->execute($conditions_prepare);
                $stat_rejected = current ( $req_cmd_stat_rejected->fetchAll(PDO::FETCH_OBJ) );
                $result['total_cmd_rejected']['nbre'] = $stat_rejected->nbre;


              }else{

                if( intval( $status ) == 1 ){
                   //total commandes livrées
                    $conditions_prepare[':status'] = 1 ;
                    $req_cmd_stat_livrees = $pdo->prepare( $sql_liste_stat.' '.$condition_sql_liste );
                    $req_cmd_stat_livrees->execute($conditions_prepare);
                    $stat_livrees = current ( $req_cmd_stat_livrees->fetchAll(PDO::FETCH_OBJ) );
                    $result['total_cmd_livrees']['montant'] = number_format($stat_livrees->montant_ht, 0, '', ' ');//$stat_livrees->montant_ht;
                    $result['total_cmd_livrees']['nbre'] = $stat_livrees->nbre; 
                }
                

                if( intval( $status ) == 0  ){
                    //EN ATTENTE
                    $req_cmd_stat_pending = $pdo->prepare( $sql_liste_stat.' '.$condition_sql_liste );
                    $req_cmd_stat_pending->execute($conditions_prepare);
                    $stat_pending = current ( $req_cmd_stat_pending->fetchAll(PDO::FETCH_OBJ) );
                    $result['total_cmd_pending']['nbre'] = $stat_pending->nbre;
                }

                if( intval( $status ) == 3  ){
                    //EN ATTENTE
                    $req_cmd_stat_on_road = $pdo->prepare( $sql_liste_stat.' '.$condition_sql_liste );
                    $req_cmd_stat_on_road->execute($conditions_prepare);
                    $stat_on_road = current ( $req_cmd_stat_on_road->fetchAll(PDO::FETCH_OBJ) );
                    $result['total_cmd_on_road']['montant'] = number_format($stat_on_road->montant_ht, 0, '', ' ');//$stat_on_road->montant_ht;
                    $result['total_cmd_on_road']['nbre'] = $stat_on_road->nbre;
                }

                if( intval( $status ) == 4  ){
                    $req_cmd_stat_rejected = $pdo->prepare( $sql_liste_stat.' '.$condition_sql_liste );
                    $req_cmd_stat_rejected->execute($conditions_prepare);
                    $stat_rejected = current ( $req_cmd_stat_rejected->fetchAll(PDO::FETCH_OBJ) );
                    $result['total_cmd_rejected']['nbre'] = $stat_rejected->nbre;
                }

              }

            //RECUPERE LE HTML DE LA PAGINATION à laide dune fonction
              $nombre_pages = ceil( $result['total_cmd']['nbre'] / $nombre_cmd );
              $result['html_pagination'] = html_pagination( $nombre_pages, $numero_page );
              

            //CREATION HTML liste de commandes
              $result['html_list_cmd'] = html_list_quick_cmd( $commandes, $result['total_cmd']['nbre'], $offset );
            //   debugger($result['html_list_cmd']);

              $result['link_for_extract'] = SITE_BASE_URL.'commandesRapide/extraction/start_date&'.$start_date.'/start_hour&'.$start_hour.'/end_date&'.$end_date.'/end_hour&'.$end_hour.'/tel_user&'.$tel_user.'/cmd_amount&'.$cmd_amount.'/cmd_id&'.$cmd_id.'/status&'.$status; 

        }

        
        // !isset($client_id) 
        // || !isset($cmd_amount) || !isset($cmd_id) || !isset($status) || !isset($number_page_running)
        // echo ' <pre>'.print_r($_POST).'</pre>';
        // die();
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







