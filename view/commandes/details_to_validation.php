<!-- BEGIN CONTENT-->
<div id="content">
    <span id="linkToDeleteToOrder" class="hidden"><?php echo 'ajax/deleteProductToOrder.php'; ?></span>
    <span id="linkToUpdateToOrder" class="hidden"><?php echo 'ajax/updateProductToOrder.php'; ?></span>
    <span id="linkToValidateOrder" class="hidden"><?php echo 'ajax/setValidateOrder.php'; ?></span>

    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'commandes/liste_to_validation'; ?>">Commandes à valider</a></li>
                <li class="active">Le Détails/</li>
            </ol>
        </div>


        <div class="row products-container wrap">
            
            <div class="col-md-7 cart-view-product-container">
                <table class="table shop-cart">
                    <tbody>
                        <form id="cart-content-order">
                        <?php 
                            $i=0;
                            $classPairTr="pair-product-item";
                            $classPairTrTwo="pair-product-item-subtotal-amount";
                            foreach ($produits as $p):
                                $checkClass = $i % 2;
                                $classPairTr= ($checkClass == 0) ? "pair-product-item" : "impair-product-item";
                                $classPairTrTwo= ($checkClass == 0) ? "pair-product-item-subtotal-amount" : "impair-product-item-subtotal-amount";
                        ?>
                            <tr class="cart_item <?php echo $classPairTr;  echo ' '.$p->token; ?>  ">
                                <td class="product-remove">
                                    <a href="" class="remove remove-product-order"
                                        id-commande="<?php echo $token_commande; ?>" 
                                        id-product="<?php echo $p->token; ?>">
                                        ×
                                    </a>
                                </td>
                                <td class="product-thumbnail text-center product-info">
                                    <a href="<?php //echo $p['link_to_details']; ?>">
                                        <strong><?php echo $p->nom_produit; ?></strong>
                                    </a>
                                    <a href="<?php //echo $p['link_to_details']; ?>">
                                        <img src="<?php echo WEBROOT_URL_FRONT.'images/shop/thumb/'.$p->image.'.jpg'; ?>" alt=""> 
                                        
                                    </a>
                                    <span class="amount amount-cart">
                                        <?php echo $p->quantite_unitaire_produit; ?> <?php //echo $p['symbole_unite']; ?> x 
                                        <?php echo $p->prix_quantite_unitaire; ?> F 
                                    </span>
                                </td>
                                <td class="product-quantity text-center">
                                    <div class="quantity">
                                        <span class="qty-minus" data-min="1">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                        <input type="text" name="<?php echo $p->token; ?>" 
                                            value="<?php echo $p->quantite_cmd; ?>" 
                                            title="Nombre de tas de quantité unitaire. Exemple : 2 tas de
                                            <?php echo $p->quantite_unitaire_produit; ?> 
                                            <?php //echo $p['symbole_unite']; ?> 
                                            <?php //echo ( empty($p['symbole_unite']) ) ? '' : 'de '; ?> 
                                            <?php echo $p->nom_produit; ?>" 
                                            class="quantite-product-detail input-text qty text" size="4" required>
                                        <span class="qty-plus" data-max="">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                    </div>
                                </td>
                                <td class="product-subtotal">
                                    <span class="amount">
                                        <?php 
                                            echo number_format($p->quantite_cmd * $p->prix_qtte_unitaire_cmd, 0, '', ' ');
                                        ?> F
                                    </span>
                                </td>
                            </tr>
                            <tr class="cart_item cart-item-info-responsive text-center <?php echo $classPairTrTwo;  echo ' '.$p->token; ?>">
                                <td colspan="3" class="product-subtotal-responsive">
                                    sous total produit :  <?php echo $p->quantite_cmd * $p->prix_qtte_unitaire_cmd; ?> F
                                </td>
                            </tr>
                        <?php 
                            //$i++; 
                            endforeach; 
                        ?>
                        <tr>
                            <td colspan="4" class="vieaw-cart-customer">
                                <span class="header-cart-customer-libelle">
                                    LE CLIENT : 
                                </span>
                                <span class="header-cart-customer-name">
                                    <?php echo ucfirst( $client->nom.' '.$client->prenoms ) ?> 
                                </span> 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="actions">
                                <a class="continue-shopping add-product text-center" href="<?php echo BASE_URL.DS.'commandes/add_product_validation/'.$commande->token; ?>"> 
                                    Ajouter un produit
                                    <i class="fa fa-plus"></i>
                                </a>
                                <!-- <input type="submit" class="update-cart" name="update_cart" value="Modifier Panier" /> -->
                                <button id="cmd_search_form_btn" class="update-cart btn btn-primary btn-raised ld-ext-right " type="submit">
                                    Modifier Panier
                                    <div class="ld ld-ring ld-spin"></div>
                                </button>
                            </td>
                        </tr>
                        <input type="hidden" name="tokenCommande" value="<?php echo $token_commande ?>">
                        </form>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <div class="cart-totals">
                    <table>
                        <tbody>
                            <tr class="cart-subtotal">
                                <th>Montant HT</th>
                                <td id="sous-total-vue-detail" 
                                sous-total-cart="<?php echo $commande->montant_ht  ?>">
                                    <?php echo number_format($commande->montant_ht, 0, '', ' ')?> F                                    
                                </td>
                            </tr>
                            <tr class="cart-subtotal">
                                <th>Montant Réduit</th>
                                <td id="sous-total-vue-panier" 
                                sous-total-cart="<?php echo $commande->montant_reduction  ?>">
                                    <?php echo number_format($commande->montant_reduction, 0, '', ' ')?> F
                                </td>
                            </tr>
                            <tr class="shipping">
                                <th>TVA</th>
                                <td id="frais-livraison" montant-livraison="500">
                                    <?php 
                                        $tva = ceil( $commande->montant_reduction * 0.18 );
                                        echo number_format($tva, 0, '', ' ')
                                    ?> F
                                </td>
                            </tr>
                            <tr class="order-total">
                                <th>Total à Payer</th>
                                <td>
                                    <strong id="total-vue-panier">
                                    <?php echo number_format($commande->montant_reduction + $tva, 0, '', ' ')?> F
                                        
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="proceed-to-checkout">
                        <a href="#" class="order-connect-btn checkout set-validation-btn-detail"
                        cmd-id="<?php echo $token_commande; ?>">
                            VALIDER
                        </a>
                    </div>
                </div>
                
            </div>

                                      
            
        </div>


        </div><!--end .section-body -->
    </section>
   

<!-- START MODAL VALIDATION -->

<div class="modal own-modal fade" id="modal-set-validation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> VALIDER LA COMMANDE </h4>
        
      </div>

      <form id="form-set-validation" class="form">
                                    
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    Vous pouvez modifier le montant de la commande pour appliquer une reduction.
                </em>
            </div>
            <div class="card-body ">
                                <!-- floating-label -->
                <div id="" class="col-md-12 text-center errorForm"></div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_id" class="form-control" disabled>
                            <input type="hidden" name="cmd_id" class="form-control" >
                            <label for="cmd_id">Identifiant De Commande</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_montant_ht" class="form-control" disabled>
                            <label for="cmd_montant_ht"> Montant HT </label>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_montant_reduct" class="form-control" value="">
                            <label for="cmd_montant_ttc">Montant Réduit</label>
                        </div>
                    </div>
                </div>

                <!-- <input type="hidden" name="cmd_id" value=""> -->

            </div>


        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="confirm_btn" class="form-confirm-btn btn btn-primary btn-raised ld-ext-right " type="submit">
                        CONFIRMER
                        <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
      </div>
      </form>

    </div>
  </div>
</div>

<!-- END MODAL VALIDATION -->


</div><!--end #content-->
<!-- END CONTENT -->
