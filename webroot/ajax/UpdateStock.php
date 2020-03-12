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
    //name_produit=17&name_supplier=1&qtte=200&old_qtte=20&montant=14500&frais=500&montant_ttc=15000&token=STK2019060004AM
    if( !isset($name_produit) || !isset($name_supplier) || !isset($qtte) || !isset($montant) || !isset($frais) || !isset($montant_ttc)
     || !isset($old_qtte) || !isset($token) ) 
    {
        $error_statut = true;
        $error_text = "Oups, Erreur !";
        $error_text_second = 'Veuillez ne pas modifier la page. Tous les paramètres sont obligatoires.';
        //debugger($_POST);
    }else{
        
        //verifie si au moins un champs de filtre est renseigné
        if( empty($name_produit) || empty($name_supplier) || empty($qtte) || empty($montant) || strlen($frais) == 0 || empty($montant_ttc) 
        || empty($old_qtte) || empty($token) )
        {
            $error_statut = true;
            $error_text = "Oups, Erreur !";
            $error_text_second = "Veuillez renseigner les champs obligatoires avant de valider le formulaire."; 
        }else{       
            // debugger($_FILES);     
            //verifie si l'image est de bonne qualité
            $stock_is_good = true;

            //recupere les infos actuelles du stock
            $req = $pdo->prepare('SELECT id,quantite_initiale FROM stocks where token = :token '); 
            $req->execute( array('token' => $token ) ); $stock = current( $req->fetchAll(PDO::FETCH_OBJ) );

            //fais la difference entre la nouvelle quantité et l'ancienne
            $diff_stock = intval($qtte) - intval($stock->quantite_initiale);
            // debugger($diff_stock);
            if($diff_stock == 0){ //si la difference entre la nouvelle quantité et l'ancienne est = 0
                $stock_is_good = true;
            }

            if($diff_stock > 0){ //la difference entre la nouvelle quantité et l'ancienne est positive
                $stock_is_good = true;
                $date = date("Y-m-d H:i:s");
                //augmente le stock du produit du surplus
                $req_update = $pdo->prepare("UPDATE produits SET stock = stock + $diff_stock, date_modification = :date_modification WHERE id = :id ");
                $req_update->execute( array( ':date_modification' => $date, ':id' => $name_produit ) );
            }

            if($diff_stock < 0){ //la difference entre la nouvelle quantité et l'ancienne est negative

                $diff_stock = abs( $diff_stock ); // recupere la valeur absolue de la difference

                //recuepere le stock restant du produit
                $req = $pdo->prepare('SELECT id,stock,nom FROM produits where id = :id '); 
                $req->execute( array('id' => $name_produit ) ); $product = current( $req->fetchAll(PDO::FETCH_OBJ) );

                //verifie s'il y a assez de produit en stock afin de deduire la difference
                if( $diff_stock > $product->stock  ){ // s'il n'y a pas assez de produit en stock
                    $stock_is_good = false;
                    $error_statut = true;
                    $error_text = "Oups, Erreur !";
                    $error_text_second = "Il n'y a pas assez de produit en stock pour vous permettre de reduire la quantité de $stock->quantite_initiale à $qtte.";
                }else{
                    $stock_is_good = true;
                    $date = date("Y-m-d H:i:s");
                    $req_update = $pdo->prepare("UPDATE produits SET stock = stock - $diff_stock, date_modification = :date_modification WHERE id = :id ");
                    $req_update->execute( array( ':date_modification' => $date, ':id' => $name_produit ) );
                }
                
            }

            //verifie si c'est ok pour l'image
            if( $stock_is_good ){//si image ok
                //attribut les valeur par defaut au champs qui ne sont pas obligatoire

                $name_produit = intval($name_produit);
                $name_supplier = intval($name_supplier);
                $qtte = str_replace(',', '.', trim($qtte));
                $qtte = floatval($qtte);
                $montant = intval($montant);
                $frais = intval($frais);
                $montant_ttc = intval($montant_ttc);

                $date = date("Y-m-d H:i:s");

                //insertion du produit en base
                $req_prepare['fields'] = array( 'date_modification', 'id_produit', 'quantite_initiale', 'montant', 'frais_livraison', 'montant_ttc',
                'id_fournisseur' );
                $req_prepare['values'] = array(
                                    'date_modification' => $date,
                                    'id_produit' => $name_produit,
                                    'quantite_initiale' => $qtte,
                                    'montant' => $montant,
                                    'frais_livraison' => $frais,
                                    'montant_ttc' => $montant_ttc,
                                    'id_fournisseur' => $name_supplier
                                    );
                $req_prepare['condition'] = 'token = :token';
                $req_prepare['values']['token'] = $token;
                update($pdo, $req_prepare, 'stocks');


                // $retour['cmd_id'] = $cmd_id;
                $error_text = ' Succes ! ';
                $error_text_second = "La ligne de stock a été modifiée. " ;
                $retour['error_text'] = $error_text;
                $retour['error_text_second'] = $error_text_second;
                $retour['linkToList'] = SITE_BASE_URL.'stocks/liste';
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
