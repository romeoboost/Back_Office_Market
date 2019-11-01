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

//password=erth&token=jjhshgfcbcjhj45hhd // token

//verifier si tous les parametres existent
if( !isset($_POST) || empty($_POST) || !isset($_POST['token']) || !isset($_POST['password']) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page.';
}else{
  //debugger($_SESSION['bo_user']['tel']);
  extract($_POST);

  //verifier si tous les parametres obligatoires ne sont pas vides
  if( empty($token) || empty($password) ){ //verifie si le produit existe dans le panier
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec de suppression de l'unité de mesure. Aucun champs ne doit être vide.";
  }else{

    $token = trim($token);
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
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Le mot de passe est incorrect. Veuillez reessayer.'; //, réessayez avec les acces corrects
    } else {

      //debugger($_SESSION['bo_user']['tel']); // unit
      $req_recup = $pdo->prepare('SELECT * FROM unites WHERE token = :token ORDER BY id DESC'); 
      $req_recup->execute( array( ':token' => $token ) );
      $unit = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );
      
      // Verifie si la unit existe bien en base
      if( empty($unit) ){ 
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "Echec de suppression de l'unité de mésure.";
      }else{
        //recupere la liste des produits liés à la catégorie
        $req_recup = $pdo->prepare('SELECT * FROM produits WHERE id_unite = :id_unite ORDER BY id DESC'); 
        $req_recup->execute( array( ':id_unite' => $unit->id ) );
        $produits = $req_recup->fetchAll(PDO::FETCH_OBJ);
        
        //Verifie si la catégorie est liée à des produits
        if( !empty($produits) ){
          $error_statut = true;
          $error_text = "Oups, Erreur !";
          $error_text_second = "Echec de suppression de l'unité de mesure. L'unité de mesure est déjà liée à un ou plusieurs produits.";
        }else{

          //Supprime la catégorie
            $delete_req = $pdo->prepare("DELETE FROM unites WHERE token = :token "); 
            $delete_req->execute( array( ':token' => $token ) );  

            $retour['token'] = $token;

            $retour['enregistrement'] = 'oui';

            $error_text = ' Succes ! ';
            $error_text_second = "L'unité de mesure. ".ucfirst( $unit->libelle )." a été supprimée. ";

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




