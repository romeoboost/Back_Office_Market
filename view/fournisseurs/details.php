<!-- BEGIN CONTENT-->
<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'fournisseurs/liste'; ?>">Fournisseurs</a></li>
                <li class="active">Détails</li>
                <li class="active"><?php echo ucfirst( $fournisseur->nom ); ?>/</li>
            </ol>
        </div>

        <div class="section-body contain-lg">
            <div class="row">           
                <div class="col-lg-12">
                    <div class="card card-tiles style-default-light">

                        <!-- BEGIN BLOG POST HEADER -->
                        <div class="row style-default-light">
                            
                            <div class="col-sm-12 info-category-container">
                                <div class="row info-category-content" >
                                    <div class="col-xs-6">
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> Identifiant : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo $fournisseur->token ; ?> </b>
                                             </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> Nom : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo ucfirst( $fournisseur->nom ); ?> </b>
                                             </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> Téléphone : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo $fournisseur->tel ;  ?> </b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> Email : </div>
                                                <div class="pull-right product-info"> 
                                                    <b> <?php echo $fournisseur->email; ?> </b>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> Date de creation : </div>
                                                <div class="pull-right product-info"> 
                                                    <b><?php echo dateFormat($fournisseur->date_creation); ?></b>
                                                 </div>
                                            </div>
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> Date de dernière modification : </div>
                                                <div class="pull-right product-info"> 
                                                    <b><?php echo dateFormat($fournisseur->date_modification); ?></b>
                                                </div>
                                            </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div><!--end .row -->
                        <!-- END BLOG POST HEADER -->

                        <div class="row card">
                                <div class="col-sm-12">
                                    <h4 class="text-medium list-order-product-title">Liste des stocks liés au Fournisseur
                                        <span class="badge"><?php echo count($stocks['liste']); ?></span>
                                    </h4>
                                </div>
                                
                                <div class="col-md-12 table-responsive">
                                    <table class=" table table-hover shipping-details-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">ID Stock</th>
                                                <th class="text-center">Montant</th>
                                                <th class="text-center">Frais</th>
                                                <th class="text-center">Montant TTC</th>
                                                <th class="text-center">Produit</th>
                                                <th class="text-center">Quantité Fournie</th>
                                                <th class="text-center">Unit. Mésure</th>
                                                <th class="text-center">Date creation</th>
                                                <th class="text-center">Date Modification</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $nbre_cmd_plus = count($stocks['liste']) ; ?>
                                            <?php if( !empty( $stocks['liste'] ) ): ?>
                                            <?php foreach ( $stocks['liste'] as $stock ): ?>
                                            <tr class="text-center <?php echo $stock->stock_id; ?>">
                                                <td><?php echo $nbre_cmd_plus--; ?></td>
                                                <td class="token" ><?php echo $stock->stock_id; ?> </td>
                                                <td class="montant_ht" ><?php echo number_format($stock->montant_ht, 0, '', ' '); ?> </td>
                                                <td class="frais_livraison" ><?php echo number_format($stock->frais_livraison, 0, '', ' '); ?> </td>
                                                <td class="montant_total" ><?php echo number_format($stock->montant_total, 0, '', ' '); ?> </td>
                                                <td class="produit" ><?php echo $stock->produit; ?> </td>
                                                <td class="qtte" ><?php echo number_format($stock->qtte, 0, '', ' '); ?> </td>
                                                <td class="unite"><?php echo ucfirst( $unit_mesure[$stock->unite] ); ?></td>
                                                <td><?php echo dateFormat($stock->date_creation); ?></td>
                                                <td><?php echo dateFormat($stock->date_modification); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php endif; ?>

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
