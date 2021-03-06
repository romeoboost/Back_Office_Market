<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <section class="">
        <div class="row align-items-center" >
        <div class="section-body col-md-9 content-section-center offset-sm-2">
            <form class="form product_update_form with_date" enctype="multipart/form-data">
                <em class="text-caption">(*) Champs obligatoires. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <h2 class="text-default-bright">Formulaire de modification de produit</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Retourner à la liste des produits" href="<?php echo SITE_BASE_URL.'produits/liste'; ?>">
                                        <i class="md md-settings-backup-restore"></i></a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <!-- floating-label -->
                                <div id="errorForm" class="col-md-12 text-center"></div>
                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name_product" class="form-control" id="name_product" 
                                            value="<?php echo ucfirst( $produit->nom_produit ); ?>" required>
                                            <label for="name_product">Nom du Produit*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="file" name="image" class="form-control-file" id="image" >
                                            <label for="image">Image du produit* (300 x 300)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="category_product" name="category_product" class="form-control dirty selectpicker" 
                                            data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <?php foreach ( $categories as $categorie ): ?>
                                                    <option class="toUpCase" value="<?php echo  $categorie->id ?>"
                                                        <?php echo ( $categorie->id == $produit->id_categorie ) ? 'selected' : ''; ?>
                                                        >
                                                        <?php echo strtoupper( $categorie->nom ); ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                            <label for="category_product">Cotégorie Produit*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="page_home" name="page_home" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0" <?php echo ( $produit->page_accueil == 0 ) ? 'selected' : ''; ?> >NON</option>
                                                <option value="1" <?php echo ( $produit->page_accueil == 1 ) ? 'selected' : ''; ?> >OUI</option>
                                            </select>
                                            <label for="page_home">Afficher sur la page d'accueil</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="amount_product" class="form-control" id="amount_product" 
                                            value="<?php echo  $produit->prix_qtite_unit ; ?>"
                                            required>
                                            <label for="amount_product">Prix produit*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="status_product" name="status_product" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0" <?php echo ( $produit->produit_statut == 0 ) ? 'selected' : ''; ?> >NON ACTIF</option>
                                                <option value="1" <?php echo ( $produit->produit_statut == 1 ) ? 'selected' : ''; ?> >ACTIF</option>
                                            </select>
                                            <label for="status_product">Statut</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="unit_qtt_sold" class="form-control" id="unit_qtt_sold" 
                                            value="<?php echo  $produit->qtite_unit ; ?>"
                                            required>
                                            <label for="unit_qtt_sold">Quantité Unitaire Vendue*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="unit_mesure" name="unit_mesure" class="form-control dirty selectpicker" 
                                                data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <?php foreach ( $unit_mesure as $id => $unit ): ?>
                                                    <option value="<?php echo  $id ?>" 
                                                        <?php echo ( $id == $produit->unite ) ? 'selected' : ''; ?>
                                                        >
                                                        <?php echo ucfirst( $unit ) ; ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                            <label for="unit_mesure">Unité Mésure*</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="promo_product" name="promo_product" class="form-control dirty selectpicker" data-live-search="true" >
                                                <option value="" >&nbsp;</option>
                                                <option value="0" <?php echo ( $produit->ispromo == 0 ) ? 'selected' : ''; ?> >NON</option>
                                                <option value="1" <?php echo ( $produit->ispromo == 1 ) ? 'selected' : ''; ?> >OUI</option>
                                            </select>
                                            <label for="promo_product">Promo</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="percent_promo_product" class="form-control" id="percent_promo_product" 
                                            value="<?php echo  $produit->percent_promo ; ?>"
                                            required>
                                            <label for="percent_promo_product">Pourcentage Promo</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="token_produit" class="form-control" id="percent_promo_product" 
                                            value="<?php echo  $produit->token_produit ; ?>">


                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <textarea name="descript_product" id="textarea1" class="form-control" rows="3" placeholder="" value="" required><?php echo  $produit->description ; ?></textarea>
                                            <label for="rejected_message">Desccription du produit*</label>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end .card-body -->
                            <div class="card-actionbar">
                                <div class="card-actionbar-row">
                                    <button id="update_product_btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                                            CONFIRMER
                                            <div class="ld ld-ring ld-spin"></div>
                                    </button>
                                </div>
                            </div>
                        </div><!--end .card -->
            </form> 


        </div><!--end .section-body -->
        </div>
    </section>
    <!-- END TABLE HOVER -->
</div>

