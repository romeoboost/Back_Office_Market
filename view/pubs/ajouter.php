<div id="content">
    <span id="linkToAddElement" class="hidden">ajax/AddPub.php</span>
    <!-- BEGIN TABLE HOVER -->
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'pubs/liste'; ?>">Pages Publicitaires</a></li>
                <li class="active">Ajouter/</li>
            </ol>
        </div>
        <div class="row align-items-center" >
        <div class="section-body col-md-9 content-section-center offset-sm-2">
            <form class="form pub_add_form with_date" enctype="multipart/form-data">
                <em class="text-caption">(*) Champs obligatoires. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <h2 class="text-default-bright">Formulaire d'ajout de campagnes publicitaires</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Revenir à la liste des catégories" 
                                    href="<?php echo SITE_BASE_URL.'pubs/liste'; ?>">
                                        <i class="md md-settings-backup-restore"></i></a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <!-- floating-label -->
                                <div id="errorForm" class="col-md-12 text-center"></div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group " id="">
                                            <div class="input-group date" id="StartDate">
                                                <div class="input-group-content">
                                                    <input type="text" name="start_date" class="form-control" id="StartDateInput" required>
                                                    <label>Date Début Campagne*</label>
                                                </div>
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="input-group date" id="EndDate">
                                                <div class="input-group-content">
                                                    <input type="text" name="end_date" class="form-control" id="EndDateInput" required>
                                                    <label>Date Fin Campagne*</label>
                                                </div>
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <!-- <input type="text" class="form-control" id="Lastname2">
                                            <label for="Lastname2">Date Fin</label> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name_compagny" class="form-control" id="name_category" required>
                                            <label for="name_category">Nom Entreprise*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="file" name="image" class="form-control-file" id="image" required>
                                            <label for="image">Image* (173 x 750)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="status" name="status" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0">NON ACTIF</option>
                                                <option value="1">ACTIF</option>
                                            </select>
                                            <label for="status">Statut*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="position" name="position" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                            <label for="position">Position*</label>
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


        </div><!--end .section-body -->
        </div>
    </section>
    <!-- END TABLE HOVER -->
</div>

