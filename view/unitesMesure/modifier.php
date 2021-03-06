<div id="content">
    
    <span id="linkToGetElement" class="hidden">ajax/UpdateUnitMesure.php</span>
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'unitesMesure/liste'; ?>"> Unité de Mésure </a></li>
                <li class="active">Modifier/</li>
            </ol>
        </div>
        <div class="row align-items-center" >
        <div class="section-body col-md-9 content-section-center offset-sm-2">
            <form class="form unit_update_form with_date" enctype="multipart/form-data">
                <em class="text-caption">(*) Champs obligatoires. </em>
                <div class="card">
                    <div class="card-head card-head-xs style-primary">
                        <header>
                            <h2 class="text-default-bright">Formulaire de modification d'unité de mesure</h2>
                        </header>

                        <div class="tools">
                            <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                            data-original-title="Revenir à la liste des catégories" 
                            href="<?php echo SITE_BASE_URL.'unitesMesure/liste'; ?>">
                                <i class="md md-settings-backup-restore"></i></a>
                        </div>
                    </div>
                    <div class="card-body ">
                        <!-- floating-label -->
                        <div id="errorForm" class="col-md-12 text-center"></div>
                        <div class="row">                                    
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="name_element" class="form-control" id="name_element" 
                                    value="<?php echo $unite->libelle ; ?>" required>
                                    <label for="name_element">Libellé*</label>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="symbole" class="form-control" id="symbole" 
                                    value="<?php echo $unite->symbole ; ?>" required>
                                    <label for="symbole">Symbole*</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="token" value="<?php echo  $unite->token ?>">

                    </div><!--end .card-body -->
                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <button id="confirm_btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                                    CONFIRMER
                                    <div class="ld ld-ring ld-spin"></div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div><!--end .section-body -->
        </div>
    </section>
    <!-- END TABLE HOVER -->
</div>

