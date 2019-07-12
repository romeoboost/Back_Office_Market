<!-- BEGIN CONTENT-->
<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'livreurs/liste'; ?>">Livreurs</a></li>
                <li class="active">Détails</li>
                <li class="active"><?php echo ucfirst( $livreur->nom ); ?>/</li>
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
                                                <b><?php echo $livreur->token ; ?> </b>
                                             </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> Nom : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo ucfirst( $livreur->nom ).' '.ucfirst( $livreur->prenoms ); ; ?> </b>
                                             </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> Téléphone : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo $livreur->tel ;  ?> </b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> Email : </div>
                                                <div class="pull-right product-info"> 
                                                    <b> <?php echo $livreur->email; ?> </b>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> Date de creation : </div>
                                                <div class="pull-right product-info"> 
                                                    <b><?php echo dateFormat($livreur->date_creation); ?></b>
                                                 </div>
                                            </div>
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> Date de dernière modification : </div>
                                                <div class="pull-right product-info"> 
                                                    <b><?php echo dateFormat($livreur->date_modification); ?></b>
                                                </div>
                                            </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div><!--end .row -->
                        <!-- END BLOG POST HEADER -->

                        <div class="row card">
                                <div class="col-sm-12">
                                    <h4 class="text-medium list-order-product-title">Liste des commandes liées au produit 
                                        <span class="badge"><?php echo count( $commandes['liste'] ); ?></span>
                                    </h4>
                                </div>
                                
                                <div class="col-md-12 table-responsive">
                                    <table class=" table table-hover shipping-details-table">
                                        <thead>
                                            <tr>
                                                
                                                <th class="text-center">ID Commande</th>
                                                <th class="text-center">Montant HT</th>
                                                <th class="text-center">Frais Livraison</th>
                                                <th class="text-center">Montant Total Commande</th>
                                                <th class="text-center">Statut Commande</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Date dernière modification</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($commandes['liste'] as $commande) : ?>
                                                <tr>
                                                    <td class="text-center" data-label="Token"><?php echo $commande->cmd_id; ?></td>
                                                    <td class="text-center" data-label="Montant HT">
                                                        <?php echo number_format( $commande->montant_ht, 0, '', ' '); ?> F
                                                    </td>
                                                    <td class="text-center" data-label="Frais Livraison">
                                                        <?php echo number_format( $commande->frais_livraison, 0, '', ' '); ?>
                                                    </td>
                                                    <td class="text-center" data-label="Montant TTC">
                                                        <?php echo number_format( $commande->montant_total, 0, '', ' '); ?>
                                                    </td>
                                                    <td class="text-center" data-label="">
                                                        <span class="cmd-status badge-detail style-<?php echo status_displayed($commande->cmd_statut)['color'] ?>">
                                                            <?php echo status_displayed($commande->cmd_statut)['libele'] ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center" data-label="Quantité totale">
                                                        <?php echo dateFormat($commande->cmd_date_creation); ?>
                                                    </td>
                                                    <td class="text-center" data-label="Quantité totale">
                                                        <?php echo dateFormat($commande->date_modification); ?>
                                                    </td>
                                                    
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
