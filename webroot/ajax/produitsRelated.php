<?php
include 'connectDB.php';
include 'fonction.php';
define('WEBROOT_URL', 'http://localhost/Market/webroot/');
define('SITE_BASE_URL', 'http://localhost/Market/');
if (empty(session_id())) {
    session_start();
    $_SESSION['menu'] = 'Marche';
}

$error_statut = false;
$error_text = '';
$error_html = '';
$retour = array();
$produits_liste_html='';
$pagination_html='';
$productDataDisplay=false;

$OrderFields = array(
                    1 => 'produits.id DESC',
                    2 => 'produits.id DESC',
                    3 => 'produits.nouveau DESC, produits.date_modification DESC',
                    4 => 'produits.promo DESC',
                    5 => 'produits.prix_quantite_unitaire ASC, produits.quantite_unitaire DESC',
                    6 => 'produits.prix_quantite_unitaire DESC, produits.quantite_unitaire ASC',
                    7 => ''
                    );

$conditions_prepare=array();

$sql_liste="SELECT produits.id AS id, produits.nom AS nom_produit, produits.token AS token_produit, produits.quantite_unitaire as qtite_unit,
        produits.id_unite as unite, produits.prix_quantite_unitaire as prix_qtite_unit, produits.slug as slug,produits.nouveau as isnew,
        produits.promo as ispromo, produits.pourcentage_promo as percent_promo,
        produits.image as image,
        categories_produits.nom AS categorie,
        tailles.nom AS taille
      FROM produits
      INNER JOIN categories_produits ON produits.id_categorie_produit=categories_produits.id
      INNER JOIN tailles ON produits.id_taille=tailles.id ";

if ($_POST) {
    extract($_POST);
    //die(var_dump($_POST));
    $productDataCategory = isset($productDataCategory) ? strtolower($productDataCategory) : '';

    //rajoute la condition de filtre sur la catégorie
    if(!empty($productDataCategory)){ 
        $sql_liste.="WHERE categories_produits.token =:productDataCategory ";
        $conditions_prepare[':productDataCategory']=$productDataCategory;
    }

    //Rajoute l'ordonnancement
    $sql_liste.="ORDER BY rand() ";


    //Rajoute le nombre d'element a recuperer
    $sql_liste.="LIMIT 0,4";
    //debugger($sql_liste);
    
    $req = $pdo->prepare($sql_liste); //':email' => $user_login,
    $req->execute($conditions_prepare);
    // // var_dump($req);
    // // die();
    $produits = $req->fetchAll(PDO::FETCH_OBJ);
    //debugger($produits);

    //recupere le tableau des unités dues produits
    //($unites[$p->unite] == 'NA') ? '' : $unites[$p->unite]
    $unites=array();
    $sql_unite="SELECT id,libelle,symbole FROM unites";
    $req_unite = $pdo->prepare($sql_unite);
    $req_unite->execute(array());
    $unites_from_bd = $req_unite->fetchAll(PDO::FETCH_OBJ);
    foreach ($unites_from_bd as $u) {
       $unites[$u->id] = $u->symbole;
     }

    //debugger($unites); 

    if(!empty($produits)) // si produit trouvé
    {
        $productDataDisplay=true;
        //construction html list de produit
        foreach ($produits as $p) {

            $prix_html='';
            $symbole_unite=($unites[$p->unite] == 'NA') ? '' : $unites[$p->unite]; //determine le symbole de lunite du produit

            $produits_liste_html.='<div class="product-item text-center">
                                        <div class="product-thumb">
                                            <a href="'.SITE_BASE_URL.'produit/details/'.$p->slug.'">
                                                <div class="badges">
                                                    
                                                ';
            $nouveau_html=($p->isnew==1) ? '<span class="new">Nouveau</span>' : ' ';
            $promo_html=($p->ispromo==1) ? '<span class="onsale">Promo</span>' : ' ';

            $produits_liste_html.='                '.$nouveau_html;
            $produits_liste_html.='                '.$promo_html;


            $produits_liste_html.='              </div>
                                                <img src="'.WEBROOT_URL.'images/shop/'.$p->image.'.jpg" alt="" />
                                            </a>
                                            <div class="product-action">
                                                <span class="add-to-cart">
                                                    <a href="#" class="add-to-cart-btn" id-product="'.$p->token_produit.'" data-toggle="tooltip" data-placement="top" title="Add to cart"></a>
                                                </span>
                                                <span class="quickview">
                                                    <a href="'.SITE_BASE_URL.'produit/details/'.$p->slug.'" data-toggle="tooltip" data-placement="top" title="Quickview"></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <a href="'.SITE_BASE_URL.'produit/details/'.$p->slug.'">
                                                <h2 class="title">'.ucfirst($p->nom_produit).'</h2>
                                                <span class="price">';

            $prix_produit = $p->prix_qtite_unit - ($p->prix_qtite_unit*$p->percent_promo/100);

            $prix_html=''.($p->ispromo==1) ? '<del>'.$p->prix_qtite_unit .'</del>': ' ';
            $prix_html.='<ins>'.$prix_produit;
            $prix_html.=' CFA/ '.$p->qtite_unit.' '.$symbole_unite.' </ins> ';
            //die(var_dump($prix_html));

            $produits_liste_html.='                '.$prix_html;

            $produits_liste_html.='             </span>
                                            </a>
                                        </div>
                                   </div> ';

        }

    }else{
        $produits_liste_html.='<div class="product-list-empty">
                                    <div class="product-list-empty-description">Aucun produit trouvé.</div>
                                    <div id="" class="text-center"><a class="initial-product-reload">Actualiser</a></div>
                                </div>';
    }



}

$retour['produits_liste_html']=$produits_liste_html;
$retour['productDataDisplay']=$productDataDisplay;

$retour_json = json_encode($retour);

echo $retour_json;

//echo 'OK';    
//echo ' <pre>'.print_r($_POST).'</pre>';
//echo ' <pre>';print_r($matiere);echo '</pre>';









