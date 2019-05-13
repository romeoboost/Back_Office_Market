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
$retour['enregistrement'] = 'non';
if( isset($_GET) && isset($_SESSION) ){
  //debugger($_SESSION);
  // session_destroy();
  // die();
}

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page';
}else{
  //debugger($_POST);
  extract($_POST);
  if( !isset($tokenProduit) || !isset($nbreProduit) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = "Oups, Erreur !";
    $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
    //debugger($_POST);
  }else{
    if( empty($tokenProduit) || empty($nbreProduit) )
    {
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      //debugger($register_sexe);
    }else{
      
      /////////////////// IL FAUDRA VERIFIER SI $nbreProduit est un entier ////////////////////////

      //debugger($_POST);
        /////////Verfier si le produit existe en base
        $tokenProduit = strtolower($tokenProduit);
        $nbreProduit = intval($nbreProduit);

        $conditions_prepare=array();

        $sql_liste="SELECT produits.id AS id, produits.nom AS nom_produit, produits.token AS token_produit, 
        produits.quantite_unitaire as qtite_unit,
        produits.id_unite as unite, produits.prix_quantite_unitaire as prix_qtite_unit, produits.slug as slug,produits.nouveau as isnew,
        produits.promo as ispromo, produits.pourcentage_promo as percent_promo, produits.stock AS stock,
        produits.image as image, categories_produits.nom AS categorie, tailles.nom AS taille
        FROM produits
        INNER JOIN categories_produits ON produits.id_categorie_produit=categories_produits.id
        INNER JOIN tailles ON produits.id_taille=tailles.id ";

        $sql_liste.="WHERE produits.token =:token ";
        $conditions_prepare[':token']=$tokenProduit;
        //debugger($sql_liste);
        $req = $pdo->prepare($sql_liste); 
        $req->execute($conditions_prepare);

        $produit = current($req->fetchAll(PDO::FETCH_OBJ));
        //debugger($produit);

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

          $New_Nbre = $nbreProduit;
          if( isset($_SESSION['cart']['products_list'][$produit->token_produit]['qtite_cart']) ){
            $New_Nbre += $_SESSION['cart']['products_list'][$produit->token_produit]['qtite_cart'];
          }

          if($produit->stock < $New_Nbre*$produit->qtite_unit){ // verifie s'il y en a encore en stock
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Désolé le stock est épuisé pour le produit ".$produit->nom_produit;

            $error_text_second = ($produit->stock > 0 ) ? "Désolé il ne reste que ".$produit->stock." ".$symbole_unite." pour le produit ".$produit->nom_produit :  $error_text_second;
            //debugger($error_text);
          }else{ // y en a en stock et donc on ajoute au panier
            //debugger($produit);

            $newInCart=true;
            $Iscartempty=true;

            $symbole_unite=($unites[$produit->unite] == 'NA') ? '' : $unites[$produit->unite]; //determine le symbole de lunite du produit
            $prix_produit = $produit->prix_qtite_unit - ($produit->prix_qtite_unit*$produit->percent_promo/100);

            if( !isset($_SESSION['cart']) || empty($_SESSION['cart']) || !isset($_SESSION['cart']['total_amount']) 
                || !isset($_SESSION['cart']['products_list']) ){ // Verifie si le panier existe déjà ou s'il est vide
              // on initie le panier
              $_SESSION['cart']['last_updated_at'] = date("Y-m-d H:i:s");
              $_SESSION['cart']['total_amount'] = 0;
              $_SESSION['cart']['total_nbre'] = 0;
              $_SESSION['cart']['products_list'] = array();

              //On recupere la destination par defaut
              $dest_sql_text="SELECT token,commune,frais FROM livraison_destinations ORDER BY id ASC LIMIT 0,1";
              $dest_sql = $pdo->prepare($dest_sql_text);
              $dest_sql->execute(array());
              $destination = current($dest_sql->fetchAll(PDO::FETCH_OBJ));

              //On defini dans la session la destination de livraison
              $_SESSION['cart']['shipping_dest']['token'] = $destination->token;
              $_SESSION['cart']['shipping_dest']['commune'] = $destination->commune;
              $_SESSION['cart']['shipping_dest']['frais'] = $destination->frais;

              // On ajoute le premier produit
              $_SESSION['cart']['products_list'][$produit->token_produit]['nom'] = ucfirst($produit->nom_produit);
              $_SESSION['cart']['products_list'][$produit->token_produit]['qtite_unit'] = $produit->qtite_unit;
              $_SESSION['cart']['products_list'][$produit->token_produit]['symbole_unite'] = $symbole_unite;
              $_SESSION['cart']['products_list'][$produit->token_produit]['qtite_unit'] = $produit->qtite_unit;
              $_SESSION['cart']['products_list'][$produit->token_produit]['link_to_image'] = WEBROOT_URL.'images/shop/thumb/'.$produit->image.'.jpg';
              $_SESSION['cart']['products_list'][$produit->token_produit]['link_to_details'] = SITE_BASE_URL.'produit/details/'.$produit->slug;
              $_SESSION['cart']['products_list'][$produit->token_produit]['prix_qtite_unit'] = $prix_produit;

              $_SESSION['cart']['products_list'][$produit->token_produit]['qtite_cart'] = $nbreProduit;
              $_SESSION['cart']['products_list'][$produit->token_produit]['price_cart'] = $prix_produit*$nbreProduit;

              $_SESSION['cart']['total_amount'] = $prix_produit*$nbreProduit;
              $_SESSION['cart']['total_nbre'] = $nbreProduit;

            }else{ // le panier existe et n'est pas vide
              $Iscartempty=false;
              //debugger($_SESSION);
              if( !isset($_SESSION['cart']['products_list'][$produit->token_produit]) || 
                   empty($_SESSION['cart']['products_list'][$produit->token_produit]) ){ //verifie si le produit n'existe pas deja dans le panier
                
                //defini valeur date de dernier modif
                $_SESSION['cart']['last_updated_at'] = date("Y-m-d H:i:s");

                // On ajoute le premier produit au panier existant
                $_SESSION['cart']['products_list'][$produit->token_produit]['nom'] = ucfirst($produit->nom_produit);
                $_SESSION['cart']['products_list'][$produit->token_produit]['qtite_unit'] = $prix_produit;
                $_SESSION['cart']['products_list'][$produit->token_produit]['symbole_unite'] = $symbole_unite;
                $_SESSION['cart']['products_list'][$produit->token_produit]['qtite_unit'] = $produit->qtite_unit;
                $_SESSION['cart']['products_list'][$produit->token_produit]['link_to_image'] = WEBROOT_URL.'images/shop/thumb/'.$produit->image.'.jpg';
                $_SESSION['cart']['products_list'][$produit->token_produit]['link_to_details'] = SITE_BASE_URL.'produit/details/'.$produit->slug;
                $_SESSION['cart']['products_list'][$produit->token_produit]['prix_qtite_unit'] = $prix_produit;

                $_SESSION['cart']['products_list'][$produit->token_produit]['qtite_cart'] = $nbreProduit;
                $_SESSION['cart']['products_list'][$produit->token_produit]['price_cart'] = $prix_produit*$nbreProduit;



              }else{ // produit existe deja dans le panier 
                $newInCart=false;
                $_SESSION['cart']['last_updated_at'] = date("Y-m-d H:i:s");

                $_SESSION['cart']['products_list'][$produit->token_produit]['qtite_cart'] += $nbreProduit;
                $_SESSION['cart']['products_list'][$produit->token_produit]['price_cart'] += $prix_produit*$nbreProduit;
              }

              $_SESSION['cart']['total_amount'] += $prix_produit*$nbreProduit;
              $_SESSION['cart']['total_nbre'] += $nbreProduit;

            }

            $_SESSION['cart']['products_list'][$produit->token_produit]['isNewInCart']=$newInCart; // defini si le produit est nouveau dans le panier ou pas
            //debugger($_SESSION['cart']);
            //$Iscartempty=true;
            $retour['cart']['product'] = $_SESSION['cart']['products_list'][$produit->token_produit];
            $retour['cart']['product']['token'] = $produit->token_produit;

            $retour['cart']['IsEmpty'] = $Iscartempty;
            $retour['cart']['total_amount'] = $_SESSION['cart']['total_amount'];
            $retour['cart']['total_nbre'] = $_SESSION['cart']['total_nbre']; 

            $error_text = 'Produit ajouté avec succès.';
            $error_text_second = 'Dépechez vous de commander !';     
          }
       //debugger($enregistrement);
  

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


// <div class="alert alert-warning alert-dismissible fade show" role="alert">
//   <strong>Holy guacamole!</strong> You should check in on some of those fields below.
//   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
// </div>

// CL20180300033
  // structure numero de membre
  // AM AAAA MM NUMERO CI
  //EX : AM20180300001CI


/*
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
#membre#

id
nom
prenom
date_naissance
id_pays
id_metier
email
tel
password
date_creation
date_modification
statut
id_user
carte_membre
photo
numero_membre
id_poste

------------------------------------------------

#paiement#
id
id_membre
order_id
jwt
currency
transaction_amount
statut_id
transaction_id
paid_transaction_amount
paid_currency
change_rate
onflictual_transaction_amount
conflictual_currency
wallet
*/



/*
[operation_token] => hgdsttdf-b845-78c9-4hg7-74mpoef114ui
    [order] => 
    [jwt] => 
    [currency] => XOF
    [transaction_amount] =>

*/




