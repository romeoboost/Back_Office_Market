<!-- BEGIN CONTENT-->
<div id="content">
    <span id="token_commande" class="hidden"><?php echo $token_commande; ?></span>
    <span id="linkToAddToOrder" class="hidden"><?php echo 'ajax/addProductToOrder.php'; ?></span>

    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'commandes/details_to_validation/'.$token_commande;; ?>">Commandes à Valider</a></li>
                <li class="active">Ajouter Produit à la Commande/ <?php echo $token_commande; ?></li>
            </ol>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="card search-product-form col-md-5">
                    <!-- <div class="card-body "> -->
                        <!-- Search form -->
                        <form class="navbar-search expended col-md-12" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" name="headerSearch" 
                                placeholder="Entrer le nom du produit">
                            </div>
                            <button type="submit" class="btn btn-icon-toggle ink-reaction">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    <!-- </div> -->
                </div>
            </div><!--end .row -->

            <div class="row products-container wrap">
                <?php if( !empty( $produits ) ): ?>
                    <?php foreach ( $produits as $produit ): ?>
                        <div id="list_produits" class="card-product">
                            <span class="themark">
                                BeatByDre
                            </span>
                            <div class="imgBx">
                                <img src="<?php echo WEBROOT_URL.'images/shop/'.$produit->image.'.jpg?14225386230' ?>"  alt="">
                            </div>
                            <div class="contentBx">
                            <h3><?php echo ucfirst( $produit->nom_produit ); ?></h3>
                            <h2 class="price"><?php echo number_format($produit->prix_qtite_unit, 0, '', ' '); ?> F</h2>  
                                <a href="#" id-product="<?php echo $produit->token_produit; ?>" 
                                    id-commande="<?php echo $token_commande; ?>"
                                    class="buy <?php echo ( $produit->stock <= 0 ) ? 'disabled' : 'add-to-order-btn'; ?> ">
                                    <?php if ( $produit->stock > 0 ){ ?>
                                        Ajouter au panier
                                        <i class="fa fa-shopping-cart"></i>
                                    <?php } else { ?>
                                        Stock épuisé
                                    <?php } ?>
                                </a>  
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                                
                
            </div>


        </div><!--end .section-body -->
    </section>
   

</div><!--end #content-->
<!-- END CONTENT -->
