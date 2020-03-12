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
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-info no-margin">
                                <div class="col-sm-12 text-center">
                                    <span class="data-title">TOTAL 
                                    </span>
                                </div>
                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding total_produit">
                                       <?php echo number_format($produits_stat['total'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->


                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-success no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">STOCK EPUISE</span>
                                </div>

                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding total_produit_stock_off">
                                       <?php echo number_format($produits_stat['produits_stock_off'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>

                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-warning no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">JAMAIS COMMANDES </span>
                                </div>
                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding total_never_cmd">
                                       <?php echo number_format($produits_stat['produits_non_cmd'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->

                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-warning no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">NON ACTIFS </span>
                                </div>
                                <div class="col-sm-12 text-center no-padding">
                                    <strong class="text-xl stat-data-value no-padding total_non_actif">
                                       <?php echo number_format($produits_stat['produits_non_actif'], 0, '', ' '); ?>
                                       
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                              
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->

               
            </div>


            <form class="form product_search_form with_date">
                <em class="text-caption">Ce formulaire permet de filtrer la liste des produits et les statistiques.
                        Il faut renseigner au moins un champs avant de valider. </em>
                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header>
                                    <!-- Formulaire de recherche -->
                                    <h2 class="text-default-bright">Formulaire de recherche</h2>
                                </header>

                                <div class="tools">
                                    <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="left" 
                                    data-original-title="Annuler le filtre" href="<?php echo SITE_BASE_URL.'produits/liste'; ?>">
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
                                            <input type="text" name="name_product" class="form-control" id="name_product">
                                            <label for="name_product">Nom du Produit</label>
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="form-group ">
                                            <select id="category_product" name="category_product" class="form-control dirty selectpicker" 
                                            data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <?php foreach ( $categories as $categorie ): ?>
                                                    <option class="toUpCase" value="<?php echo  $categorie->id ?>">
                                                        <?php echo strtoupper( $categorie->nom ); ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                            <label for="category_product">Cotégorie Produit</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="stock_product" class="form-control" id="stock_product">
                                            <label for="stock_product">Stock Restant</label>
                                        </div>
                                    </div> 
                                    
                                </div>

                                <div class="row">
                                    
                                    <div class="col-sm-4">
                                        <div class="form-group ">
                                            <select id="unit_mesure" name="unit_mesure" class="form-control dirty selectpicker" 
                                                data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <?php foreach ( $unit_mesure as $id => $unit ): ?>
                                                    <option  value="<?php echo  $id ?>">
                                                        <?php echo ucfirst( $unit ) ; ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                            <label for="unit_mesure">Unité Mésure</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group ">
                                            <select id="status_product" name="status_product" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0">NON ACTIF</option>
                                                <option value="1">ACTIF</option>
                                            </select>
                                            <label for="status_product">Statut</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group ">
                                            <select id="promo_product" name="promo_product" class="form-control dirty selectpicker" data-live-search="true">
                                                <option value="" >&nbsp;</option>
                                                <option value="0">NON</option>
                                                <option value="1">OUI</option>
                                            </select>
                                            <label for="promo_product">Promo</label>
                                        </div>
                                    </div>

                                </div>

                                
                                <div class="row">                                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="amount_product" class="form-control" id="amount_product">
                                            <label for="amount_product">Prix (normal)</label>
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
                        <h2 class="text-default-bright">Liste des produits</h2>
                        <!-- <p>
                            Add <code>.table-hover</code> to enable a hover state on table rows within a <code>&lt;tbody&gt;</code>.
                        </p> -->
                    </header>
                    <div class="tools">
                        <a id=" add-product-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
                            href="<?php echo SITE_BASE_URL.'produits/ajouter'; ?>" 
                             data-original-title="Ajouter un nouveau produit">
                            <i class="fa fa-plus-square"></i>
                        </a>
                        <a id="extract-excel-btn" class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="left"
    href="<?php echo SITE_BASE_URL.'produits/extraction/start_date&2018-01-01/start_hour&00:00:00/end_date&'.date("Y-m-d").'/end_hour&23:59:59/name_product&/category_product&/stock_product&/unit_mesure&/status_product&/promo_product&/amount_product&'; ?>" 
                        target="_blank" data-original-title="Extraire le tableau vers Excel">
                            <i class="fa fa-file-excel-o"></i>
                        </a>
                    </div>
                </div><!--end .card-head -->
                <div class="card-body">
                  <div class="table-responsive">

                      <table id="product-list" class="table table-hover" 
                        filter-data-startDate="" filter-data-startHour=""
                        filter-data-endDate="" filter-data-endHour=""
                        filter-data-nameProduct="" filter-data-categoryProduct=""
                        filter-data-stockProduct="" filter-data-unitMesure=""
                        filter-data-statusProduct="" filter-data-promoProduct=""
                        filter-data-amountProduct=""
                        filter-data-pageRunning="<?php echo $numero_page_encours; ?>" 
                        >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Aperçu</th>
                                    <th>Nom</th>
                                    <th>Catégorie</th>
                                    <th>Stock restant</th>
                                    <th class="text-center">Qtté. Unit. Vendue</th>
                                    <th class="text-center">Unit. Mésure</th>
                                    <th class="text-center">Prix Qtté Unit.</th>
                                    <th>Promo</th>                                    
                                    <th>Prix Promo</th>                                    
                                    <th>Statut</th>
                                    <th class="">Date création</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $nbre_cmd_plus = $produits_stat['total']; ?>
                                <?php if( !empty( $produits ) ): ?>
                                <?php foreach ( $produits as $produit ): ?>
                                <tr class="<?php echo $produit->token_produit.' '.color_ligne_product($produit); ?>">
                                    <td><?php echo $nbre_cmd_plus--; ?></td>
                                    <td><img class="img-circle width-1" src="<?php echo WEBROOT_URL_FRONT.'images/shop/'.$produit->image; ?>.jpg?1422538624" alt="" /></td>
                                    <td class="name_product" ><?php echo ucfirst( $produit->nom_produit ); ?></td>
                                    <td><?php echo ucfirst( $produit->categorie ); ?></td>
                                    <td class="stock_product"><?php echo $produit->stock; ?></td>
                                    <td><?php echo $produit->qtite_unit ?></td>
                                    <td><?php echo ucfirst( $unit_mesure[$produit->unite] ); ?></td>
                                    <td><?php echo number_format($produit->prix_qtite_unit, 0, '', ' '); ?></td>
                                    <td><?php echo ($produit->ispromo == 1) ? 'OUI' : 'NON'; ?></td>
                                    <td>
                                        <?php 
                                            $prix_promo = ($produit->ispromo == 1) ? number_format($produit->prix_qtite_unit - $produit->prix_qtite_unit*$produit->percent_promo/100, 0, '', ' ') : '-';
                                            echo $prix_promo; 
                                        ?>
                                    </td>
                                    <td><?php echo ($produit->produit_statut == 1) ? 'ACTIF' : 'NON ACTIF'; ?></td>
                                    <td><?php echo dateFormat($produit->date_creation); ?></td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" product-id="<?php echo $produit->token_produit; ?>"
                                         data-original-title="Modifier les informations du produit">
                                            <a href="<?php echo BASE_URL.DS.'produits/modifier/'.$produit->token_produit; ?>">
                                                    <i class="fa fa-pencil"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" product-id="<?php echo $produit->token_produit; ?>"
                                         data-original-title="Voir les détails du produit">
                                            <a href="<?php echo BASE_URL.DS.'produits/details/'.$produit->token_produit; ?>">
                                                    <i class="md md-description"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn delete-product-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" product-id="<?php echo $produit->token_produit; ?>"
                                         data-original-title="Supprimer le produit"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>
                      </table>

                      <div class="col-sm-12 text-center">
                            <ul id="list-product-pagination" class="pagination ">
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
<div class="modal own-modal fade" id="modal-delete-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-uppercase" id="exampleModalLongTitle"> SUPPRIMER LE PRODUIT </h4>
      </div>
      <form id="form-delete-product" class="form">
      <div class="modal-body order-confirmation-body">
        <div class="row">
            <div id="" class="col-md-12 text-center">
                <em class="text-caption">
                    (*) Champs obligatoires. On ne peut supprimer les produits déjà liés à une commande ou un stock.
                </em><br>
            </div>
            
            <div class="card-body ">
                <div id="" class="col-md-12 text-center errorForm"></div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="name_product" class="form-control"  disabled>
                            <label for="name_product"> Nom du Produit </label>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="stock_product" class="form-control"  disabled>
                            <label for="stock_product"> Stock Restant </label>
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
                <input type="hidden" name="product_id" value="">

            </div>


        </div>
      </div>
      <div class="modal-footer text-center">
            <div class="card-actionbar-row">
                <button id="modal-delete-product-confirm-btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
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

