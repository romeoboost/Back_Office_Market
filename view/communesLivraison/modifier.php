<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'communesLivraison/liste'; ?>">Communes de Livraison</a></li>
                <li class="active">Modifier/</li>
            </ol>
        </div>
        <div class="row align-items-center" >
        <div class="section-body col-md-9 content-section-center offset-sm-2">
            <form class="form city_update_form with_date" enctype="multipart/form-data">
                <em class="text-caption">(*) Champs obligatoires. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <h2 class="text-default-bright">Formulaire d'ajout de commune</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Revenir à la liste des communes" 
                                    href="<?php echo SITE_BASE_URL.'communesLivraison/liste'; ?>">
                                        <i class="md md-settings-backup-restore"></i></a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <!-- floating-label -->
                                <div id="errorForm" class="col-md-12 text-center"></div>
                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name_city" class="form-control" id="name_city" 
                                            value="<?php echo ucfirst( $commune->commune ); ?>" required>
                                            <label for="name_city">Nom*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="status_city" name="status_city" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0" <?php echo ( $commune->statut == 0 ) ? 'selected' : ''; ?>>NON ACTIF</option>
                                                <option value="1" <?php echo ( $commune->statut == 1 ) ? 'selected' : ''; ?>>ACTIF</option>
                                            </select>
                                            <label for="status_city">Statut*</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="long_city" class="form-control" id="long_city" 
                                            value="<?php echo ucfirst( $commune->longitude ); ?>">
                                            <label for="long_city">Longitude</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="lag_city" class="form-control" id="lag_city" 
                                            value="<?php echo ucfirst( $commune->lagitude ); ?>">
                                            <label for="lag_city">Lagitude</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="token" value="<?php echo $commune->token; ?>">

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


        </div><!--end .section-body -->
        </div>
    </section>
    <!-- END TABLE HOVER -->
</div>

