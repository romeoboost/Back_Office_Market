<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <span id="linkToDeleteElement" class="hidden">ajax/DeleteFees.php</span>
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'fraisLivraison/liste'; ?>"> Grille de frais de livraison </a></li>
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
                                       <?php echo number_format($fraisLivraison['total'], 0, '', ' '); ?>
                                       
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
                        <h2 class="text-default-bright">Liste des frais de livraison</h2>
                        <!-- <p>
                            Add <code>.table-hover</code> to enable a hover state on table rows within a <code>&lt;tbody&gt;</code>.
                        </p> -->
                    </header>
                    <div class="tools">
                        <a id=" add-unit-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
                            href="<?php echo SITE_BASE_URL.'fraisLivraison/ajouter'; ?>" 
                             data-original-title="Ajouter une unité de mésure">
                            <i class="fa fa-plus-square"></i>
                        </a>
                    </div>
                </div><!--end .card-head -->
                <div class="card-body">
                  <div class="table-responsive">

                      <table id="fees-list" class="table table-hover" 
                        filter-data-startDate="" filter-data-startHour="" filter-data-endDate="" filter-data-endHour=""
                        filter-data-libelle="" filter-data-symbole="" filter-data-pageRunning="<?php echo $numero_page_encours; ?>" 
                        >
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Minimum</th>
                                    <th class="text-center">Maximum</th>
                                    <th class="text-center">Montant Frais</th>
                                    <th class="text-center">Date création</th>
                                    <th class="text-center">Date dernière modification</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nbre_cmd_plus = $fraisLivraison['total']; ?>
                                <?php if( !empty( $fraisLivraison['liste'] ) ): ?>
                                <?php foreach ( $fraisLivraison['liste'] as $fee ): ?>
                                <tr class="text-center <?php echo $fee->token; ?>">
                                    <td class="text-center"><?php echo $nbre_cmd_plus--; ?></td>
                                    <td class="text-center min"><?php echo number_format($fee->min, 0, '', ' '); ?></td>
                                    <td class="text-center max"><?php echo number_format($fee->max, 0, '', ' '); ?></td>
                                    <td class="text-center fee"><?php echo number_format($fee->frais, 0, '', ' '); ?></td>
                                    <td class="text-center"><?php echo dateFormat($fee->date_creation); ?></td>
                                    <td class="text-center"><?php echo dateFormat($fee->date_modification); ?></td>
                                    <td class="text-center ">
                                        <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top"
                                            fee-id="<?php echo $fee->token; ?>" data-original-title="Modifier les informations du tarif">
                                            <a href="<?php echo BASE_URL.DS.'fraisLivraison/modifier/'.$fee->token; ?>">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" 
                                           data-placement="top" fee-id="<?php echo $fee->token; ?>" data-original-title="Supprimer la ligne de tarif">
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
<div class="modal own-modal fade" id="modal-delete-fee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> SUPPRIMER LE TARIF </h4>
      </div>
      <form id="form-delete-fee" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    (*) Champs obligatoires.
                </em><br>
            </div>    
            <div class="card-body ">
                <div id="" class="col-md-12 text-center errorForm"></div>
                <div class="row">                                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="min_amount" class="form-control" id="min_amount" disabled required>
                            <label for="min_amount">Montant Minimum*</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="max_amount" class="form-control" id="max_amount" disabled required>
                            <label for="max_amount">Montant Maximum*</label>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="fee" class="form-control" id="fee"  disabled required>
                            <label for="fee">Montant Frais*</label>
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

