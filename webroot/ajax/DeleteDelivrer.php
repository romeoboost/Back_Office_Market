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

//[password] => mxlxjx  [token] => FNS2019060006AM

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
      $error_text_second = "Echec de suppression du livreur. Aucun champs obligatoire ne doit être vide.";
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

      //debugger($_SESSION['bo_user']['tel']);
      $req_recup = $pdo->prepare('SELECT * FROM livreurs WHERE token = :token ORDER BY id DESC'); 
      $req_recup->execute( array( ':token' => $token ) );
      $livreur = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );
      
      // Verifie si la livreur existe bien en base
      if( empty($livreur) ){ 
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "Echec de suppression du livreur.";
      }else{
        //recupere la liste des produits liés à la catégorie
        $req_recup = $pdo->prepare('SELECT * FROM commandes WHERE id_livreur = :id_livreur ORDER BY id DESC'); 
        $req_recup->execute( array( ':id_livreur' => $livreur->id ) );
        $stocks = $req_recup->fetchAll(PDO::FETCH_OBJ);
        
        //Verifie si la catégorie est liée à des produits
        if( !empty($stocks) ){
          $error_statut = true;
          $error_text = "Oups, Erreur !";
          $error_text_second = "Echec de suppression du livreur. Le livreur est déjà lié à un ou plusieurs ligne commandes.";
        }else{

          //Supprime du livreur
            $delete_req = $pdo->prepare("DELETE FROM livreurs WHERE token = :token "); 
            $delete_req->execute( array( ':token' => $token ) );  

            $retour['token'] = $token;

            $retour['enregistrement'] = 'oui';

            $error_text = ' Succes ! ';
            $error_text_second = "Le livreur ".ucfirst( $livreur->nom )." a été supprimé. ";

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




