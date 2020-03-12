<div id="content">
    <!-- BEGIN TABLE HOVER -->
    <span id="linkToDeleteElement" class="hidden">ajax/DeleteAvis.php</span>
    <span id="linkToGetElement" class="hidden">ajax/SearchAvis.php</span>
    <span id="linkSetHomeElement" class="hidden">ajax/UpdateSetHomeAvis.php</span>
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'avis/liste'; ?>">AVIS</a></li>
                <li class="active">Liste/</li>
            </ol>
        </div>

        <div class="section-body">
            <div class="row">
                <?php //debug($d); ?>
                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-4 col-sm-3">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-info no-margin">
                                <div class="col-sm-12 text-center">
                                    <span class="data-title">TOTAL 
                                    </span>
                                </div>
                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding total_element total">
                                       <?php echo number_format($elements['total']['nbre'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->


                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-4 col-sm-3">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-success no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">REPONDUS</span>
                                </div>

                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding actifs">
                                       <?php echo number_format($elements['actifs'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>

                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-4 col-sm-3">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-warning no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">EN ATTENTE </span>
                                </div>
                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding non_actifs">
                                       <?php echo number_format($elements['non_actifs'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

               
            </div>


            <form class="form avis_search_form with_date">
                <em class="text-caption"> Ce formulaire permet de filtrer la liste des elements. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <!-- Formulaire de recherche -->
                                    <h2 class="text-default-bright">Formulaire de recherche</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Annuler le filtre" href="<?php echo SITE_BASE_URL.'avis/liste'; ?>">
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
                                            <input type="text" name="filter_content" class="form-control" id="name_product">
                                            <label for="filter_content">Contenu</label>
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="form-group ">
                                            <select id="filter_status" name="filter_status" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0">EN ATTENTE</option>
                                                <option value="1">REPONDU</option>
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
                        <h2 class="text-default-bright">Liste des Avis</h2>
                        <!-- <p>
                            Add <code>.table-hover</code> to enable a hover state on table rows within a <code>&lt;tbody&gt;</code>.
                        </p> -->
                    </header>
                    <div class="tools">
                        <!-- <a id="extract-excel-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
    href="<?php echo SITE_BASE_URL.'pubs/extraction/start_date&2018-01-01/start_hour&00:00:00/end_date&'.date("Y-m-d").'/end_hour&23:59:59/name_cotegory&/status_cotegory&'; ?>" 
                        target="_blank" data-original-title="Extraire le tableau vers Excel">
                            <i class="fa fa-file-excel-o"></i>
                        </a> -->
                    </div>
                </div><!--end .card-head -->
                <div class="card-body">
                  <div class="table-responsive">

                      <table id="avis-list" class="table table-hover" 
                        filter-data-startDate="" filter-data-startHour=""
                        filter-data-endDate="" filter-data-endHour=""
                        filter-data-content="" filter-data-filterStatus=""
                        filter-data-pageRunning="<?php echo $numero_page_encours; ?>" 
                        >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Client?</th>
                                    <th class="text-center">Nom</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Produit</th>
                                    <th class="text-center">Contenu</th>
                                    <th class="text-center">Page D'accueil ?</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-center">Date Création</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $nbre_cmd_plus = $elements['total']['nbre']; ?>
                                <?php if( !empty( $elements['liste'] ) ): ?>
                                <?php foreach ( $elements['liste'] as $element ): ?>
                                <tr class="text-center <?php echo $element->token; ?>">
                                    <td><?php echo $nbre_cmd_plus--; ?></td>
                                    <td class="isClient" ><?php echo ($element->id_c == 0) ? 'NON' : 'OUI' ; ?></td>
                                    <?php $nom = ($element->id_c == 0) ? htmlspecialchars($element->nom_avis).' '.htmlspecialchars($element->prenoms_avis) : htmlspecialchars($element->nom_client).' '.htmlspecialchars($element->prenoms_client); ?>
                                    <td class="Nom" ><?php echo ucfirst(htmlspecialchars($nom)); ?></td>
                                    <?php $email = ($element->id_c == 0) ? htmlspecialchars($element->email_avis) : htmlspecialchars($element->email_client); ?>
                                    <td class="Email" ><?php echo htmlspecialchars($email); ?></td>
                                    <td class="Produit" ><?php echo $element->produit; ?></td>
                                    <td class="contenu" >
                                        <?php echo substr($element->contenu, 60) ; echo strlen(htmlspecialchars($element->contenu)) > 60 ? '...' : htmlspecialchars($element->contenu) ;?>
                                    </td>
                                    <td class="isHome" ><?php echo ($element->page_accueil == 0) ? 'NON' : 'OUI' ; ?></td>
                                    <td class="status">
                                         <?php echo ($element->statut == 0) ? 'EN ATTENTE' : 'REPONDU' ; ?>
                                     </td>
                                    <td class="date_debut"><?php echo dateFormat($element->date_creation); ?></td>
                                    <td class="">
                                        <?php if( empty($element->reponse_admin_contenu) ){?>
                                        <button type="button" class="btn btn-icon-toggle response-btn" data-toggle="tooltip" data-placement="top" 
                                            element-id="<?php echo $element->token; ?>" data-original-title="Repondre au commentaire">
                                            <a href="<?php echo BASE_URL.DS.'avis/repondre/'.$element->token; ?>">
                                                    <i class="md md-insert-comment"></i>
                                            </a>
                                        </button>
                                        <?php }else{ ?>
                                            <button type="button" class="btn btn-icon-toggle update-response-btn " data-toggle="tooltip" data-placement="top" 
                                                element-id="<?php echo $element->token; ?>" data-original-title="Modifier la reponse au commentaire">
                                                <a href="<?php echo BASE_URL.DS.'avis/modifier/'.$element->token; ?>">
                                                        <i class="fa fa-pencil"></i>
                                                </a>
                                            </button>
                                        <?php } ?>
                                        <?php if( $element->page_accueil == 0 ){?>
                                        <button type="button" class="btn btn-icon-toggle set-home-btn" data-toggle="tooltip" data-placement="top" 
                                            element-id="<?php echo $element->token; ?>" data-original-title="Afficher sur la page d'acceuil"
                                            page-acceuil-value="<?php echo $element->page_accueil; ?>">
                                                    <i class="md md-home"></i>
                                        </button>
                                        <?php }else{ ?>
                                            <button type="button" class="btn btn-icon-toggle set-home-btn" data-toggle="tooltip" data-placement="top" 
                                                element-id="<?php echo $element->token; ?>" data-original-title="Rétirer de la page d'acceuil"
                                                page-acceuil-value="<?php echo $element->page_accueil; ?>">
                                                        <i class="md md-check-box-outline-blank"></i>
                                            </button>
                                        <?php } ?>
                                        <button type="button" class="btn btn-icon-toggle detail-element-btn " data-toggle="tooltip" data-placement="top"
                                                category-id="<?php echo $element->token; ?>" data-original-title="Voir les détails du commentaire">
                                            <a href="<?php echo BASE_URL.DS.'avis/details/'.$element->token; ?>">
                                                    <i class="md md-description"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" 
                                                element-id="<?php echo $element->token; ?>" data-original-title="Supprimer l'element">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>
                      </table>

                      <div class="col-sm-12 text-center">
                            <ul id="list-avis-pagination" class="pagination ">
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
<div class="modal own-modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> SUPPRIMER LE COMMENTAIRE </h4>
      </div>
      <form id="form-delete" class="form">
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
                            <input type="text" name="nom" class="form-control"  disabled>
                            <label for="nom"> Nom Utilisateur </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="produit" class="form-control"  disabled>
                            <label for="produit"> Produit </label>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <!-- <input type="text" name="element_name" class="form-control"  disabled>
                            <label for="element_name"> Nom de la Compagnie </label> -->
                            <h5 class="form-delete-paraph-title">Message</h5>
                            <p class="contenu-comments-form">
                                
                            </p>
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
                <button id="modal-delete-element-confirm-btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
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

