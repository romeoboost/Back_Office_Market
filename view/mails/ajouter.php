<!-- BEGIN CONTENT-->
<div id="content">

    <span id="linkToSendNewMail" class="hidden">ajax/SendNewMails.php</span>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'mails/ajouter'; ?>">- E-Mails</a></li>
                <li class="active">Envoyer un nouveau mail /</li>
            </ol>
        </div>
    <div class="col-md-12 col-lg-12 scroll-sm">
        <section class="has-actions style-default-bright">
            <!-- BEGIN INBOX -->
            <div class="section-body">
                <div class="row ">
                    <!-- BEGIN INBOX NAV -->
                    <div class="col-sm-4 col-md-3 col-lg-2 box-mail-guide">
                        <!-- <form class="navbar-search margin-bottom-xxl " role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" name="contactSearch" placeholder="Enter your keyword">
                            </div>
                            <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                        </form> -->
                        <ul class="nav nav-pills nav-stacked nav-icon">
                            <li><small>MAILBOXES</small></li>
                            <li class="active"><a href="<?php echo BASE_URL.DS.'mails/ajouter'; ?>">
                                <span class="glyphicon glyphicon-plus"></span> Nouveau Mail </a>
                            </li>
                            <li class=""><a href="<?php echo BASE_URL.DS.'mails/liste'; ?>">
                                <span class="glyphicon glyphicon-inbox"></span>Tous les e-mails 
                                <small>( <?php echo number_format($elements['total']['nbre'], 0, '', ' '); ?> )</small></a>
                            </li>
                            
                            <li><small>Tags</small></li>
                            <li><a href="inbox#"><i class="fa fa-dot-circle-o text-info"></i>EN ATTENTE 
                                <small>( <?php echo number_format($elements['non_actifs'], 0, '', ' '); ?> )</small></a>
                            </li>
                            <li><a href="inbox#"><i class="fa fa-dot-circle-o text-success"></i>REPONDU 
                                <small>( <?php echo number_format($elements['actifs'], 0, '', ' '); ?> )</small></a>
                            </li>
                        </ul>
                    </div><!--end . -->
                    <!-- END INBOX NAV -->

                    <div class="col-sm-8 col-md-9 col-lg-10">
                    
                        <div class="text-divider visible-xs"><span>Email list</span></div>
                        <div class="row">

                            <!-- BEGIN EMAIL CONTENT -->
                            <div class="col-md-12 col-lg-12 box-mail-message">
                                <h3>Composez Votre Mail</h3>
                                    <form class="form formulaire_envoi_mail" id="formCompose" action="#">
                                        <div id="" class="col-md-12 text-center errorForm"></div>
                                        <div class="form-group floating-label">
                                            <input type="email" class="form-control" id="to" name="to" required>
                                            <label for="to1">À</label>
                                            <a class="link-default pull-right" href="compose#emailOptions" data-toggle="collapse"></a>
                                        </div><!--end .form-group -->
                                        <div class="form-group floating-label">
                                            <input type="text" class="form-control" id="Subject" name="Subject" required>
                                            <label for="Subject1">Objet</label>
                                        </div><!--end .form-group -->
                                        <div class="form-group">
                                            <textarea id="simple-summernote" name="message" class="form-control control-6-rows" spellcheck="false" ></textarea>
                                        </div><!--end .form-group -->
                                        <div class="card-actionbar">
                                            <div class="card-actionbar-row">
                                                <button id="confirm_btn" class="btn btn-accent btn-raised ld-ext-right " type="submit">
                                                        ENVOYER <i class="md md-send"></i>
                                                        <div class="ld ld-ring ld-spin"></div>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                            </div><!--end .col -->
                            <!-- END EMAIL CONTENT -->

                        </div><!--end .row -->
                    </div><!--end .col -->

                </div><!--end .row -->
            </div><!--end .section-body -->
            <!-- END INBOX -->

        </section>
    </div>
</div><!--end #content-->
        <!-- END CONTENT -->
