<div id="content">


    <!-- BEGIN TABLE HOVER -->
    <section class="">
        <div class="section-body">


            <div class="row">
                <?php //debug($d); ?>
                <!-- <div class="col-md-12 col-sm-6">
                    <h3 class="stat-part-title">COMMANDES</h3>
                </div> -->
                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-2 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-info no-margin">
                                <div class="col-sm-12 text-center">
                                    <span class="data-title">TOTAL 
                                        <!-- <i data-toggle="tooltip" data-placement="bottom" data-original-title="Ne contient pas les commandes annulées ou rejetées"
                                         class="fa fa-question-circle"></i> -->
                                    </span>
                                </div>
                                <div class="col-sm-9 float-left no-padding">
                                    <strong class="text-lg stat-data-value no-padding total_cmd_montant">
                                       <?php echo number_format($total_cmd['montant'], 0, '', ' '); ?> 
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-3 float-right no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_nbre">
                                        <?php echo  number_format($total_cmd['nbre'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                                
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->


                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-2 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-success no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">livrées</span>
                                </div>
                                <div class="col-sm-9 float-left no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_livrees_montant">
                                        <?php echo  number_format($total_cmd_livrees['montant'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-3 float-right no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_livrees_nbre">
                                        <?php echo  number_format($total_cmd_livrees['nbre'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                                
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-2 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-warning no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">en attente</span>
                                </div>
                                <div class="col-sm-9 float-left no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_pending_montant">
                                        <?php echo  number_format($total_cmd_pending['montant'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-3 float-right no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_pending_nbre">
                                        <?php echo  number_format($total_cmd_pending['nbre'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                                
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-2 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-pending no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">En livraison</span>
                                </div>
                                <div class="col-sm-9 float-left no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_on_road_montant">
                                        <?php echo  number_format($total_cmd_on_road['montant'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-3 float-right no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_on_road_nbre">
                                        <?php echo  number_format($total_cmd_on_road['nbre'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                                
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

                <div class="col-md-2 ">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-danger no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">REJETEES</span>
                                </div>
                                <div class="col-sm-9 float-left no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_rejected_montant">
                                        <?php echo  number_format($total_cmd_rejected['montant'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-3 float-right no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_rejected_nbre">
                                        <?php echo  number_format($total_cmd_rejected['nbre'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                                
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

                <div class="col-md-2 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-danger no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">ANNULEES</span>
                                </div>
                                <div class="col-sm-9 float-left no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_cancelled_montant">
                                        <?php echo  number_format($total_cmd_cancelled['montant'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-3 float-right no-padding">
                                    <strong class="text-lg stat-data-value total_cmd_cancelled_nbre">
                                        <?php echo  number_format($total_cmd_cancelled['nbre'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                                
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->
               
            </div>


            <form class="form cmd_search_form with_date">
                <em class="text-caption">Ce formulaire permet de filtrer la liste des commandes et les statistiques.
                        Il faut renseigner au moins un champs avant de valider. 
                </em>
                <div class="card">
                    <div class="card-head card-head-xs style-primary">
                        <header>
                            <!-- Formulaire de recherche -->
                            <h2 class="text-default-bright">Formulaire de recherche</h2>
                        </header>

                        <div class="tools">
                            <a class="btn btn-icon-toggle btn-collapse"><i class="fa fa-angle-down"></i></a>
                            <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                            data-original-title="Annuler le filtre" href="<?php echo BASE_URL.DS.'commandes/liste'; ?>">
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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="tel_user" class="form-control" id="client_tel">
                                    <label for="client_tel">Téléphone Du Client</label>
                                </div>
                            </div> 
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="client_id" class="form-control" id="client_id">
                                    <label for="client_id">Identifiant du Client</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="cmd_amount" class="form-control" id="montant_cmd">
                                    <label for="montant_cmd">Montant</label>
                                </div>
                            </div> 
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="cmd_id" class="form-control" id="cmd_id">
                                    <label for="cmd_id">Identifiant De Commande</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <select id="select2" name="status" class="form-control dirty selectpicker" data-live-search="true">
                                        <option value="" >&nbsp;</option>
                                        <option value="0">EN ATTENTE</option>
                                        <option value="3">EN COURS DE LIVRAISON</option>
                                        <option value="1">LIVREE</option>
                                        <option value="2">ANNULEE</option>                                                
                                        <option value="4">REJETEE</option>
                                    </select>
                                    <label for="select2">Statut</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="number_page_running" value="<?php echo $numero_page_encours; ?>">

                    </div><!--end .card-body -->
                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <!-- <button id="cmd_search_form_btn" 
                                type="submit" class="btn btn-flat btn-primary ink-reaction">FILTRER
                                <div class="ld ld-ring ld-spin"></div>
                            </button> -->
                            <button id="cmd_search_form_btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                                    FILTRER
                                    <div class="ld ld-ring ld-spin"></div>
                            </button>
                        </div>
                    </div>
                </div><!--end .card -->
                <!-- <em class="text-caption">Ce formulaire permet de filtrer la liste des commandes.
                Il faut renseigner au moins un champs avant de valider. </em> -->
            </form> 
                


            <div class="card">
                <div class="card-head card-head-xs style-primary list-element">
                    <header>
                        <h2 class="text-default-bright">Liste des commandes</h2>
                        <!-- <p>
                            Add <code>.table-hover</code> to enable a hover state on table rows within a <code>&lt;tbody&gt;</code>.
                        </p> -->
                    </header>
                    <div class="tools">
                        <a id="extract-excel-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
                        href="<?php echo SITE_BASE_URL.'commandes/extraction/start_date&'.$order_first->date_first.'/start_hour&00:00:00/end_date&'.date("Y-m-d").'/end_hour&23:59:59/tel_user&/client_id&/cmd_amount&/cmd_id&/status&'; ?>" 
                        target="_blank" data-original-title="Extraire le tableau vers Excel">
                            <i class="fa fa-file-excel-o"></i></a>
                    </div>
                </div><!--end .card-head -->
                <div class="card-body">
                  <div class="table-responsive">

                      <table id="order-list" class="table table-hover " 
                        filter-data-startDate="" filter-data-startHour=""
                        filter-data-endDate="" filter-data-endHour=""
                        filter-data-telUser="" filter-data-clientId=""
                        filter-data-cmdAmount="" filter-data-cmdId=""
                        filter-data-status=""
                        filter-data-pageRunning="<?php echo $numero_page_encours; ?>" 
                        >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>ID Client</th>
                                    <th>Montant HT</th>
                                    <th>Frais Livr.</th>
                                    <th>Montant TTC</th>
                                    <th>ID Commande</th>
                                    <th>Statut</th>
                                    <th class="">Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nbre_cmd_plus = $total_cmd['nbre']; ?>
                                <?php if( !empty( $commandes ) ): ?>
                                <?php foreach ( $commandes as $commande ): ?>
                                    <tr class="<?php echo $commande->cmd_id; ?>">
                                        <td class=""><?php echo $nbre_cmd_plus--; ?></td>
                                        <td class=""><?php echo ucfirst( htmlspecialchars($commande->client_nom) ).' '.ucfirst( explode( ' ',htmlspecialchars($commande->client_prenoms) )[0] ); ?> </td>
                                        <td class=""><?php echo $commande->client_id ?></td>
                                        <td data-list-montant-ht="<?php echo $commande->montant_ht ?>" class="montant_ht"><?php echo number_format($commande->montant_ht, 0, '', ' '); ?></td>
                                        <td data-list-frais-livraison="<?php echo $commande->frais_livraison ?>" class="frais_livraison"><?php echo number_format($commande->frais_livraison, 0, '', ' '); ?></td>
                                        <td data-list-montant-ttc="<?php echo $commande->montant_total ?>" class="montant_ttc"><?php echo number_format($commande->montant_total, 0, '', ' '); ?></td>
                                        <td class="cmd_id"><?php echo $commande->cmd_id; ?></td>
                                        <td class="">
                                            <span class="cmd-status badge style-<?php echo status_displayed($commande->cmd_statut)['color'] ?>">
                                                <?php echo status_displayed($commande->cmd_statut)['libele'] ?>
                                            </span>
                                        </td>
                                        <td><?php echo dateFormat($commande->cmd_date_creation); ?></td>
                                        <td class="text-right">
                                            <?php if( $commande->cmd_statut == 0 ): ?>
                                                <!-- <button type="button" class="btn btn-icon-toggle set-shipping-btn" data-toggle="tooltip" 
                                                    data-placement="top" data-original-title="Livrer" cmd-id="<?php echo $commande->cmd_id; ?>">
                                                    <i class="md md-local-shipping"></i>
                                                </button> -->
                                                <button type="button" class="btn btn-icon-toggle set-rejected-btn" data-toggle="tooltip" 
                                                    data-placement="top" data-original-title="Rejetter la commande" cmd-id="<?php echo $commande->cmd_id; ?>">
                                                    <i class="fa fa-times-circle-o"></i>
                                                </button>
                                            <?php endif; ?>
                                            <?php if( $commande->cmd_statut == 1 ): ?>
                                                <!-- <button type="button" class="btn btn-icon-toggle set-shipping-btn" data-toggle="tooltip" 
                                                    data-placement="top" data-original-title="Reprendre la livraison" cmd-id="<?php echo $commande->cmd_id; ?>">
                                                    <i class="md md-local-shipping"></i>
                                                </button> -->
                                            <?php endif; ?>
                                            <?php if( $commande->cmd_statut == 3 ): ?>
                                                <!-- <button type="button" class="btn btn-icon-toggle set-confirm-shipping-btn" data-toggle="tooltip" cmd-id="<?php echo $commande->cmd_id; ?>"
                                                    data-placement="top" data-original-title="Confirmer la livraison">
                                                    <i class="md md-check-box"></i>
                                                </button> -->
                                                <!-- <button type="button" class="btn btn-icon-toggle set-stop-shipping-btn" data-toggle="tooltip" cmd-id="<?php echo $commande->cmd_id; ?>"
                                                    data-placement="top" data-original-title="Arrêter la livraison">
                                                    <i class="fa fa-pause"></i>
                                                </button> -->
                                            <?php endif; ?>
                                            <?php if( $commande->cmd_statut == 4 ): ?>
                                                <button type="button" class="btn btn-icon-toggle set-restore-btn" data-toggle="tooltip" cmd-id="<?php echo $commande->cmd_id; ?>"
                                                    data-placement="top" data-original-title="Restaurer la commande">
                                                    <i class="md md-settings-backup-restore"></i>
                                                </button>
                                            <?php endif; ?>

                                            <button type="button" class="btn btn-icon-toggle check-details-btn" data-toggle="tooltip" cmd-id="<?php echo $commande->cmd_id; ?>"
                                                data-placement="top" data-original-title="Détails de la commandes">
                                                <a href="<?php echo BASE_URL.DS.'commandes/details/'.$commande->cmd_id; ?>">
                                                    <i class="md md-description"></i>
                                                </a>
                                            </button>
                                            <button type="button" class="btn btn-icon-toggle delete-order-btn" data-toggle="tooltip" cmd-id="<?php echo $commande->cmd_id; ?>"
                                                 data-placement="left" data-original-title="Supprimer la commandes">
                                                 <i class="fa fa-trash-o"></i>
                                             </button>
                                        </td>
                                    </tr>                                                   
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                      </table>
                      <div class="col-sm-12 text-center">
                            <ul id="list-cmd-pagination" class="pagination ">
                                <li class="page-item <?php echo ( $numero_page_encours == 1) ? 'disabled' : '' ?>">
                                  <a class="page-link" href="<?php echo ( $numero_page_encours > 1) ? $numero_page_encours - 1 : '' ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                </li>
                                <?php for( $i=1; $i <= $nombre_pages; $i++ ){ ?>
                                    <li class="page-item <?php echo page_active($i, $numero_page_encours); ?>">
                                        <a class="page-link" href="<?php echo ( $numero_page_encours == $i) ? '' : $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>

                                <li class="page-item <?php echo ( $numero_page_encours == $nombre_pages) ? 'disabled' : '' ?>">
                                  <a class="page-link" href="<?php echo ( $numero_page_encours == $nombre_pages) ? '' : $numero_page_encours + 1 ?>" aria-label="Next">
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




<!-- START MODAL DELIVRERY -->

<div class="modal own-modal fade" id="modal-set-shipping" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> ATTRIBUER UN LIVREUR A LA COMMANDE </h4>
      </div>
      <form id="form-set-shipping" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div class="card-body ">
                                <!-- floating-label -->
                <div id="" class="col-md-12 text-center errorForm"></div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_montant_ht" class="form-control" disabled>
                            <label for="cmd_montant_ht"> Montant HT </label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_frais_livraison" class="form-control"  disabled>
                            <label for="client_id"> Frais Livraison</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_montant_ttc" class="form-control" disabled value="">
                            <label for="cmd_montant_ttc">Montant TTC</label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_id" class="form-control" disabled>
                            <input type="hidden" name="cmd_id" class="form-control" >
                            <label for="cmd_id">Identifiant De Commande</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group ">
                            <select id="select3" name="livreur" class="form-control dirty selectpicker" data-live-search="true">
                                <option value="" >&nbsp;</option>
                                <?php foreach ( $livreurs as $livreur ): ?>
                                    <option value="<?php echo  $livreur->id ?>">
                                        <?php echo strtoupper( $livreur->nom ).' ('.ucfirst( explode( ' ',$livreur->prenoms )[0] ).')'; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <label for="select3">Choisir Le Livreur</label>
                        </div>
                    </div>
                </div>
                <!-- <input type="hidden" name="cmd_id" value=""> -->

            </div>


        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="modal-set-shipping-confirm-btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                        CONFIRMER
                        <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
      </div>
      </form>

    </div>
  </div>
</div>

<!-- END MODAL DELIVRERY -->

<!-- START MODAL STOP DELIVRERY -->
<div class="modal own-modal fade" id="modal-set-stop-shipping" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> STOPPER LA LIVRAISON DE LA COMANDE </h4>
      </div>
      <form id="form-set-stop-shipping" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div class="card-body ">
                                <!-- floating-label -->
                <div id="" class="col-md-12 text-center errorForm"></div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_montant_ht" class="form-control"  disabled>
                            <label for="cmd_montant_ht"> Montant HT </label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_frais_livraison" class="form-control"  disabled>
                            <label for="client_id"> Frais Livraison</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_montant_ttc" class="form-control"  disabled value="">
                            <label for="cmd_montant_ttc">Montant TTC</label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_id" class="form-control" disabled>
                            <input type="hidden" name="cmd_id" class="form-control" >
                            <label for="cmd_id">Identifiant De Commande</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group ">
                            <input type="text" name="livreur_displayed" class="form-control" disabled>
                            <input type="hidden" name="livreur" class="form-control" >
                            <label for="cmd_id">Livreur</label>
                        </div>
                    </div>
                </div>
                <!-- <input type="hidden" name="cmd_id" value=""> -->

            </div>


        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="modal-set-stop-shipping-confirm-btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                        CONFIRMER
                        <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
      </div>
      </form>

    </div>
  </div>
</div>
<!-- END MODAL STOP DELIVRERY -->


<!-- START MODAL DELETE ORDER -->
<div class="modal own-modal fade" id="modal-delete-order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> SUPPRIMER LA COMMANDE </h4>
      </div>
      <form id="form-delete-order" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    Une fois supprimée, la commande n'apparaitra plus dans le back office et dans l'espace du client. Elle sera supprimée de la base de donnée.
                    Plus aucune action ne pourra être effectuée sur cette commande.
                </em><br>
            </div>
            
            <div class="card-body ">
                <!-- <em class="text-caption">Ce formulaire permet de filtrer la liste des commandes et les statistiques.
                        Il faut renseigner au moins un champs avant de valider. </em> -->
                                <!-- floating-label -->
                <div id="" class="col-md-12 text-center errorForm"></div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_montant_ht" class="form-control"  disabled>
                            <label for="cmd_montant_ht"> Montant HT </label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_frais_livraison" class="form-control"  disabled>
                            <label for="cmd_frais_livraison"> Frais Livraison</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_montant_ttc" class="form-control"  disabled value="">
                            <label for="cmd_montant_ttc">Montant TTC</label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_id" class="form-control" disabled>
                            <input type="hidden" name="cmd_id" class="form-control" >
                            <label for="cmd_id">Identifiant De Commande</label>
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
                <!-- <input type="hidden" name="cmd_id" value=""> -->

            </div>


        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="modal-delete-order-confirm-btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
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


<!-- START MODAL REJECT ORDER -->
<div class="modal own-modal fade" id="modal-reject-order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> REJETTER LA COMMANDE </h4>
      </div>
      <form id="form-reject-order" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <!-- <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    Une fois supprimée, la commande n'apparaitra plus dans le back office et dans l'espace du client. Elle sera supprimée de la base de donnée.
                    Plus aucune action ne pourra être effectuée sur cette commande.
                </em><br>
            </div> -->
            
            <div class="card-body ">
                <!-- <em class="text-caption">Ce formulaire permet de filtrer la liste des commandes et les statistiques.
                        Il faut renseigner au moins un champs avant de valider. </em> -->
                                <!-- floating-label -->
                <div id="" class="col-md-12 text-center errorForm"></div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_montant_ht" class="form-control"  disabled>
                            <label for="cmd_montant_ht"> Montant HT </label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_frais_livraison" class="form-control"  disabled>
                            <label for="cmd_frais_livraison"> Frais Livraison</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_montant_ttc" class="form-control"  disabled value="">
                            <label for="cmd_montant_ttc">Montant TTC</label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="cmd_id" class="form-control" disabled>
                            <input type="hidden" name="cmd_id" class="form-control" >
                            <label for="cmd_id">Identifiant De Commande</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group ">
                            <textarea name="rejected_message" id="textarea1" class="form-control" rows="3" placeholder=""></textarea>
                            <label for="rejected_message">MOTIF DE REJET</label>
                        </div>
                    </div>
                </div>
                <!-- <input type="hidden" name="cmd_id" value=""> -->
            </div>
        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="modal-reject-order-confirm-btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                        CONFIRMER
                        <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- END MODAL REJECT ORDER -->





</div>

