<!-- BEGIN CONTENT-->
<div id="content">

    <span id="linkToDeleteElement" class="hidden">ajax/DeleteMails.php</span>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'mails/liste'; ?>">- E-MAILS</a></li>
                <li class="active">Liste/</li>
            </ol>
        </div>
    <div class="col-md-12 col-lg-12 scroll-sm">
        <section class="has-actions style-default-bright">
            <!-- BEGIN INBOX -->
            <div class="section-body">
                <div class="row ">
                    <!-- BEGIN INBOX NAV -->
                    <div class="col-sm-4 col-md-3 col-lg-2 box-mail-guide">
                        <!-- <form class="navbar-search margin-bottom-xxl" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" name="contactSearch" placeholder="Enter your keyword">
                            </div>
                            <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                        </form> -->
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
                            <li><a href="<?php echo BASE_URL.DS.'mails/liste/all/0'; ?>"><i class="fa fa-dot-circle-o text-info"></i>EN ATTENTE 
                                <small>( <?php echo number_format($elements['non_actifs'], 0, '', ' '); ?> )</small></a>
                            </li>
                            <li><a href="<?php echo BASE_URL.DS.'mails/liste/all/1'; ?>"><i class="fa fa-dot-circle-o text-success"></i>REPONDU 
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
                                            <?php $nom = ($element->id_c == 0) ? htmlspecialchars($element->nom_prenoms_messages) : htmlspecialchars($element->nom_client).' '.htmlspecialchars($element->prenoms_client); ?>
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
                                <div class="text-divider hidden-md hidden-lg"><span>Email</span></div>
                                <?php $objet = (trim($element->objet) == '') ? 'SANS OBJET' : $element->objet; //var_dump($element->objet); ?>
                                <h1 class="no-margin"><?php echo $objet; ?><small> <?php echo ($element->statut == 0) ? '' : '/ REPONSE ADMINISTRATEUR' ; ?></small></h1>
                                <div class="btn-group stick-top-right">
                                    <a href="#" class="btn btn-icon-toggle btn-default email-delete-btn" data-toggle="tooltip" data-placement="top" 
                                        element-id="<?php echo $element->token; ?>" data-original-title="Supprimer l'element">
                                        <i class="md md-delete"></i>
                                    </a>
                                    <?php if( empty($element->reponse_admin_contenu) ){?>
                                        <a href="<?php echo BASE_URL.DS.'mails/repondre/'.$element->token; ?>" class="btn btn-icon-toggle btn-default"><i class="md md-reply-all"></i></a>
                                    <?php } ?>
                                </div>
                                <span class="pull-right text-default-light">
                                    <?php echo ($element->statut == 0) ? dateFormat($element->date_creation) : dateFormat($element->date_reponse) ; ?>     
                                </span>
                                <strong>
                                    <?php 
                                        if( $element->statut == 0 ){
                                            $nom = ($element->id_c == 0) ? $element->nom_prenoms_messages : $element->nom_client.' '.$element->prenoms_client; 
                                        }else{
                                            $nom = $users_bo['liste'][$element->id_admin_reponse];
                                        }
                                        echo $nom;
                                    ?>      
                                </strong>
                                <hr/>
                                <p class="lead">
                                    <?php if( empty($element->reponse_admin_contenu) ){?>
                                        <?php echo $element->contenu ?>
                                    <?php }else{ ?>
                                        <?php echo $element->reponse_admin_contenu ?>
                                    <?php } ?>
                                </p>

                                <br>
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
