<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'stocks/liste'; ?>">Stocks</a></li>
                <li class="active">Ajouter/</li>
            </ol>
        </div>
        <div class="row align-items-center" >
        <div class="section-body col-md-9 content-section-center offset-sm-2">
            <form class="form stocks_add_form with_date" enctype="multipart/form-data">
                <em class="text-caption">(*) Champs obligatoires. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <h2 class="text-default-bright">Formulaire d'ajout de stock</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Retourner à la liste des stocks" href="<?php echo SITE_BASE_URL.'stocks/liste'; ?>">
                                        <i class="md md-settings-backup-restore"></i></a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <!-- floating-label -->
                                <div id="errorForm" class="col-md-12 text-center"></div>

                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="name_produit" name="name_produit" class="form-control dirty selectpicker" 
                                            data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <?php foreach ( $produits as $produit ): ?>
                                                    <option class="toUpCase" value="<?php echo  $produit->id ?>">
                                                        <?php echo strtoupper( $produit->nom ); ?> 
                                                        ( Unité mésure = <?php echo strtoupper( $unit_mesure[$produit->unite ] ); ?> )
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                            <label for="name_produit">Le Produit*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="name_supplier" name="name_supplier" class="form-control dirty selectpicker" 
                                            data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <?php foreach ( $fournisseurs as $fournisseur ): ?>
                                                    <option class="toUpCase" value="<?php echo  $fournisseur->id ?>">
                                                        <?php echo strtoupper( $fournisseur->nom ); ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                            <label for="name_supplier">Le Fournisseur*</label>
                                        </div>
                                    </div>
                                    
                                </div>


                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="number" name="qtte" class="form-control" id="qtte" required>
                                            <label for="qtte"> Quantité *</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="number" name="montant" class="form-control" id="montant" required>
                                            <label for="montant">  Montant du stock (HT) *</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="number" name="frais" class="form-control" id="frais" required value="0">
                                            <label for="frais"> Frais *</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="number" name="montant_ttc" class="form-control" id="montant_ttc" required>
                                            <label for="montant_ttc">  Montant Total*</label>
                                        </div>
                                    </div>
                                </div>


                            </div><!--end .card-body -->
                            <div class="card-actionbar">
                                <div class="card-actionbar-row">
                                    <button id="confirm_btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                                            CONFIRMER
                                            <div class="ld ld-ring ld-spin"></div>
                                    </button>
                                </div>
                            </div>
                        </div><!--end .card -->
                        <!-- <em class="text-caption">Ce formulaire permet de filtrer la liste des commandes.
                        Il faut renseigner au moins un champs avant de valider. </em> -->
                    </form> 
            <!-- <div class="card">
                <div class="card-head card-head-xs style-primary list-element">
                    <header>
                        <h2 class="text-default-bright">Liste des commandes</h2>
                    </header>
                </div>
                <div class="card-body">
                  
                </div> 
            </div> -->


        </div><!--end .section-body -->
        </div>
    </section>
    <!-- END TABLE HOVER -->
</div>

