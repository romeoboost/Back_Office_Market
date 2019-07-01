<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'stocks/liste'; ?>">Stocks</a></li>
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
                                <div class="col-sm-9 float-left no-padding">
                                    <strong class="text-lg stat-data-value no-padding total_montant">
                                       <?php echo number_format($stocks['total']['montant'], 0, '', ' '); ?> 
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-3 float-right no-padding">
                                    <strong class="text-lg stat-data-value total_nbre">
                                        <?php echo  number_format($stocks['total']['nbre'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->               
            </div>

            <form class="form stocks_search_form with_date">
                <em class="text-caption"> Ce formulaire permet de filtrer la liste des stocks de produits. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <!-- Formulaire de recherche -->
                                    <h2 class="text-default-bright">Formulaire de recherche</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Annuler le filtre" href="<?php echo SITE_BASE_URL.'categories/liste'; ?>">
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
                                            <input type="number" name="montant" class="form-control" id="montant">
                                            <label for="montant">Montant </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="name_product" class="form-control" id="name_product">
                                            <label for="name_product">Nom du produit</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="name_supplier" class="form-control" id="name_supplier">
                                            <label for="name_supplier">Nom du Fornisseur</label>
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
                        <h2 class="text-default-bright">Liste des stocks</h2>
                        <!-- <p>
                            Add <code>.table-hover</code> to enable a hover state on table rows within a <code>&lt;tbody&gt;</code>.
                        </p> -->
                    </header>
                    <div class="tools">
                        <a id=" add-unit-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
                            href="<?php echo SITE_BASE_URL.'stocks/ajouter'; ?>" 
                             data-original-title="Ajouter une unité de mésure">
                            <i class="fa fa-plus-square"></i>
                        </a>
                        <a id="extract-excel-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
    href="<?php echo SITE_BASE_URL.'stocks/extraction/start_date&2018-01-01/start_hour&00:00:00/end_date&'.date("Y-m-d").'/end_hour&23:59:59/montant&/name_product&/name_supplier&'; ?>" 
                        target="_blank" data-original-title="Extraire le tableau vers Excel">
                            <i class="fa fa-file-excel-o"></i>
                        </a>
                    </div>
                </div><!--end .card-head -->
                <div class="card-body">
                  <div class="table-responsive">

                      <table id="stocks-list" class="table table-hover" 
                        filter-data-startDate="" filter-data-startHour="" filter-data-endDate="" filter-data-endHour=""
                        filter-data-montant="" filter-data-nameProduct="" filter-data-nameSupplier="" 
                        filter-data-pageRunning="<?php echo $numero_page_encours; ?>" 
                        >

                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">ID Stock</th>
                                    <th class="text-center">Montant</th>
                                    <th class="text-center">Frais</th>
                                    <th class="text-center">Montant TTC</th>
                                    <th class="text-center">Produit</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-center">Unit. Mésure</th>
                                    <th class="text-center">Fournisseur</th>
                                    <th class="text-center">Date creation</th>
                                    <th class="text-center">Date Modification</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php $nbre_cmd_plus = $stocks['total']['nbre']; ?>
                                <?php if( !empty( $stocks['liste'] ) ): ?>
                                <?php foreach ( $stocks['liste'] as $stock ): ?>
                                <tr class="text-center <?php echo $stock->stock_id; ?>">
                                    <td><?php echo $nbre_cmd_plus--; ?></td>
                                    <td class="token" ><?php echo $stock->stock_id; ?> </td>
                                    <td class="montant_ht" ><?php echo number_format($stock->montant_ht, 0, '', ' '); ?> </td>
                                    <td class="frais_livraison" ><?php echo number_format($stock->frais_livraison, 0, '', ' '); ?> </td>
                                    <td class="montant_total" ><?php echo number_format($stock->montant_total, 0, '', ' '); ?> </td>
                                    <td class="produit" ><?php echo $stock->produit; ?> </td>
                                    <td class="qtte" ><?php echo number_format($stock->qtte, 0, '', ' '); ?> </td>
                                    <td class="unite"><?php echo ucfirst( $unit_mesure[$stock->unite] ); ?></td>
                                    <td class="" ><?php echo ucfirst( $stock->fournisseur_nom ); ?> </td>
                                    <td><?php echo dateFormat($stock->date_creation); ?></td>
                                    <td><?php echo dateFormat($stock->date_modification); ?></td>
                                    <td class="">
                                        <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top"
                                            stock-id="<?php echo $stock->stock_id; ?>" data-original-title="Modifier le stock">
                                            <a href="<?php echo BASE_URL.DS.'stocks/modifier/'.$stock->stock_id; ?>">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" 
                                           data-placement="top" stock-id="<?php echo $stock->stock_id; ?>" data-original-title="Supprimer le stock">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                      </table>

                       <div class="col-sm-12 text-center">
                            <ul id="list-stocks-pagination" class="pagination ">
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
<div class="modal own-modal fade" id="modal-delete-stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> SUPPRIMER LA LIGNE DE STOCK </h4>
      </div>
      <form id="form-delete-stock" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    (*) Champs obligatoires. On ne peut supprimer une ligne de stock dont la quantité est supérieure à la quantité de produits restants.
                </em><br>
            </div>    
            <div class="card-body ">
                <div id="" class="col-md-12 text-center errorForm"></div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="token" class="form-control"  disabled>
                            <label for="name_category"> Identifiant de Stock </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="product_name" class="form-control"  disabled>
                            <label for="product_name"> Nom du produit </label>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="qtte" class="form-control"  disabled>
                            <label for="qtte"> Quantité </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="unite" class="form-control"  disabled>
                            <label for="unite"> Unité de Mésure </label>
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

