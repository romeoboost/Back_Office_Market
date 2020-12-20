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
$field_error ='none';
$retour = array();
$retour['enregistrement'] = 'non';
$error_text = "Oups, Erreur !";

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
}else{
  //debugger($_POST);
  extract($_POST);
  //verifier si les champs existe
  if( !isset($cmd_id) || !isset($cmd_montant_reduct) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text_second = 'Aucun Champs ne doit manquer';
    //debugger($_POST);
  }else{
    //verifier si les champs obligatoires ne sont pas vides
    if( empty($cmd_id)  ) //verifie si les champs obligatoires sont pas vides
    {
      $error_statut = true;
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      
    }else{
        
        $cmd_id = trim($cmd_id);
        $cmd_montant_reduct = intval($cmd_montant_reduct);
        // debugger($cmd_montant_reduct);

        $req_recup = $pdo->prepare('SELECT * FROM commandes WHERE token = :token ORDER BY id DESC'); 
        $req_recup->execute( array( ':token' => $cmd_id ) );
        $commande = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

        //verifie si le statut de la commande est vraiment en attente
        if( $commande->statut != 0 && $commande->statut != 4){
          $error_statut = true;
          $error_text_second = 'La commande doit avoir le statut " EN ATTENTE " ou " REJETTEE ".';

        }else{
          ###### verifier que les produits sont toujours disponibles en stock ####
          //Recuperer la liste des produits dans la commande
          $req_recup = $pdo->prepare('SELECT * FROM commandes_produits 
            WHERE id_commande = :id_commande ORDER BY id DESC'); 
          $req_recup->execute( array( ':id_commande' => $commande->id ) );
          $produits_cmd_list = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

          if( empty($produits_cmd_list) ){
            $error_statut = true;
            $error_text = 'Oups, Erreur.'; 
            $error_text_second = 'La commande ne contient pas de produits.'; 
          }else{


            foreach ($produits_cmd_list as $produit_cmd) {
              if(!$error_statut){
                  $req_recup = $pdo->prepare('SELECT * FROM produits WHERE id = :id ORDER BY id DESC LIMIT 0,1'); 
                  $req_recup->execute( array( ':id' => $produit_cmd->id_produit ) );
                  $produit = current($req_recup->fetchAll(PDO::FETCH_OBJ));
                  if( empty($produit) ){
                    $error_statut = true;
                    $error_text = "Oups, Erreur !";
                    $error_text_second = "Certains produits contenus n'existent plus.";
                  }else{
                    //-- verifier si le produite existe toujours en stock
                    //$nbreProduit_panier = intval($nbreProduit); ################### BREAK ##########
                    if($produit->stock < $produit_cmd->quantite*$produit_cmd->qtte_unitaire || $produit->stock == 0){
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




          }



          ///////-------- TRAITEMENT FINAL -----//////
          //definir le montant de reduction
          $cmd_montant_reduct = ($cmd_montant_reduct == 0) ? $commande->montant_ht : $cmd_montant_reduct;

          $tva = ceil( $cmd_montant_reduct*0.18 );
          //redefini le montant total
          $montant_total = ceil( $tva + $cmd_montant_reduct );

          // debugger($cmd_montant_reduct);
          //Mise à jour du statut de la commande
          $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;
          $date = date("Y-m-d H:i:s");
          $statut = 7;
          //Modifie le statut de la commande
          $update_req = $pdo->prepare("UPDATE commandes SET statut = :statut, 
                                      date_modification = :date_modification, id_utilisateur = :id_utilisateur, 
                                      montant_total = :montant_total, montant_reduction = :montant_reduction
                                      WHERE token = :token "); 
          $update_req->execute( array( 
                                  ':statut' => $statut,
                                  ':id_utilisateur' => $id_bo_user,
                                  ':montant_reduction' => $cmd_montant_reduct,
                                  ':montant_total' => $montant_total,
                                  ':date_modification' => $date,
                                  ':token' => $cmd_id
                                  ) 
                                );
          $retour['cmd_id'] = $cmd_id;
          $retour['cmd_statut'] = $commande->statut;
          $retour['linkToList'] = SITE_BASE_URL.'commandes/liste_to_validation';
          // $btn_confirm_shipping_html = '<button type="button" class="btn btn-icon-toggle set-stop-shipping-btn" data-toggle="tooltip" cmd-id="'.$cmd_id.'"
          //                                   data-placement="top" data-original-title="Arrêter la livraison">
          //                                   <i class="fa fa-pause"></i>
          //                               </button> ';
          // $retour['btn_confirm_shipping_html'] = $btn_confirm_shipping_html;
          $error_text = ' Succes ! ';
          $error_text_second = "La commande $cmd_id a été Validée. Le client peut effectuer le paiement à la caisse." ;

          ///////-------- FIN TRAITEMENT FINAL -----//////

        }
    }
  }
  
}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

$retour['error_text'] = $error_text;
$retour['error_text_second'] = $error_text_second;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text . '</span><br> 
                        <span class="">' . $error_text_second . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;



