<div class="card contain-sm style-transparent">
    <div class="card-body">
        <div class="row">

            <div class="col-sm-6 col-sm-offset-3">
                <br/>
                <div class="col-md-12 text-center">
                    <span class="text-bold text-center login-app-name" style="color: #0aa89e;">
                       LOGICIEL GESTION
                    </span> <br/>
                    <span class="text-bold text-center login-app-name">
                        <?php echo APPLI_NAME; ?>
                    </span>
                </div>
                
                <br/><br/>
                <div id="errorLoginForm" class="col-md-12 text-center"></div>
                <div class="col-md-12">
                    <form id="authentication-login-form" class="form floating-label" action="" accept-charset="utf-8" method="post">
                        
                        <div class="form-group">
                            <input type="text" class="form-control authentication-input" id="username" name="username"
                            required>
                            <label for="username">Login</label>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control authentication-input" id="password" name="password"
                            required>
                            <label for="password">Mot de passe</label>
                            <p class="help-block"><a href="login#">Mot de passe oublié ?</a></p>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xs-6 text-left">
                                <div class="checkbox checkbox-inline checkbox-styled">
                                    <label>
                                        <input type="checkbox"> <span>Se souvenir de moi</span>
                                    </label>
                                </div>
                            </div><!--end .col -->
                            <div class="col-xs-6 text-right ">
                                <button id="login-button-valide" 
                                    class="btn btn-primary btn-raised ld-ext-right " type="submit">
                                        Connexion
                                        <div class="ld ld-ring ld-spin"></div>
                                </button>
                            </div><!--end .col -->
                        </div><!--end .row -->
                    </form>
                </div>
            </div><!--end .col -->


        </div><!--end .row -->
    </div><!--end .card-body -->
</div><!--end .card -->
