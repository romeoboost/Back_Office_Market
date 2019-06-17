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

//verifier si tous les parametres existent
if( !isset($_POST) || empty($_POST) || !isset($_POST['cmd_id']) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page.';
}else{
  //debugger($_POST);
  extract($_POST);

  //verifier si tous les parametres obligatoires ne sont pas vides
  if( empty($cmd_id) ){ //verifie si le produit existe dans le panier
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec d'annulation de la commande.";
  }else{

    //recuperation de la commande en base
    $cmd_id = trim($cmd_id);
    $req_recup = $pdo->prepare('SELECT * FROM commandes WHERE token = :token ORDER BY id DESC'); 
    $req_recup->execute( array( ':token' => $cmd_id ) );
    $commande = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

    // Verifie si la commande existe bien en base
    if( empty($commande) ){ 
      $error_statut = true;
      $error_text = "Oups, Erreur !";
      $error_text_second = "Echec d'annulation du produit du panier.";
    }else{

      //Verifie que le statut de la commande est bien à en attente (0 )
      if( $commande->statut != 4 ){
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = "Cette commande ne peut être annulée.";
      }else{
        
        

        //recuperer la liste de produits contenu dans la commande et leur nombre
        $req_recup = $pdo->prepare('SELECT * FROM commandes_produits WHERE id_commande = :id_commande ORDER BY id DESC'); 
        $req_recup->execute( array( ':id_commande' => $commande->id ) );
        $produits = $req_recup->fetchAll(PDO::FETCH_OBJ) ;

        //Boucle sur les produits contenus dans la commande
        $produits_stock_failed = "Le stock pour les produits : ";
        foreach ($produits as $produit) {
          # code...
          $qtte_commande = $produit->quantite*$produit->qtte_unitaire;
          $req_update = $pdo->prepare("SELECT id,stock,nom from produits WHERE id = :id ");
          $req_update->execute( array( ':id' => $produit->id_produit ) );
          $produit_stock = current( $req_update->fetchAll(PDO::FETCH_OBJ) );

          //Verifie si le nombre de produit commandé est supperieur ou égale au nombre de produit restant en stock
          if( $produit_stock->stock < $qtte_commande ){
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $produits_stock_failed .= $produit_stock->nom." [stock restant = ".$produit_stock->stock." ], ";
          }

        }
        $produits_stock_failed .= " est insuffisant pour satisfaire la commande.";
        $error_text_second = $produits_stock_failed;
        

        if( !$error_statut ){
          // debugger($produits);
          //Mise à jour le nombre de produits en stock avec ceux contenu dans la commande
          foreach ($produits as $produit) {
            # code...
            $qtte_commande = $produit->quantite*$produit->qtte_unitaire;
            $date = date("Y-m-d H:i:s");
            $req_update = $pdo->prepare("UPDATE produits SET stock = stock - $qtte_commande, date_modification = :date_modification 
                                         WHERE id = :id ");
            $req_update->execute( array( ':date_modification' => $date, ':id' => $produit->id_produit ) );
          }

          $date = date("Y-m-d H:i:s");
          $statut = 0;
          $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;

          //Modifie le statut de la commande
          $update_req = $pdo->prepare("UPDATE commandes SET statut = :statut, id_utilisateur = :id_utilisateur, date_modification = :date_modification
                                                 WHERE token = :token "); 
          $update_req->execute( array( 
                                  ':statut' => $statut,
                                  ':id_utilisateur' => $id_bo_user,
                                  ':date_modification' => $date,
                                  ':token' => $cmd_id
                                  ) 
                                );

          //renvoi le bon html pour le nouveau statut du produit
          // $retour['error_html'] = '<span class="badge badge-danger"> annulée </span>';

          $retour['cmd_id'] = $cmd_id;
          $btn_restore_html = '<button type="button" class="btn btn-icon-toggle set-shipping-btn" data-toggle="tooltip" 
                                data-placement="top" data-original-title="Livrer" cmd-id="'.$cmd_id.'">
                                                              <i class="md md-local-shipping"></i>
                                                          </button>';
          $retour['btn_rejected_html'] = $btn_restore_html;

          $enregistrement = 'oui';
          $retour['enregistrement'] = $enregistrement;

          $error_text = ' Succes ! ';
          $error_text_second = "La commande $cmd_id a été restaurée.";

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


// <div class="alert alert-warning alert-dismissible fade show" role="alert">
//   <strong>Holy guacamole!</strong> You should check in on some of those fields below.
//   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
// </div>




