<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <span id="linkToAddCustomer" class="hidden"><?php echo 'ajax/makePayment.php'; ?></span>
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'commandes/liste_to_pay'; ?>">Commandes à Payer</a></li>
                <li class="active">Paiement/</li>
            </ol>
        </div>
        <div class="row align-items-center wrap" >
            <div class="col-md-5">
                <div class="card">  
                    <div class="card-head card-head-xs style-primary list-element">
                        <header>
                            <h2 class="text-default-bright">Informations Clients</h2>
                        </header>
                    </div><!--end .card-head -->
                    <div class="card-body ">
                        <div class="col-xs-12">
                            <div class="clearfix">
                                <div class="pull-left product-libelle"> Montant Commande : </div>
                                <div class="pull-right product-info"> 
                                    <b><?php echo number_format($commande->montant_total, 0, '', ' '); ?> </b>
                                    </div>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left product-libelle"> Reste à Payer : </div>
                                <div class="pull-right product-info"> 
                                    <b><?php echo number_format($commande->reste_a_payer, 0, '', ' '); ?> </b>
                                    </div>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left product-libelle"> NOM CLIENT: </div>
                                <div class="pull-right product-info"> 
                                    <b><?php echo ucfirst( htmlspecialchars ($client->nom) ); ?> </b>
                                    </div>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left product-libelle"> PRENOMS CLIENT: </div>
                                <div class="pull-right product-info"> 
                                    <b><?php echo ucfirst( htmlspecialchars ($client->prenoms) ); ?></b>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left product-libelle"> Téléphone Client : </div>
                                <div class="pull-right product-info"> 
                                    <b> <?php echo htmlspecialchars($client->tel); ?> </b>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left product-libelle"> Type Client : </div>
                                <div class="pull-right product-info"> 
                                    <b> <?php echo libelle_type_client( $client->type_client ); ?> </b>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left product-libelle"> Solde Client: </div>
                                <div class="pull-right product-info"> 
                                    <b> <?php echo number_format($client->solde_apres, 0, '', ' '); ?> </b>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left product-libelle"> SEXE CLIENT: </div>
                                <div class="pull-right product-info"> 
                                    <b> <?php echo ($client->sexe == 1) ? 'HOMME' : 'FEMME'; ?> </b>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-xs-6">
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
                        </div> -->
                        <br><br>    
                    </div><!--end .card-body -->
                </div>
            </div>
            <div class="section-body col-md-5 ">
                <form class="form customer_add_form with_date" enctype="multipart/form-data">
                <!-- <em class="text-caption">(*) Champs obligatoires. </em> -->
                    <div class="card">
                        <div class="card-head card-head-xs style-warning">
                            <header>
                                <h2 class="text-default-bright">Formulaire de versements (paiement) </h2>
                            </header>

                            <div class="tools">
                                <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                data-original-title="Revenir à la liste des catégories" 
                                href="<?php echo SITE_BASE_URL.'commandes/liste_to_pay'; ?>">
                                    <i class="md md-settings-backup-restore"></i></a>
                            </div>
                        </div>
                        <div class="card-body ">
                        <em class="text-caption">(*) Champs obligatoires. </em>
                            <!-- floating-label -->
                            <div id="errorForm" class="col-md-12 text-center"></div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <select id="type" name="type" class="form-control dirty selectpicker" data-live-search="true">
                                            <option value="0" selected>ESPECE</option>
                                            <option value="1">UTILISER SON SOLDE</option>
                                            <option value="2">A CREDIT</option>
                                        </select>
                                        <label for="type">Type De Règlement*</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="number" name="montant_verser" class="form-control" id="montant_verser" >
                                        <label for="montant_verser">Montant</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="tokenCommande" value="<?php echo $token_commande ?>">

                        </div><!--end .card-body -->
                        <div class="card-actionbar">
                            <div class="card-actionbar-row">
                                <button id="confirm_btn" class="form-confirm-btn btn btn-primary btn-raised ld-ext-right " type="submit">
                                        CONFIRMER
                                        <div class="ld ld-ring ld-spin"></div>
                                </button>
                            </div>
                        </div>
                    </div><!--end .card -->
                    <!-- <em class="text-caption">Ce formulaire permet de filtrer la liste des commandes.
                    Il faut renseigner au moins un champs avant de valider. </em> -->
                </form> 

            </div><!--end .section-body -->
            
        </div>
    <!-- </section> -->

    <!-- END TABLE HOVER -->

    <!-- <section> -->
        <div class="row card col-md-10" style="margin-left: 1px;">
            <div class="col-sm-12">
                <h4 class="text-medium list-order-product-title">
                Liste des Versements liées à la commande
                    <span class="badge"><?php echo count($versements); ?></span>
                </h4>
            </div>
            
            <div class="col-md-12 table-responsive">
                <table class=" table table-hover shipping-details-table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">TYPE PAIEMENT</th>
                            <th class="text-center">Montant à Payer</th>
                            <th class="text-center">Montant Versé</th>                                    
                            <th class="text-center">Reste</th>
                            <th class="text-center">Date Versement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nbre_cmd_plus = count($versements); ?>
                        <?php foreach ($versements as $versement) : ?>
                            <tr class="text-center">
                                <td class=""><?php echo $nbre_cmd_plus--; ?></td>
                                <td class="cmd_id">
                                    <?php echo ($versement->type_paiement == 0) ? 'ESPECE' : 'AVEC SOLDE'; ?>
                                </td>
                                <td class="montant_ht"><?php echo number_format($versement->montant_a_payer, 0, '', ' '); ?></td>
                                <td class="frais_livraison"><?php echo number_format($versement->montant_verser, 0, '', ' '); ?></td>
                                <td class="montant_ttc"><?php echo number_format($versement->reste, 0, '', ' '); ?></td>
                                <td><?php echo dateFormat($versement->date_creation); ?></td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!--end .col -->
        </div><!--end .row -->
    </section>
</div>

