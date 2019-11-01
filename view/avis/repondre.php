<!-- BEGIN CONTENT-->
<div id="content">
    <span id="linkToUpdateElement" class="hidden">ajax/UpdateAvis.php</span>
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_URL.DS.'avis/liste'; ?>">Avis</a></li>
                <li class="active">Repondre/</li>
            </ol>
        </div>

        <div class="section-body contain-lg">
            <div class="row">        

                        <!-- BEGIN INBOX EMAIL LIST -->
                        <div class="col-md-8 col-lg-8 height-10 scroll-sm detail-comments-box">
                            <div class="list-group list-gray">
                                <div href="inbox" class="list-group-item">
                                    <h5>Commentaire de l'utilisateur (<b><?php echo ($element->id_c == 0) ? 'NON CLIENT' : 'CLIENT' ; ?></b>)</h5>
                                    <?php $nom = ($element->id_c == 0) ? $element->nom_avis.' '.$element->prenoms_avis : $element->nom_client.' '.$element->prenoms_client; ?>
                                    <?php $email = ($element->id_c == 0) ? $element->email_avis : $element->email_client; ?>
                                    <h4><?php echo ucwords( $nom ) ; ?><span> / <?php echo $email; ?></span></h4>
                                    <p class="hidden-xs hidden-sm">
                                        <?php echo $element->contenu  ; ?>
                                    </p>
                                    <div class="stick-top-right small-padding text-default-light text-sm"><?php echo dateFormat($element->date_creation); ?></div>
                                    <div class="stick-bottom-right small-padding">
                                        <?php if( $element->page_accueil == 0 ){?>
                                            <span data-toggle="tooltip" data-placement="top" data-original-title="n'est pas Affiché sur la page d'acceuil" 
                                                    class="md md-check-box-outline-blank">
                                            </span>
                                        <?php }else{ ?>
                                            <span data-toggle="tooltip" data-placement="top" data-original-title="Affiché sur la page d'acceuil" class="md md-home">
                                            </span>
                                        <?php } ?>
                                        
                                    </div>
                                </div>
                                <div href="inbox" class="list-group-item focus">
                                    <!-- <div class="stick-top-left small-padding"><i class="fa fa-dot-circle-o text-info"></i></div> -->
                                    <h5>Reponse de l'admin</h5>
                                    <h4><?php echo ($element->statut == 0) ? '' : $users_bo['liste'][$element->id_admin_reponse] ; ?></h4>
                                    <div class="stick-top-right small-padding text-default-light text-sm">
                                        <?php echo ($element->statut == 0) ? '' : dateFormat($element->date_reponse) ; ?>
                                    </div>
                                    <div class="stick-top-right small-padding text-default-light text-sm">
                                        <?php echo ($element->statut == 0) ? '' : dateFormat($element->date_reponse) ; ?>
                                    </div>
                                    <form class="form post_response_form with_date" enctype="multipart/form-data">
                                                <div class="card">
                                                    <div class="card-body ">
                                                        <!-- floating-label -->
                                                        <div id="errorForm" class="col-md-12 text-center"></div>
                                                        <input type="hidden" name="token" class="form-control" id="token" 
                                                                    value="<?php echo  $element->token ; ?>">


                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group ">
<textarea name="descript_product" id="textarea1" class="form-control" rows="2" placeholder="" value="" required><?php echo  $element->reponse_admin_contenu ; ?></textarea>
                                                                    <label for="rejected_message">Message*</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!--end .card-body -->
                                                    <div class="card-actionbar">
                                                        <div class="card-actionbar-row">
                                                            <button id="post_response_btn" class="btn btn-primary btn-raised ld-ext-right " type="submit">
                                                                    ENVOYER
                                                                    <div class="ld ld-ring ld-spin"></div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div><!--end .card -->
                                    </form>
                                </div>
                            </div><!--end .list-group -->
                            
                        </div><!--end .col -->
                        <!-- END INBOX EMAIL LIST -->
                        <div class="col-sm-3">
                                
                            <div class="detail-product-img-content-comment" data-toggle="tooltip" data-placement="top" 
                            data-original-title="<?php echo $element->produit; ?>" >
                                <img class="img-responsive" src="<?php echo WEBROOT_URL_FRONT.'images/shop/'.$element->image; ?>.jpg?1422538624" alt="" 
                                />
                            </div>
                            
                        </div>

                


            </div><!--end .row -->

            

        </div><!--end .section-body -->
    

    </section>

</div><!--end #content-->
<!-- END CONTENT -->
