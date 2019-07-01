<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'categories/liste'; ?>">Catégories Produits</a></li>
                <li class="active">Modifier/</li>
            </ol>
        </div>
        <div class="row align-items-center" >
        <div class="section-body col-md-9 content-section-center offset-sm-2">
            <form class="form cotegory_update_form with_date" enctype="multipart/form-data">
                <em class="text-caption">(*) Champs obligatoires. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <h2 class="text-default-bright">Formulaire de modification de catégorie de produit</h2>
                                </header>
                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Revenir à la liste des catégories" 
                                    href="<?php echo SITE_BASE_URL.'categories/liste'; ?>">
                                        <i class="md md-settings-backup-restore"></i></a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <!-- floating-label -->
                                <div id="errorForm" class="col-md-12 text-center"></div>
                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name_category" class="form-control" id="name_category" 
                                            value="<?php echo ucfirst( $categorie->nom ); ?>" required>
                                            <label for="name_category">Nom*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="file" name="image" class="form-control-file" id="image">
                                            <label for="image">Image (150 x 150)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="status_cotegory" name="status_cotegory" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0" <?php echo ( $categorie->statut == 0 ) ? 'selected' : ''; ?> >
                                                    NON ACTIF
                                                </option>
                                                <option value="1" <?php echo ( $categorie->statut == 1 ) ? 'selected' : ''; ?>>
                                                    ACTIF
                                                </option>
                                            </select>
                                            <label for="status_cotegory">Statut*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="icon_cotegory" name="icon_cotegory" class="form-control dirty selectpicker" 
                                            data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <?php foreach ( $icons as $icon ): ?>
                                                    <option data-icon="glyph-icon flaticon-<?php echo $icon; ?>" class="toUpCase" 
                                                        value="<?php echo  $icon ?>"
                                                        <?php echo ( $categorie->icon == $icon ) ? 'selected' : ''; ?>
                                                    >
                                                       <?php echo $icon; ?> 
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                            <label for="icon_cotegory">Icon de la Cotégorie*</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="token" class="form-control" id="token" value="<?php echo  $categorie->token ; ?>" >
                                    <input type="hidden" name="old_image" class="form-control" id="old_image" value="<?php echo  $categorie->image ; ?>" >

                                </div>

                            </div><!--end .card-body -->
                            <div class="card-actionbar">
                                <div class="card-actionbar-row">
                                    <button id="update_category_btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
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

