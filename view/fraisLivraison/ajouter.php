<div id="content">
    
    <span id="linkToAddElement" class="hidden">ajax/AddFees.php</span>
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'fraisLivraison/liste'; ?>">Grille de frais de livraison</a></li>
                <li class="active">Ajouter/</li>
            </ol>
        </div>
        <div class="row align-items-center" >
        <div class="section-body col-md-9 content-section-center offset-sm-2">
            <form class="form fee_add_form with_date" enctype="multipart/form-data">
                <em class="text-caption">(*) Champs obligatoires. </em>
                <div class="card">
                    <div class="card-head card-head-xs style-primary">
                        <header>
                            <h2 class="text-default-bright">Formulaire d'ajout de frais de livraison</h2>
                        </header>

                        <div class="tools">
                            <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                            data-original-title="Revenir à la liste des catégories" 
                            href="<?php echo SITE_BASE_URL.'fraisLivraison/liste'; ?>">
                                <i class="md md-settings-backup-restore"></i></a>
                        </div>
                    </div>
                    <div class="card-body ">
                        <!-- floating-label -->
                        <div id="errorForm" class="col-md-12 text-center"></div>
                        <div class="row">                                    
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="number" name="min_amount" class="form-control" id="min_amount" required>
                                    <label for="name_element">Montant Minimum*</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="number" name="max_amount" class="form-control" id="max_amount" required>
                                    <label for="name_element">Montant Maximum*</label>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="number" name="fee" class="form-control" id="fee" required>
                                    <label for="symbole">Montant Frais*</label>
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
            </form>

        </div><!--end .section-body -->
        </div>
    </section>
    <!-- END TABLE HOVER -->
</div>

