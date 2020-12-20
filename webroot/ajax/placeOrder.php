<?php
include 'connectDB.php';
include 'fonction.php';

if (empty(session_id())) {
    session_start();
    //$_SESSION['menu'] = 'Nous_Rejoindre';
}
//debugger($_SESSION);
$error_statut = false;
$error_text = '';
$error_text_second = '';
$field_error ='none';
$retour = array();
//$retour['enregistrement'] = 'non';

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page';
}else{
  // debugger($_SESSION);
  extract($_POST);
  if( !isset( $_SESSION['cart']['customer'] ) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = "Oups, Erreur !";
    $error_text_second = 'Veuillez lier un client à la commande.';
    //debugger($_POST);
  }else{
    if( empty( $_SESSION['cart']['customer'] ) )
    {
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = 'Veuillez lier un client à la commande.';
      //debugger($register_sexe);
    }else{

      //le token du client
      $userT = $_SESSION['cart']['customer']['token'];

      //verifier que le client existe en base
      $req_recup = $pdo->prepare('SELECT * FROM clients WHERE token = :token ORDER BY id DESC LIMIT 0,1'); 
      $req_recup->execute( array( ':token' => $userT ) );
      $client = current($req_recup->fetchAll(PDO::FETCH_OBJ));
      // debugger($client);
      if( empty($client) ){
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Merci de lier un client à la commande.';
      }else{
        // -- Verifier si le panier n'est pas vide ou sil existe
        if( !isset($_SESSION['cart']) || !isset($_SESSION['cart']['products_list']) || empty($_SESSION['cart']) 
          || empty( $_SESSION['cart']['products_list']) ){
          // debugger($_SESSION);
          $error_statut = true;
          $error_text = "Oups, Erreur !";
          $error_text_second = 'Votre panier est vide.';
        }else{

          //-- Verifier si les produits du panier existe bien en base
          $panier = array();
          $montant_cmde_HT = 0;
          $montant_cmde_TT = 0;
          $frais_livraison = 0;
          foreach ($_SESSION['cart']['products_list'] as $token_produit => $info_produit) {
              if(!$error_statut){
                  $req_recup = $pdo->prepare('SELECT * FROM produits WHERE token = :token ORDER BY id DESC LIMIT 0,1'); 
                  $req_recup->execute( array( ':token' => $token_produit ) );
                  $produit = current($req_recup->fetchAll(PDO::FETCH_OBJ));
                  if( empty($produit) ){
                    $error_statut = true;
                    $error_text = "Oups, Erreur !";
                    $error_text_second = 'Le produit d\'identfiant .'.$token_produit.' n\'existe pas.';
                  }else{
                    //-- verifier si le produite existe toujours en stock
                    //$nbreProduit_panier = intval($nbreProduit);
                    $nbreProduit = isset( $_SESSION['cart']['products_list'][$token_produit]['qtite_cart'] ) ? floatval($_SESSION['cart']['products_list'][$token_produit]['qtite_cart']) : 0 ;
                    if($produit->stock < $nbreProduit*$produit->quantite_unitaire || $produit->stock == 0){
                      $error_statut = true;
                      $error_text = "Oups, Erreur !";
                      $error_text_second = "Désolé le stock est épuisé pour le produit ".$produit->nom;
                      $error_text_second = ($produit->stock > 0 ) ? "Désolé il ne reste que ".$produit->stock." pour le produit ".$produit->nom :  $error_text_second;
                    }else{
                      //-- Recuperer les vrais informations du produits (le montant) 
                      $prix_produit = $produit->prix_quantite_unitaire - ($produit->prix_quantite_unitaire*$produit->pourcentage_promo/100);

                      $panier[$token_produit]['id'] = $produit->id;
                      $panier[$token_produit]['montant_panier'] = $prix_produit*$nbreProduit;
                      $panier[$token_produit]['nbre'] = $_SESSION['cart']['products_list'][$token_produit]['qtite_cart'];
                      $panier[$token_produit]['qtte_unitaire'] = $produit->quantite_unitaire;
                      $panier[$token_produit]['prix_qtte_unitaire'] = $prix_produit;


                      //-- Reconstituer le montant ht
                      $montant_cmde_HT += $panier[$token_produit]['montant_panier'];

                    }

                  }
              }
          }

          //verifier si le user back office est encore connecté et recuperer ses éléméents
          $req_recup = $pdo->prepare('SELECT * FROM utilisateurs WHERE token = :token ORDER BY id DESC LIMIT 0,1'); 
          $req_recup->execute( array( ':token' => $_SESSION['bo_user']['token'] ) );
          $user_bo = current($req_recup->fetchAll(PDO::FETCH_OBJ));

          if( empty($user_bo) ){
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Vous devriez être connecté.";
          }

          if(!$error_statut){
                // die();
                $shipping_details = array();

                // -- Verifier si le token destination n'est pas vide
                // $tokenDestination = isset( $_SESSION['cart']['shipping_dest'] ) ? $_SESSION['cart']['shipping_dest'] : 'mongsfsfccxxx';
                $tokenDestination['token'] = 'mongsfsfccxxx';

                $req_recup = $pdo->prepare('SELECT * FROM livraison_destinations WHERE token = :token ORDER BY id DESC LIMIT 0,1'); 
                $req_recup->execute( array( ':token' => $tokenDestination['token'] ) );
                $lieu_shipping = current($req_recup->fetchAll(PDO::FETCH_OBJ));

                
                //-- verifier si la destination existe en base
                if( empty($lieu_shipping) ){
                    $error_statut = true;
                    $error_text = "Oups, Erreur !";
                    $error_text_second = 'Veuillez choisir une commune de livraison dans la liste.';
                }else{

                    // debugger($lieu_shipping);
                     //-- recuperer les infos de la destination
                    $shipping_details['id'] = $lieu_shipping->id;
                    $shipping_details['frais'] = getFees($pdo, $montant_cmde_HT);
                    // $frais_livraison = $lieu_shipping->frais;
                    $frais_livraison = getFees($pdo, $montant_cmde_HT);

                    //-- Reconstituer le montant total
                    $montant_cmde_TT = $montant_cmde_HT + $frais_livraison;
                    $retour['panier'] = $panier;
                    $retour['montant_cmde_TT'] = $montant_cmde_TT;
                    $retour['frais_livraison'] = intval($frais_livraison);

                    $date = date("Y-m-d H:i:s");

                    // debugger($panier);
          					$req = $pdo->prepare(" SHOW TABLE STATUS LIKE 'commandes' ");
          					$req->execute( array() ); $Mbre_actuel_Obj = current( $req->fetchAll() );
          					$Nbre_Product_Actuel = isset($Mbre_actuel_Obj['Auto_increment']) ? intval( $Mbre_actuel_Obj['Auto_increment'] ) - 1 : 0;
                    					         
                    $token_cmde = getCmdeNumber($Nbre_Product_Actuel, 'MKT');

                    $req_insert = $pdo->prepare(' INSERT INTO commandes (
                                                              token, id_client, statut, montant_ht, frais_livraison, montant_total, id_livraison_destination, 
                                                              id_utilisateur, date_creation, date_modification
                                                           )
                                                  VALUES(
                                                        :token, :id_client, :statut, :montant_ht, :frais_livraison, :montant_total, :id_livraison_destination,
                                                        :id_utilisateur, :date_creation, :date_modification
                                                        )'
                                                );
               
                    $req_insert->execute( array( 
                        'token' => $token_cmde,
                        'id_client' => $client->id,
                        'statut' => 0,
                        'montant_ht' => $montant_cmde_HT,
                        'frais_livraison' => $frais_livraison,
                        'montant_total' => $montant_cmde_TT,
                        'id_livraison_destination' => $lieu_shipping->id,
                        'id_utilisateur' => $user_bo->id,
                        'date_creation' => $date,
                        'date_modification' => $date 
                        ) 
                    );

                    $req_recup = $pdo->prepare('SELECT id FROM commandes ORDER BY id DESC LIMIT 0,1'); 
                    $req_recup->execute();
                    $cmde_inserted = current($req_recup->fetchAll(PDO::FETCH_OBJ));

                    //-- insertion dans la table commandes_produits
                    foreach ($panier as $k => $p) {
                      # code...
                      $date = date("Y-m-d H:i:s");
                      $req_insert = $pdo->prepare(' INSERT INTO commandes_produits (
                                                              id_commande, id_produit, quantite,  qtte_unitaire, prix_qtte_unitaire, date_creation, date_modification
                                                           )
                                                  VALUES(
                                                        :id_commande, :id_produit, :quantite, :qtte_unitaire, :prix_qtte_unitaire, :date_creation, :date_modification
                                                        )'
                                                );
                      $req_insert->execute( array( 
                          'id_commande' => $cmde_inserted->id,
                          'id_produit' => $p['id'],
                          'quantite' => $p['nbre'],
                          'qtte_unitaire' => $p['qtte_unitaire'],
                          'prix_qtte_unitaire' => $p['prix_qtte_unitaire'],
                          'date_creation' => $date,
                          'date_modification' => $date 
                          ) 
                      );

                      $qtte_total = $p['nbre']*$p['qtte_unitaire'];
                       //-- update la table produit pour diminuer le nbre en stock
                      $req_recup = $pdo->prepare("UPDATE produits SET stock = stock - $qtte_total WHERE token = :token "); 
                      $req_recup->execute( array( ':token' => $k ) );

                      // $panier[$token_produit]['id'] = $produit->id;
                      // $panier[$token_produit]['montant_panier'] = $prix_produit*$nbreProduit;
                      // $panier[$token_produit]['nbre'] = $_SESSION['cart']['products_list'][$token_produit]['qtite_cart']; 
                    }

                    //-- insertion dans la table shipping_infos
                    $date = date("Y-m-d H:i:s");
                    // $loc_lat = strlen($loc_lat) == 0 ? 0 : $loc_lat ;
                    $loc_lat = 0 ;
                    // $loc_long = strlen($loc_long) == 0 ? 0 : $loc_long ;

                    $quartier = 'YAKRO';
                    $description_lieu_livraison = 'YAKRO';
                    $loc_long = 0 ;
                      $req_insert = $pdo->prepare(' INSERT INTO shipping_infos (
                                                              id_client, id_commande, nom, prenoms, tel, email, id_destination, quartier, 
                                                              longitude, lagitude, description, date_creation, date_modification
                                                           )
                                                  VALUES(
                                                        :id_client, :id_commande, :nom, :prenoms, :tel, :email, :id_destination, :quartier, 
                                                        :longitude, :lagitude, :description, :date_creation, :date_modification
                                                        )'
                                                );
                      $req_insert->execute( array( 
                          'id_client' => $client->id,
                          'id_commande' => $cmde_inserted->id,
                          'nom' => $client->nom,
                          'prenoms' => $client->prenoms,
                          'tel' => $client->tel,
                          'email' => $client->email,
                          'id_destination' => $lieu_shipping->id,
                          'quartier' => $quartier,
                          'longitude' => $loc_long,
                          'lagitude' => $loc_lat,
                          'description' => $description_lieu_livraison,
                          'date_creation' => $date,
                          'date_modification' => $date 
                          ) 
                      );
                    
                      $error_text = 'Commande enregistrée avec succès. <br>Numero de commande : '.$token_cmde;
                      $error_text_second = 'La commande part en validation.';

                      //Vider le panier du client 
                       $_SESSION['cart'] = array();

                }



          }
        



        }

      }
        
    

    }
  }
  
}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

$retour['error_text'] = $error_text;
$retour['error_text_second'] = $error_text_second;

$retour['error'] = 'non';
$retour['error_html'] = '';

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    //$retour['error_html'] = $error_html;
    $retour['field_error'] = $field_error;
    header('Operation echouée', true, 400);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;

/**
 * Modification sur la bd (11-12-2019)
 * ALTER TABLE `shipping_infos` ADD `longitude` VARCHAR(255) NOT NULL AFTER `quartier`;
 * ALTER TABLE `shipping_infos` ADD `lagitude` VARCHAR(255) NOT NULL AFTER `quartier`;
 * ALTER TABLE `shipping_infos` CHANGE `lagitude` `lagitude` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0', CHANGE `longitude` `longitude` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0';
 */

 /*
 * Modif DB (12-03-2020)
 * ALTER TABLE `commandes_produits` CHANGE `qtte_unitaire` `qtte_unitaire` FLOAT NULL DEFAULT NULL;
 * ALTER TABLE `produits` CHANGE `stock` `stock` FLOAT NOT NULL DEFAULT '0';
 */


