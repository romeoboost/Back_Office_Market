<!-- BEGIN CONTENT-->
<div id="content">

    <span id="linkToResponseMail" class="hidden">ajax/ResponseMails.php</span>
    <span id="linkToDeleteElement" class="hidden">ajax/DeleteMails.php</span>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'mails/liste'; ?>">- E-MAILS</a></li>
                <li class="active">Repondre/</li>
            </ol>
        </div>

    <div class="col-md-12 col-lg-12 scroll-sm">
        <section class="has-actions style-default-bright">
            <!-- BEGIN INBOX -->
            <div class="section-body">
                <div class="row ">
                    <!-- BEGIN INBOX NAV -->
                    <div class="col-sm-4 col-md-3 col-lg-2 box-mail-guide">
                        <form class="navbar-search margin-bottom-xxl" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" name="contactSearch" placeholder="Enter your keyword">
                            </div>
                            <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                        </form>
                        <ul class="nav nav-pills nav-stacked nav-icon">
                            <li><small>MAILBOXES</small></li>
                            <li class=""><a href="<?php echo BASE_URL.DS.'mails/ajouter'; ?>">
                                <span class="glyphicon glyphicon-plus"></span> Nouveau Mail </a>
                            </li>
                            <li class="active"><a href="<?php echo BASE_URL.DS.'mails/liste'; ?>">
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

                            <!-- BEGIN INBOX EMAIL LIST -->
                            <div class="col-md-5 col-lg-4 height-6 scroll-sm list-email-box">
                                <div class="list-group list-email list-gray">
                                    <?php $nbre_cmd_plus = $elements['total']['nbre']; $focus = 'focus' ;?>
                                    <?php if( !empty( $elements['liste'] ) ): ?>
                                    <?php foreach ( $elements['liste'] as $element ): ?>
                                        <a href="<?php echo BASE_URL.DS.'mails/liste/'.$element->token; ?>" class="list-group-item 
                                            <?php echo ($element->token == $element_focus->token) ? 'focus' : '' ;?>">

                                            <div class="stick-top-left small-padding"><i class="fa fa-dot-circle-o text-<?php echo ($element->statut == 0) ? 'info' : 'success' ; ?>"></i></div>
                                            <?php $nom = ($element->id_c == 0) ? $element->nom_prenoms_messages : htmlspecialchars($element->nom_client).' '.htmlspecialchars($element->prenoms_client); ?>
                                            <h5> <?php echo ucfirst($nom); ?> <small>(<?php echo ($element->id_c == 0) ? 'NON CLIENT' : 'CLIENT' ; ?>)</small></h5>
                                            <?php $objet = (trim($element->objet) == '') ? 'SANS OBJET' : htmlspecialchars($element->objet); //var_dump($element->objet); ?>

                                            <h4><?php echo $objet; ?></h4>
                                            
                                            <p class="hidden-xs hidden-sm">
                                                <?php echo substr(htmlspecialchars($element->contenu), 60) ; echo strlen(htmlspecialchars($element->contenu)) > 60 ? '...' : htmlspecialchars($element->contenu) ;?>
                                            </p>
                                            <div class="stick-top-right small-padding text-default-light text-sm"><?php echo dateFormat($element->date_creation); ?></div>
                                            <div class="stick-bottom-right small-padding ">
                                                <!-- <span class="glyphicon glyphicon-trash"></span> -->
                                                <button type="button" class="btn delete-btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" 
                                                element-id="<?php echo $element->token; ?>" data-original-title="Supprimer l'element">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>
                                        </a>
                                        <?php $focus = '' ;?>
                                    <?php endforeach; ?>
                                    <?php endif; ?>

                                </div><!--end .list-group -->
                            </div><!--end .col -->
                            <!-- END INBOX EMAIL LIST -->

                            <?php $element = $element_focus; ?>                            
                            <!-- BEGIN EMAIL CONTENT -->
                            <div class="col-md-7 col-lg-8 box-mail-message">
                                <h3>REPONDRE</h3>
                                    <form class="form formulaire_repondre_mail" id="formCompose">
                                        <div class="form-group floating-label">
                                            <?php $email = ($element->id_c == 0) ? $element->email_messages : htmlspecialchars($element->email_client); ?>
                                            <input type="email" class="form-control" id="to" name="to" value="<?php echo htmlspecialchars($email); ?>">
                                            <label for="to1">À</label>
                                        </div><!--end .form-group -->
                                        <div class="form-group floating-label">
                                            <?php $objet = (trim($element->objet) == '') ? 'SANS OBJET' : htmlspecialchars($element->objet); ?>
                                            <input type="text" class="form-control" id="Subject" name="Subject"  value="Re: <?php echo htmlspecialchars($objet) ?>">
                                            <label for="Subject">Objet</label>
                                        </div><!--end .form-group -->
                                        <div class="form-group">
                                            <textarea id="simple-summernote" name="message" class="form-control control-10-rows" placeholder="Entrer le message ici..." spellcheck="false">
                                                    <br/><br/>
                                                    <hr/>
                                                    <div style="background-color: #c7d0d0; padding: 5px;">
                                                        <p>
                                                            <?php $nom = ($element->id_c == 0) ? $element->nom_prenoms_messages : htmlspecialchars($element->nom_client).' '.htmlspecialchars($element->prenoms_client); ?>
                                                            <strong>De:</strong> <?php echo ucfirst($nom) ?> [ <?php echo htmlspecialchars($email); ?> ] <br/>
                                                            <strong>Date:</strong>  <?php echo dateFormat($element->date_creation) ?> ‎‎<br/>
                                                            <strong>À:</strong>  <?php echo APPLI_NAME ?>
                                                        </p>
                                                        <p>
                                                            <?php echo htmlspecialchars($element->contenu) ?>
                                                        </p>
                                                    </div>
                                            </textarea>
                                        </div><!--end .form-group -->
                                        <input type="hidden" name="token"  value="<?php echo $element_focus->token; ?>">
                                        <input type="hidden" name="admin_id"  value="<?php echo $_SESSION['bo_user']['id']; ?>">
                                            
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
