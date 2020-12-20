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
  if( !isset($tokenProduit) || !isset($nombre) || !isset($tokenCommande) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = "Oups, Erreur !";
    $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
    //debugger($_POST);
  }else{
    if( empty($tokenProduit) || empty($nombre) || empty($tokenCommande) )
    {
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //debugger($register_sexe);
    }else{
      
        //Verfier si le produit existe en base
        $tokenProduit = strtolower($tokenProduit);
        $tokenCommande = strtolower($tokenCommande);
        $nombre = intval($nombre);

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

          $New_Nbre = $nombre;
          if( !empty( $produit_cmd ) ){
            $New_Nbre += $produit_cmd->quantite;
          }

          // debugger($New_Nbre);

          if($produit->stock < $New_Nbre*$produit->qtite_unit){ // verifie s'il y en a encore en stock
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Désolé le stock est épuisé pour le produit ".$produit->nom_produit;

            $error_text_second = ($produit->stock > 0 ) ? "Désolé il ne reste que ".$produit->stock." ".$symbole_unite." pour le produit ".$produit->nom_produit :  $error_text_second;
            //debugger($error_text);
          }else{ // y en a en stock et donc on ajoute au panier
            // debugger('Produit disponible en stock');

            $newInCart=true;
            $Iscartempty=true;

            $symbole_unite=($unites[$produit->unite] == 'NA') ? '' : $unites[$produit->unite]; //determine le symbole de lunite du produit
            $prix_produit = $produit->prix_qtite_unit - ($produit->prix_qtite_unit*$produit->percent_promo/100);

            $date = date("Y-m-d H:i:s");
            $quantite_cmd = $New_Nbre;
            $prix_produit_cmd = $prix_produit*$New_Nbre;

            //redefini le montant HT
            $montant_ht = $commande->montant_ht + $prix_produit*$nombre; 
            //redefini le montant reduit
            $montant_reduit = $montant_ht;
            //TVA
            $tva = ceil( $montant_ht*0.18 );
            //redefini le montant total
            $montant_total = $tva + $montant_ht; 

            $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;

            //mise à jour des infos de la commande
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
            // debugger($montant_total);
            // Verifie si le produit fait parti de la commande
            if( empty($produit_cmd) ){  
              //insertion dans la table commandes_produits
              $date = date("Y-m-d H:i:s");
              $req_insert = $pdo->prepare(' INSERT INTO commandes_produits (
                                                      id_commande, id_produit, quantite,  qtte_unitaire, prix_qtte_unitaire, date_creation, date_modification
                                                    )
                                          VALUES(
                                                :id_commande, :id_produit, :quantite, :qtte_unitaire, :prix_qtte_unitaire, :date_creation, :date_modification
                                                )'
                                        );
              $req_insert->execute( array( 
                  'id_commande' => $commande->id,
                  'id_produit' => $produit->id,
                  'quantite' => $quantite_cmd,
                  'qtte_unitaire' => $produit->qtite_unit,
                  'prix_qtte_unitaire' => $prix_produit,
                  'date_creation' => $date,
                  'date_modification' => $date 
                  ) 
              );

            }else{
              //update dans la table commandes_produits
              //mise à jour des infos de la commande
              $update_req = $pdo->prepare("UPDATE commandes_produits SET quantite = :quantite, 
                          prix_qtte_unitaire = :prix_qtte_unitaire, qtte_unitaire = :qtte_unitaire,
                          date_modification = :date_modification
                          WHERE id_commande = :id_commande AND id_produit = :id_produit "); 
              $update_req->execute( array( 
                      ':quantite' => $quantite_cmd,
                      ':prix_qtte_unitaire' => $prix_produit,
                      ':qtte_unitaire' => $produit->qtite_unit,
                      ':date_modification' => $date,
                      ':id_commande' => $commande->id,
                      ':id_produit' => $produit->id
                      ) 
                    );

            }

            //-- update la table produit pour diminuer le nbre en stock
            $qtte_total = $nombre*$produit->qtite_unit;              
            $req_recup = $pdo->prepare("UPDATE produits SET stock = stock - $qtte_total WHERE token = :token "); 
            $req_recup->execute( array( ':token' => $tokenProduit ) );

            $retour['linkToList'] = SITE_BASE_URL.'commandes/details_to_validation/'.$tokenCommande;

            $error_text = 'Produit ajouté avec succès.';
            $error_text_second = 'Voir le details de la commande !';     
          }
        // debugger($retour);
  

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

