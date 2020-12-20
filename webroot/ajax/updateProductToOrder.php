<?php
include 'connectDB.php';
include 'fonction.php';
if (empty(session_id())) {
    session_start();
    //$_SESSION['menu'] = 'Nous_Rejoindre';
}
// debugger($_POST);

$error_statut = false;
$error_text = '';
$error_text_second = '';
$field_error ='none';
$retour = array();
//$retour['enregistrement'] = 'non';

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page.';
}else{
  //preparer requete sql
  $sql_liste="SELECT produits.id AS id, produits.nom AS nom_produit, produits.token AS token_produit, 
  produits.quantite_unitaire as qtite_unit,
  produits.id_unite as unite, produits.prix_quantite_unitaire as prix_qtite_unit, produits.slug as slug,produits.nouveau as isnew,
  produits.promo as ispromo, produits.pourcentage_promo as percent_promo, produits.stock AS stock,
  produits.image as image, categories_produits.nom AS categorie
  FROM produits
  INNER JOIN categories_produits ON produits.id_categorie_produit=categories_produits.id ";

  $sql_liste.="WHERE produits.token =:token ";

  $tokenCommande = $_POST['tokenCommande'];
  unset($_POST['tokenCommande']);
  // debugger($_POST);

  //recuperation des infos de la commande
  $req_recup = $pdo->prepare('SELECT * FROM commandes WHERE token = :token ORDER BY id DESC'); 
  $req_recup->execute( array( ':token' => $tokenCommande ) );
  $commande = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

  if( empty($commande) ){
    $error_statut = true;
    $error_text = "Oups, Erreur !";
    $error_text_second = "La commande n'existe pas.";
  }else{
    //Faire une boucle sur la liste des produits
    foreach ($_POST as $token => $value) {

      //recueper les infos du produit en base
      $conditions_prepare[':token']=$token;
      $req = $pdo->prepare($sql_liste);
      $req->execute($conditions_prepare);
      $produit = current($req->fetchAll(PDO::FETCH_OBJ));

      //Recuperer les infos du produits dans la liste des produit commandé
      $req_recup = $pdo->prepare('SELECT * FROM commandes_produits 
        WHERE id_commande = :id_commande and id_produit = :id_produit ORDER BY id DESC'); 
      $req_recup->execute( array( ':id_commande' => $commande->id, ':id_produit' => $produit->id ) );
      $produit_cmd = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

      //verifie si le produit est dans la commande
      if( empty($produit_cmd) ){
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "Echec de modification de votre commande.";
      }else{
        //debugger($produit_cmd);
        //verifie que le nombre de produit n'est pas 0
        if( !isset($value) || intval($value) == 0 ){
          $error_statut = true;
          $error_text = "Oups, Erreur !";
          $error_text_second = "Désolé la valeur du nombre de produit doit être numerique et supérieur à 0.";
        }else{

          $value = intval($value);
          //verifie si le produit est encore disponible en stock
          if($produit->stock < $value*$produit->qtite_unit){
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Désolé le stock restant pour le produit ".$produit->nom_produit." est moins 
                                  de ".$value*$produit->qtite_unit." ( $value x $produit->qtite_unit )";
            //debugger($error_text);
          }
        }
        
      }
    }

  }
  

  //debugger($error_text);

  //SI les produits ont passé l'étape de checking
  if(!$error_statut){
    $montant_ht = 0;
    foreach ($_POST as $token => $value) {
      $date = date("Y-m-d H:i:s");

      $conditions_prepare[':token']=$token;
      $req = $pdo->prepare($sql_liste);
      $req->execute($conditions_prepare);
      $produit = current($req->fetchAll(PDO::FETCH_OBJ));

      $value = intval($value); 
      $prix_produit = $produit->prix_qtite_unit - ($produit->prix_qtite_unit*$produit->percent_promo/100);
      $quantite_cmd = $value;
      $prix_produit_cmd = $prix_produit*$value;

      $montant_ht += $prix_produit*$value;

      //Recuperer les infos du produits dans la liste des produit commandé
      $req_recup = $pdo->prepare('SELECT * FROM commandes_produits 
        WHERE id_commande = :id_commande and id_produit = :id_produit ORDER BY id DESC'); 
      $req_recup->execute( array( ':id_commande' => $commande->id, ':id_produit' => $produit->id ) );
      $produit_cmd = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

      //mettre a jour le produit
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

      
      //compare le nombre de produit de la commande initiale au nombre modufié
      $diff_nombre = $value - $produit_cmd->quantite;

      //si le nombre de produit modifié est supérieur au nombre initial dans la commande
      if( $diff_nombre > 0 ){
        //retirer la difference au stock
        $qtte_total = $diff_nombre*$produit->qtite_unit;              
        $req_recup = $pdo->prepare("UPDATE produits SET stock = stock - $qtte_total WHERE token = :token "); 
        $req_recup->execute( array( ':token' => $produit->token_produit ) );
      }else{
        if( $diff_nombre < 0 ){
          //ajouter la difference au stock
          $diff_nombre = abs($diff_nombre);
          $qtte_total = $diff_nombre*$produit_cmd->qtte_unitaire;              
          $req_recup = $pdo->prepare("UPDATE produits SET stock = stock + $qtte_total WHERE token = :token "); 
          $req_recup->execute( array( ':token' => $produit->token_produit ) );
        }
      }

      // debugger($montant_ht);

    }

    // debugger($montant_ht);

    $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;

    $date = date("Y-m-d H:i:s");
    //redefini le montant reduit
    $montant_reduit = $montant_ht;
    //TVA
    $tva = ceil( $montant_ht*0.18 );
    //redefini le montant total
    $montant_total = $tva + $montant_ht;
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

    $retour['linkToList'] = SITE_BASE_URL.'commandes/details_to_validation/'.$tokenCommande;
    $error_text = 'Commandes modifiée avec succès.';
    $error_text_second = 'Dépechez vous de commander !';

  }
  
  //debugger($_SESSION['cart']['products_list']);

}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

$retour['error'] = 'non';
$retour['error_html'] = '';
$retour['error_text'] = $error_text;
$retour['error_text_second'] = $error_text_second;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    //$retour['field_error'] = $field_error;
    header('Operation echouée', true, 400);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;




