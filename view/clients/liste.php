<div id="content">


    <!-- BEGIN TABLE HOVER -->
    <section class="">
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'clients/liste'; ?>">Clients</a></li>
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
                                       <?php echo number_format($clients['total'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->


                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-4 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-success no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">ACTIFS</span>
                                </div>

                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding actifs">
                                       <?php echo number_format($clients['actifs'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>

                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-4 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-warning no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">NON ACTIFS </span>
                                </div>
                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding non_actifs">
                                       <?php echo number_format($clients['non_actifs'], 0, '', ' '); ?>                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

               
            </div>


            <form class="form clients_search_form with_date">
                <em class="text-caption">Ce formulaire permet de filtrer la liste des commandes et les statistiques.
                        Il faut renseigner au moins un champs avant de valider. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <!-- Formulaire de recherche -->
                                    <h2 class="text-default-bright">Formulaire de recherche</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Annuler le filtre" href="<?php echo BASE_URL.DS.'clients/liste'; ?>">
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
                                            <input type="text" name="nom" class="form-control" id="nom">
                                            <label for="nom">Nom</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="prenoms" class="form-control" id="prenoms">
                                            <label for="prenoms">Prenoms</label>
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="client_id" class="form-control" id="client_id">
                                            <label for="client_id">Identifiant</label>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="tel" class="form-control" id="client_tel">
                                            <label for="tel">Téléphone</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="status" name="status" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0">NON ACTIF</option>
                                                <option value="1">ACTIF</option>
                                            </select>
                                            <label for="status">Statut</label>
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="sexe" name="sexe" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0">FEMME</option>
                                                <option value="1">HOMME</option>
                                            </select>
                                            <label for="sexe">Sexe</label>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="number_page_running" value="<?php echo $numero_page_encours; ?>">

                            </div><!--end .card-body -->
                            <div class="card-actionbar">
                                <div class="card-actionbar-row">
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
                        <h2 class="text-default-bright">Liste des Clients</h2>
                        <!-- <p>
                            Add <code>.table-hover</code> to enable a hover state on table rows within a <code>&lt;tbody&gt;</code>.
     // [start_date] => 26-05-2019, [start_hour] => , [end_date] =>, [end_hour] =>, [nom] => Kesso, [prenoms] => Romeo
    // [client_id] => CLI055525MTK, [tel] => 01010101, [status] => 1, [sexe] => 1
                        </p> -->
                    </header>
                    <div class="tools">
                        <a id="extract-excel-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
href="<?php echo SITE_BASE_URL.'clients/extraction/start_date&2018-01-01/start_hour&00:00:00/end_date&'.date("Y-m-d").'/end_hour&23:59:59/
nom&/prenoms&/client_id&/tel&/status&/sexe&'; ?>" 
                        target="_blank" data-original-title="Extraire le tableau vers Excel">
                            <i class="fa fa-file-excel-o"></i></a>
                    </div>
                </div><!--end .card-head -->
                <div class="card-body">
                  <div class="table-responsive">

                      <table id="clients-list" class="table table-hover " 
                        filter-data-startDate="" filter-data-startHour=""
                        filter-data-endDate="" filter-data-endHour=""
                        filter-data-telUser="" filter-data-clientId=""
                        filter-data-name="" filter-data-lastname=""
                        filter-data-status="" filter-data-email="" filter-data-sexe=""
                        filter-data-pageRunning="<?php echo $numero_page_encours; ?>" 
                        >
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th class="text-center">Nom</th>
                                    <th class="text-center">Prenoms</th>
                                    <th class="text-center">ID Client</th>
                                    <th class="text-center">Tel</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Sexe</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-center">Date Creation</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total_plus = $clients['total']; ?>
                                <?php if( !empty( $clients['liste'] ) ): ?>
                                <?php foreach ( $clients['liste'] as $client ): ?>
                                    <tr class="text-center <?php echo $client->token; ?>">
                                        <td class=""><?php echo $total_plus--; ?></td>
                                        <td class="nom"><?php echo ucfirst( htmlspecialchars ($client->nom) ); ?> </td>
                                        <td class="prenom"><?php echo ucfirst( htmlspecialchars ($client->prenoms) ); ?> </td>
                                        <td class="token"><?php echo $client->token ?></td>
                                        <td class=""><?php echo htmlspecialchars ($client->tel) ?></td>
                                        <td class=""><?php echo htmlspecialchars ($client->email) ?></td>
                                        <td  class="sexe"><?php echo ($client->sexe == 1) ? 'HOMME' : 'FEMME'; ?></td>
                                        <td  class="statut"><?php echo ($client->statut == 1) ? 'ACTIF' : 'NON ACTIF'; ?></td>
                                        <td><?php echo dateFormat($client->date_creation); ?></td>
                                        <td class="text-right">
                                            <?php if( $client->statut == 1 ): ?>
                                                <button type="button" class="btn btn-icon-toggle set-rejected-btn" data-toggle="tooltip" 
                                                    data-placement="top" data-original-title="Desactiver le client " clients-id="<?php echo $client->token; ?>">
                                                    <i class="fa fa-times-circle-o"></i>
                                                </button>
                                            <?php endif; ?>
                                            <?php if( $client->statut == 0 ): ?>
                                                <button type="button" class="btn btn-icon-toggle set-restore-btn" data-toggle="tooltip" 
                                                clients-id="<?php echo $client->token; ?>"
                                                    data-placement="top" data-original-title="Reactiver le client">
                                                    <i class="md md-settings-backup-restore"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-icon-toggle check-details-btn" data-toggle="tooltip" 
                                            clients-id="<?php echo $client->token; ?>"
                                                data-placement="top" data-original-title="Détails du client">
                                                <a href="<?php echo BASE_URL.DS.'clients/details/'.$client->token; ?>">
                                                    <i class="md md-description"></i>
                                                </a>
                                            </button>
                                            <button type="button" class="btn btn-icon-toggle delete-btn" data-toggle="tooltip" 
                                            clients-id="<?php echo $client->token; ?>"
                                                 data-placement="left" data-original-title="Supprimer le client">
                                                 <i class="fa fa-trash-o"></i>
                                             </button>
                                        </td>
                                    </tr>                                                   
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                      </table>
                      <div class="col-sm-12 text-center">
                            <ul id="list-clients-pagination" class="pagination ">
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




<!-- START MODAL DELETE CLIENTS -->
<div class="modal own-modal fade" id="modal-delete-clients" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> SUPPRIMER LE CLIENT </h4>
      </div>
      <form id="form-delete-clients" class="form">
      <div class="modal-body clients-confirmation-body">
        <div class="row">
            <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    Une fois supprimé, le client n'apparaitra plus dans le back office. Il sera supprimé de la base de donnée.
                    Plus aucune action ne pourra être effectuée sur ses informations.
                </em><br>
            </div>
            <div class="card-body ">
                <div id="" class="col-md-12 text-center errorForm"></div>
                
                 <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="nom" class="form-control"  disabled>
                            <label for="nom"> Nom </label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="prenom" class="form-control"  disabled>
                            <label for="prenom"> Prenom </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="client_id" class="form-control" disabled>
                            <input type="hidden" name="client_id" class="form-control" >
                            <label for="client_id">Identifiant Du Client</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" >
                            <label for="password">Mot de passe</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="modal-delete-confirm-btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                        CONFIRMER
                        <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
      </div>
      </form>

    </div>
  </div>
</div>
<!-- END MODAL DELETE CLIENTS -->


<!-- START MODAL REJECT CLIENTS -->
<div class="modal own-modal fade" id="modal-reject-clients" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> DESACTIVER LE CLIENT </h4>
      </div>
      <form id="form-reject-clients" class="form">
      <div class="modal-body clients-confirmation-body">
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
                            <input type="text" name="nom" class="form-control"  disabled>
                            <label for="nom"> Nom </label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="prenom" class="form-control"  disabled>
                            <label for="prenom"> Prenom</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="client_id" class="form-control" disabled>
                            <input type="hidden" name="client_id" class="form-control" >
                            <label for="client_id">Identifiant Du Client</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="modal-reject-clients-confirm-btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                        CONFIRMER
                        <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- END MODAL REJECT CLIENTS -->





</div>

