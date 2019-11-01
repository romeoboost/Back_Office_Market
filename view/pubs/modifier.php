<div id="content">
    <span id="linkToUpdateElement" class="hidden">ajax/UpdatePub.php</span>
    <!-- BEGIN TABLE HOVER -->
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'pubs/liste'; ?>">Pages Publicitaires</a></li>
                <li class="active">Modifier/</li>
            </ol>
        </div>
        <div class="row align-items-center" >
        <div class="section-body col-md-9 content-section-center offset-sm-2">
            <form class="form pub_update_form with_date" enctype="multipart/form-data">
                <em class="text-caption">(*) Champs obligatoires. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <h2 class="text-default-bright">Formulaire de modification de campagnes publicitaires</h2>
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
                                                    <input type="text" name="start_date" class="form-control" id="StartDateInput"
                                                    value="<?php echo dateFormat($element->date_debut, 'd-m-Y') ; ?>" requred> 
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
                                                    <input type="text" name="end_date" class="form-control" id="EndDateInput" 
                                                    value="<?php echo dateFormat($element->date_fin, 'd-m-Y') ; ?>" required>
                                                    <label>Date Fin Campagne*</label>
                                                </div>
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name_compagny" class="form-control" id="name_category"
                                            value="<?php echo $element->entreprise ; ?>" required>
                                            <label for="name_category">Nom Entreprise*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="file" name="image" class="form-control-file" id="image" >
                                            <label for="image">Image (150 x 150)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="status" name="status" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0" <?php echo ( $element->statut == 0 ) ? 'selected' : ''; ?> >NON ACTIF</option>
                                                <option value="1" <?php echo ( $element->statut == 1 ) ? 'selected' : ''; ?> >ACTIF</option>
                                            </select>
                                            <label for="status">Statut*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <select id="position" name="position" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="1" <?php echo ( $element->position == 1 ) ? 'selected' : ''; ?> >1</option>
                                                <option value="2" <?php echo ( $element->position == 2 ) ? 'selected' : ''; ?> >2</option>
                                                <option value="3" <?php echo ( $element->position == 3 ) ? 'selected' : ''; ?> >3</option>
                                                <option value="4" <?php echo ( $element->position == 4 ) ? 'selected' : ''; ?> >4</option>
                                            </select>
                                            <label for="position">Position*</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="token" class="" id="token" value="<?php echo $element->token ; ?>" required>
                                    <input type="hidden" name="old_image" class="" id="old_image" value="<?php echo $element->image ; ?>" required>

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
                        </div>
                    </form> 


        </div><!--end .section-body -->
        </div>
    </section>
    <!-- END TABLE HOVER -->
</div>

