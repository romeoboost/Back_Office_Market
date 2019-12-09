<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <section class="">
        <div class="section-header"> 
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'accueil/index'; ?>">Mot de passe administrateur</a></li>
                <li class="active">Modifier/</li>
            </ol>
        </div>
        <div class="row align-items-center" >
        <div class="section-body col-md-8 content-section-center ">
            <form class="form admin_password_update_form with_date" enctype="multipart/form-data">
                <em class="text-caption">(*) Champs obligatoires. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <h2 class="text-default-bright">Formulaire de modification de mot de passe</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Revenir à la liste des communes" 
                                    href="<?php echo SITE_BASE_URL.'accueil/index'; ?>">
                                        <i class="md md-settings-backup-restore"></i></a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <!-- floating-label -->
                                <div id="errorForm" class="col-md-12 text-center"></div>
                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="password" name="old_password" class="form-control password" id="old_password" 
                                            required>
                                            <label for="old_password">Ancien Mot de Passe*</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="password" name="new_password" class="form-control password" id="new_password" 
                                            required>
                                            <label for="new_password">Nouveau Mot de Passe*</label>
                                        </div>
                                    </div>
                                </div>

								<div class="row">
									<div class="col-sm-6 ">
                                        <div class="form-group">
                                            <input type="password" name="confirm_new_password" class="form-control password" id="confirm_new_password" 
                                            required>
                                            <label for="confirm_new_password">Nouveau Mot de Passe*</label>
                                        </div>
                                    </div>
                                </div>
								<div class="col-sm-12 text-right show-password">
                                        <label>
                                            <input id="show-password-checkbox" type="checkbox">  Afficher mot de passe 
                                        </label>
                                </div>
                                <input type="hidden" name="token" value="<?php echo $_SESSION['bo_user']['token']; ?>">

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

