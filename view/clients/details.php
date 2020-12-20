<!-- BEGIN CONTENT-->
<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'clients/liste'; ?>">Clients</a></li>
                <li class="active">Détails</li>
                <li class="active"><?php echo ucfirst( $client->nom ); ?>/</li>
            </ol>
        </div>

        <div class="section-body contain-lg">
            <div class="row">           
                <div class="col-lg-12">
                    <div class="card card-tiles style-default-light">

                        <!-- BEGIN BLOG POST HEADER -->
                        <div class="row style-default-light">
                            
                            <div class="col-sm-10 info-category-container">
                                <div class="row info-category-content" >
                                    <div class="col-xs-6">
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> NOM : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo ucfirst( htmlspecialchars ($client->nom) ); ?> </b>
                                             </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> PRENOMS : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo ucfirst( htmlspecialchars ($client->prenoms) ); ?></b>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> Identifiant CLient : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo $client->token; ?> </b>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> Téléphone : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo htmlspecialchars($client->tel); ?> </b>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> Email : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo htmlspecialchars($client->email); ?> </b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> Type Client : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo libelle_type_client( $client->type_client ); ?> </b>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> Solde : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo number_format($client->solde_apres, 0, '', ' '); ?> </b>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left product-libelle"> SEXE : </div>
                                            <div class="pull-right product-info"> 
                                                <b> <?php echo ($client->sexe == 1) ? 'HOMME' : 'FEMME'; ?> </b>
                                            </div>
                                        </div>
                                            <div class="clearfix">
                                            <div class="pull-left product-libelle"> DATE DE CREATION : </div>
                                            <div class="pull-right product-info"> 
                                                <b><?php echo dateFormat($client->date_creation); ?></b>
                                             </div>
                                            </div>
                                            <div class="clearfix">
                                                <div class="pull-left product-libelle"> DATE DE DERNIERE MODIFICATION : </div>
                                                <div class="pull-right product-info"> 
                                                    <b><?php echo dateFormat($client->date_modification); ?></b>
                                                </div>
                                            </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div><!--end .row -->
                        <!-- END BLOG POST HEADER -->

                        <div class="row card">
                                <div class="col-sm-12">
                                    <h4 class="text-medium list-order-product-title">
                                    Liste des Commandes liées à ce client
                                        <span class="badge"><?php echo count($commandes); ?></span>
                                    </h4>
                                </div>
                                
                                <div class="col-md-12 table-responsive">
                                    <table class=" table table-hover shipping-details-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">ID Commande</th>
                                                <th class="text-center">Montant HT</th>
                                                <th class="text-center">Frais Livr.</th>
                                                <th class="text-center">Montant TTC</th>                                    
                                                <th class="text-center">Statut</th>
                                                <th class="text-center">Date création</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $nbre_cmd_plus = count($commandes); ?>
                                            <?php foreach ($commandes as $commande) : ?>
                                                <tr class="text-center">
                                                    <td class=""><?php echo $nbre_cmd_plus--; ?></td>
                                                    <td class="cmd_id"><?php echo $commande->cmd_id; ?></td>
                                                    <td class="montant_ht"><?php echo number_format($commande->montant_ht, 0, '', ' '); ?></td>
                                                    <td class="frais_livraison"><?php echo number_format($commande->frais_livraison, 0, '', ' '); ?></td>
                                                    <td class="montant_ttc"><?php echo number_format($commande->montant_total, 0, '', ' '); ?></td>
                                                    <td class="">
                                                        <span class="cmd-status badge style-<?php echo status_displayed($commande->cmd_statut)['color'] ?>">
                                                            <?php echo status_displayed($commande->cmd_statut)['libele'] ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo dateFormat($commande->cmd_date_creation); ?></td> 
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
