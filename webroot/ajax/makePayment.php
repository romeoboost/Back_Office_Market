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
$error_text_second  ='';

if(!isset($_POST) || empty($_POST) ){
  $error_statut = true;
  $error_text = 'Veuillez remplir correctement le formulaire';
}else{
  // debugger($_POST);
  extract($_POST);
  //type=0&montant_verser=100&tokenCommande=CMD2020120056MKT

  if( !isset($type) || !isset($montant_verser) || !isset($tokenCommande) ) //verifie si tous les champs existent
  {
    $error_statut = true;
    $error_text = 'Aucun Champs ne doit manquer';
  }else{
    if( empty($tokenCommande) || strlen($type) == 0 )
    {
      $error_statut = true;
      $error_text = 'Veuillez remplir correctement le formulaire. Aucun champs obligatoire ne doit être vide.';
    }else{
      // debugger($_POST);

      //recuperer les informations de la commandes
      $req_recup = $pdo->prepare('SELECT * FROM commandes WHERE token = :token ORDER BY id DESC'); 
      $req_recup->execute( array( ':token' => $tokenCommande ) );
      $commande = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

      if( empty($commande) ){
        $error_statut = true;
        $error_text = "La commande n'existe pas.";
      }else{
        //recueper les informations du client
        $req_recup = $pdo->prepare('SELECT * FROM clients WHERE id = :id ORDER BY id DESC'); 
        $req_recup->execute( array( ':id' => $commande->id_client ) );
        $client = current( $req_recup->fetchAll(PDO::FETCH_OBJ) );

        if( empty($client) ){
          $error_statut = true;
          $error_text = "Le client n'existe pas.";
        }else{
          //recuperer les informations du dernier versement
          $req_recup = $pdo->prepare('SELECT * FROM versements WHERE id = :id ORDER BY id DESC'); 
          $req_recup->execute( array( ':id' => $commande->id ) );
          $versements = $req_recup->fetchAll(PDO::FETCH_OBJ);
          $last_versements = current( $versements );

          // debugger($client);

          $type = intval($type);
          $montant_verser = intval($montant_verser);
          $solde_plus = 0;
          $statut_commande = 9;
          $reste_a_payer = 0;

          ###### PAIEMENT ESPECE #####
          if( $type == 0){
            //verifier si champ montant vide ou pas
            if( empty( $montant_verser ) || $montant_verser <= 0 ){
              $error_statut = true;
              $error_text = "Veuillez saisir une valeur de montant.";
            }else {
              # code...
              $solde_plus = $montant_verser - $commande->reste_a_payer;
              //identifier si paiement partielle ou paiement total
              if( $montant_verser < $commande->reste_a_payer ){ // si le montant verser inf à reste à payer
                $statut_commande = 8;
                $reste_a_payer = $commande->reste_a_payer - $montant_verser;
              }

              $abs_solde_plus = abs( $solde_plus );
              if( $commande->statut == 7 ){ // si aucun versemen pour la commande
                //mettre à jour le solde du client
                if( $solde_plus > 0 ){ // si le solde est positif
                  $req_recup = $pdo->prepare("UPDATE clients SET solde_apres = solde_apres + $abs_solde_plus, solde_avant = $client->solde_apres WHERE id = :id "); 
                  $req_recup->execute( array( ':id' => $client->id ) );
                }else{
                  if( $solde_plus < 0 ){  // si le solde est négatif            
                    $req_recup = $pdo->prepare("UPDATE clients SET solde_apres = solde_apres - $abs_solde_plus, solde_avant = $client->solde_apres WHERE id = :id "); 
                    $req_recup->execute( array( ':id' => $client->id ) );
                  }
                }
              }else{ // si au moins versemen pour la commande
                if( $commande->statut == 8 ){
                  $req_recup = $pdo->prepare("UPDATE clients SET solde_apres = solde_apres + $montant_verser, solde_avant = $client->solde_apres WHERE id = :id "); 
                  $req_recup->execute( array( ':id' => $client->id ) );
                }

              }

              

              $id_bo_user = ( isset( $_SESSION['bo_user']['id'] ) && !empty( $_SESSION['bo_user']['id'] ) ) ? intval( $_SESSION['bo_user']['id'] ) : 0;

              // debugger($client);
              //mettre a jour la commande statut et reste à payer
              $date = date("Y-m-d H:i:s");
              //Modifie le statut de la commande
              $update_req = $pdo->prepare("UPDATE commandes SET statut = :statut, 
                                          date_modification = :date_modification, id_utilisateur = :id_utilisateur, 
                                          reste_a_payer = :reste_a_payer
                                          WHERE token = :token "); 
              $update_req->execute( array( 
                                      ':statut' => $statut_commande,
                                      ':id_utilisateur' => $id_bo_user,
                                      ':reste_a_payer' => $reste_a_payer,
                                      ':date_modification' => $date,
                                      ':token' => $tokenCommande
                                      ) 
                                    );
              
              // debugger($commande);
              //inserer versement
              $req = $pdo->prepare(" SHOW TABLE STATUS LIKE 'versements' ");
              $req->execute( array() ); $Mbre_actuel_Obj = current( $req->fetchAll() );
              $Nbre_Product_Actuel = isset($Mbre_actuel_Obj['Auto_increment']) ? intval( $Mbre_actuel_Obj['Auto_increment'] ) - 1 : 0;
                                  
              $token_cmde = getCmdeNumber($Nbre_Product_Actuel, 'VS');

              $date = date("Y-m-d H:i:s");
              $req_insert = $pdo->prepare(' INSERT INTO versements (
                                                      token, id_commande, id_client, type_paiement, montant_a_payer, montant_verser, reste, date_creation, date_modification
                                                    )
                                          VALUES(
                                            :token, :id_commande, :id_client, :type_paiement, :montant_a_payer, :montant_verser, :reste, :date_creation, :date_modification
                                                )'
                                        );
              $req_insert->execute( array( 
                  'token' => $token_cmde,
                  'id_commande' => $commande->id,
                  'id_client' => $client->id,
                  'type_paiement' => $type,
                  'montant_a_payer' => $commande->reste_a_payer,
                  'montant_verser' => $montant_verser,
                  'reste' => $reste_a_payer,
                  'date_creation' => $date,
                  'date_modification' => $date 
                  ) 
              );

              // debugger($commande);

              $retour['linkToList'] = SITE_BASE_URL.'commandes/pay/'.$tokenCommande;
              if($statut_commande == 9){
                $retour['linkToList'] = SITE_BASE_URL.'commandes/liste_to_pay';
              }
              $error_text = 'Paiement effectué avec succès.';
              $error_text_second = 'Reste à payer : '.$reste_a_payer; 
            }

          }elseif($type == 1) { ###### PAIEMENT DEPUIS SOLDE #####
            $error_statut = true;
            $error_text = "Type de paiement non encore pris en compte.";
          }else{ ###### PAIEMENT A CREDIT #####
            $error_statut = true;
            $error_text = "Type de paiement non encore pris en compte.";
          }

        }


      }

             

        
      

      
    }
  }
  
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
    $retour['field_error'] = $field_error;
    header("Une erreur s'est produite", true, 503);
    //die($error_html);
}
$retour_json = json_encode($retour);

echo $retour_json;



