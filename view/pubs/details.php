<!-- BEGIN CONTENT-->
<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'categories/liste'; ?>">Catégories</a></li>
                <li class="active">Détails</li>
                <li class="active"><?php echo ucfirst( $categorie->nom ); ?>/</li>
            </ol>
        </div>

        <div class="section-body contain-lg">
            <div class="row">           
                <div class="col-lg-12">
                    <div class="card card-tiles style-default-light">

                        <!-- BEGIN BLOG POST HEADER -->
                        <div class="row style-default-light">
                            
                            <div class="col-sm-3">
                                
                                <div class="detail-category-img-content">
                                    <img class="img-responsive" src="<?php echo WEBROOT_URL_FRONT.'images/category/'.$categorie->image; ?>.png?1422538624" alt="" 
                                    />
                                </div>
                                
                            </div><!--end .col -->
                            
                            <div class="col-sm-9 info-category-container">
                                <div class="row info-category-content" >
                                    <div class="col-xs-6">
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> NOM CATEGORIE : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo ucfirst( $categorie->nom ); ?> </b>
                                             </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> ICON : </div>
                                            <div class="pull-right product-info"> 
                                                <b><i class="glyph-icon flaticon-<?php echo $categorie->icon; ?>"></i></b>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> STATUT : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo ($categorie->statut == 1) ? 'ACTIF' : 'NON ACTIF'; ?> </b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                            <div class="clearfix">
                                            <div class="pull-left product-libelle"> DATE DE CREATION : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo dateFormat($categorie->date_creation); ?></b>
                                             </div>
                                            </div>
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> DATE DE DERNIERE MODIFICATION : </div>
                                                <div class="pull-right product-info"> 
                                                    <b><?php echo dateFormat($categorie->date_modification); ?></b>
                                                </div>
                                            </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div><!--end .row -->
                        <!-- END BLOG POST HEADER -->

                        <div class="row card">
                                <div class="col-sm-12">
                                    <h4 class="text-medium list-order-product-title">Liste des produits liés à la catégorie produit 
                                        <span class="badge"><?php echo count($produits); ?></span>
                                    </h4>
                                </div>
                                
                                <div class="col-md-12 table-responsive">
                                    <table class=" table table-hover shipping-details-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Aperçu</th>
                                                <th class="text-center">Nom</th>
                                                <th class="text-center">Stock restant</th>
                                                <th class="text-center">Qtté. Unit. Vendue</th>
                                                <th class="text-center">Unit. Mésure</th>
                                                <th class="text-center">Prix Qtté Unit.</th>
                                                <th class="text-center">Promo</th>                                    
                                                <th class="text-center">Prix Promo</th>                                    
                                                <th class="text-center">Statut</th>
                                                <th class="text-center">Date création</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($produits as $produit) : ?>
                                                <tr class="text-center">
                                                    <td><img class="img-circle width-1" src="<?php echo WEBROOT_URL_FRONT.'images/shop/'.$produit->image; ?>.jpg?1422538624" alt="" /></td>
                                                    <td class="name_product" ><?php echo ucfirst( $produit->nom_produit ); ?></td>
                                                    <td class="stock_product"><?php echo number_format($produit->stock, 0, '', ' '); ?></td>
                                                    <td><?php echo number_format($produit->qtite_unit, 0, '', ' '); ?></td>
                                                    <td><?php echo ucfirst( $unit_mesure[$produit->unite] ); ?></td>
                                                    <td><?php echo number_format($produit->prix_qtite_unit, 0, '', ' '); ?></td>
                                                    <td><?php echo ($produit->ispromo == 1) ? 'OUI' : 'NON'; ?></td>
                                                    <td>
                                                        <?php 
                                                            $prix_promo = ($produit->ispromo == 1) ? number_format($produit->prix_qtite_unit - $produit->prix_qtite_unit*$produit->percent_promo/100, 0, '', ' ') : '-';
                                                            echo $prix_promo; 
                                                        ?>
                                                    </td>
                                                    <td><?php echo ($produit->produit_statut == 1) ? 'ACTIF' : 'NON ACTIF'; ?></td>
                                                    <td><?php echo dateFormat($produit->date_creation); ?></td> 
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div><!--end .col -->
                            </div><!--end .row -->
                    </div><!--end .card -->
                </div><!--end .col -->
            </div><!--end .row -->

            

        </div><!--end .section-body -->
    

    </section>

</div><!--end #content-->
<!-- END CONTENT -->
