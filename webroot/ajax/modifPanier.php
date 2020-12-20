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
  //debugger($_SESSION['cart']['products_list']);
  //preparer requete sql
  $sql_liste="SELECT produits.id AS id, produits.nom AS nom_produit, produits.token AS token_produit, 
  produits.quantite_unitaire as qtite_unit,
  produits.id_unite as unite, produits.prix_quantite_unitaire as prix_qtite_unit, produits.slug as slug,produits.nouveau as isnew,
  produits.promo as ispromo, produits.pourcentage_promo as percent_promo, produits.stock AS stock,
  produits.image as image, categories_produits.nom AS categorie
  FROM produits
  INNER JOIN categories_produits ON produits.id_categorie_produit=categories_produits.id ";

  $sql_liste.="WHERE produits.token =:token ";
  
  // //debugger($sql_liste);
  // $req = $pdo->prepare($sql_liste); 
  // $req->execute($conditions_prepare);

  //Faire une boucle sur la liste des produits
  foreach ($_POST as $token => $value) {

    //verifie si le produit est dans le panier
    if( !isset($_SESSION['cart']['products_list'][$token]) ){
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec de modification de votre panier.";
    }else{

      //debugger(intval($value));
      //is_int ( mixed $var )
      //verifie que le nombre de produit n'est pas 0
      if( !isset($value) || intval($value) == 0 ){
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "Désolé la valeur du nombre de produit doit être numerique et supérieur à 0.";
      }else{

        //recueper les infos du produit en base
        $conditions_prepare[':token']=$token;
        $req = $pdo->prepare($sql_liste);
        $req->execute($conditions_prepare);
        $produit = current($req->fetchAll(PDO::FETCH_OBJ));

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

  //debugger($error_text);

  //SI les produits ont passé l'étape de checking
  if(!$error_statut){
    $_SESSION['cart']['total_amount'] = 0;
    $_SESSION['cart']['total_nbre'] = 0;
    foreach ($_POST as $token => $value) {

      $conditions_prepare[':token']=$token;
      $req = $pdo->prepare($sql_liste);
      $req->execute($conditions_prepare);
      $produit = current($req->fetchAll(PDO::FETCH_OBJ));

      $value = intval($value); 
      $prix_produit = $produit->prix_qtite_unit - ($produit->prix_qtite_unit*$produit->percent_promo/100);
      $_SESSION['cart']['products_list'][$token]['qtite_cart'] = $value;
      $_SESSION['cart']['products_list'][$token]['price_cart'] = $prix_produit*$value;

      $_SESSION['cart']['total_amount'] += $prix_produit*$value;
      $_SESSION['cart']['total_nbre'] += $value;
    }

    //recuperation des frais de livraison
    $retour['cart']['total_amount'] = $_SESSION['cart']['total_amount'];
    $_SESSION['cart']['shipping_dest']['frais'] = getFees($pdo, $_SESSION['cart']['total_amount']);
    $retour['cart']['shipping_dest'] = $_SESSION['cart']['shipping_dest'];

    $error_text = 'Panier modifié avec succès.';
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




