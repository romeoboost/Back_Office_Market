<!-- BEGIN CONTENT-->
<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'produits/liste'; ?>">Produits</a></li>
                <li class="active">Détails</li>
                <li class="active"><?php echo ucfirst( $produit->nom_produit ); ?> /</li>
            </ol>
        </div>

        <div class="section-body contain-lg">
            <div class="row">           
                <div class="col-lg-12">
                    <div class="card card-tiles style-default-light">

                        <!-- BEGIN BLOG POST HEADER -->
                        <div class="row style-default-light">
                            
                            <div class="col-sm-3">
                                
                                <div class="detail-product-img-content">
                                    <img class="img-responsive" src="<?php echo WEBROOT_URL_FRONT.'images/shop/'.$produit->image; ?>.jpg?1422538624" alt="" 
                                    />
                                </div>
                                
                            </div><!--end .col -->
                            
                            <div class="col-sm-9 info-product-container">
                                <div class="row info-product-content" >
                                    <div class="col-xs-4">
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> NOM PRODUIT : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo ucfirst( $produit->nom_produit ); ?> </b>
                                             </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> CATEGORIE : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo ucfirst( $produit->categorie ); ?></b>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> STATUT : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo ($produit->produit_statut == 1) ? 'ACTIF' : 'NON ACTIF'; ?> </b>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-xs-4">
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle">PAGE D'ACCUEIL : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo ($produit->page_accueil == 1) ? 'OUI' : 'NON'; ?> </b>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> STOCK RESTANT : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo $produit->stock; ?></b>
                                             </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> UNITE MESURE : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo ucfirst( $unit_mesure[$produit->unite] ); ?></b>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-xs-4">
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle">QUANTITE UNITAIRE VENDUE : </div>
                                                <div class="pull-right product-info"> 
                                                    <b> <?php echo $produit->qtite_unit; ?> </b>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> PRIX QUANTITE UNITAIRE : </div>
                                                <div class="pull-right product-info"> 
                                                    <b><?php echo number_format($produit->prix_qtite_unit, 0, '', ' '); ?> F</b>
                                                 </div>
                                            </div>
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> PROMOTION : </div>
                                                <div class="pull-right product-info"> 
                                                    <b><?php echo ($produit->ispromo == 1) ? 'OUI' : 'NON'; ?></b>
                                                </div>
                                            </div>
                                            
                                    </div>
                                </div>
                                
                                <div class="row info-product-content" >
                                    <div class="col-xs-5">
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle">POURCENTAGE PROMOTION : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo $produit->percent_promo ; ?> % </b>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> DATE DE CREATION : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo dateFormat($produit->date_creation); ?></b>
                                             </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> DATE DE DERNIERE MODIFICATION : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo dateFormat($produit->date_modification); ?></b>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-xs-7">
                                            
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> DESCRIPTION : </div>
                                                <div class=" product-info"> 
                                                    <p><b> <?php echo $produit->description ; ?></b></p>

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
                                        <span class="badge"><?php echo count($commandes); ?></span>
                                    </h4>
                                </div>
                                
                                <div class="col-md-12 table-responsive">
                                    <table class=" table table-hover shipping-details-table">
                                        <thead>
                                            <tr>
                                                
                                                <th class="text-center">ID Commande</th>
                                                <th class="text-center">Quantité Commandée</th>
                                                <th class="text-center">Montant Produit</th>
                                                <th class="text-center">Montant Commande</th>
                                                <th class="text-center">Statut Commande</th>
                                                <th class="text-center">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($commandes as $commande) : ?>
                                                <tr>
                                                    <td class="text-center" data-label="Nom"><?php echo $commande->cmd_id; ?></td>
                                                    <td class="text-center" data-label="Nombre"><?php echo $commande->nbre_cmd*$commande->qtte_unitaire_cmd; ?></td>
                                                    <td class="text-center" data-label="Quantité unitaire vendue">
                                                        <?php echo number_format( $commande->nbre_cmd*$commande->prix_qtte_unitaire_cmd, 0, '', ' '); ?> F
                                                    </td>
                                                    <td class="text-center" data-label="Unité de mésure">
                                                        <?php echo number_format( $commande->montant_ht, 0, '', ' '); ?>
                                                    </td>
                                                    <td class="text-center" data-label="Prix quantitié unitaire">
                                                        <span class="cmd-status badge-detail style-<?php echo status_displayed($commande->cmd_statut)['color'] ?>">
                                                            <?php echo status_displayed($commande->cmd_statut)['libele'] ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center" data-label="Quantité totale">
                                                        <?php echo dateFormat($commande->cmd_date_creation); ?>
                                                    </td>
                                                    
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div><!--end .col , 0, '', ' '); -->
                            </div><!--end .row -->
                    </div><!--end .card -->
                </div><!--end .col -->
            </div><!--end .row -->

            

        </div><!--end .section-body -->
    

    </section>

</div><!--end #content-->
<!-- END CONTENT -->
