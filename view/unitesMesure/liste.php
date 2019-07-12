<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <span id="linkToDeleteElement" class="hidden">ajax/DeleteUnit.php</span>
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'unitesMesure/liste'; ?>">Unités de Mésure des Produits</a></li>
                <li class="active">Liste/</li>
            </ol>
        </div>

        <div class="section-body">
            <div class="row">
                <?php //debug($d); ?>
                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-4 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-info no-margin">
                                <div class="col-sm-12 text-center">
                                    <span class="data-title">TOTAL 
                                    </span>
                                </div>
                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding total_units">
                                       <?php echo number_format($unitesMesure['total'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->               
            </div>
            <div class="card">
                <div class="card-head card-head-xs style-primary list-element">
                    <header>
                        <h2 class="text-default-bright">Liste des unités de mesures</h2>
                        <!-- <p>
                            Add <code>.table-hover</code> to enable a hover state on table rows within a <code>&lt;tbody&gt;</code>.
                        </p> -->
                    </header>
                    <div class="tools">
                        <a id=" add-unit-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
                            href="<?php echo SITE_BASE_URL.'unitesMesure/ajouter'; ?>" 
                             data-original-title="Ajouter une unité de mésure">
                            <i class="fa fa-plus-square"></i>
                        </a>
                    </div>
                </div><!--end .card-head -->
                <div class="card-body">
                  <div class="table-responsive">

                      <table id="units-list" class="table table-hover" 
                        filter-data-startDate="" filter-data-startHour="" filter-data-endDate="" filter-data-endHour=""
                        filter-data-libelle="" filter-data-symbole="" filter-data-pageRunning="<?php echo $numero_page_encours; ?>" 
                        >
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Libéllé</th>
                                    <th class="text-center">Symbole</th>
                                    <th class="text-center">Date création</th>
                                    <th class="text-center">Date dernière modification</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nbre_cmd_plus = $unitesMesure['total']; ?>
                                <?php if( !empty( $unites ) ): ?>
                                <?php foreach ( $unites as $unite ): ?>
                                <tr class="text-center <?php echo $unite->token; ?>">
                                    <td class="text-center"><?php echo $nbre_cmd_plus--; ?></td>
                                    <td class="text-center libelle_unit" ><?php echo ucfirst( $unite->libelle ); ?></td>
                                    <td class="text-center symbole_unit"><?php echo ($unite->symbole == 'NA') ? 'Nombre' : $unite->symbole; ?></td>
                                    <td class="text-center"><?php echo dateFormat($unite->date_creation); ?></td>
                                    <td class="text-center"><?php echo dateFormat($unite->date_modification); ?></td>
                                    <td class="text-center ">
                                        <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top"
                                            unite-id="<?php echo $unite->token; ?>" data-original-title="Modifier les informations de l'unité de mesure">
                                            <a href="<?php echo BASE_URL.DS.'unitesMesure/modifier/'.$unite->token; ?>">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" 
                                           data-placement="top" unite-id="<?php echo $unite->token; ?>" data-original-title="Supprimer l'unité de mesure">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                      </table>                          
                  </div>
                </div><!--end .card-body <span class="sr-only">(current)</span> -->  
            </div>
        </div><!--end .section-body -->
    </section>
    <!-- END TABLE HOVER -->


<!-- START MODAL DELETE ORDER -->
<div class="modal own-modal fade" id="modal-delete-units" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> SUPPRIMER LA CATEGORIE </h4>
      </div>
      <form id="form-delete-units" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    (*) Champs obligatoires. On ne peut supprimer les unités de mésure déjà liées à un produit.
                </em><br>
            </div>    
            <div class="card-body ">
                <div id="" class="col-md-12 text-center errorForm"></div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="libelle_unit" class="form-control"  disabled>
                            <label for="libelle_unit"> Libéllé</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="symbole_unit" class="form-control"  disabled>
                            <label for="symbole_unit"> Symbole </label>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group ">
                            <input type="password" name="password" class="form-control" required>
                            <label for="password">Mot De Passe*</label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="token" value="">
            </div>
        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="confirm_btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                        CONFIRMER
                        <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
      </div>
      </form>

    </div>
  </div>
</div>
<!-- END MODAL DELETE ORDER -->

</div>

