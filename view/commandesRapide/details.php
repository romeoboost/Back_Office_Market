<!-- BEGIN CONTENT-->
<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'commandesRapide/liste'; ?>">Commandes Rapides</a></li>
                <li class="active">Détails/</li>
            </ol>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-printable style-default-light">
                        <div class="card-head">
                            <div class="tools">
                                <div class="btn-group">
                                    <a class="btn btn-floating-action btn-primary" href="javascript:void(0);" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Imprimer La vue"
                                        onclick="javascript:window.print();">
                                        <i class="md md-print"></i>
                                    </a>
                                </div>
                            </div>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright ">

                            <!-- BEGIN INVOICE HEADER -->
                            <div class="row">
                                <div class="col-xs-8">
                                    <h1 class="text-light">
                                        <!-- <i class="fa fa-microphone fa-fw fa-2x text-accent-dark">
                                        </i> -->
                                        <?php echo $commande->token ?> 
                                        <!-- <strong class="text-accent-dark">Speakers</strong> -->
                                    </h1>
                                    <div class="col-sm-12"> 
                                        <span> Date de création : </span>
                                        <b> <?php echo dateFormat($commande->date_creation); ?> </b> 
                                    </div>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <h2 class="">
                                        <span class="cmd-status badge-detail style-<?php echo status_displayed($commande->statut)['color'] ?>">
                                            <?php echo status_displayed($commande->statut)['libele'] ?>
                                        </span>
                                    </h2>
                                    <div class="col-sm-12"> 
                                        <span> Date du dernier statut : </span>
                                        <b> <?php echo dateFormat($commande->date_modification); ?> </b> 
                                    </div>
                                </div>
                            </div><!--end .row -->
                            <!-- END INVOICE HEADER -->

                            <br/>

                            <!-- BEGIN INVOICE DESCRIPTION -->
                            <div class="row">
                                <div class="col-xs-4">
                                    <h4 class="text-light">Informations du Client</h4>
                                    <dl class="dl-horizontal detail-cmd-info">
                                        <dt class="text-left">Nom & Prénoms</dt>
                                        <?php
                                            $client_prenom = ( isset( explode( ' ',$commande->prenoms )[1] ) ) ? ucfirst( explode( ' ',$commande->prenoms )[1] ) : '';
                                        ?>
                                        <dd><?php echo ucfirst( htmlspecialchars ($commande->nom) ).' '.ucfirst( explode( ' ',htmlspecialchars ($commande->prenoms) )[0] ).' '.htmlspecialchars ($client_prenom); ?></dd>
                                        <dt>Téléphone</dt>
                                        <dd><?php echo htmlspecialchars ($commande->tel); ?></dd>
                                        <dt>E-Mail</dt>
                                        <dd><?php echo htmlspecialchars ($commande->email); ?></dd>

                                    </dl>
                                </div><!--end .col -->

                                <div class="col-xs-5">
                                    <h4 class="text-light">Informations sur Livraison</h4>
                                    <dl class="dl-horizontal detail-cmd-info-shipping">

                                        <dt>Commune</dt>
                                        <dd><?php echo ucfirst( $commune->commune ); ?></dd>
                                        <dt>Quartier</dt>
                                        <dd><?php echo ucfirst( htmlspecialchars ($commande->receiver_quartier) ); ?></dd>

                                        <dt>Longitude</dt>
                                        <dd><?php echo ucfirst( $commande->longitude ); ?></dd>

                                        <dt>Latitude</dt>
                                        <dd><?php echo ucfirst( $commande->lagitude ); ?></dd>


                                        <dt>Description du lieu</dt>
                                        <dd><?php echo $commande->receiver_description; ?></dd>
                                        <?php if( isset($livreur) && !empty( $livreur ) ): ?>
                                            <dt>Livreur</dt>
                                            <dd><?php echo strtoupper( $livreur->nom ).' ('.ucfirst( explode( ' ',$livreur->prenoms )[0] ).')'; ?></dd>
                                        <?php endif; ?>
                                    </dl>
                                </div><!--end .col -->


                                <div class="col-xs-3">
                                    <div class="well">
                                        <div class="clearfix">
                                            <div class="pull-left"> MONTANT HT : </div>
                                            <div class="pull-right"> 
                                                <b><?php echo number_format($commande->montant_ht, 0, '', ' '); ?> F </b>
                                             </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left"> FRAIS DE LIVRAISON : </div>
                                            <div class="pull-right"> 
                                                <b><?php echo number_format($commande->frais_livraison, 0, '', ' '); ?> F </b>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left"> MONTANT TTC : </div>
                                            <div class="pull-right"> 
                                                <b> <?php echo number_format($commande->montant_total, 0, '', ' '); ?> F </b>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end .col -->
                            </div><!--end .row -->
                            <!-- END INVOICE DESCRIPTION -->

                            <br/>

                            <!-- BEGIN INVOICE PRODUCTS -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="text-light">Détail de la commande</h4>
                                </div>
                                
                                <div class="col-md-12 style-default-light">
                                   <div class="col-sm-5">
                                    <div class="detail-product-img-content">
                                        <img class="img-responsive quick-cmd" 
                                        src="<?php echo WEBROOT_URL_FRONT.'images/quick_order/large/'.$commande->image; ?>.jpg?1422538624" alt="">
                                    </div>
                                   </div>
                                   <div class="col-sm-7 info-product-container">
                                            <h5>Description de la commande : </h5>
                                            <p class="quick-cmd-detail-descript"><?php echo htmlspecialchars ($commande->description_commande); ?></p>
                                   </div>
                                </div><!--end .col -->
                            </div><!--end .row -->
                            <!-- END INVOICE PRODUCTS -->

                            <div class="row"> 
                                <div class="col-sm-12">
                                    <div class="col-xs-12">
                                        <h4 class="text-light">Autres Informations</h4>
                                        <dl class="dl-horizontal detail-cmd-other-info">
                                            <!-- <dt class="text-left">Dernier utilisateur Back Office ayant traité l'opération</dt> -->
                                            <?php
                                                $split_lastname = ( isset( $user_bo->prenoms ) ) ? explode( ' ',$user_bo->prenoms ) : array();
                                                $recept_prenom = ( isset( $split_lastname[1] ) ) ? ucfirst( $split_lastname[1] ) : '';
                                            ?>
                                            <?php if( isset($user_bo) && !empty( $user_bo ) ): ?>
                                                <dt>Dernier utilisateur Back Office ayant traité la commande</dt>
                                                <dd><?php echo strtoupper( $user_bo->nom ).' '.ucfirst( explode( ' ',$user_bo->prenoms )[0] ).' '.$recept_prenom; ?></dd>
                                            <?php endif; ?>
                                            <?php if( intval( $commande->statut ) == 4 ): ?>
                                                <dt>Motif du rejet de la transaction</dt>
                                                <dd><?php echo $commande->motif_rejet; ?></dd>
                                            <?php endif; ?>
                                        </dl>
                                    </div><!--end .col -->
                                </div>
                            </div>

                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
            </div><!--end .row -->
        </div><!--end .section-body -->
    </section>

</div><!--end #content-->
<!-- END CONTENT -->
