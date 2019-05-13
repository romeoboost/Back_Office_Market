<?php
include 'connectDB.php';
include 'fonction.php';
define('WEBROOT_URL', 'http://localhost/Market/webroot/');
define('SITE_BASE_URL', 'http://localhost/Market/');
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
  //debugger($_POST);
  extract($_POST);
  if( !isset($userT) || !isset($nom) || !isset($prenoms) || !isset($tel) || !isset($email) || !isset($lieu_livraison) || !isset($quartier)
   || !isset($description_lieu_livraison) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = "Oups, Erreur !";
    $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
    //debugger($_POST);
  }else{
    if( empty($userT) || empty($nom) || empty($prenoms) || empty($tel) || empty($email) || empty($lieu_livraison) || empty($quartier) )
    {
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //debugger($register_sexe);
    }else{
      //verifier que le client existe en base
      $req_recup = $pdo->prepare('SELECT * FROM clients WHERE token = :token ORDER BY id DESC LIMIT 0,1'); 
      $req_recup->execute( array( ':token' => $userT ) );
      $client = current($req_recup->fetchAll(PDO::FETCH_OBJ));
      if( empty($client) ){
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Vous devez être connecté pour commander.';
      }else{
        // -- Verifier si le panier n'est pas vide ou sil existe
        if( !isset($_SESSION['cart']) || !isset($_SESSION['cart']['products_list']) || empty($_SESSION['cart']) 
          || empty( $_SESSION['cart']['products_list']) ){
          debugger($_SESSION);
          $error_statut = true;
          $error_text = "Oups, Erreur !";
          $error_text_second = 'Votre panier est vide. 1';
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
                    $error_text_second = 'Votre panier est vide.'.$token_produit;
                  }else{
                    //-- verifier si le produite existe toujours en stock
                    //$nbreProduit_panier = intval($nbreProduit);
                    $nbreProduit = isset( $_SESSION['cart']['products_list'][$token_produit]['qtite_cart'] ) ? intval($_SESSION['cart']['products_list'][$token_produit]['qtite_cart']) : 0 ;
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

          if(!$error_statut){
                $shipping_details = array();

                // -- Verifier si le token destination n'est pas vide
                $tokenDestination = isset( $_SESSION['cart']['shipping_dest'] ) ? $_SESSION['cart']['shipping_dest'] : '';

                $req_recup = $pdo->prepare('SELECT * FROM livraison_destinations WHERE token = :token ORDER BY id DESC LIMIT 0,1'); 
                $req_recup->execute( array( ':token' => $tokenDestination['token'] ) );
                $lieu_shipping = current($req_recup->fetchAll(PDO::FETCH_OBJ));

                
                //-- verifier si la destination existe en base
                if( empty($lieu_shipping) ){
                    $error_statut = true;
                    $error_text = "Oups, Erreur !";
                    $error_text_second = 'Veuillez choisir une commune de livraison dans la liste.';
                }else{
                     //-- recuperer les infos de la destination
                    $shipping_details['id'] = $lieu_shipping->id;
                    $shipping_details['frais'] = $lieu_shipping->frais;
                    $frais_livraison = $lieu_shipping->frais;

                    //-- Reconstituer le montant total
                    $montant_cmde_TT = $montant_cmde_HT + $frais_livraison;
                    $retour['panier'] = $panier;
                    $retour['montant_cmde_TT'] = $montant_cmde_TT;
                    $retour['frais_livraison'] = intval($frais_livraison);

                    $date = date("Y-m-d H:i:s");

                    //-- insertion dans la table commandes
                    $req = $pdo->prepare('SELECT COUNT(id) as nbre FROM commandes '); 
                    $req->execute(array());
                    $Mbre_actuel_Obj = current($req->fetchAll(PDO::FETCH_OBJ));

                    $token_cmde = getCmdeNumber($Mbre_actuel_Obj->nbre, 'MKT');

                    $req_insert = $pdo->prepare(' INSERT INTO commandes (
                                                              token, id_client, statut, montant_ht, frais_livraison, montant_total, id_livraison_destination, 
                                                              date_creation, date_modification
                                                           )
                                                  VALUES(
                                                        :token, :id_client, :statut, :montant_ht, :frais_livraison, :montant_total, :id_livraison_destination,
                                                        :date_creation, :date_modification
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
                      $req_insert = $pdo->prepare(' INSERT INTO shipping_infos (
                                                              id_client, id_commande, nom, prenoms, tel, email, id_destination, quartier, 
                                                              description, date_creation, date_modification
                                                           )
                                                  VALUES(
                                                        :id_client, :id_commande, :nom, :prenoms, :tel, :email, :id_destination, :quartier, 
                                                              :description, :date_creation, :date_modification
                                                        )'
                                                );
                      $req_insert->execute( array( 
                          'id_client' => $client->id,
                          'id_commande' => $cmde_inserted->id,
                          'nom' => $nom,
                          'prenoms' => $prenoms,
                          'tel' => $tel,
                          'email' => $email,
                          'id_destination' => $lieu_shipping->id,
                          'quartier' => $quartier,
                          'description' => $description_lieu_livraison,
                          'date_creation' => $date,
                          'date_modification' => $date 
                          ) 
                      );
                    
                      $error_text = 'Commande enregistrée avec Succès. <br>Numero de commande : '.$token_cmde;
                      $error_text_second = 'Vous serez livré dans un délais de 24H';

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




