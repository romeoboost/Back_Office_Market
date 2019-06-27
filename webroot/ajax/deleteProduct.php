<?php
include 'connectDB.php';
include 'fonction.php';

if (empty(session_id())) {
    session_start();
    //$_SESSION['menu'] = 'Nous_Rejoindre';
}
//debugger($_POST);
$error_statut = false;
$error_text = '';
$error_text_second = '';
$field_error ='none';
$retour = array();

//product_id=CMD2019050031MKT&password=dgtgtf

//verifier si tous les parametres existent
if( !isset($_POST) || empty($_POST) || !isset($_POST['product_id']) || !isset($_POST['password']) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page.';
}else{
  //debugger($_SESSION['bo_user']['tel']);
  extract($_POST);

  //verifier si tous les parametres obligatoires ne sont pas vides
  if( empty($product_id) || empty($password) ){ //verifie si le produit existe dans le panier
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec de suppression de la commande. Aucun champs ne doit être vide.";
  }else{

    $product_id = trim($product_id);
    $password = md5($password);
    $username = trim($_SESSION['bo_user']['tel']);

    //recuperation des info du user back office
    $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE tel =:tel AND password =:password"); //
    $req->execute(array(':tel' => $username, ':password' => $password));
    $user = current($req->fetchAll(PDO::FETCH_OBJ));
    // debugger( $user );
    //Verifie si mot de passe correct.
    if ( empty($user) ) {
        $error_statut = true;
        $error_text = 'Le mot de passe est incorrect. Veuillez reessayer.'; //, réessayez avec les acces corrects
    } else {

      //debugger($_SESSION['bo_user']['tel']);
      $req_recup = $pdo->prepare('SELECT * FROM produits WHERE token = :token ORDER BY id DESC'); 
      $req_recup->execute( array( ':token' => $product_id ) );
      $produit = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );
      
      // Verifie si la commande existe bien en base
      if( empty($produit) ){ 
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "Echec de suppression du produit.";
      }else{
        //recupere la liste des stock liés au produit
        $req_recup = $pdo->prepare('SELECT * FROM stocks WHERE id_produit = :id_produit ORDER BY id DESC'); 
        $req_recup->execute( array( ':id_produit' => $produit->id ) );
        $stock = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );
        
        //Verifie si le produit est lié à un stock
        if( !empty($stock) || intval( $produit->stock ) > 0  ){
          $error_statut = true;
          $error_text = "Oups, Erreur !";
          $error_text_second = "Echec de suppression du produit. Le produit est déjà lié à un stock.";
        }else{

          //recupere la liste des commandes liées au produit
          $req_recup = $pdo->prepare('SELECT * FROM commandes_produits WHERE id_produit = :id_produit ORDER BY id DESC'); 
          $req_recup->execute( array( ':id_produit' => $produit->id ) );
          $produit_cmd = $req_recup->fetchAll(PDO::FETCH_OBJ) ;

          //verifie si le produit est lié à une commande
          if( !empty($produit_cmd) ){
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Echec de suppression du produit. Le produit est déjà lié à une commande.";
          }else{
            // debugger( $produit );
            // $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;

            //Supprime le produit
            $update_req = $pdo->prepare("DELETE FROM produits WHERE token = :token "); 
            $update_req->execute( array( ':token' => $product_id ) );  

            $retour['product_id'] = $product_id;

            $retour['enregistrement'] = 'oui';

            $error_text = ' Succes ! ';
            $error_text_second = "Le produit ".ucfirst( $produit->nom )." a été supprimée. ";
          }

        }
  
      }

    }

    
  }
  //debugger($_SESSION['cart']['products_list']);

}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

$retour['error'] = 'non';

$retour['error_text'] = $error_text;
$retour['error_text_second'] = $error_text_second;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text_second . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    //$retour['field_error'] = $field_error;
    header('Operation echouée', true, 400);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;


// <div class="alert alert-warning alert-dismissible fade show" role="alert">
//   <strong>Holy guacamole!</strong> You should check in on some of those fields below.
//   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
// </div>




