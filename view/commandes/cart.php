<!-- BEGIN CONTENT-->
<div id="content">
<span id="linkToOrder" class="hidden"><?php echo WEBROOT_URL.'ajax/placeOrder.php'; ?></span>
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'commandes/liste'; ?>">Commandes</a></li>
                <li class="active">Le Panier/</li>
            </ol>
        </div>


        <div class="row products-container wrap">
            <?php if( !isset($_SESSION['cart']['products_list']) || empty($_SESSION['cart']['products_list']) ) { ?>
                <div class="col-sm-12 text-center">
                    <div class="commerce">
                        <h2 class="text-center home-welcome-title">
                            Votre panier est vide.
                        </h2>
					    <h2 class="text-center home-app-name redirect-to-init-order">
                            <a class="organik-btn " href="<?php echo BASE_URL.DS.'commandes/init_order'; ?>">
                                Initier une commande 
                            </a>
                        </h2>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="col-md-7 cart-view-product-container">
                    <table class="table shop-cart">
                        <tbody>
                            <form id="cart-content-panier">
                            <?php 
                                $i=0;
                                $classPairTr="pair-product-item";
                                $classPairTrTwo="pair-product-item-subtotal-amount";
                                foreach ($_SESSION['cart']['products_list'] as $token => $p):
                                    $checkClass = $i % 2;
                                    $classPairTr= ($checkClass == 0) ? "pair-product-item" : "impair-product-item";
                                    $classPairTrTwo= ($checkClass == 0) ? "pair-product-item-subtotal-amount" : "impair-product-item-subtotal-amount";
                            ?>
                                <tr class="cart_item <?php echo $classPairTr;  echo ' '.$token; ?>  ">
                                    <td class="product-remove">
                                        <a href="" class="remove remove-product-cart" id-product="<?php echo $token; ?>">×</a>
                                    </td>
                                    <td class="product-thumbnail text-center product-info">
                                        <a href="<?php echo $p['link_to_details']; ?>">
                                            <strong><?php echo $p['nom']; ?></strong>
                                        </a>
                                        <a href="<?php echo $p['link_to_details']; ?>">
                                            <img src="<?php echo $p['link_to_image']; ?>" alt=""> 
                                        </a>
                                        <span class="amount amount-cart">
                                            <?php echo $p['qtite_unit']; ?> <?php echo $p['symbole_unite']; ?> x 
                                            <?php echo $p['prix_qtite_unit']; ?> F 
                                        </span>
                                    </td>
                                    <td class="product-quantity text-center">
                                        <div class="quantity">
                                            <span class="qty-minus" data-min="1">
                                                <i class="fa fa-minus"></i>
                                            </span>
                                            <input type="text" name="<?php echo $token; ?>" 
                                                value="<?php echo $p['qtite_cart']; ?>" 
                                                title="Nombre de tas de quantité unitaire. Exemple : 2 tas de
                                                <?php echo $p['qtite_unit']; ?> <?php echo $p['symbole_unite']; ?> <?php echo ( empty($p['symbole_unite']) ) ? '' : 'de '; ?> <?php echo $p['nom']; ?>" 
                                                class="quantite-product-detail input-text qty text" size="4" required>
                                            <span class="qty-plus" data-max="">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount"><?php echo $p['price_cart']; ?> F</span>
                                    </td>
                                </tr>
                                <tr class="cart_item cart-item-info-responsive text-center <?php echo $classPairTrTwo;  echo ' '.$token; ?>">
                                    <td colspan="3" class="product-subtotal-responsive">
                                        sous total produit :  <?php echo $p['price_cart']; ?> F
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
                                        <?php echo isset( $_SESSION['cart']['customer'] ) ? $_SESSION['cart']['customer']['name'] : "Aucun client" ?> 
                                    </span> 
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="actions">
                                    <a class="continue-shopping text-center" href="<?php echo BASE_URL.DS.'commandes/init_order'; ?>"> 
                                        Liste des produits
                                    </a>
                                    <!-- <input type="submit" class="update-cart" name="update_cart" value="Modifier Panier" /> -->
                                    <button id="cmd_search_form_btn" class="update-cart btn btn-primary btn-raised ld-ext-right " type="submit">
                                        Modifier Panier
                                        <div class="ld ld-ring ld-spin"></div>
                                    </button>
                                </td>
                            </tr>
                            </form>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-4">
                    <div class="cart-totals">
                        <table>
                            <tbody>
                                <tr class="cart-subtotal">
                                    <th>Sous Total</th>
                                    <td id="sous-total-vue-panier" 
                                    sous-total-cart="<?php echo isset( $_SESSION['cart']['total_amount'] ) ? $_SESSION['cart']['total_amount'] : "0" ?>">
                                        <?php echo isset( $_SESSION['cart']['total_amount'] ) ? $_SESSION['cart']['total_amount'] : "0" ?> F
                                    </td>
                                </tr>
                                <tr class="shipping">
                                    <th>TVA</th>
                                    <td id="frais-livraison" montant-livraison="500">
                                        <?php echo ucfirst($_SESSION['cart']['shipping_dest']['frais']) ?>
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td>
                                        <strong id="total-vue-panier">
                                            <?php 
                                                echo isset( $_SESSION['cart']['total_amount'] ) ? $_SESSION['cart']['total_amount']+$_SESSION['cart']['shipping_dest']['frais'] : "0" 
                                            ?> F
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="proceed-to-checkout">
                            <?php if ( isset($_SESSION['user']) ): ?>
                                <a href="<?php echo BASE_URL.DS.'commande/details'; ?>" class="">
                                    Commander
                                </a>
                            <?php else: ?>
                                <a href="#" class="order-connect-btn checkout order-cmd-button-base">
                                    ENREGISTRER
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </div>

            <?php } ?>                            
            
        </div>


        </div><!--end .section-body -->
    </section>
   

</div><!--end #content-->
<!-- END CONTENT -->
