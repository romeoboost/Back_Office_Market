<?php
include 'connectDB.php';
include 'fonction.php';
setlocale(LC_TIME, "fr_FR", "French");
if (empty(session_id())) {
    session_start();
    //$_SESSION['menu'] = 'Nous_Rejoindre';
}
$error_statut = false;
$error_text = '';
$error_html = '';
$retour = array();
$result = array();

$conditions_prepare=array();

// sleep(5);
if ($_POST) {
    
    extract($_POST);
    // extract($_FILES);
    // debugger($_POST);
    //verifie si tous les champs existent
    //[password] => gfh    [token] => STK2019060004AM
    if( !isset($password) || !isset($token) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($password) || empty($token) )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner les champs obligatoires avant de valider le formulaire."; 
        }else{

            $token = trim($token);
            $password = md5($password);
            $username = trim($_SESSION['bo_user']['tel']);

            //recuperation des info du user back office
            $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE tel =:tel AND password =:password"); //
            $req->execute(array(':tel' => $username, ':password' => $password));
            $user = current($req->fetchAll(PDO::FETCH_OBJ));

            if ( empty($user) ) {
                $error_statut = true;
                $error_text = "Oups, Erreur !";
                $error_text_second = 'Le mot de passe est incorrect. Veuillez reessayer.'; //, réessayez avec les acces corrects
            } else {
                $req = $pdo->prepare('SELECT id,quantite_initiale,id_produit FROM stocks where token = :token '); 
                $req->execute( array('token' => $token ) ); $stock = current( $req->fetchAll(PDO::FETCH_OBJ) );

                if( empty($stock) ){ 
                    $error_statut = true;
                    $error_text = "Oups, Erreur !";
                    $error_text_second = "Echec de suppression du stock.";
                }else{
                    $req = $pdo->prepare('SELECT id,stock,nom FROM produits where id = :id '); 
                    $req->execute( array('id' => $stock->id_produit ) ); $product = current( $req->fetchAll(PDO::FETCH_OBJ) );
                    if($stock->quantite_initiale > $product->stock){
                        $error_statut = true;
                        $error_text = "Oups, Erreur !";
                        $error_text_second = "Il n'y a pas assez de produit en stock ($product->stock) pour vous permettre de supprimer un stock de quantité $stock->quantite_initiale .";
                    }else{
                        $qtte_delete = intval( $stock->quantite_initiale );
                        $date = date("Y-m-d H:i:s");
                        $req_update = $pdo->prepare("UPDATE produits SET stock = stock - $qtte_delete, date_modification = :date_modification WHERE id = :id ");
                        $req_update->execute( array( ':date_modification' => $date, ':id' => $stock->id_produit ) );

                        $delete_req = $pdo->prepare("DELETE FROM stocks WHERE token = :token "); 
                        $delete_req->execute( array( ':token' => $token ) );  

                        $retour['token'] = $token;

                        $retour['enregistrement'] = 'oui';

                        $error_text = ' Succes ! ';
                        $error_text_second = "Le stock ".$token." a été supprimé. ";

                    }

                }

            }         
            
        }


    }
    
    
}

$retour['error_text'] = $error_text;
$retour['error_text_second'] = $error_text_second;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible text-align-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text_second . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    // $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;
