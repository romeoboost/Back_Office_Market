<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <span id="linkToDeleteElement" class="hidden">ajax/DeleteCity.php</span>
    <span id="linkToGetElement" class="hidden">ajax/SearchCity.php</span>
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'communesLivraison/liste'; ?>">Commune de Livraison</a></li>
                <li class="active">Liste/</li>
            </ol>
        </div>

        <div class="section-body">


            <div class="row">
                <?php //debug($d); ?>
                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-3 col-sm-3">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-info no-margin">
                                <div class="col-sm-12 text-center">
                                    <span class="data-title">TOTAL 
                                    </span>
                                </div>
                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding total_commune">
                                       <?php echo number_format($communes['total'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->


                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-3 col-sm-3">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-success no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">ACTIFS</span>
                                </div>

                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding actifs">
                                       <?php echo number_format($communes['actifs'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>

                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-3 col-sm-3">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-warning no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">NON ACTIFS </span>
                                </div>
                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding non_actifs">
                                       <?php echo number_format($communes['non_actifs'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-3 col-sm-3">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-warning no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">JAMAIS EU DE LIVRAISON </span>
                                </div>
                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding no_order">
                                       <?php echo number_format($communes['no_order'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

               
            </div>


            <form class="form commune_search_form with_date">
                <em class="text-caption"> Ce formulaire permet de filtrer la liste des communes. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <!-- Formulaire de recherche -->
                                    <h2 class="text-default-bright">Formulaire de recherche</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Annuler le filtre" href="<?php echo SITE_BASE_URL.'communesLivraison/liste'; ?>">
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
                                            <!-- <input type="text" class="form-control" id="Lastname2">
                                            <label for="Lastname2">Date Fin</label> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="filter_name" class="form-control" id="name_product">
                                            <label for="filter_name">Nom de la commune</label>
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="form-group ">
                                            <select id="filter_status" name="filter_status" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0">NON ACTIF</option>
                                                <option value="1">ACTIF</option>
                                            </select>
                                            <label for="filter_status">Statut</label>
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
                        <h2 class="text-default-bright">Liste des Communes</h2>
                        <!-- <p>
                            Add <code>.table-hover</code> to enable a hover state on table rows within a <code>&lt;tbody&gt;</code>.
                        </p> -->
                    </header>
                    <div class="tools">
                        <a id=" add-product-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
                            href="<?php echo SITE_BASE_URL.'communesLivraison/ajouter'; ?>" 
                             data-original-title="Ajouter une nouvelle communes">
                            <i class="fa fa-plus-square"></i>
                        </a>
                        <a id="extract-excel-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
    href="<?php echo SITE_BASE_URL.'communesLivraison/extraction/start_date&2018-01-01/start_hour&00:00:00/end_date&'.date("Y-m-d").'/end_hour&23:59:59/name_cotegory&/status_cotegory&'; ?>" 
                        target="_blank" data-original-title="Extraire le tableau vers Excel">
                            <i class="fa fa-file-excel-o"></i>
                        </a>
                    </div>
                </div><!--end .card-head -->
                <div class="card-body">
                  <div class="table-responsive">

                      <table id="commune-list" class="table table-hover" 
                        filter-data-startDate="" filter-data-startHour=""
                        filter-data-endDate="" filter-data-endHour=""
                        filter-data-filterName="" filter-data-filterStatus=""
                        filter-data-pageRunning="<?php echo $numero_page_encours; ?>" 
                        >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Nom</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-center">Nombre Commandes</th>
                                    <th class="text-center">Longitude</th>
                                    <th class="text-center">Lagitude</th>
                                    <th class="text-center">Date création</th>
                                    <th class="text-center">Date Modification</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $nbre_cmd_plus = $communes['total']; ?>
                                <?php if( !empty( $communes['liste'] ) ): ?>
                                <?php foreach ( $communes['liste'] as $commune ): ?>
                                <tr class="text-center <?php echo $commune->token; ?>">
                                    <td><?php echo $nbre_cmd_plus--; ?></td>
                                    <td class="element_name" ><?php echo ucfirst( $commune->commune ); ?></td>
                                    <td><?php echo ($commune->statut == 1) ? 'ACTIF' : 'NON ACTIF'; ?></td>
                                    <td><?php echo number_format($communes['liste_order'][$commune->id], 0, '', ' '); ?></td>
                                    <td><?php echo $commune->longitude; ?></td>
                                    <td><?php echo $commune->lagitude; ?></td>
                                    <td><?php echo dateFormat($commune->date_creation); ?></td>
                                    <td><?php echo dateFormat($commune->date_modification); ?></td>
                                    <td class="">
                                        <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" commune-id="<?php echo $commune->token; ?>"
                                         data-original-title="Modifier les informations de la commune">
                                            <a href="<?php echo BASE_URL.DS.'communesLivraison/modifier/'.$commune->token; ?>">
                                                    <i class="fa fa-pencil"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" commune-id="<?php echo $commune->token; ?>"
                                         data-original-title="Supprimer la commune"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>
                      </table>

                      <div class="col-sm-12 text-center">
                            <ul id="list-commune-pagination" class="pagination ">
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
<div class="modal own-modal fade" id="modal-delete-commune" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> SUPPRIMER LA CATEGORIE </h4>
      </div>
      <form id="form-delete-commune" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    (*) Champs obligatoires. On ne peut supprimer les catégories déjà liées à un produit.
                </em><br>
            </div>    
            <div class="card-body ">
                <div id="" class="col-md-12 text-center errorForm"></div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="name_commune" class="form-control"  disabled>
                            <label for="name_commune"> Nom de la Catégorie </label>
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
                <input type="hidden" name="commune_id" value="">
            </div>
        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="modal-delete-commune-confirm-btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
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

