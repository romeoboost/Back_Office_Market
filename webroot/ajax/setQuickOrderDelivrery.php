<?php
include 'connectDB.php';
include 'fonction.php';
if (empty(session_id())) {
    session_start();
    //$_SESSION['menu'] = 'Nous_Rejoindre';
}

//debugger($_SESSION);
$error_statut = false;
$error_text = '';
$field_error ='none';
$retour = array();
$retour['enregistrement'] = 'non';
$error_text = "Oups, Erreur !";

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = "Oups, Erreur !";
  $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
}else{
  extract($_POST);
  //verifier si les champs existe ||cmd_montant_ht=0&cmd_id=QCD2019120004AM&livreur=4
  if( !isset($cmd_id) || !isset($livreur) || !isset($cmd_montant_ht) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text_second = 'Aucun Champs ne doit manquer';
    //debugger($_POST);
  }else{
    //verifier si les champs obligatoires ne sont pas vides
    if( empty($cmd_id) || empty($livreur)  || empty($cmd_montant_ht) ) //verifie si les champs obligatoires sont pas vides
    {
      $error_statut = true;
      $error_text_second = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
      if( empty($cmd_montant_ht) ){ 
        $error_text_second = 'Veuillez remplir correctement le formulaire. Le champs "Montant de la commande" ne peut pas être égale à 0.';
      }
    }else{
      
        
        $cmd_id = trim($cmd_id);
        $livreur = intval($livreur);

        
        // debugger($montant_TTC);

        $req_recup = $pdo->prepare('SELECT * FROM rapide_commandes WHERE token = :token ORDER BY id DESC'); 
        $req_recup->execute( array( ':token' => $cmd_id ) );
        $commande = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

        //verifie si le statut de la commande est vraiment en attente
        if( $commande->statut != 0 && $commande->statut != 1){
          $error_statut = true;
          $error_text_second = 'La commande doit avoir le statut " EN ATTENTE " ou " LIVRÉE ".';

        }else{

          $total_amount_cart = intval( $cmd_montant_ht );
          $fees = getFees($pdo, $total_amount_cart);
          $montant_TTC = $total_amount_cart + $fees;

          //Mise à jour du statut de la commande
          $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;
          $date = date("Y-m-d H:i:s");
          $statut = 3;
          //Modifie le statut de la commande
          $update_req = $pdo->prepare("UPDATE rapide_commandes SET statut = :statut, id_livreur = :id_livreur, 
                      date_modification = :date_modification, id_utilisateur = :id_utilisateur, montant_ht = :montant_ht,
                      frais_livraison = :frais_livraison, montant_total = :montant_total WHERE token = :token "); 
          $update_req->execute( array( 
                                ':statut' => $statut,
                                ':montant_ht' => $total_amount_cart,
                                ':frais_livraison' => $fees,
                                ':montant_total' => $montant_TTC,
                                ':id_livreur' => $livreur,
                                ':id_utilisateur' => $id_bo_user,
                                ':date_modification' => $date,
                                ':token' => $cmd_id
                              ) 
                            );
          $retour['cmd_id'] = $cmd_id;
          $retour['cmd_statut'] = $commande->statut;
          $btn_confirm_shipping_html = '<button type="button" class="btn btn-icon-toggle set-stop-shipping-btn quick-order" data-toggle="tooltip" cmd-id="'.$cmd_id.'"
                                            data-placement="top" data-original-title="Arrêter la livraison">
                                            <i class="fa fa-pause"></i>
                                        </button> ';
          $retour['btn_confirm_shipping_html'] = $btn_confirm_shipping_html;

          $retour['montant_ht'] = $total_amount_cart;
          $retour['frais_livraison'] = $fees;
          $retour['montant_total'] = $montant_TTC;
          $error_text = ' Succes ! ';
          $error_text_second = "La mise à jour de la commande $cmd_id a été éffectuée. " ;
        }
    }
  }
  
}
//echo 'ALL <pre>';print_r($_POST);echo '</pre>';

$retour['error_text'] = $error_text;
$retour['error_text_second'] = $error_text_second;

if ($error_statut) {
    $error_html = '
                    <div class="col-sm-12 alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="">' . $error_text . '</span><br> 
                        <span class="">' . $error_text_second . '</span>
                    </div>  ';
    $retour['error'] = 'oui';
    $retour['error_html'] = $error_html;
    $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;



