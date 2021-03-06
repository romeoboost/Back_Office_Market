<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <span id="linkToGetElement" class="hidden">ajax/SearchDelivrer.php</span>
    <span id="linkToDeleteElement" class="hidden">ajax/DeleteDelivrer.php</span>
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'livreurs/liste'; ?>">Livreurs</a></li>
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
                                    <strong class="text-xl stat-data-value no-padding total">
                                       <?php echo number_format($livreurs['total']['nbre'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

               
            </div>


            <form class="form livreurs_search_form with_date">
                <em class="text-caption"> Ce formulaire permet de filtrer la liste des catégories de livreurs. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <!-- Formulaire de recherche -->
                                    <h2 class="text-default-bright">Formulaire de recherche</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Annuler le filtre" href="<?php echo SITE_BASE_URL.'livreurs/liste'; ?>">
                                        <i class="md md-settings-backup-restore"></i></a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <!-- floating-label -->
                                <div id="errorForm" class="col-md-12 text-center"></div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group " id="">
                                            <div class="input-group date" id="StartDate">
                                                <div class="input-group-content">
                                                    <input type="text" name="start_date" class="form-control" id="StartDateInput">
                                                    <label>Date Début</label>
                                                </div>
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group ">
                                            <div class="input-group date" id="StartHour">
                                                <div class="input-group-content">
                                                    <input type="text" name="start_hour" class="form-control" id="StartHourInput">
                                                    <label>Heure Début</label>
                                                </div>
                                                <span class="input-group-addon"><i class="md md-access-time"></i></span>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="input-group date" id="EndDate">
                                                <div class="input-group-content">
                                                    <input type="text" name="end_date" class="form-control" id="EndDateInput">
                                                    <label>Date Fin</label>
                                                </div>
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <!-- <input type="text" class="form-control" id="Lastname2">
                                            <label for="Lastname2">Date Fin</label> -->
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="input-group date" id="EndHour">
                                                <div class="input-group-content">
                                                    <input type="text" name="end_hour" class="form-control" id="EndHourInput">
                                                    <label>Heure Fin</label>
                                                </div>
                                                <span class="input-group-addon"><i class="md md-access-time"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="name_delivrer" class="form-control" id="name_delivrer">
                                            <label for="name_delivrer">Nom du livreur</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="tel" class="form-control" id="tel">
                                            <label for="tel">Téléphone</label>
                                        </div>
                                    </div>                                     
                                </div>

                                <input type="hidden" name="number_page_running" value="<?php echo $numero_page_encours; ?>">

                            </div><!--end .card-body -->
                            <div class="card-actionbar">
                                <div class="card-actionbar-row">
                                    <button id="confirm_filter" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                                            FILTRER
                                            <div class="ld ld-ring ld-spin"></div>
                                    </button>
                                </div>
                            </div>
                        </div><!--end .card -->
                        
                    </form> 
                


            <div class="card">
                <div class="card-head card-head-xs style-primary list-element">
                    <header>
                        <h2 class="text-default-bright">Liste des Livreurs</h2>
                        <!-- <p>
                            Add <code>.table-hover</code> to enable a hover state on table rows within a <code>&lt;tbody&gt;</code>.
                        </p> -->
                    </header>
                    <div class="tools">
                        <a id="add-element-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
                            href="<?php echo SITE_BASE_URL.'livreurs/ajouter'; ?>" 
                             data-original-title="Ajouter une nouveau livreurs">
                            <i class="fa fa-plus-square"></i>
                        </a>

                        <a id="extract-excel-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
    href="<?php echo SITE_BASE_URL.'livreurs/extraction/start_date&2018-01-01/start_hour&00:00:00/end_date&'.date("Y-m-d").'/end_hour&23:59:59/name_delivrer&/tel&'; ?>" 
                        target="_blank" data-original-title="Extraire le tableau vers Excel">
                            <i class="fa fa-file-excel-o"></i>
                        </a>
                    </div>
                </div><!--end .card-head -->
                <div class="card-body">
                  <div class="table-responsive">

                      <table id="livreurs-list" class="table table-hover" 
                        filter-data-startDate="" filter-data-startHour=""
                        filter-data-endDate="" filter-data-endHour=""
                        filter-data-nameDelivrer="" filter-data-tel=""
                        filter-data-pageRunning="<?php echo $numero_page_encours; ?>" 
                        >
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">ID Livreur</th>
                                    <th class="text-center">Nom</th>
                                    <th class="text-center">Téléphone</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Date création</th>
                                    <th class="text-center">Date Mondification</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $nbre_cmd_plus = $livreurs['total']['nbre']; ?>
                                <?php if( !empty( $livreurs['liste'] ) ): ?>
                                <?php foreach ( $livreurs['liste'] as $livreur ): ?>
                                <tr class="text-center <?php echo $livreur->token; ?>">
                                    <td><?php echo $nbre_cmd_plus--; ?></td>
                                    <td class="token" ><?php echo $livreur->token; ?> </td>
                                    <td class="name_delivrer" ><?php echo ucfirst( $livreur->nom ).' '.ucfirst( $livreur->prenoms ); ?></td>
                                    <td> <?php echo $livreur->tel; ?> </td>
                                    <td> <?php echo $livreur->email; ?> </td>
                                    <td><?php echo dateFormat($livreur->date_creation); ?></td>
                                    <td><?php echo dateFormat($livreur->date_modification); ?></td>
                                    <td class="">
                                        <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" livreurs-id="<?php echo $livreur->token; ?>"
                                         data-original-title="Modifier les informations du livreur">
                                            <a href="<?php echo BASE_URL.DS.'livreurs/modifier/'.$livreur->token; ?>">
                                                    <i class="fa fa-pencil"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" livreurs-id="<?php echo $livreur->token; ?>"
                                         data-original-title="Voir les détails du livreur">
                                            <a href="<?php echo BASE_URL.DS.'livreurs/details/'.$livreur->token; ?>">
                                                    <i class="md md-description"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" livreurs-id="<?php echo $livreur->token; ?>"
                                         data-original-title="Supprimer le livreur"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>
                      </table>

                      <div class="col-sm-12 text-center">
                            <ul id="list-livreurs-pagination" class="pagination ">
                                <li class="page-item <?php echo ( $numero_page_encours == 1) ? 'disabled' : '' ?>">
                                  <a class="page-link" href="<?php echo ( $numero_page_encours > 1) ? $numero_page_encours - 1 : '' ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                </li>
                                <?php for( $i=1; $i <= $nombre_pages; $i++ ){ ?>
                                    <li class="page-item <?php echo page_active($i, $numero_page_encours); ?>">
                                        <a class="page-link" href="<?php echo ( $numero_page_encours == $i) ? '' : $i; ?>" >
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <li class="page-item <?php echo ( $numero_page_encours == $nombre_pages) ? 'disabled' : '' ?>">
                                  <a class="page-link" href="<?php echo ( $numero_page_encours == $nombre_pages) ? '' : $numero_page_encours + 1 ?>" 
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                  </a>
                                </li>
                           </ul>
                      </div>
                          
                  </div>
                </div><!--end .card-body <span class="sr-only">(current)</span> -->  
            </div>
        </div><!--end .section-body -->

    </section>
    <!-- END TABLE HOVER -->




<!-- START MODAL DELETE ORDER -->
<div class="modal own-modal fade" id="modal-delete-livreurs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> SUPPRIMER LE LIVREUR </h4>
      </div>
      <form id="form-delete-livreurs" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    (*) Champs obligatoires. On ne peut supprimer les livreurs déjà liés à une ligne de stock.
                </em><br>
            </div>    
            <div class="card-body ">
                <div id="" class="col-md-12 text-center errorForm"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="text" name="name_delivrer" class="form-control"  disabled>
                            <label for="name_delivrer"> Nom du Livreur </label>
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

