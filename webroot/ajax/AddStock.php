<?php
include 'connectDB.php';
include 'fonction.php';
setlocale(LC_TIME, "fr_FR", "French");

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
    if( !isset($name_produit) || !isset($name_supplier) || !isset($qtte) || !isset($montant) || !isset($frais) || !isset($montant_ttc) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($name_produit) || empty($name_supplier) || empty($qtte) || empty($montant) || strlen($frais) == 0 || empty($montant_ttc) )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner correctement les champs obligatoires avant de valider le formulaire"; 
        }else{       
            // $req = $pdo->prepare('SELECT id as nbre FROM stocks order by id desc limit 0,1');
            //SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'tablename' 
            $req = $pdo->prepare(" SHOW TABLE STATUS LIKE 'stocks' "); 
            // $req = $pdo->prepare(" SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'stocks' "); 
            $req->execute( array() ); $Mbre_actuel_Obj = current( $req->fetchAll() );
            // $Nbre_Product_Actuel = isset($Mbre_actuel_Obj->nbre) ? $Mbre_actuel_Obj->nbre : 1 ; // le nombe actuel des clients
            // $Nbre_Product_Actuel = isset($Mbre_actuel_Obj['Auto_increment']) ? $Mbre_actuel_Obj['Auto_increment']: 1 ;
            // extract( $Mbre_actuel_Obj );
            // debugger( $Mbre_actuel_Obj['Auto_increment'] );
            $Nbre_Product_Actuel = isset($Mbre_actuel_Obj['Auto_increment']) ? intval( $Mbre_actuel_Obj['Auto_increment'] ) : 1;
            //die($Auto_increment);

            $name_produit = intval($name_produit);
            $name_supplier = intval($name_supplier);
            $qtte = intval($qtte);
            $montant = intval($montant);
            $frais = intval($frais);
            $montant_ttc = intval($montant_ttc);

            $token = getTokenNumber($Nbre_Product_Actuel, 'AM', 'STK');

            $date = date("Y-m-d H:i:s");

            //insertion du produit en base
            $req_prepare['fields'] = array( 'date_creation', 'date_modification', 'id_produit', 'quantite_initiale', 'montant', 'frais_livraison', 'montant_ttc',
            'id_fournisseur', 'token' );
            $req_prepare['values'] = array(
                                'date_creation' => $date,
                                'date_modification' => $date,
                                'id_produit' => $name_produit,
                                'quantite_initiale' => $qtte,
                                'montant' => $montant,
                                'frais_livraison' => $frais,
                                'montant_ttc' => $montant_ttc,
                                'id_fournisseur' => $name_supplier,
                                'token' => $token
                            );
            insert($pdo, $req_prepare, 'stocks');

            $date = date("Y-m-d H:i:s");
            $req_update = $pdo->prepare("UPDATE produits SET stock = stock + $qtte, date_modification = :date_modification WHERE id = :id ");
            $req_update->execute( array( ':date_modification' => $date, ':id' => $name_produit ) );

            // $retour['cmd_id'] = $cmd_id;
            $error_text = ' Succes ! ';
            $error_text_second = "Le stock a été ajoutée. " ;
            $retour['error_text'] = $error_text;
            $retour['error_text_second'] = $error_text_second;
            $retour['linkToList'] = SITE_BASE_URL.'stocks/liste';
            
        }


    }
    
    
}

// debugger($error_statut);
// die();

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
