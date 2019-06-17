       <!-- BEGIN CONTENT-->
<div id="content">
            
    <section>
        <div class="section-body">
            <div class="row">
                <?php //debug($d); ?>
                <div class="col-md-12 col-sm-6">
                    <h3 class="stat-part-title">COMMANDES</h3>
                </div>
                <!-- BEGIN ALERT - REVENUE -->
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-info no-margin">
                                <div class="col-sm-12 text-center">
                                    <span class="data-title">TOTAL</span>
                                </div>
                                <div class="col-sm-8 float-left no-padding">
                                    <strong class="text-lg stat-data-value">
                                        <?php echo number_format($total_cmd['montant'], 0, '', ' '); ?> F
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-4 float-right no-padding">
                                    <strong class="text-lg stat-data-value">
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
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-success no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">livrées</span>
                                </div>
                                <div class="col-sm-8 float-left no-padding">
                                    <strong class="text-lg stat-data-value">
                                        <?php echo  number_format($total_cmd_livrees['montant'], 0, '', ' '); ?> F
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-4 float-right no-padding">
                                    <strong class="text-lg stat-data-value">
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
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-warning no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">en attente</span>
                                </div>
                                <div class="col-sm-8 float-left no-padding">
                                    <strong class="text-lg stat-data-value">
                                        <?php echo  number_format($total_cmd_pending['montant'], 0, '', ' '); ?> F
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-4 float-right no-padding">
                                    <strong class="text-lg stat-data-value">
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
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="col-sm-12 alert alert-callout alert-pending no-margin">
                                <div class="col-sm-12  text-center">
                                    <span class="data-title">En cours de livraison</span>
                                </div>
                                <div class="col-sm-8 float-left no-padding">
                                    <strong class="text-lg stat-data-value">
                                        <?php echo  number_format($total_cmd_on_road['montant'], 0, '', ' '); ?> F
                                    </strong><br/>
                                    <span class="opacity-50">Montant</span>
                                </div>
                                <div class="col-sm-4 float-right no-padding">
                                    <strong class="text-lg stat-data-value">
                                        <?php echo  number_format($total_cmd_on_road['nbre'], 0, '', ' '); ?>
                                    </strong><br/>
                                    <span class="opacity-50">Nombre</span>
                                </div>                                
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END ALERT - REVENUE -->
               
            </div><!--end .row -->
            <div class="row">

                <!-- BEGIN SITE ACTIVITY -->
                <div class="col-md-12">
                    <div class="card ">
                        <div class="row">
                            <div id="stat-container" class="col-md-9 stat-container">
                                <div class="card-head">
                                    <header class="text-center">
                                        <!-- Statistique des sept (7) derniers jours -->
                                        <span class="data-title">Statistique des sept (7) derniers jours</span>
                                    </header>
                                </div><!--end .card-head -->
                                <div class="card-body height-auto">
                                    <!-- <div id="flot-visitors-legend" class="flot-legend-horizontal stick-top-right 
                                    no-y-padding"></div>
                                    <div id="flot-visitors" class="flot height-7" data-title="Activity entry" 
                                    data-color="#7dd8d2,#0aa89e"></div> -->
                                    
                                    <div class="col-sm-6 stat-number-chart">
                                        <canvas id="canvasNumber" height="350"></canvas>
                                    </div>
                                    <div class="col-sm-6 stat-amount-chart">
                                        <canvas id="canvasAmount" height="350"></canvas>
                                    </div>
                                </div><!--end .card-body -->
                            </div><!--end .col -->
                            <div class="col-md-3">
                                <div class="card-head">
                                    <header><span class="data-title">Statistiques du jour</span></header> 
                                </div>
                                <div class="card-body height-auto">
                                    <span class="stat-day-title">TOTAL </span><strong>
                                        <?php echo  number_format($total_cmd_today['montant'], 0, '', ' '); ?> F
                                    </strong>
                                    <span class="pull-right text-success text-sm">
                                        <?php echo  $total_cmd_today['percent']; ?>% 
                                    </span>
                                    <div class="progress progress-hairline">
                                        <div class="progress-bar progress-bar-primary-dark" 
                                            style="width:<?php echo  $total_cmd_today['style']; ?>%">
                                        </div>
                                    </div>
                                    
                                    <span class="stat-day-title">LIVREES </span><strong>
                                        <?php echo  number_format($total_cmd_livrees_today['montant'], 0, '', ' '); ?> F</strong>
                                    <span class="pull-right text-success text-sm">
                                        <?php echo  $total_cmd_livrees_today['percent']; ?>% 
                                        <i class="md md-trending-up"></i></span>
                                    <div class="progress progress-hairline">
                                        <div class="progress-bar progress-bar-primary-dark" 
                                        style="width:<?php echo  $total_cmd_livrees_today['style']; ?>%"></div>
                                    </div>

                                    <span class="stat-day-title">ANNULEES </span><strong>
                                     <?php echo  number_format($total_cmd_cancelled_today['montant'], 0, '', ' '); ?> F</strong>
                                    <span class="pull-right text-danger text-sm">
                                        <?php echo  $total_cmd_cancelled_today['percent']; ?>% 
                                        <i class="md md-trending-down"></i></span>
                                    <div class="progress progress-hairline">
                                        <div class="progress-bar progress-bar-danger" 
                                        style="width:<?php echo  $total_cmd_cancelled_today['style']; ?>%"></div>
                                    </div>

                                    <span class="stat-day-title">EN ATTENTE </span><strong>
                                     <?php echo  number_format($total_cmd_pending_today['montant'], 0, '', ' '); ?> F</strong>
                                    <span class="pull-right text-success text-sm">
                                        <?php echo  $total_cmd_pending_today['percent']; ?>% 
                                        <i class="md md-trending-up"></i></span>
                                    <div class="progress progress-hairline">
                                        <div class="progress-bar progress-bar-primary-dark" 
                                        style="width:<?php echo  $total_cmd_pending_today['style']; ?>%"></div>
                                    </div>

                                    <span class="stat-day-title">EN LIVRAISON </span><strong>
                                     <?php echo  number_format($total_cmd_on_road_today['montant'], 0, '', ' '); ?> F</strong><br>
                                    <span class="pull-right text-success text-sm">
                                        <?php echo  $total_cmd_on_road_today['percent']; ?>% 
                                        <i class="md md-trending-up">
                                    </i></span><br>
                                    <div class="progress progress-hairline">
                                        <div class="progress-bar progress-bar-primary-dark" 
                                        style="width:<?php echo  $total_cmd_on_road_today['style']; ?>%"></div>
                                    </div>
                                </div><!--end .card-body -->
                            </div><!--end .col -->
                        </div><!--end .row -->
                    </div><!--end .card -->
                </div><!--end .col -->
                <!-- END SITE ACTIVITY -->

             

            </div><!--end .row -->


            <div class="row">


                <!-- BEGIN REGISTRATION HISTORY height="350" -->
                <div class="col-md-6 ">
                    <div class="col-md-12">
                        <h3 class="stat-part-title">CLIENTS</h3>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-head">
                                <header>NOMBRE DE CLIENTS INSCRITS</header>
                            </div><!--end .card-head -->
                            <div class="card-body no-padding height-10">
                                <div class="row">                                    
                                    <div class="col-sm-12">
                                        <div class="force-padding  text-default-light">
                                            <h3 class="no-margin text-center text-primary-dark">
                                                <span id="stat-total-users" class="text-xxl">11</span>
                                            </h3>
                                        </div>
                                    </div><!--end .col -->
                                </div><!--end .row -->
                                <div class="row">
                                    <div class="col-md-12 stat-customer-chart">
                                        <canvas id="canvasCustomers" ></canvas>
                                    </div>
                                </div>
                                
                            </div><!--end .card-body -->
                        </div><!--end .card -->
                    </div>
                    
                </div><!--end .col -->
                <!-- END REGISTRATION HISTORY -->

                <!-- BEGIN NEW REGISTRATIONS -->
                <div class="col-md-6">
                    <div class="col-md-12">
                        <h3 class="stat-part-title">PRODUITS</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-head">
                                <header>PRODUITS LES PLUS COMMANDES</header>
                               <!--  <div class="tools hidden-md">
                                    <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                </div> -->
                            </div><!--end .card-head -->
                            <div class="card-body no-padding height-10 scroll">
                                <ul id="product-list-stat-container" class="list divider-full-bleed">
                                    
                                </ul>
                            </div><!--end .card-body -->
                        </div><!--end .card -->
                    </div>
                </div><!--end .col -->
                <!-- END NEW REGISTRATIONS -->

            </div><!--end .row -->
        </div><!--end .section-body -->
    </section>

</div><!--end #content-->
        <!-- END CONTENT -->
