<?php
include 'connectDB.php';
include 'fonction.php';
// if (empty(session_id())) {
//     session_start();
//     $_SESSION['menu'] = 'Marche';
// }
setlocale(LC_TIME, "fr_FR", "French");
$error_statut = false;
$error_text = '';
$error_html = '';
$retour = array();
$result = array();
$conditions_prepare=array();

//sleep(5);

if(!isset($_POST) || empty($_POST) ){ //verifie si post envoyé et non vide
  $error_statut = true;
  $error_text = 'Une erreur s\'est produite veuillez reessayer plus tard.' ;
  $field_error ='none';
}else{
    extract($_POST);
  if( !isset( $verif ) ) //verifie si variable envoyée
  {
    $error_statut = true;
    $error_text = 'Une erreur s\'est produite, veuillez reessayer plus tard sans modifier le Document HTML.';
    $field_error ='none';
    //debugger($_POST);
  }else{
    //sql syntaxe
    $sql_syntaxe="SELECT produits.nom AS nom_produit, commandes_produits.id_produit, 
                          SUM(commandes_produits.quantite*commandes_produits.qtte_unitaire) as nbre,
                          produits.id_unite as unite, produits.image as image
                  FROM commandes_produits
                  INNER JOIN produits ON commandes_produits.id_produit=produits.id
                  GROUP BY commandes_produits.id_produit 
                  ORDER BY nbre DESC
                  LIMIT 0,6 ";

    //recupère nombre de clients
    $req = $pdo->prepare($sql_syntaxe); //':email' => $user_login,
    $req->execute();
    $produits = $req->fetchAll(PDO::FETCH_OBJ);
    $result['produits'] = $produits;

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

    $html_rendered = "";
    if(empty($produits)){
      $error_statut = true;
      $error_text = "Aucun produit commandé pour l'instant." ;
      $field_error ='none';
      $html_rendered = '<li class="tile text-lg"> Aucun produit commandé pour l\'instant. </li>';
    }else{
      foreach ($produits as $produit) {
        # code...
        $symbole_unite=($unites[$produit->unite] == 'NA') ? '' : $unites[$produit->unite];

        $html_rendered .= '<li class="tile">';
        $html_rendered .=   '<div class="tile-content">';
        $html_rendered .=     '<div class="tile-icon">';
        $html_rendered .=       '<img src="'.WEBROOT_URL_FRONT.'images/shop/'.$produit->image.'.jpg" alt="" />';     
        $html_rendered .=     '</div>';
        $html_rendered .=     '<div class="tile-text">';
        $html_rendered .=       '<span class="product-name text-lg"> '.ucfirst( $produit->nom_produit ).' </span>';
        $html_rendered .=       '<span class="product-order-number text-sm">( commandés à ce jour : '.$produit->nbre.' </span>';
        $html_rendered .=       '<span class="product-unity text-sm"> '.$symbole_unite.' )</span>';
        $html_rendered .=     '</div>';
        $html_rendered .=   '</div>';
        $html_rendered .= '</li>';

      }
    }
    
    $result['list_produits_html'] = $html_rendered;
  }
}


$retour['result']=$result;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible text-align-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;

//echo 'OK';    
//echo ' <pre>'.print_r($_POST).'</pre>';
//echo ' <pre>';print_r($matiere);echo '</pre>';







