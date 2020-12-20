<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <span id="linkToAddCustomer" class="hidden"><?php echo 'ajax/UpdateCustomer.php'; ?></span>
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'clients/liste'; ?>">Clients</a></li>
                <li class="active">Ajouter/</li>
            </ol>
        </div>
        <div class="row align-items-center" >
        <div class="section-body col-md-9 content-section-center offset-sm-2">
            <form class="form customer_add_form with_date" enctype="multipart/form-data">
                <em class="text-caption">(*) Champs obligatoires. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <h2 class="text-default-bright">Formulaire d'ajout du client</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Revenir à la liste des catégories" 
                                    href="<?php echo SITE_BASE_URL.'clients/liste'; ?>">
                                        <i class="md md-settings-backup-restore"></i></a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <!-- floating-label -->
                                <div id="errorForm" class="col-md-12 text-center"></div>

                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="nom_client" class="form-control" 
                                                value="<?php echo ucfirst( htmlspecialchars ($client->nom) ); ?>"
                                                id="nom_client" required>
                                            <label for="nom_client">Nom*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="prenoms_client" class="form-control" 
                                                value="<?php echo ucfirst( htmlspecialchars ($client->prenoms) ); ?>"
                                                id="prenoms_client" required>
                                            <label for="prenoms_client">Prénoms*</label>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="tel" class="form-control" id="tel" 
                                            value="<?php echo ucfirst( htmlspecialchars ($client->tel) ); ?>"
                                            required>
                                            <label for="tel">Tel*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" id="email"
                                            value="<?php echo ucfirst( htmlspecialchars ($client->email) ); ?>" 
                                            >
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="sexe" name="sexe" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0"
                                                    <?php echo ($client->sexe == 0) ? 'selected' : ''; ?>>FEMME</option>
                                                <option value="1"
                                                    <?php echo ($client->sexe == 1) ? 'selected' : ''; ?>>HOMME</option>
                                            </select>
                                            <label for="sexe">Sexe*</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="type" name="type" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="2" 
                                                    <?php echo ($client->type_client == 2) ? 'selected' : ''; ?>>GROSSISTE</option>
                                                <option value="1"
                                                    <?php echo ($client->type_client == 1) ? 'selected' : ''; ?>>DEMI GROSSISTE</option>
                                                <option value="0"
                                                    <?php echo ($client->type_client == 0) ? 'selected' : ''; ?>>DETAILLANT</option>
                                                <option value="3"
                                                    <?php echo ($client->type_client == 3) ? 'selected' : ''; ?>>EXCHANGE</option>
                                            </select>
                                            <label for="type">Type De Client*</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $client->token; ?>" name="token">

                            </div><!--end .card-body -->
                            <div class="card-actionbar">
                                <div class="card-actionbar-row">
                                    <button id="confirm_btn" class="form-confirm-btn btn btn-primary btn-raised ld-ext-right " type="submit">
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

