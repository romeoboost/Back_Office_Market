<?php
include 'connectDB.php';
include 'fonction.php';
if (empty(session_id())) {
    session_start();
    //$_SESSION['menu'] = 'Nous_Rejoindre';
}
// debugger($_SESSION);
$error_statut = false;
$error_text = '';
$error_text_second = '';
$field_error ='none';
$retour = array();
$retour['enregistrement'] = 'non';
if( isset($_GET) && isset($_SESSION) ){
  //debugger($_SESSION);
  // session_destroy();
  // die();
}

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page.';
}else{
  // debugger($_POST);
  extract($_POST);
  //[tokenProduit] => PDT2020030029AM, [tokenCommande] => CMD2019050040MKT, [nombre] => 1
  if( !isset($tokenProduit) || !isset($tokenCommande) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = "Oups, Erreur !";
    $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
    //debugger($_POST);
  }else{
    if( empty($tokenProduit) || empty($tokenCommande) )
    {
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //debugger($register_sexe);
    }else{
      
        //Verfier si le produit existe en base
        $tokenProduit = strtolower($tokenProduit);
        $tokenCommande = strtolower($tokenCommande);

        $conditions_prepare=array();

        $sql_liste="SELECT produits.id AS id, produits.nom AS nom_produit, produits.token AS token_produit, 
        produits.quantite_unitaire as qtite_unit,
        produits.id_unite as unite, produits.prix_quantite_unitaire as prix_qtite_unit, produits.slug as slug,produits.nouveau as isnew,
        produits.promo as ispromo, produits.pourcentage_promo as percent_promo, produits.stock AS stock,
        produits.image as image, categories_produits.nom AS categorie
        FROM produits
        INNER JOIN categories_produits ON produits.id_categorie_produit=categories_produits.id
        ";

        $sql_liste.="WHERE produits.token =:token ";
        $conditions_prepare[':token']=$tokenProduit;
        $req = $pdo->prepare($sql_liste); 
        $req->execute($conditions_prepare);

        $produit = current($req->fetchAll(PDO::FETCH_OBJ));
        // debugger($produit);

        //recupere le tableau des unites
        $sql_unite="SELECT id,libelle,symbole FROM unites";
        $req_unite = $pdo->prepare($sql_unite);
        $req_unite->execute(array());
        $unites_from_bd = $req_unite->fetchAll(PDO::FETCH_OBJ);
        foreach ($unites_from_bd as $u) {
           $unites[$u->id] = $u->symbole;
         }

        $symbole_unite=($unites[$produit->unite] == 'NA') ? '' : $unites[$produit->unite]; //determine le symbole de lunite du produit

        if ( empty($produit) ) {
          $error_statut = true;
          $error_text = "Oups, Erreur !";
          $error_text_second = "ce produit n'est pas disponible.";
        }else{

          // debugger('Nombre de produit : '. $nombre);
          //recuperation des infos de la commande
          $req_recup = $pdo->prepare('SELECT * FROM commandes WHERE token = :token ORDER BY id DESC'); 
          $req_recup->execute( array( ':token' => $tokenCommande ) );
          $commande = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

          //Recuperer les infos du produits dans la liste des produit commandé
          $req_recup = $pdo->prepare('SELECT * FROM commandes_produits 
            WHERE id_commande = :id_commande and id_produit = :id_produit ORDER BY id DESC'); 
          $req_recup->execute( array( ':id_commande' => $commande->id, ':id_produit' => $produit->id ) );
          $produit_cmd = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

          if( empty($produit_cmd) || empty($commande) ){
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "ce produit ne fait plus partie de la commande.";
            $error_text_second = empty($commande) ? "Cette commande n'existe plus." : $error_text_second;
          }else{
            $prix_produit_cmd = $produit_cmd->quantite*$produit_cmd->prix_qtte_unitaire;

            //redefini le montant HT
            $montant_ht = $commande->montant_ht - $prix_produit_cmd; 
            //redefini le montant reduit
            $montant_reduit = $montant_ht;
            //TVA
            $tva = ceil( $montant_ht*0.18 );
            //redefini le montant total
            $montant_total = ceil( $tva + $montant_ht ); 

            // debugger($montant_ht);

            $date = date("Y-m-d H:i:s");
            $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;

            //supprimer le produit dans la commande
            $update_req = $pdo->prepare("DELETE FROM commandes_produits 
              WHERE id_commande = :id_commande AND id_produit = :id_produit  "); 
            $update_req->execute( array( ':id_commande' => $commande->id, ':id_produit' => $produit->id ) );

            //mettre à jour le stock
            $produit_nombre_cmd = $produit_cmd->quantite*$produit_cmd->qtte_unitaire; 
            $req_recup = $pdo->prepare("UPDATE produits SET stock = stock + $produit_nombre_cmd WHERE token = :token "); 
            $req_recup->execute( array( ':token' => $tokenProduit ) );

            if( $montant_ht > 0 ){
              //met à jour la commande
              $update_req = $pdo->prepare("UPDATE commandes SET montant_ht = :montant_ht, montant_total = :montant_total, 
                                        id_utilisateur = :id_utilisateur, montant_reduction = :montant_reduction,
                                        date_modification = :date_modification
                                        WHERE token = :token "); 
              $update_req->execute( array( 
                                      ':montant_ht' => $montant_ht,
                                      ':id_utilisateur' => $id_bo_user,
                                      ':montant_reduction' => $montant_reduit,
                                      ':montant_total' => $montant_total,
                                      ':date_modification' => $date,
                                      ':token' => $tokenCommande
                                      ) 
                                    );
              
              $error_text = 'Produit retiré avec succès.';
              $error_text_second = '';
            }else{
              //supprime la commande
              $delete_req = $pdo->prepare("DELETE FROM commandes WHERE token = :token  "); 
              $delete_req->execute( array( ':token' => $tokenCommande ) ); 

              $error_text = 'Produit retiré avec succès.';
              $error_text_second = "La commande a été également supprimée, vu que c'était le dernier produit contenu dans commande.";
            }

            $retour['linkToList'] = SITE_BASE_URL.'commandes/details_to_validation/'.$tokenCommande;


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

