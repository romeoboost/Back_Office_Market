(function($) {

	"use strict";
    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };

    //$("#myModal").modal();
    var UrlToAddMember = $("#linkToAddMember").html();
    var UrlToLogin = $("#linkToLogin").html();
    var linkToHome = $("#linkToHome").html();
    var linkToStatOrder = $("#linkToStatOrder").html();
    var linkToStatCustomer = $("#linkToStatCustomer").html();
    var linkToStatProducts = $("#linkToStatProducts").html();
    var linkToSearchOrders = $("#linkToSearchOrders").html();
    var linkToSearchQuickOrders = $("#linkToSearchQuickOrders").html();
    
    var linkToSetOrderDelivrery = $("#linkToSetOrderDelivrery").html();
    var linkToSetQuickOrderDelivrery = $("#linkToSetQuickOrderDelivrery").html();
    var linkToGetLivreur = $("#linkToGetLivreur").html();
    var linkToGetQuickLivreur = $("#linkToGetQuickLivreur").html();
    var linkToSetStopOrderDelivrery = $("#linkToSetStopOrderDelivrery").html();
    var linkToSetStopQuickOrderDelivrery = $("#linkToSetStopQuickOrderDelivrery").html();
    var linkToRejectOrder = $("#linkToRejectOrder").html();
    var linkToRejectQuickOrder = $("#linkToRejectQuickOrder").html();
    var linkToRestoreOrder = $("#linkToRestoreOrder").html();
    var linkToRestoreQuickOrder = $("#linkToRestoreQuickOrder").html();
    var linkToDeleteOrder = $("#linkToDeleteOrder").html();
    var linkToDeleteQuickOrder = $("#linkToDeleteQuickOrder").html();
    var linkToSearchProducts = $("#linkToSearchProducts").html();
    var linkToAddProduct = $("#linkToAddProduct").html();
    var linkToUpdateProduct = $("#linkToUpdateProduct").html();
    var linkToDeleteProduct = $("#linkToDeleteProduct").html();
    var linkToSearchCategory = $("#linkToSearchCategory").html();
    var linkToAddCategory = $("#linkToAddCategory").html();
    var linkToUpdateCategory = $("#linkToUpdateCategory").html();
    var linkToDeleteCategory = $("#linkToDeleteCategory").html();
    var linkToSearchClients = $("#linkToSearchClients").html();
    var linkToRejectClients = $("#linkToRejectClients").html();
    var linkToRestoreClients = $("#linkToRestoreClients").html();
    var linkToDeleteClients = $("#linkToDeleteClients").html();
    var linkToSearchStocks = $("#linkToSearchStocks").html();
    var linkToAddStock = $("#linkToAddStock").html();
    var linkToUpdateStock = $("#linkToUpdateStock").html();
    var linkToDeleteStock = $("#linkToDeleteStock").html();
    var linkToSearchFournisseurs = $("#linkToSearchFournisseurs").html();
    var linkToAddFournisseur = $("#linkToAddFournisseur").html();
    var linkToUpdateSupplier = $("#linkToUpdateSupplier").html();
    var linkToDeleteSupplier = $("#linkToDeleteSupplier").html();
    // linkToSearchElements



    if( $('.with_date')[0] ){
        //console.log('formDate');
        $('#StartDate').datetimepicker({
            locale: 'fr',
            format: 'DD-MM-YYYY'
        });
        // $('#StartDateInput').datetimepicker({
        //     locale: 'fr',
        //     format: 'DD-MM-YYYY'
        // });

        $('#StartHour').datetimepicker({
            locale: 'fr',
            format: 'HH:mm:ss'
        });
        // $('#StartHourInput').datetimepicker({
        //     locale: 'fr',
        //     format: 'hh:mm:ss'
        // });

        $('#EndDate').datetimepicker({
            locale: 'fr',
            format: 'DD-MM-YYYY'
        });
        // $('#EndDateInput').datetimepicker({
        //     locale: 'fr',
        //     format: 'DD-MM-YYYY'
        // });

        $('#EndHour').datetimepicker({
            locale: 'fr',
            format: 'HH:mm:ss'
        });
        // $('#EndHourInput').datetimepicker({
        //     locale: 'fr',
        //     format: 'hh:mm:ss'
        // });
    }
    // else{
    //     console.log('NO formDate');
    // }    

    

    //statProductsDashboard();

    var wrapStat = document.getElementById('stat-container');

    if(wrapStat==null || wrapStat===false){
    }else{
        
        //Verifie la page a completement été chargée
        let stateCheck = setInterval(() => {
          if (document.readyState === 'complete') {
            clearInterval(stateCheck);
            //console.log('The page is document ready');// document ready
            orderCharts();
            //customerCharts();
          }
        }, 600);

        let stateCheck_two = setInterval(() => {
          if (document.readyState === 'complete') {
            clearInterval(stateCheck_two);
            customerCharts();
          }
        }, 900);

        let stateCheck_three = setInterval(() => {
          if (document.readyState === 'complete') {
            clearInterval(stateCheck_three);
            statProductsDashboard();
          }
        }, 1000);

    }

    /**START MAIL PROCESS**/

    var mailBox = document.getElementById('simple-summernote');
    if( mailBox != null ){
        $('#simple-summernote').summernote();
    }

    //form envoi de nouveau lail
    $('.formulaire_envoi_mail').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);
        var url_process = $('#linkToWebroot').html()+$('#linkToSendNewMail').html();
        console.log( $(this).serialize() );
        // console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        // update_element_default( $(this).serialize(), self, url_process );
        add_element_default( $(this).serialize(), self, url_process );

        return false;
    });

    //form reponse à un mail
    $('.formulaire_repondre_mail').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);
        var url_process = $('#linkToWebroot').html()+$('#linkToResponseMail').html();
        console.log( $(this).serialize() );
        // console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        // update_element_default( $(this).serialize(), self, url_process );
        add_element_default( $(this).serialize(), self, url_process );

        return false;
    });

    ////Cliquer sur le bouton pour supprimer la ligne de pub
    $('.box-mail-message').on('click', '.email-delete-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var token = $(this).attr('element-id');
        var url_process = $('#linkToWebroot').html()+$('#linkToDeleteElement').html();

        var textinfo = "Ce mail sera supprimé du Back Office.";

        console.log( url_process );
        Swal({
          title: 'Êtes vous sure ?',
          text: textinfo,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0aa89e',
          cancelButtonColor: '#d33',
          confirmButtonText: 'OK',
          cancelButtonText: 'Annuler'
        }).then((result) => {
          if (result.value) {
            // set_home(token, isAccueil, self, url_process); 
            // APPELER FONCTION DE SUPPRESSION
            var dataFilter = {token:token};
            delete_mails(dataFilter, url_process);
          }
        });
       
        return false;
    });

    /**END MAIL PROCESS**/

    /** START COMMENTS PROCESS **/

    //validation du formulaire de recherche des éléments
    $('.avis_search_form').on('submit', function (e) {
        e.preventDefault();
        console.log( $(this).serialize() );
        var linkToSearchElements = $('#linkToWebroot').html()+$('#linkToGetElement').html()
        console.log( linkToSearchElements );
        $(this).find("#confirm_filter").addClass('disabled');
        $(this).find("#confirm_filter").addClass('running');
        var self = $(this);
        ///name_supplier&/tel&        
        search_elements( $(this).serialize(), self, linkToSearchElements );

        var start_date = $(this).find(" :input[name='start_date']").val();
        var start_hour = $(this).find(" :input[name='start_hour']").val();
        var end_date = $(this).find(" :input[name='end_date']").val();
        var end_hour = $(this).find(" :input[name='end_hour']").val();
        var filter_content = $(this).find(" :input[name='filter_content']").val();
        var filter_status = $(this).find(" :input[name='filter_status']").val();

        $('#avis-list').attr('filter-data-startDate', start_date);
        $('#avis-list').attr('filter-data-startHour', start_hour);
        $('#avis-list').attr('filter-data-endDate', end_date);
        $('#avis-list').attr('filter-data-endHour', end_hour);
        $('#avis-list').attr('filter-data-filterStatus', filter_status);
        $('#avis-list').attr('filter-data-content', filter_content);
        // console.log( sexe );
        return false;
    });

    //pagination de liste clients
    $('#list-avis-pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        var linkToSearchElements = $('#linkToWebroot').html()+$('#linkToGetElement').html()
        var numero = $(this).attr('href');
        // console.log(numero);
        var start_date = $('#avis-list').attr('filter-data-startDate');
        var start_hour = $('#avis-list').attr('filter-data-startHour');
        var end_date = $('#avis-list').attr('filter-data-endDate');
        var end_hour = $('#avis-list').attr('filter-data-endHour');
        var filter_status = $('#avis-list').attr('filter-data-filterStatus');
        var filter_content = $('#avis-list').attr('filter-data-content');
        var pagination = true;        

        var dataFilter = {start_date:start_date,start_hour:start_hour,end_date:end_date,end_hour:end_hour,pagination:pagination,
            filter_status:filter_status,filter_content:filter_content,number_page_running:numero};
        
        if( !isNaN( parseInt(numero) ) ){
            search_elements(dataFilter, 'pagination', linkToSearchElements);      
        }
        //$(".cmd_search_form :input[name='number_page_running']").val(numero);
        $('#avis-list').attr('filter-data-pageRunning', numero);
        return false;
    });
    
    //form d'ajout frais
    $('.post_response_form').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);
        var url_process = $('#linkToWebroot').html()+$('#linkToUpdateElement').html();
        console.log( $(this).serialize() );
        console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        update_element_default( $(this).serialize(), self, url_process );

        return false;
    });
    
    //Cliquer sur le bouton pour reactiver un client
    $('#avis-list tbody').on('click', '.set-home-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        //console.log(self);
        var token = $(this).attr('element-id');
        var isAccueil = $(this).attr('page-acceuil-value');
        var url_process = $('#linkToWebroot').html()+$('#linkSetHomeElement').html();
        var textinfo = '';
        if( parseInt(isAccueil) ==  0){
            textinfo = "Vous vous apprêter à mettre l'avis sur la page d'accueil.";
        }else{
            textinfo = "Vous vous apprêter à rétirer l'avis de la page d'accueil.";
        }

         Swal({
          title: 'Êtes vous sure ?',
          text: textinfo,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0aa89e',
          cancelButtonColor: '#d33',
          confirmButtonText: 'OK',
          cancelButtonText: 'Annuler'
        }).then((result) => {
          if (result.value) {
            //console.log(self);
            set_home(token, isAccueil, self, url_process);            
          }
        });        
        return false;
    });

    /*Function rejet de commande*/
    function set_home(token, isAccueil, self, url_process){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url_process,
            data: {token:token,isAccueil:isAccueil},
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
                //mettre a jour l'intitulé du statut de la commande
               $('#avis-list tbody .'+token+' .isHome').html(data.status_libelle);
               //  //mettre a jour les bouton d'actions
                    
                //remplacer
                $("#avis-list tbody ."+token+" .set-home-btn").attr('data-original-title', data.status_action);
                $("#avis-list tbody ."+token+" .set-home-btn").attr('page-acceuil-value', data.status_value);
                $("#avis-list tbody ."+token+" .set-home-btn").html(data.status_action_icon_html);
                // console.log($("#avis-list tbody ."+token+" .set-home-btn"));
                $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    $("#avis-list tbody ."+token).fadeOut(250).fadeIn(250).fadeOut(250).fadeIn(250);
                  }
                });
            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
              if(jqXHR.responseJSON){
                    //$('#confirm-order-modal').hide();
                    Swal({
                      type: 'error',
                      title: jqXHR.responseJSON.error_text,
                      text: jqXHR.responseJSON.error_text_second
                    });
                    //return html_status_initial;
              }

            }
        });

    }

    //Cliquer sur le bouton pour supprimer la ligne de pub
    $('#avis-list tbody').on('click', '.delete-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var token = $(this).attr('element-id');

        // console.log( token );
        var nom = $('tbody .'+token+' .Nom').html();
        var produit = $('tbody .'+token+' .Produit').html();
        var contenu = $('tbody .'+token+' .contenu').html();
        // var token = $('tbody .'+token+' .element-id').html();
        console.log( token );

        $("#form-delete :input[name='nom']").val(nom);
        $("#form-delete :input[name='produit']").val(produit);
        $("#form-delete .contenu-comments-form").html(contenu);
        $("#form-delete :input[name='token']").val(token);

        $('#modal-delete').modal('show');
        
       return false;
    });

    //validation du formulaire de suppression de pub
    // $('#form-delete').on('submit',function(e){
    //     e.preventDefault();
    //     var url_process = $('#linkToWebroot').html()+$('#linkToDeleteElement').html()
    //     var self = $(this);
    //     $(this).find("#confirm_btn").addClass('disabled');
    //     $(this).find("#confirm_btn").addClass('running');
    //     var delete_data = $(this).serialize();
    //     delete_element_default( delete_data, self, url_process );
    // });


    
    /** STOP COMMENTS PROCESS **/

    /** START PUB PROCESS */
    //form d'ajout de pub
    $('.pub_add_form').on('submit', function (e) {
        e.preventDefault();

        var form = $('.pub_add_form')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);

        var self = $(this);
        var url_process = $('#linkToWebroot').html()+$('#linkToAddElement').html();
        console.log( $(this).serialize() );
        console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');
        
        add_pub( formData, self, url_process );

        return false;

    });

    //form de modification de pub
    $('.pub_update_form').on('submit', function (e) {
        e.preventDefault();

        var form = $('.pub_update_form')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);

        var self = $(this);
        var url_process = $('#linkToWebroot').html()+$('#linkToUpdateElement').html();
        console.log( $(this).serialize() );
        console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');
        
        add_pub( formData, self, url_process );

        return false;

    });

    //Cliquer sur le bouton pour supprimer la ligne de pub
    $('#pubs-list tbody').on('click', '.delete-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var token = $(this).attr('element-id');

        // console.log( token );
        var min = $('tbody .'+token+' .date_debut_pub').html();
        var max = $('tbody .'+token+' .date_fin_pub').html();
        var fee = $('tbody .'+token+' .element_name').html();
        // console.log( min );

        $("#form-delete :input[name='date_debut_pub']").val(min);
        $("#form-delete :input[name='date_fin_pub']").val(max);
        $("#form-delete :input[name='element_name']").val(fee);
        $("#form-delete :input[name='password']").val('');
        $("#form-delete :input[name='token']").val(token);

        $('#modal-delete').modal('show');
        
       return false;
    });

    //validation du formulaire de suppression de pub
    $('#form-delete').on('submit',function(e){
        e.preventDefault();
        var url_process = $('#linkToWebroot').html()+$('#linkToDeleteElement').html()
        var self = $(this);
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');
        var delete_data = $(this).serialize();
        delete_element_default( delete_data, self, url_process );
    });

    function add_pub(add_data, self, linkToAddPub){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToAddPub,
            data: add_data,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function (data, textStatus, jqXHR) {
                self.find("#confirm_btn").removeClass('disabled');
                self.find("#confirm_btn").removeClass('running');
                // $('.cotegory_add_form')[0].reset();
                console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToList);
                  }
                });

            },
            error: function(jqXHR) {
                console.log(jqXHR.responseText);
                self.find("#confirm_btn").removeClass('disabled');
                self.find("#confirm_btn").removeClass('running');  
                $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
            }
        });
    }

    //validation du formulaire de recherche de pubs
    $('.pubs_search_form').on('submit', function (e) {
        e.preventDefault();
        console.log( $(this).serialize() );
        var linkToSearchElements = $('#linkToWebroot').html()+$('#linkToGetElement').html()
        console.log( linkToSearchElements );
        $(this).find("#confirm_filter").addClass('disabled');
        $(this).find("#confirm_filter").addClass('running');
        var self = $(this);
        ///name_supplier&/tel&        
        search_elements( $(this).serialize(), self, linkToSearchElements );

        var start_date = $(this).find(" :input[name='start_date']").val();
        var start_hour = $(this).find(" :input[name='start_hour']").val();
        var end_date = $(this).find(" :input[name='end_date']").val();
        var end_hour = $(this).find(" :input[name='end_hour']").val();
        var filter_name = $(this).find(" :input[name='filter_name']").val();
        var filter_status = $(this).find(" :input[name='filter_status']").val();
                       // filter-data-montant="" filter-data-nameProduct="" filter-data-nameSupplier=""
        $('#pubs-list').attr('filter-data-startDate', start_date);
        $('#pubs-list').attr('filter-data-startHour', start_hour);
        $('#pubs-list').attr('filter-data-endDate', end_date);
        $('#pubs-list').attr('filter-data-endHour', end_hour);
        $('#pubs-list').attr('filter-data-filterStatus', filter_status);
        $('#pubs-list').attr('filter-data-nameCompagny', filter_name);
        // console.log( sexe );
        return false;

    });

    //pagination de liste pub
    $('#list-pubs-pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        var linkToSearchElements = $('#linkToWebroot').html()+$('#linkToGetElement').html()
        var numero = $(this).attr('href');
        // console.log(numero);
        var start_date = $('#pubs-list').attr('filter-data-startDate');
        var start_hour = $('#pubs-list').attr('filter-data-startHour');
        var end_date = $('#pubs-list').attr('filter-data-endDate');
        var end_hour = $('#pubs-list').attr('filter-data-endHour');
        var filter_status = $('#pubs-list').attr('filter-data-filterStatus');
        var filter_name = $('#pubs-list').attr('filter-data-nameCompagny');
        var pagination = true;        

        var dataFilter = {start_date:start_date,start_hour:start_hour,end_date:end_date,end_hour:end_hour,pagination:pagination,
            filter_status:filter_status,filter_name:filter_name,number_page_running:numero};
        
        if( !isNaN( parseInt(numero) ) ){
            search_elements(dataFilter, 'pagination', linkToSearchElements);      
        }
        //$(".cmd_search_form :input[name='number_page_running']").val(numero);
        $('#pubs-list').attr('filter-data-pageRunning', numero);
        return false;
    });


    /** END PUB PROCESS **/


    /***START FEES PROCESS**/
    //form d'ajout frais
    $('.fee_add_form').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);
        var url_process = $('#linkToWebroot').html()+$('#linkToAddElement').html();
        console.log( $(this).serialize() );
        console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        add_element_default( $(this).serialize(), self, url_process );

        return false;
    });

    //form d'ajout frais
    $('.fee_update_form').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);
        var url_process = $('#linkToWebroot').html()+$('#linkToUpdateElement').html();
        console.log( $(this).serialize() );
        console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        update_element_default( $(this).serialize(), self, url_process );

        return false;
    });

    //Cliquer sur le bouton pour supprimer frais livr
    $('#fees-list tbody').on('click', '.delete-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var token = $(this).attr('fee-id');

        // console.log( token );
        var min = $('tbody .'+token+' .min').html();
        var max = $('tbody .'+token+' .max').html();
        var fee = $('tbody .'+token+' .fee').html();
        // console.log( min );

        $("#form-delete-fee :input[name='min_amount']").val(min);
        $("#form-delete-fee :input[name='max_amount']").val(max);
        $("#form-delete-fee :input[name='fee']").val(fee);
        $("#form-delete-fee :input[name='password']").val('');
        $("#form-delete-fee :input[name='token']").val(token);

        $('#modal-delete-fee').modal('show');
        
       return false;
    });

    //validation du formulaire de suppression des frais
    $('#form-delete-fee').on('submit',function(e){
        e.preventDefault();
        var url_process = $('#linkToWebroot').html()+$('#linkToDeleteElement').html()
        var self = $(this);
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');
        var delete_data = $(this).serialize();
        delete_element_default( delete_data, self, url_process );
    });


    //validation du formulaire de recherche de communes
    $('.commune_search_form').on('submit', function (e) {
        e.preventDefault();
        console.log( $(this).serialize() );
        var linkToSearchElements = $('#linkToWebroot').html()+$('#linkToGetElement').html()
        console.log( linkToSearchElements );
        $(this).find("#confirm_filter").addClass('disabled');
        $(this).find("#confirm_filter").addClass('running');
        var self = $(this);
        ///name_supplier&/tel&        
        search_elements( $(this).serialize(), self, linkToSearchElements );

        var start_date = $(this).find(" :input[name='start_date']").val();
        var start_hour = $(this).find(" :input[name='start_hour']").val();
        var end_date = $(this).find(" :input[name='end_date']").val();
        var end_hour = $(this).find(" :input[name='end_hour']").val();
        var filter_name = $(this).find(" :input[name='filter_name']").val();
        var filter_status = $(this).find(" :input[name='filter_status']").val();
                       // filter-data-montant="" filter-data-nameProduct="" filter-data-nameSupplier=""
        $('#commune-list').attr('filter-data-startDate', start_date);
        $('#commune-list').attr('filter-data-startHour', start_hour);
        $('#commune-list').attr('filter-data-endDate', end_date);
        $('#commune-list').attr('filter-data-endHour', end_hour);
        $('#commune-list').attr('filter-data-filterName', filter_name);
        $('#commune-list').attr('filter-data-filterStatus', filter_status);
        // console.log( sexe );
        return false;

    });

    //form d'ajout de commune
    $('.city_add_form').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);
        var url_process = $('#linkToAddCity').html();
        // console.log( $(this).serialize() );
        // console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        add_element_default( $(this).serialize(), self, url_process );

        return false;
    });

    //Form de modification de commune
    $('.city_update_form').on('submit', function (e) {
        e.preventDefault();
        var url_process = $('#linkToUpdateCity').html()
        var self = $(this);
        console.log( $(this).serialize() );
        console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        update_element_default( $(this).serialize(), self, url_process );
        return false;
    });

    //Action pour supprimer la commune
    //Cliquer sur le bouton pour supprimer frais livr
    $('#commune-list tbody').on('click', '.delete-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var token = $(this).attr('commune-id');
        var element_name = $('tbody .'+token+' .element_name').html();
        var element_statut = $('tbody .'+token+' .element_statut').html();

        $("#form-delete-commune :input[name='name_city']").val(element_name);
        $("#form-delete-commune :input[name='status_city']").val(element_statut);
        $("#form-delete-commune :input[name='password']").val('');
        $("#form-delete-commune :input[name='token']").val(token);

        $('#modal-delete-commune').modal('show');
        
      return false;
    });

    //validation du formulaire de suppression des frais
    $('#form-delete-commune').on('submit',function(e){
        e.preventDefault();
        var url_process = $('#linkToDeleteCity').html()
        var self = $(this);
        $(this).find(".confirm_btn").addClass('disabled');
        $(this).find(".confirm_btn").addClass('running');
        var delete_data = $(this).serialize();
        console.log(url_process);
        delete_element_default( delete_data, self, url_process );
    });

    /**END FEES PROCESS**/

    /** MOT DE PASSE ADMIN */
    /*MODIFICATION DE MOT DE PASSE*/
    $('.admin_password_update_form').on('submit',function(e){
      e.preventDefault();
      var url_process = $('#linkToUpdateAdminPassword').html()
      var self = $(this);
      // console.log($(this).serialize());
      Swal({
        title: 'Êtes vous sure ?',
        text: 'Vous êtes sur le point de modifier le mot de passe de l\'administrateur du Back Office.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2ecc71',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK',
        cancelButtonText: 'Annuler'
      }).then((result) => {
        if (result.value) {
          //console.log( form_update_password );
          self.find("#confirm_btn").addClass('disabled');
          self.find("#confirm_btn").addClass('running');
          update_element_default( $(this).serialize(), self, url_process );
        }
      });
      return false;

    });

    /*AFFICHER MOT DE PASSE */
    $('#show-password-checkbox').on('change',function(e){
      var password_inputs = document.querySelectorAll('.password');
      //console.log( document.getElementById('show-password-checbox-login').checked );
      for(var i=0; i < password_inputs.length ; i++){
        if( document.getElementById('show-password-checkbox').checked ){        
          password_inputs[i].type="text";
        }else{
          password_inputs[i].type="password";
        }
      }
      
    });

    /** END PROCESS MOT DE PASSE ADMIN **/

    //Cliquer sur le bouton pour supprimer une unité de mesure
    $('#units-list tbody').on('click', '.delete-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var token = $(this).attr('unite-id');

        // console.log( token );
        var libelle_unit = $('tbody .'+token+' .libelle_unit').html();
        var symbole_unit = $('tbody .'+token+' .symbole_unit').html();

        $("#form-delete-units :input[name='libelle_unit']").val(libelle_unit);
        $("#form-delete-units :input[name='symbole_unit']").val(symbole_unit);
        $("#form-delete-units :input[name='token']").val(token);
        $("#form-delete-units :input[name='password']").val('');

        $('#modal-delete-units').modal('show');
        
        return false;
    });

    
    //validation du formulaire de suppression du client
    $('#form-delete-units').on('submit',function(e){
        e.preventDefault();
        var url_process = $('#linkToWebroot').html()+$('#linkToDeleteElement').html()
        var self = $(this);
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');
        var delete_data = $(this).serialize();
        delete_element_default( delete_data, self, url_process );
    });

    //form d'ajout unit
    $('.unit_add_form').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);
        var url_process = $('#linkToWebroot').html()+$('#linkToGetElement').html();
        console.log( $(this).serialize() );
        console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        add_element_default( $(this).serialize(), self, url_process );

        return false;
    });

    //Form unit update submit
    $('.unit_update_form').on('submit', function (e) {
        e.preventDefault();
        var url_process = $('#linkToWebroot').html()+$('#linkToGetElement').html()
        var self = $(this);

        console.log( $(this).serialize() );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        update_element_default( $(this).serialize(), self, url_process );
        return false;
    });


/**BEGIN delivrer PROCESS**/
//Cliquer sur le bouton pour supprimer un stock
    $('#livreurs-list tbody').on('click', '.delete-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var token = $(this).attr('livreurs-id');

        // console.log( token );
        var name_delivrer = $('#livreurs-list tbody .'+token+' .name_delivrer').html();

        $("#form-delete-livreurs :input[name='name_delivrer']").val(name_delivrer);
        $("#form-delete-livreurs :input[name='token']").val(token);
        $("#form-delete-livreurs :input[name='password']").val('');

        $('#modal-delete-livreurs').modal('show');
        
        return false;
    });

    //validation du formulaire de suppression du client
    $('#form-delete-livreurs').on('submit',function(e){
        e.preventDefault();
        var url_process = $('#linkToWebroot').html()+$('#linkToDeleteElement').html()
        var self = $(this);
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');
        var delete_data = $(this).serialize();
        delete_element_default( delete_data, self, url_process );
    });

    /*Function de suppression d'élément*/
    function delete_element_default(delete_data, self, url_process){
        // console.log(delete_product_data);       
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url_process,
            data: delete_data,
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
               //Arrete le spinner du boutnon de validation du formulaire
                self.find("#confirm_btn").removeClass('disabled');
                self.find("#confirm_btn").removeClass('running');
                    
                var password = '';
                self.find(":input[name='password']").val(password);
                $('.modal').modal('hide');

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    //supprimer la ligne de la categorie
                    $(" tbody ."+data.token).fadeOut(700);
                  }
                });
            },
            error: function(jqXHR) {
              self.find("#confirm_btn").removeClass('disabled');
              self.find("#confirm_btn").removeClass('running');  
              console.log(jqXHR.responseText);
              if( jqXHR.responseJSON.error_html ){
                $('.errorForm ').html(jqXHR.responseJSON.error_html);
              }

            }
        });

    }

    /*Function de suppression d'élément*/
    function delete_mails(delete_data, url_process){
        // console.log(delete_product_data);       
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url_process,
            data: delete_data,
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    //actualiser la page
                    window.location.replace(data.linkToList);
                  }
                });
            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( jqXHR.responseJSON.error_html ){
                $('.errorForm ').html(jqXHR.responseJSON.error_html);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    //supprimer la ligne de la categorie
                    // $(" tbody ."+data.token).fadeOut(700);
                  }
                });
              }

            }
        });

    }

//validation du formulaire de recherche de stocks
    $('.livreurs_search_form').on('submit', function (e) {
        e.preventDefault();
        console.log( $(this).serialize() );
        var linkToSearchElements = $('#linkToWebroot').html()+$('#linkToGetElement').html()
        console.log( linkToSearchElements );
        $(this).find("#confirm_filter").addClass('disabled');
        $(this).find("#confirm_filter").addClass('running');
        var self = $(this);
        ///name_supplier&/tel&        
        search_elements( $(this).serialize(), self, linkToSearchElements );

        var start_date = $(this).find(" :input[name='start_date']").val();
        var start_hour = $(this).find(" :input[name='start_hour']").val();
        var end_date = $(this).find(" :input[name='end_date']").val();
        var end_hour = $(this).find(" :input[name='end_hour']").val();
        var tel = $(this).find(" :input[name='tel']").val();
        var name_supplier = $(this).find(" :input[name='name_delivrer']").val();
                       // filter-data-montant="" filter-data-nameProduct="" filter-data-nameSupplier=""
        $('#fournisseurs-list').attr('filter-data-startDate', start_date);
        $('#fournisseurs-list').attr('filter-data-startHour', start_hour);
        $('#fournisseurs-list').attr('filter-data-endDate', end_date);
        $('#fournisseurs-list').attr('filter-data-endHour', end_hour);
        $('#fournisseurs-list').attr('filter-data-tel', tel);
        $('#fournisseurs-list').attr('filter-data-nameDelivrer', name_supplier);
        // console.log( sexe );
        return false;

    });    
    
    //pagination de liste clients
    $('#list-livreurs-pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        var linkToSearchElements = $('#linkToWebroot').html()+$('#linkToGetElement').html()
        var numero = $(this).attr('href');
        // console.log(numero);
        var start_date = $('#livreurs-list').attr('filter-data-startDate');
        var start_hour = $('#livreurs-list').attr('filter-data-startHour');
        var end_date = $('#livreurs-list').attr('filter-data-endDate');
        var end_hour = $('#livreurs-list').attr('filter-data-endHour');
        var montant = $('#livreurs-list').attr('filter-data-tel');
        var name_delivrer = $('#livreurs-list').attr('filter-data-nameDelivrer');
        var pagination = true;        

        var dataFilter = {start_date:start_date,start_hour:start_hour,end_date:end_date,end_hour:end_hour,pagination:pagination,
            tel:tel,name_delivrer:name_delivrer,number_page_running:numero};
        
        if( !isNaN( parseInt(numero) ) ){
            search_livreurs(dataFilter, 'pagination', linkToSearchElements);      
        }
        //$(".cmd_search_form :input[name='number_page_running']").val(numero);
        $('#livreurs-list').attr('filter-data-pageRunning', numero);
        return false;
    });
    
    //rechercher stock avec ajax
    function search_elements(filter_data, self, linkToSearchElements){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToSearchElements,
            data: filter_data,
            success: function (data, textStatus, jqXHR) {
               
               $(' tbody ').hide().html( data.result.html_list_elements ).fadeIn(700);
               $(' .pagination ').hide().html( data.result.html_pagination ).fadeIn(700); 
               // console.log(data);
               if(!filter_data.pagination){
                    
                    if( self.find("#confirm_filter").hasClass('disabled') ){
                        self.find("#confirm_filter").removeClass('disabled');
                        self.find("#confirm_filter").removeClass('running');
                    }
                    $('.total').hide().html( data.result.stat.total.nbre ).fadeIn(1000);
                    // $('.total_nbre').hide().html( data.result.stat.nbre ).fadeIn(1000);

                    if( typeof data.result.stat.actifs !== 'undefined'  ){
                        $('.actifs').hide().html( data.result.stat.actifs ).fadeIn(1000);
                    }
                    if( typeof data.result.stat.non_actifs !== 'undefined'  ){
                        $('.non_actifs').hide().html( data.result.stat.non_actifs ).fadeIn(1000);
                    }
                    if( typeof data.result.stat.no_order !== 'undefined'  ){
                        $('.no_order').hide().html( data.result.stat.no_order ).fadeIn(1000);
                    }
               } 
               
               $('#extract-excel-btn').attr('href', data.result.link_for_extract);
               $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

            },
            error: function(jqXHR) {
                console.log(jqXHR.responseText);
                if( self.find("#confirm_filter").hasClass('disabled') ){
                    self.find("#confirm_filter").removeClass('disabled');
                    self.find("#confirm_filter").removeClass('running');
                }

                if( typeof jqXHR.responseJSON['error_html'] !== 'undefined' ){
                    $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                }

            }
        });
    }

    //form d'ajout de produit
    $('.delivrer_add_form').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);

        var url_process = $('#linkToWebroot').html()+$('#linkToGetElement').html()

        console.log( $(this).serialize() );
        console.log( url_process );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        add_element_default( $(this).serialize(), self, url_process );

        return false;

    });

    function add_element_default( add_data, self, url_process ){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url_process,
            data: add_data,
            success: function (data, textStatus, jqXHR) {
                self.find("#confirm_btn").removeClass('disabled');
                self.find("#confirm_btn").removeClass('running');
                // self[0].reset();
                console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToList);
                  }
                });
            },
            error: function(jqXHR) {
                console.log(jqXHR.responseText);
                self.find("#confirm_btn").removeClass('disabled');
                self.find("#confirm_btn").removeClass('running'); 
                // $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                if( typeof jqXHR.responseJSON['error_html'] !== 'undefined' ){
                    $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                }
            }
        });
    }

//form modification categories
    $('.delivrer_update_form').on('submit', function (e) {
        e.preventDefault();
        var url_process = $('#linkToWebroot').html()+$('#linkToGetElement').html()
        var self = $(this);

        console.log( $(this).serialize() );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        update_element_default( $(this).serialize(), self, url_process );
        return false;
    });

    //function de modification categories
    function update_element_default(add_data, self, url_process){
        // console.log( add_data );
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url_process,
            data: add_data,
            success: function (data, textStatus, jqXHR) {
                // $('.product_update_form')[0].reset();
                if( self.find("#confirm_btn").hasClass('disabled') ){
                    self.find("#confirm_btn").removeClass('disabled');
                    self.find("#confirm_btn").removeClass('running');
                }
                console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToList);
                  }
                });
            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( self.find("#confirm_btn").hasClass('disabled') ){
                    self.find("#confirm_btn").removeClass('disabled');
                    self.find("#confirm_btn").removeClass('running');
                }
              if( typeof jqXHR.responseJSON['error_html'] !== 'undefined' ){
                    $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                }
            }
        });
    }

    /**ENDNG delivrer PROCESS**/


    /**BEGIN SUPPLIER TRAITMENT**/
    //Cliquer sur le bouton pour supprimer un stock
    $('#fournisseurs-list tbody').on('click', '.delete-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var token = $(this).attr('fournisseurs-id');

        // console.log( token );
        var name_supplier = $('#fournisseurs-list tbody .'+token+' .name_supplier').html();

        $("#form-delete-fournisseurs :input[name='name_supplier']").val(name_supplier);
        $("#form-delete-fournisseurs :input[name='token']").val(token);
        $("#form-delete-fournisseurs :input[name='password']").val('');

        $('#modal-delete-fournisseurs').modal('show');
        
        return false;
    });

    //validation du formulaire de suppression du client
    $('#form-delete-fournisseurs').on('submit',function(e){
        e.preventDefault();
        var self = $(this);
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');
        var delete_data = $(this).serialize();
        delete_supplier( delete_data, self );
    });

    /*Function rejet de commande*/
    function delete_supplier(delete_data, self){
        // console.log(delete_product_data);       
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToDeleteSupplier,
            data: delete_data,
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
               //Arrete le spinner du boutnon de validation du formulaire
                self.find("#confirm_btn").removeClass('disabled');
                self.find("#confirm_btn").removeClass('running');
                    
                var password = '';
                self.find(":input[name='password']").val(password);
                $('#modal-delete-fournisseurs').modal('hide');
                $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    //supprimer la ligne de la categorie
                    $("#fournisseurs-list tbody ."+data.token).fadeOut(700);
                  }
                });
            },
            error: function(jqXHR) {
              self.find("#confirm_btn").removeClass('disabled');
              self.find("#confirm_btn").removeClass('running');  
              console.log(jqXHR.responseText);
              if( jqXHR.responseJSON.error_html ){
                $('.errorForm ').html(jqXHR.responseJSON.error_html);
              }

            }
        });

    }

    //form modification categories
    $('.supplier_update_form').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);

        console.log( $(this).serialize() );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        update_supplier( $(this).serialize(), self );
        return false;
    });

    //function de modification categories
    function update_supplier(add_data, self){
        // console.log( add_data );
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToUpdateSupplier,
            data: add_data,
            success: function (data, textStatus, jqXHR) {
                // $('.product_update_form')[0].reset();
                if( self.find("#confirm_btn").hasClass('disabled') ){
                    self.find("#confirm_btn").removeClass('disabled');
                    self.find("#confirm_btn").removeClass('running');
                }
                console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToList);
                  }
                });
            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( self.find("#confirm_btn").hasClass('disabled') ){
                    self.find("#confirm_btn").removeClass('disabled');
                    self.find("#confirm_btn").removeClass('running');
                }
              if( typeof jqXHR.responseJSON['error_html'] !== 'undefined' ){
                    $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                }
            }
        });
    }
    
    //form d'ajout de produit
    $('.supplier_add_form').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);

        console.log( $(this).serialize() );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        add_supplier( $(this).serialize(), self );

        return false;

    });

    function add_supplier(add_data, self){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToAddFournisseur,
            data: add_data,
            success: function (data, textStatus, jqXHR) {
                self.find("#confirm_btn").removeClass('disabled');
                self.find("#confirm_btn").removeClass('running');
                // self[0].reset();
                console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToList);
                  }
                });
            },
            error: function(jqXHR) {
                console.log(jqXHR.responseText);
                self.find("#confirm_btn").removeClass('disabled');
                self.find("#confirm_btn").removeClass('running'); 
                // $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                if( typeof jqXHR.responseJSON['error_html'] !== 'undefined' ){
                    $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                }
            }
        });
    }

    //validation du formulaire de recherche de stocks
    $('.fournisseurs_search_form').on('submit', function (e) {
        e.preventDefault();
        console.log( $(this).serialize() );
        $(this).find("#confirm_filter").addClass('disabled');
        $(this).find("#confirm_filter").addClass('running');
        var self = $(this);
        ///name_supplier&/tel&        
        search_fournisseurs( $(this).serialize(), self );

        var start_date = $(this).find(" :input[name='start_date']").val();
        var start_hour = $(this).find(" :input[name='start_hour']").val();
        var end_date = $(this).find(" :input[name='end_date']").val();
        var end_hour = $(this).find(" :input[name='end_hour']").val();
        var tel = $(this).find(" :input[name='tel']").val();
        var name_supplier = $(this).find(" :input[name='name_supplier']").val();
                       // filter-data-montant="" filter-data-nameProduct="" filter-data-nameSupplier=""
        $('#fournisseurs-list').attr('filter-data-startDate', start_date);
        $('#fournisseurs-list').attr('filter-data-startHour', start_hour);
        $('#fournisseurs-list').attr('filter-data-endDate', end_date);
        $('#fournisseurs-list').attr('filter-data-endHour', end_hour);
        $('#fournisseurs-list').attr('filter-data-tel', tel);
        $('#fournisseurs-list').attr('filter-data-nameSupplier', name_supplier);
        // console.log( sexe );
        return false;

    });    
    
    //pagination de liste clients
    $('#list-fournisseurs-pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        var numero = $(this).attr('href');
        // console.log(numero);
        var start_date = $('#fournisseurs-list').attr('filter-data-startDate');
        var start_hour = $('#fournisseurs-list').attr('filter-data-startHour');
        var end_date = $('#fournisseurs-list').attr('filter-data-endDate');
        var end_hour = $('#fournisseurs-list').attr('filter-data-endHour');
        var montant = $('#fournisseurs-list').attr('filter-data-tel');
        var name_supplier = $('#fournisseurs-list').attr('filter-data-nameSupplier');
        var pagination = true;        

        var dataFilter = {start_date:start_date,start_hour:start_hour,end_date:end_date,end_hour:end_hour,pagination:pagination,
            tel:tel,name_supplier:name_supplier,number_page_running:numero};
        
        if( !isNaN( parseInt(numero) ) ){é
            search_fournisseurs(dataFilter, 'pagination');      
        }
        //$(".cmd_search_form :input[name='number_page_running']").val(numero);
        $('#fournisseurs-list').attr('filter-data-pageRunning', numero);
        return false;
    });
    
    //rechercher stock avec ajax
    function search_fournisseurs(filter_data, self){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToSearchFournisseurs,
            data: filter_data,
            success: function (data, textStatus, jqXHR) {
               
               $(' #fournisseurs-list tbody ').hide().html( data.result.html_list_elements ).fadeIn(700);
               $(' #list-fournisseurs-pagination ').hide().html( data.result.html_pagination ).fadeIn(700); 
               console.log(data);
               if(!filter_data.pagination){
                    
                    if( self.find("#confirm_filter").hasClass('disabled') ){
                        self.find("#confirm_filter").removeClass('disabled');
                        self.find("#confirm_filter").removeClass('running');
                    }
                    $('.total').hide().html( data.result.stat.total.nbre ).fadeIn(1000);
                    // $('.total_nbre').hide().html( data.result.stat.nbre ).fadeIn(1000);
               } 
               
               $('#extract-excel-btn').attr('href', data.result.link_for_extract);
               $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

            },
            error: function(jqXHR) {
                console.log(jqXHR.responseText);
                if( self.find("#confirm_filter").hasClass('disabled') ){
                    self.find("#confirm_filter").removeClass('disabled');
                    self.find("#confirm_filter").removeClass('running');
                }

                if( typeof jqXHR.responseJSON['error_html'] !== 'undefined' ){
                    $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                }

            }
        });
    }

    /**ENDING SUPPLIER TRAITMENT**/





    //form d'ajout de produit
    $('.stocks_add_form').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);

        console.log( $(this).serialize() );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        add_stock( $(this).serialize(), self );

        return false;

    });

    function add_stock(add_data, self){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToAddStock,
            data: add_data,
            success: function (data, textStatus, jqXHR) {
                self.find("#confirm_btn").removeClass('disabled');
              self.find("#confirm_btn").removeClass('running');
                // self[0].reset();
                console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToList);
                  }
                });
            },
            error: function(jqXHR) {
                console.log(jqXHR.responseText);
                self.find("#confirm_btn").removeClass('disabled');
              self.find("#confirm_btn").removeClass('running'); 
                // $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                if( typeof jqXHR.responseJSON['error_html'] !== 'undefined' ){
                    $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                }
            },
            always: function(jqXHR) {
              self.find("#confirm_btn").removeClass('disabled');
              self.find("#confirm_btn").removeClass('running');
            }
        });
    }

    //validation du formulaire de recherche de stocks
    $('.stocks_search_form').on('submit', function (e) {
        e.preventDefault();
        console.log( $(this).serialize() );
        $(this).find("#confirm_filter").addClass('disabled');
        $(this).find("#confirm_filter").addClass('running');
        var self = $(this);
                
        search_stocks( $(this).serialize(), self );

        var start_date = $(this).find(" :input[name='start_date']").val();
        var start_hour = $(this).find(" :input[name='start_hour']").val();
        var end_date = $(this).find(" :input[name='end_date']").val();
        var end_hour = $(this).find(" :input[name='end_hour']").val();
        var montant = $(this).find(" :input[name='montant']").val();
        var name_product = $(this).find(" :input[name='name_product']").val();
        var name_supplier = $(this).find(" :input[name='name_supplier']").val();
                       // filter-data-montant="" filter-data-nameProduct="" filter-data-nameSupplier=""
        $('#stocks-list').attr('filter-data-startDate', start_date);
        $('#stocks-list').attr('filter-data-startHour', start_hour);
        $('#stocks-list').attr('filter-data-endDate', end_date);
        $('#stocks-list').attr('filter-data-endHour', end_hour);
        $('#stocks-list').attr('filter-data-montant', montant);
        $('#stocks-list').attr('filter-data-nameProduct', name_product);
        $('#stocks-list').attr('filter-data-nameSupplier', name_supplier);
        // console.log( sexe );
        return false;

    });

    //pagination de liste clients
    $('#list-stocks-pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        var numero = $(this).attr('href');
        // console.log(numero);

        var start_date = $('#stocks-list').attr('filter-data-startDate');
        var start_hour = $('#stocks-list').attr('filter-data-startHour');
        var end_date = $('#stocks-list').attr('filter-data-endDate');
        var end_hour = $('#stocks-list').attr('filter-data-endHour');
        var montant = $('#stocks-list').attr('filter-data-montant');
        var name_product = $('#stocks-list').attr('filter-data-nameProduct');
        var name_supplier = $('#stocks-list').attr('filter-data-nameSupplier');
        var pagination = true;        

        var dataFilter = {start_date:start_date,start_hour:start_hour,end_date:end_date,end_hour:end_hour,pagination:pagination,
            montant:montant,name_product:name_product,name_supplier:name_supplier,number_page_running:numero};
        
        if( !isNaN( parseInt(numero) ) ){
            search_stocks(dataFilter, 'pagination');      
        }
        //$(".cmd_search_form :input[name='number_page_running']").val(numero);
        $('#order-list').attr('filter-data-pageRunning', numero);
        return false;
    });
    
    //rechercher stock avec ajax
    function search_stocks(filter_data, self){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToSearchStocks,
            data: filter_data,
            success: function (data, textStatus, jqXHR) {
               
               $(' #stocks-list tbody ').hide().html( data.result.html_list_stocks ).fadeIn(700);
               $(' #list-stocks-pagination ').hide().html( data.result.html_pagination ).fadeIn(700); 
               console.log(data);
               if(!filter_data.pagination){
                    
                    if( self.find("#confirm_filter").hasClass('disabled') ){
                        self.find("#confirm_filter").removeClass('disabled');
                        self.find("#confirm_filter").removeClass('running');
                    }
                    $('.total_montant').hide().html( data.result.stat.montant ).fadeIn(1000);
                    $('.total_nbre').hide().html( data.result.stat.nbre ).fadeIn(1000);
               } 
               
               $('#extract-excel-btn').attr('href', data.result.link_for_extract);
               $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

            },
            error: function(jqXHR) {
                console.log(jqXHR.responseText);
                if( self.find("#confirm_filter").hasClass('disabled') ){
                    self.find("#confirm_filter").removeClass('disabled');
                    self.find("#confirm_filter").removeClass('running');
                }

                if( typeof jqXHR.responseJSON['error_html'] !== 'undefined' ){
                    $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                }

            }
        });
    }

    //form modification categories
    $('.stocks_update_form').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);

        console.log( $(this).serialize() );
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');

        update_stocks( $(this).serialize(), self );
        return false;
    });

    //function de modification categories
    function update_stocks(add_data, self){
        // console.log( add_data );
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToUpdateStock,
            data: add_data,
            success: function (data, textStatus, jqXHR) {
                // $('.product_update_form')[0].reset();
                if( self.find("#confirm_btn").hasClass('disabled') ){
                    self.find("#confirm_btn").removeClass('disabled');
                    self.find("#confirm_btn").removeClass('running');
                }
                console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToList);
                  }
                });

            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( self.find("#confirm_btn").hasClass('disabled') ){
                    self.find("#confirm_btn").removeClass('disabled');
                    self.find("#confirm_btn").removeClass('running');
                }
              if( typeof jqXHR.responseJSON['error_html'] !== 'undefined' ){
                    $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
                }

            },
            complete: function(jqXHR){
                 
            }
        });
    }

    //Cliquer sur le bouton pour supprimer un stock
    $('#stocks-list tbody').on('click', '.delete-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var token = $(this).attr('stock-id');

        console.log( token );
        var produit = $('#stocks-list tbody .'+token+' .produit').html();
        var qtte = $('#stocks-list tbody .'+token+' .qtte').html();
        var unite = $('#stocks-list tbody .'+token+' .unite').html();

        $("#form-delete-stock :input[name='product_name']").val(produit);
        $("#form-delete-stock :input[name='qtte']").val(qtte);
        $("#form-delete-stock :input[name='unite']").val(unite);
        $("#form-delete-stock :input[name='token']").val(token);
        $("#form-delete-stock :input[name='password']").val('');

        $('#modal-delete-stock').modal('show');
        
        return false;
    });

    //validation du formulaire de suppression du client
    $('#form-delete-stock').on('submit',function(e){
        e.preventDefault();
        var self = $(this);
        $(this).find("#confirm_btn").addClass('disabled');
        $(this).find("#confirm_btn").addClass('running');
        var delete_data = $(this).serialize();
        delete_stock( delete_data, self );
    });

    /*Function rejet de commande*/
    function delete_stock(delete_data, self){
        // console.log(delete_product_data);       
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToDeleteStock,
            data: delete_data,
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
               //Arrete le spinner du boutnon de validation du formulaire
                self.find("#confirm_btn").removeClass('disabled');
                self.find("#confirm_btn").removeClass('running');
                    
                var password = '';
                self.find(":input[name='password']").val(password);
                $('#modal-delete-stock').modal('hide');
                $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    //supprimer la ligne de la categorie
                    $("#stocks-list tbody ."+data.token).fadeOut(700);
                  }
                });
            },
            error: function(jqXHR) {
              self.find("#confirm_btn").removeClass('disabled');
              self.find("#confirm_btn").removeClass('running');  
              console.log(jqXHR.responseText);
              if( jqXHR.responseJSON.error_html ){
                $('.errorForm ').html(jqXHR.responseJSON.error_html);
              }

            }
        });

    }
    

    /**ENDING STOCK TRAITMENT**/







    /***BEGIN CLIENTS TRAITMENT***/
    $('.clients_search_form').on('submit', function (e) {
        e.preventDefault();
        console.log( $(this).serialize() );
        $("#cmd_search_form_btn").addClass('disabled');
        $("#cmd_search_form_btn").addClass('running');
                
        search_clients( $(this).serialize() );

        var start_date = $(".clients_search_form :input[name='start_date']").val();
        var start_hour = $(".clients_search_form :input[name='start_hour']").val();
        var end_date = $(".clients_search_form :input[name='end_date']").val();
        var end_hour = $(".clients_search_form :input[name='end_hour']").val();
        var nom = $(".clients_search_form :input[name='nom']").val();
        var prenoms = $(".clients_search_form :input[name='prenoms']").val();
        var client_id = $(".clients_search_form :input[name='client_id']").val();
        var tel = $(".clients_search_form :input[name='tel']").val();
        var status = $(".clients_search_form :input[name='status']").val();
        var sexe = $(".clients_search_form :input[name='sexe']").val();
                       
        $('#clients-list').attr('filter-data-startDate', start_date);
        $('#clients-list').attr('filter-data-startHour', start_hour);
        $('#clients-list').attr('filter-data-endDate', end_date);
        $('#clients-list').attr('filter-data-endHour', end_hour);
        $('#clients-list').attr('filter-data-telUser', tel);
        $('#clients-list').attr('filter-data-clientId', client_id);
        $('#clients-list').attr('filter-data-name', nom);
        $('#clients-list').attr('filter-data-lastname', prenoms);
        $('#clients-list').attr('filter-data-sexe', sexe);
        $('#clients-list').attr('filter-data-status', status);
        console.log( sexe );
        return false;

    });

    //pagination de liste clients
    $('#list-clients-pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        var numero = $(this).attr('href');
        // console.log(numero);

        var start_date = $('#clients-list').attr('filter-data-startDate');
        var start_hour = $('#clients-list').attr('filter-data-startHour');
        var end_date = $('#clients-list').attr('filter-data-endDate');
        var end_hour = $('#clients-list').attr('filter-data-endHour');
        var tel = $('#clients-list').attr('filter-data-telUser');
        var client_id = $('#clients-list').attr('filter-data-clientId');
        var nom = $('#clients-list').attr('filter-data-name');
        var prenoms = $('#clients-list').attr('filter-data-lastname');
        var sexe = $('#clients-list').attr('filter-data-sexe');
        var status = $('#clients-list').attr('filter-data-status');
        var pagination = true;        

        var dataFilter = {start_date:start_date,start_hour:start_hour,end_date:end_date,end_hour:end_hour,pagination:pagination,
            tel:tel,client_id:client_id,nom:nom,prenoms:prenoms,sexe:sexe,status:status,number_page_running:numero};
        
        if( !isNaN( parseInt(numero) ) ){
            search_clients(dataFilter);      
        }
        //$(".cmd_search_form :input[name='number_page_running']").val(numero);
        $('#order-list').attr('filter-data-pageRunning', numero);
        return false;
    });
    
    //rechercher client avec ajax
    function search_clients(filter_data){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToSearchClients,
            data: filter_data,
            success: function (data, textStatus, jqXHR) {
               
               $(' #clients-list tbody ').hide().html( data.result.html_list_clients ).fadeIn(700);
               $(' #list-clients-pagination ').hide().html( data.result.html_pagination ).fadeIn(700); 
               console.log(data);
               if(!filter_data.pagination){
                    
                    if( $("#cmd_search_form_btn").hasClass('disabled') ){
                        $("#cmd_search_form_btn").removeClass('disabled');
                        $("#cmd_search_form_btn").removeClass('running');
                    }
                    $('.total').hide().html( data.result.infos.total ).fadeIn(1000);
                    $('.actifs').hide().html( data.result.infos.actifs ).fadeIn(1000);
                    $('.non_actifs').hide().html( data.result.infos.non_actifs ).fadeIn(1000);
               } 
               
               $('#extract-excel-btn').attr('href', data.result.link_for_extract);
               $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( $("#cmd_search_form_btn").hasClass('disabled') ){
                    $("#cmd_search_form_btn").removeClass('disabled');
                    $("#cmd_search_form_btn").removeClass('running');
               }  
              
              $('#errorForm').prepend(jqXHR.responseJSON['error_html']);


            }
        });
    }

    //Cliquer sur le bouton pour rejetter un client
    $('#clients-list tbody').on('click', '.set-rejected-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var client_id = $(this).attr('clients-id');

        console.log( client_id );
        var nom = $('#clients-list tbody .'+client_id+' .nom').html();
        var prenom = $('#clients-list tbody .'+client_id+' .prenom').html();
        // var client_id = $('#clients-list tbody .'+client_id+' .token').html();

        $("#form-reject-clients :input[name='nom']").val(nom);
        $("#form-reject-clients :input[name='prenom']").val(prenom);
        // $("#form-reject-clients :input[name='cmd_montant_ttc']").val(montant_ttc);
        $("#form-reject-clients :input[name='client_id']").val(client_id);

        $('#modal-reject-clients').modal('show');
        
        return false;
    });

    //validation du formulaire de rejet du client
    $('#form-reject-clients').on('submit',function(e){
        e.preventDefault();
        $("#modal-reject-clients-confirm-btn").addClass('disabled');
        $("#modal-reject-clients-confirm-btn").addClass('running');
        var reject_clients_data = $(this).serialize();
        // console.log( reject_order_data );
        reject_clients( reject_clients_data );
    });

    /*Function rejet de client*/
    function reject_clients( reject_clients_data ){
        // console.log(reject_order_data);        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToRejectClients,
            data: reject_clients_data,
            success: function (data, textStatus, jqXHR) {
               console.log(data);
                //mettre a jour l'intitulé du statut de la commande
               $('#clients-list tbody .'+data.client_id+' .statut').html('NON ACTIF');

                //mettre a jour les bouton d'actions
                //supprimer bouton desactiver
                $("#clients-list tbody ."+data.client_id+" .set-shipping-btn").remove();

                //remplacer bouton "desactiver" par "reactiver le client"
                $("#clients-list tbody ."+data.client_id+" .set-rejected-btn").attr('data-original-title', 'Reactiver le client');
                $("#clients-list tbody ."+data.client_id+" .set-rejected-btn").html('<i class="md md-settings-backup-restore"></i>');
                //palce la classe permetant de selectionner l'action d'arreter une livraison
                $("#clients-list tbody ."+data.client_id+" .set-rejected-btn").addClass('set-restore-btn');
                $("#clients-list tbody ."+data.client_id+" .set-rejected-btn").removeClass('set-rejected-btn');

                //Arrete le spinner du boutnon de validation du formulaire
                $("#modal-reject-clients-confirm-btn").removeClass('disabled');
                $("#modal-reject-clients-confirm-btn").removeClass('running');
                //cacher la fenetre modal du formulaire du rejet
                $('#modal-reject-clients').modal('hide');
                $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    $("#clients-list tbody ."+data.client_id).fadeOut(250).fadeIn(250).fadeOut(250).fadeIn(250);
                  }
                });
            },
            error: function(jqXHR) {
                console.log(jqXHR.responseText);                
                //Arrete le spinner du boutnon de validation du formulaire
                $("#modal-reject-clients-confirm-btn").removeClass('disabled');
                $("#modal-reject-clients-confirm-btn").removeClass('running');
                //cacher la fenetre modal du formulaire du rejet
                $('#modal-reject-clients').modal('hide');
              //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
                if(jqXHR.responseJSON){
                    //$('#confirm-order-modal').hide();
                    Swal({
                      type: 'error',
                      title: jqXHR.responseJSON.error_text,
                      text: jqXHR.responseJSON.error_text_second
                    });
                    //return html_status_initial;
                }

            }
        });

    }

    //Cliquer sur le bouton pour supprimer un client
    $('#clients-list tbody').on('click', '.delete-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var client_id = $(this).attr('clients-id');

        // console.log( client_id );
        var nom = $('#clients-list tbody .'+client_id+' .nom').html();
        var prenom = $('#clients-list tbody .'+client_id+' .prenom').html();
        // var client_id = $('#clients-list tbody .'+client_id+' .token').html();

        $("#form-delete-clients :input[name='nom']").val(nom);
        $("#form-delete-clients :input[name='prenom']").val(prenom);
        // $("#form-reject-clients :input[name='cmd_montant_ttc']").val(montant_ttc);
        $("#form-delete-clients :input[name='client_id']").val(client_id);
        $("#form-delete-clients :input[name='password']").val('');

        $('#modal-delete-clients').modal('show');
        
        return false;
    });

    //validation du formulaire de suppression du client
    $('#form-delete-clients').on('submit',function(e){
        e.preventDefault();
        var self = $(this);
        $(this).find("#modal-delete-confirm-btn").addClass('disabled');
        $(this).find("#modal-delete-confirm-btn").addClass('running');
        var delete_clients_data = $(this).serialize();
        // console.log( delete_clients_data );
        delete_clients( delete_clients_data, self );
    });

    /*Function rejet de commande*/
    function delete_clients(delete_clients_data, self){
        // console.log(delete_product_data);       
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToDeleteClients,
            data: delete_clients_data,
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
               //Arrete le spinner du boutnon de validation du formulaire
                self.find("#modal-delete-confirm-btn").removeClass('disabled');
                self.find("#modal-delete-confirm-btn").removeClass('running');
                    
                var password = '';
                self.find(":input[name='password']").val(password);
                $('#modal-delete-clients').modal('hide');
                $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    //supprimer la ligne de la categorie
                    $("#clients-list tbody ."+data.client_id).fadeOut(700);
                  }
                });
            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              self.find("#modal-delete-confirm-btn").removeClass('disabled');
              self.find("#modal-delete-confirm-btn").removeClass('running');
              if( jqXHR.responseJSON.error_html ){
                $('.errorForm ').html(jqXHR.responseJSON.error_html);
              }

            }
        });

    }


    //Cliquer sur le bouton pour reactiver un client
    $('#clients-list tbody').on('click', '.set-restore-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        //console.log(self);
        var client_id = $(this).attr('clients-id');
         Swal({
          title: 'Êtes vous sure ?',
          text: 'Vous vous apprêter à reactiver le client qui a pour Identifiant : '+client_id,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0aa89e',
          cancelButtonColor: '#d33',
          confirmButtonText: 'OK',
          cancelButtonText: 'Annuler'
        }).then((result) => {
          if (result.value) {
            //console.log(self);
            restore_clients(client_id, self);            
          }
        });        
        return false;
    });

    /*Function rejet de commande*/
    function restore_clients(client_id, self){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToRestoreClients,
            data: {client_id:client_id},
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
                //mettre a jour l'intitulé du statut de la commande
               $('#clients-list tbody .'+data.client_id+' .status').html('ACTIF');
               //  //mettre a jour les bouton d'actions
                    
                //remplacer bouton "arreter livraison" par "rejeter"
                $("#clients-list tbody ."+data.client_id+" .set-restore-btn").attr('data-original-title', 'Desactiver le client');
                $("#clients-list tbody ."+data.client_id+" .set-restore-btn").html('<i class="fa fa-times-circle-o"></i>');
                //Ajouter class pour laction du bouton
                $("#clients-list tbody ."+data.client_id+" .set-restore-btn").addClass('set-rejected-btn');
                $("#clients-list tbody ."+data.client_id+" .set-restore-btn").removeClass('set-restore-btn');
                $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    $("#clients-list tbody ."+data.client_id).fadeOut(250).fadeIn(250).fadeOut(250).fadeIn(250);
                  }
                });
            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
              if(jqXHR.responseJSON){
                    //$('#confirm-order-modal').hide();
                    Swal({
                      type: 'error',
                      title: jqXHR.responseJSON.error_text,
                      text: jqXHR.responseJSON.error_text_second
                    });
                    //return html_status_initial;
              }

            }
        });

    }

    /***END CLIENTS TRAITMENT***/


    /***BEGIN CATEGORY TRAITMENT***/
    //form recherche categories
    $('.category_search_form').on('submit', function (e) {
        e.preventDefault();
        console.log( $(this).serialize() );
        $("#cmd_search_form_btn").addClass('disabled');
        $("#cmd_search_form_btn").addClass('running');
                
        search_category( $(this).serialize() );

        var start_date = $(".category_search_form :input[name='start_date']").val();
        var start_hour = $(".category_search_form :input[name='start_hour']").val();
        var end_date = $(".category_search_form :input[name='end_date']").val();
        var end_hour = $(".category_search_form :input[name='end_hour']").val();
        var name_cotegory = $(".category_search_form :input[name='name_cotegory']").val();
        var status_cotegory = $(".category_search_form :input[name='status_cotegory']").val();

        $('#category-list').attr('filter-data-startDate', start_date);
        $('#category-list').attr('filter-data-startHour', start_hour);
        $('#category-list').attr('filter-data-endDate', end_date);
        $('#category-list').attr('filter-data-endHour', end_hour);
        $('#category-list').attr('filter-data-nameCategory', name_cotegory);
        $('#category-list').attr('filter-data-status', status_cotegory);
        console.log( status_cotegory );

        return false;

    });

    //console.log($('.pagination a .page-numbers'));
    $('#list-category-pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        var numero = $(this).attr('href');
        // console.log(numero);

        var start_date = $('#category-list').attr('filter-data-startDate');
        var start_hour = $('#category-list').attr('filter-data-startHour');
        var end_date = $('#category-list').attr('filter-data-endDate');
        var end_hour = $('#category-list').attr('filter-data-endHour');
        var name_cotegory = $('#category-list').attr('filter-data-nameCategory');
        var status_cotegory = $('#category-list').attr('filter-data-status');
        var pagination = true;        

        var dataFilter = {start_date:start_date,start_hour:start_hour,end_date:end_date,end_hour:end_hour,pagination:pagination,
            name_cotegory:name_cotegory,status_cotegory:status_cotegory,number_page_running:numero};
        
        if( !isNaN( parseInt(numero) ) ){
            search_category(dataFilter);      
        }
        //$(".cmd_search_form :input[name='number_page_running']").val(numero);
        $('#order-list').attr('filter-data-pageRunning', numero);
        return false;
    });
    
    //rechercher category produit avec ajax
    function search_category(filter_data){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToSearchCategory,
            data: filter_data,
            success: function (data, textStatus, jqXHR) {
               
               $(' #category-list tbody ').hide().html( data.result.html_list_categories ).fadeIn(500);
               $(' #list-category-pagination ').hide().html( data.result.html_pagination ).fadeIn(500); 
               // console.log(data);
               if(!filter_data.pagination){
                    
                    if( $("#cmd_search_form_btn").hasClass('disabled') ){
                        $("#cmd_search_form_btn").removeClass('disabled');
                        $("#cmd_search_form_btn").removeClass('running');
                    }
                    $('.total_category').hide().html( data.result.stat.total ).fadeIn(1000);
                    $('.total_category_actifs').hide().html( data.result.stat.categorie_actifs ).fadeIn(1000);
                    $('.total_category_non_actifs').hide().html( data.result.stat.categorie_non_actifs ).fadeIn(1000);
               } 
               
               $('#extract-excel-btn').attr('href', data.result.link_for_extract);
               $('[data-toggle="tooltip"]').tooltip(); //reinitialiser le tooltip

            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( $("#cmd_search_form_btn").hasClass('disabled') ){
                    $("#cmd_search_form_btn").removeClass('disabled');
                    $("#cmd_search_form_btn").removeClass('running');
               }  
              
              $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
            }
        });
    }

    //form d'ajout de produit
    $('.cotegory_add_form').on('submit', function (e) {
        e.preventDefault();
        var form = $('.cotegory_add_form')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        

        // var formdata = new FormData( this );
        console.log( formData );
        $("#add_category_btn").addClass('disabled');
        $("#add_category_btn").addClass('running');

        add_category( formData );

        return false;

    });

    function add_category(add_data){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToAddCategory,
            data: add_data,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function (data, textStatus, jqXHR) {
               if( $("#add_category_btn").hasClass('disabled') ){
                    $("#add_category_btn").removeClass('disabled');
                    $("#add_category_btn").removeClass('running');
                }
                $('.cotegory_add_form')[0].reset();
                // console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToList);
                  }
                });

            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( $("#add_category_btn").hasClass('disabled') ){
                    $("#add_category_btn").removeClass('disabled');
                    $("#add_category_btn").removeClass('running');
                }  
                $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
            }
        });
    }

    //form modification categories
    $('.cotegory_update_form').on('submit', function (e) {
        e.preventDefault();
        var form = $('.cotegory_update_form')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        console.log( formData );
        $("#update_category_btn").addClass('disabled');
        $("#update_category_btn").addClass('running');

        update_cotegory( formData );
        return false;
    });

    //function de modification categories
    function update_cotegory(add_data){
        // console.log( add_data );
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToUpdateCategory,
            data: add_data,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function (data, textStatus, jqXHR) {
               if( $("#update_category_btn").hasClass('disabled') ){
                        $("#update_category_btn").removeClass('disabled');
                        $("#update_category_btn").removeClass('running');
                }
                // $('.product_update_form')[0].reset();
                console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToList);
                  }
                });

            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( $("#update_category_btn").hasClass('disabled') ){
                    $("#update_category_btn").removeClass('disabled');
                    $("#update_category_btn").removeClass('running');
               }  
              
              $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
            }
        });
    }

    //AFFICHER MODAL POUR SUPPRIMER produit
    $('#category-list tbody ').on('click','.delete-category-btn',function(){
        
        var category_id = $(this).attr('category-id');
        var name_category = $('#category-list tbody .'+category_id+' .name_category').html();
        // console.log( stock_product );

        $("#form-delete-category :input[name='name_category']").val(name_category);
        $("#form-delete-category :input[name='category_id']").val(category_id);
        $("#form-delete-category :input[name='password']").val('');

        $('#modal-delete-category').modal('show');
              
    });

    //soumission de formulaire pour suppression de produit
    $('#form-delete-category').on('submit',function(e){
        e.preventDefault();
        $("#modal-delete-category-confirm-btn").addClass('disabled');
        $("#modal-delete-category-confirm-btn").addClass('running');
        var delete_category_data = $(this).serialize();
        // console.log( delete_category_data );
        delete_category(delete_category_data);
        return false;
    });

    /*Function rejet de commande*/
    function delete_category(delete_category_data){
        // console.log(delete_product_data);       
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToDeleteCategory,
            data: delete_category_data,
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
               //Arrete le spinner du boutnon de validation du formulaire
                $("#modal-delete-category-confirm-btn").removeClass('disabled');
                $("#modal-delete-category-confirm-btn").removeClass('running');
                    
                var password = '';
                $("#form-delete-category :input[name='password']").val(password);
                $('#modal-delete-category').modal('hide');

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    //supprimer la ligne de la categorie
                    $("#category-list tbody ."+data.category_id).fadeOut(700);
                  }
                });
            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              $("#modal-delete-category-confirm-btn").removeClass('disabled');
              $("#modal-delete-category-confirm-btn").removeClass('running');
              if( jqXHR.responseJSON.error_html !== 'undefined' ){
                $('.errorForm ').html(jqXHR.responseJSON.error_html);
              }
              
              // if(jqXHR.responseJSON.error === 'oui'){
              //       //$('#confirm-order-modal').hide();
              //       Swal({
              //         type: 'error',
              //         title: jqXHR.responseJSON.error_text,
              //         text: jqXHR.responseJSON.error_text_second
              //       });
              //       //return html_status_initial;
              // }

            }
        });

    }

    /***END CATEGORY TRAITMENT***/
    
    // /*** PRODUCT HANDLING ***/ //
    //AFFICHER MODAL POUR SUPPRIMER produit
    $('#product-list tbody ').on('click','.delete-product-btn',function(){
        
        var product_id = $(this).attr('product-id');
        var name_product = $('#product-list tbody .'+product_id+' .name_product').html();
        var stock_product = $('#product-list tbody .'+product_id+' .stock_product').html();
        // console.log( stock_product );

        $("#form-delete-product :input[name='product_id']").val(product_id);
        $("#form-delete-product :input[name='stock_product']").val(stock_product);
        $("#form-delete-product :input[name='name_product']").val(name_product);
        $("#form-delete-product :input[name='password']").val('');

        $('#modal-delete-product').modal('show');
              
    });

    //soumission de formulaire pour suppression de produit
    $('#form-delete-product').on('submit',function(e){
        e.preventDefault();
        $("#modal-delete-product-confirm-btn").addClass('disabled');
        $("#modal-delete-product-confirm-btn").addClass('running');
        var delete_product_data = $(this).serialize();
        console.log( delete_product_data );
        delete_product(delete_product_data);
    });

    /*Function rejet de commande*/
    function delete_product(delete_product_data){
        // console.log(delete_product_data);       
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToDeleteProduct,
            data: delete_product_data,
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
               //Arrete le spinner du boutnon de validation du formulaire
                    $("#modal-delete-product-confirm-btn").removeClass('disabled');
                    $("#modal-delete-product-confirm-btn").removeClass('running');
                    
                var password = '';
                $("#form-delete-product :input[name='password']").val(password);
                $('#modal-delete-product').modal('hide');

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    //supprimer la ligne de commande
                    $("#product-list tbody ."+data.product_id).fadeOut(700);
                  }
                });
            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              $("#modal-delete-product-confirm-btn").removeClass('disabled');
              $("#modal-delete-product-confirm-btn").removeClass('running');
              if( jqXHR.responseJSON.error_html !== 'undefined' ){
                $('.errorForm ').html(jqXHR.responseJSON.error_html);
              }
              
              // if(jqXHR.responseJSON.error === 'oui'){
              //       //$('#confirm-order-modal').hide();
              //       Swal({
              //         type: 'error',
              //         title: jqXHR.responseJSON.error_text,
              //         text: jqXHR.responseJSON.error_text_second
              //       });
              //       //return html_status_initial;
              // }

            }
        });

    }

    //form recherche commandes
    $('.product_update_form').on('submit', function (e) {
        e.preventDefault();
        var form = $('.product_update_form')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        console.log( formData );
        $("#update_product_btn").addClass('disabled');
        $("#update_product_btn").addClass('running');

        update_product( formData );

        return false;

    });

    //function de modification de produit
    function update_product(add_data){
        console.log( add_data );
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToUpdateProduct,
            data: add_data,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function (data, textStatus, jqXHR) {
               if( $("#update_product_btn").hasClass('disabled') ){
                        $("#update_product_btn").removeClass('disabled');
                        $("#update_product_btn").removeClass('running');
                }
                // $('.product_update_form')[0].reset();
                console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToProductList);
                  }
                });

            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( $("#update_product_btn").hasClass('disabled') ){
                    $("#update_product_btn").removeClass('disabled');
                    $("#update_product_btn").removeClass('running');
               }  
              
              $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
            }
        });
    }

    //form d'ajout de produit
    $('.product_add_form').on('submit', function (e) {
        e.preventDefault();
        var form = $('.product_add_form')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        

        // var formdata = new FormData( this );
        console.log( formData );
        $("#add_product_btn").addClass('disabled');
        $("#add_product_btn").addClass('running');

        add_product( formData );

        return false;

    });

    function add_product(add_data){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToAddProduct,
            data: add_data,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function (data, textStatus, jqXHR) {
               if( $("#add_product_btn").hasClass('disabled') ){
                        $("#add_product_btn").removeClass('disabled');
                        $("#add_product_btn").removeClass('running');
                }
                $('.product_add_form')[0].reset();
                console.log(data);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    window.location.replace(data.linkToProductList);
                  }
                });

            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( $("#add_product_btn").hasClass('disabled') ){
                    $("#add_product_btn").removeClass('disabled');
                    $("#add_product_btn").removeClass('running');
               }  
              
              // $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
            }
        });
    }

    //form recherche produits
    $('.product_search_form').on('submit', function (e) {
        e.preventDefault();
        console.log( $(this).serialize() );
        $("#cmd_search_form_btn").addClass('disabled');
        $("#cmd_search_form_btn").addClass('running');
                
        search_product( $(this).serialize() );

        var start_date = $(".product_search_form :input[name='start_date']").val();
        var start_hour = $(".product_search_form :input[name='start_hour']").val();
        var end_date = $(".product_search_form :input[name='end_date']").val();
        var end_hour = $(".product_search_form :input[name='end_hour']").val();
        var name_product = $(".product_search_form :input[name='name_product']").val();
        var category_product = $(".product_search_form :input[name='category_product']").val();
        var stock_product = $(".product_search_form :input[name='stock_product']").val();
        var unit_mesure = $(".product_search_form :input[name='unit_mesure']").val();
        var status_product = $(".product_search_form :input[name='status_product']").val();
        var promo_product = $(".product_search_form :input[name='promo_product']").val();
        var amount_product = $(".product_search_form :input[name='amount_product']").val();
        var number_page_running = $(".product_search_form :input[name='number_page_running']").val();

        $('#product-list').attr('filter-data-startDate', start_date);
        $('#product-list').attr('filter-data-startHour', start_hour);
        $('#product-list').attr('filter-data-endDate', end_date);
        $('#product-list').attr('filter-data-endHour', end_hour);
        $('#product-list').attr('filter-data-nameProduct', name_product);
        $('#product-list').attr('filter-data-categoryProduct', category_product);
        $('#product-list').attr('filter-data-stockProduct', stock_product);
        $('#product-list').attr('filter-data-unitMesure', unit_mesure);
        $('#product-list').attr('filter-data-statusProduct', status_product);
        $('#product-list').attr('filter-data-promoProduct', promo_product);
        $('#product-list').attr('filter-data-amountProduct', amount_product);
        $('#product-list').attr('filter-data-pageRunning', number_page_running);
        console.log( status_product );

        return false;

    });

    //console.log($('.pagination a .page-numbers'));
    $('#list-product-pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        var numero = $(this).attr('href');
        // console.log(numero);

        var start_date = $('#product-list').attr('filter-data-startDate');
        var start_hour = $('#product-list').attr('filter-data-startHour');
        var end_date = $('#product-list').attr('filter-data-endDate');
        var end_hour = $('#product-list').attr('filter-data-endHour');
        var name_product = $('#product-list').attr('filter-data-nameProduct');
        var category_product = $('#product-list').attr('filter-data-categoryProduct');
        var stock_product = $('#product-list').attr('filter-data-stockProduct');
       var unit_mesure = $('#product-list').attr('filter-data-unitMesure');
       var status_product = $('#product-list').attr('filter-data-statusProduct');
        var promo_product = $('#product-list').attr('filter-data-promoProduct');
       var amount_product = $('#product-list').attr('filter-data-amountProduct');
        var number_page_running = $('#product-list').attr('filter-data-pageRunning');
        var pagination = true;        

        var dataFilter = {start_date:start_date,start_hour:start_hour,end_date:end_date,end_hour:end_hour,pagination:pagination,
            name_product:name_product,category_product:category_product,stock_product:stock_product,unit_mesure:unit_mesure,
            status_product:status_product,promo_product:promo_product,amount_product:amount_product,number_page_running:numero,pagination:pagination,status:status};
        
        if( !isNaN( parseInt(numero) ) ){
            // console.log(dataFilter);
            search_product(dataFilter);      
        }
        //$(".cmd_search_form :input[name='number_page_running']").val(numero);
        $('#order-list').attr('filter-data-pageRunning', numero);
        return false;
    });
    
    function search_product(filter_data){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToSearchProducts,
            data: filter_data,
            success: function (data, textStatus, jqXHR) {
               
               $(' #product-list tbody ').html( data.result.html_list_cmd );
               $(' #list-product-pagination ').html( data.result.html_pagination ); 
               // console.log(data);
               if(!filter_data.pagination){
                    
                    if( $("#cmd_search_form_btn").hasClass('disabled') ){
                        $("#cmd_search_form_btn").removeClass('disabled');
                        $("#cmd_search_form_btn").removeClass('running');
                    }
                    $('.total_produit').hide().html( data.result.stat.total ).fadeIn(1000);
                    $('.total_produit_stock_off').hide().html( data.result.stat.produits_stock_off ).fadeIn(1000);
                    $('.total_never_cmd').hide().html( data.result.stat.produits_non_cmd ).fadeIn(1000);
                    $('.total_non_actif').hide().html( data.result.stat.produits_non_actif ).fadeIn(1000);
               } 
               
               $('#extract-excel-btn').attr('href', data.result.link_for_extract);
               $('[data-toggle="tooltip"]').tooltip();

            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( $("#cmd_search_form_btn").hasClass('disabled') ){
                    $("#cmd_search_form_btn").removeClass('disabled');
                    $("#cmd_search_form_btn").removeClass('running');
               }  
              
              $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
            }
        });
    }

    
    // /*** FINISH PRODUCT HANDLING ***/ //
    /** START QUICK COMMANDE HANDLE*/
    //form recherche commandes
    $('.quick_cmd_search_form').on('submit', function (e) {
      e.preventDefault();
      console.log( $(this).serialize() );
      $("#cmd_search_form_btn").addClass('disabled');
      $("#cmd_search_form_btn").addClass('running');
              
      search_quick_orders( $(this).serialize() );

      // $('#list_produits').attr('product-data-display','true');
      var start_date = $(".cmd_search_form :input[name='start_date']").val();
      var start_hour = $(".cmd_search_form :input[name='start_hour']").val();
      var end_date = $(".cmd_search_form :input[name='end_date']").val();
      var end_hour = $(".cmd_search_form :input[name='end_hour']").val();
      var tel_user = $(".cmd_search_form :input[name='tel_user']").val();
      var cmd_amount = $(".cmd_search_form :input[name='cmd_amount']").val();
      var cmd_id = $(".cmd_search_form :input[name='cmd_id']").val();
      var status = $(".cmd_search_form :input[name='status']").val();
      var number_page_running = $(".cmd_search_form :input[name='number_page_running']").val();

      $('#order-list').attr('filter-data-startDate', start_date);
      $('#order-list').attr('filter-data-startHour', start_hour);
      $('#order-list').attr('filter-data-endDate', end_date);
      $('#order-list').attr('filter-data-endHour', end_hour);
      $('#order-list').attr('filter-data-telUser', tel_user);
      $('#order-list').attr('filter-data-cmdAmount', cmd_amount);
      $('#order-list').attr('filter-data-cmdId', cmd_id);
      $('#order-list').attr('filter-data-status', status);
      $('#order-list').attr('filter-data-pageRunning', number_page_running);
      console.log( start_date );

      return false;

  });

  /* Function pour rechercher les */
  function search_quick_orders(filter_data){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToSearchQuickOrders,
        data: filter_data,
        success: function (data, textStatus, jqXHR) {
           
           $(' #order-list tbody ').hide().html( data.result.html_list_cmd ).fadeIn(1000);
           $(' #list-cmd-pagination ').html( data.result.html_pagination ); 
           console.log(data);
           if(!filter_data.pagination){
                
                if( $("#cmd_search_form_btn").hasClass('disabled') ){
                    $("#cmd_search_form_btn").removeClass('disabled');
                    $("#cmd_search_form_btn").removeClass('running');
                }
                // $('.total_cmd_montant').hide().html( data.result.total_cmd.montant ).fadeIn(1000);
                $('.total_cmd_nbre').hide().html( data.result.total_cmd.nbre ).fadeIn(1000);

                $('.total_cmd_livrees_montant').hide().html( data.result.total_cmd_livrees.montant ).fadeIn(1000);
                $('.total_cmd_livrees_nbre').hide().html( data.result.total_cmd_livrees.nbre ).fadeIn(1000);

                // $('.total_cmd_pending_montant').hide().html( data.result.total_cmd_pending.montant ).fadeIn(1000);
                $('.total_cmd_pending_nbre').hide().html( data.result.total_cmd_pending.nbre ).fadeIn(1000);

                $('.total_cmd_on_road_montant').hide().html( data.result.total_cmd_on_road.montant ).fadeIn(1000);
                $('.total_cmd_on_road_nbre').hide().html( data.result.total_cmd_on_road.nbre ).fadeIn(1000);

                // $('.total_cmd_rejected_montant').hide().html( data.result.total_cmd_rejected.montant ).fadeIn(1000);
                $('.total_cmd_rejected_nbre').hide().html( data.result.total_cmd_rejected.nbre ).fadeIn(1000);


                // $('.total_produit_stock_off').hide().html( data.result.stat.produits_stock_off ).fadeIn(1000);
                // $('.total_never_cmd').hide().html( data.result.stat.produits_non_cmd ).fadeIn(1000);
                // $('.total_non_actif').hide().html( data.result.stat.produits_non_actif ).fadeIn(1000);
           }
           $('[data-toggle="tooltip"]').tooltip();
           
           $('#extract-excel-btn').attr('href', data.result.link_for_extract);

        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
          if( $("#cmd_search_form_btn").hasClass('disabled') ){
                $("#cmd_search_form_btn").removeClass('disabled');
                $("#cmd_search_form_btn").removeClass('running');
           }  
          
          $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
        }
    });
} 
    /** END QUICK COMMANDE HANDLE*/


    //form recherche commandes
    $('.cmd_search_form').on('submit', function (e) {
        e.preventDefault();
        console.log( $(this) );
        $("#cmd_search_form_btn").addClass('disabled');
        $("#cmd_search_form_btn").addClass('running');
                
        search_orders( $(this).serialize() );

        // $('#list_produits').attr('product-data-display','true');
        // var productDataOrder= $('#list_produits').attr('product-data-order'); // ordonnancement du plus... au moins...
        var start_date = $(".cmd_search_form :input[name='start_date']").val();
        var start_hour = $(".cmd_search_form :input[name='start_hour']").val();
        var end_date = $(".cmd_search_form :input[name='end_date']").val();
        var end_hour = $(".cmd_search_form :input[name='end_hour']").val();
        var tel_user = $(".cmd_search_form :input[name='tel_user']").val();
        var client_id = $(".cmd_search_form :input[name='client_id']").val();
        var cmd_amount = $(".cmd_search_form :input[name='cmd_amount']").val();
        var cmd_id = $(".cmd_search_form :input[name='cmd_id']").val();
        var status = $(".cmd_search_form :input[name='status']").val();
        var number_page_running = $(".cmd_search_form :input[name='number_page_running']").val();

        $('#order-list').attr('filter-data-startDate', start_date);
        $('#order-list').attr('filter-data-startHour', start_hour);
        $('#order-list').attr('filter-data-endDate', end_date);
        $('#order-list').attr('filter-data-endHour', end_hour);
        $('#order-list').attr('filter-data-telUser', tel_user);
        $('#order-list').attr('filter-data-clientId', client_id);
        $('#order-list').attr('filter-data-cmdAmount', cmd_amount);
        $('#order-list').attr('filter-data-cmdId', cmd_id);
        $('#order-list').attr('filter-data-status', status);
        $('#order-list').attr('filter-data-pageRunning', number_page_running);
        console.log( start_date );

        return false;

    });

    //console.log($('.pagination a .page-numbers'));
    $('#list-cmd-pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        var numero = $(this).attr('href');
        console.log(numero);

        var start_date = $('#order-list').attr('filter-data-startDate');
        var start_hour = $('#order-list').attr('filter-data-startHour');
        var end_date = $('#order-list').attr('filter-data-endDate');
        var end_hour = $('#order-list').attr('filter-data-endHour');
        var tel_user = $('#order-list').attr('filter-data-telUser');
        var client_id = $('#order-list').attr('filter-data-clientId');
        var cmd_amount = $('#order-list').attr('filter-data-cmdAmount');
        var cmd_id = $('#order-list').attr('filter-data-cmdId');
        var status = $('#order-list').attr('filter-data-status');
        var pagination = true;        

        var dataFilter = {start_date:start_date,start_hour:start_hour,end_date:end_date,end_hour:end_hour,tel_user:tel_user,client_id:client_id,cmd_amount:cmd_amount,cmd_id:cmd_id,number_page_running:numero,pagination:pagination,status:status};
        
        if( !isNaN( parseInt(numero) ) ){
            // console.log(dataFilter);
            search_orders(dataFilter);
            
        }
        //$(".cmd_search_form :input[name='number_page_running']").val(numero);
        $('#order-list').attr('filter-data-pageRunning', numero);
        return false;
    });
    

   
    /*reajustement du margin du formulaire apres avoir fermé le message d'erreur*/
    $('#errorLoginForm').on('click','.close',function(){        
        $("form#authentication-login-form").removeClass('error-form');
    });

    /*CONNEXION */
    $("form#authentication-login-form").on('submit',function (e) {
        e.preventDefault();
        // $("#login-button-valide").html("Patientez...");
        $("#login-button-valide").addClass('disabled');
        $("#login-button-valide").addClass('running');
        console.log( UrlToLogin );
        $.ajax({
            type: "POST",
            dataType: "json",
            url: UrlToLogin,
            data: $(this).serialize(),
            success: function (data, textStatus, jqXHR) {
               console.log(data);
               window.location.replace(linkToHome);
               //location.reload(true);
            },
            error: function(jqXHR) {
              console.log(jqXHR);  
              $("form#authentication-login-form").addClass('error-form');
              $("#login-button-valide").removeClass('disabled');
              $("#login-button-valide").removeClass('running');
              $('#errorLoginForm').prepend(jqXHR.responseJSON['error_html']);
              //$("#login-button-valide").val("Patientez...");
              //$('#errorLoginForm').prepend(jqXHR.responseText);
              // $("#login-button-valide").html("CONNEXION");
              
              //console.log(data);
            }
        });

        return false;
    });


    //AFFICHER MODAL POUR ARRETER LIVRAISON RAPIDE
    $('.quick-order-list tbody ').on('click','.set-stop-shipping-btn',function(){
      var cmd_id = $(this).attr('cmd-id');
      // console.log( cmd_id );
      var montant_ht = $('#order-list tbody .'+cmd_id+' .montant_ht').html();
      var frais_livraison = $('#order-list tbody .'+cmd_id+' .frais_livraison').html();
      var montant_ttc = $('#order-list tbody .'+cmd_id+' .montant_ttc').html();
      // console.log( montant_ttc );
      $("#form-set-stop-shipping :input[name='cmd_montant_ht']").val(montant_ht);
      $("#form-set-stop-shipping :input[name='cmd_frais_livraison']").val(frais_livraison);
      $("#form-set-stop-shipping :input[name='cmd_montant_ttc']").val(montant_ttc);
      $("#form-set-stop-shipping :input[name='cmd_id']").val(cmd_id);
      $.ajax({
          type: "POST",
          dataType: "json",
          url: linkToGetQuickLivreur,
          data: {cmd_id:cmd_id},
          success: function (data, textStatus, jqXHR) {
             // console.log(data);
             $("#form-set-stop-shipping :input[name='livreur_displayed']").val(data.nom_livreur);
             $("#form-set-stop-shipping :input[name='livreur']").val(data.id_livreur);
             $('#modal-set-stop-shipping').modal('show');
          },
          error: function(jqXHR) {
            console.log(jqXHR.responseText);
            //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
          }
      });        
  });


    //AFFICHER MODAL POUR ARRETER LIVRAISON
    $('#order-list tbody ').on('click','.set-stop-shipping-btn',function(){
        var cmd_id = $(this).attr('cmd-id');
        // console.log( cmd_id );
        var montant_ht = $('#order-list tbody .'+cmd_id+' .montant_ht').html();
        var frais_livraison = $('#order-list tbody .'+cmd_id+' .frais_livraison').html();
        var montant_ttc = $('#order-list tbody .'+cmd_id+' .montant_ttc').html();

        $("#form-set-stop-shipping :input[name='cmd_montant_ht']").val(montant_ht);
        $("#form-set-stop-shipping :input[name='cmd_frais_livraison']").val(frais_livraison);
        $("#form-set-stop-shipping :input[name='cmd_montant_ttc']").val(montant_ttc);
        $("#form-set-stop-shipping :input[name='cmd_id']").val(cmd_id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToGetLivreur,
            data: {cmd_id:cmd_id},
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
               $("#form-set-stop-shipping :input[name='livreur_displayed']").val(data.nom_livreur);
               $("#form-set-stop-shipping :input[name='livreur']").val(data.id_livreur);
               $('#modal-set-stop-shipping').modal('show');
            },
            error: function(jqXHR) {
              // console.log(jqXHR.responseText);
              //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
            }
        });        
    });

    //Validation du formulaire pour l'arret de la livraison
    $('#form-set-stop-shipping').on('submit',function(e){
        e.preventDefault();
        $("#modal-set-stop-shipping-confirm-btn").addClass('disabled');
        $("#modal-set-stop-shipping-confirm-btn").addClass('running');
        var set_stop_shipping_data = $(this).serialize();
        // console.log( set_stop_shipping_data );
        var type = 'normal';
        // set_stop_order_delivrery(set_stop_shipping_data);
        if( $('#form-set-shipping').hasClass('quick-order') ){
          type = 'quick';
        }
        // console.log( type );
        set_stop_order_delivrery(set_stop_shipping_data, type);
    });

    //AFFICHER MODAL POUR METTRE LA COMMANDE AU STATUT "LIVREE"
    $('#order-list tbody ').on('click','.set-shipping-btn',function(){
        
        var cmd_id = $(this).attr('cmd-id');
        console.log( cmd_id );
        var montant_ht = $('#order-list tbody .'+cmd_id+' .montant_ht').html();
        var frais_livraison = $('#order-list tbody .'+cmd_id+' .frais_livraison').html();
        var montant_ttc = $('#order-list tbody .'+cmd_id+' .montant_ttc').html();

        $("#form-set-shipping :input[name='cmd_montant_ht']").val(montant_ht);
        $("#form-set-shipping :input[name='cmd_frais_livraison']").val(frais_livraison);
        $("#form-set-shipping :input[name='cmd_montant_ttc']").val(montant_ttc);
        $("#form-set-shipping :input[name='cmd_id']").val(cmd_id);

        $('#modal-set-shipping').modal('show');
    });

    //validation du formulaire de paramétrage de la commande à "livrer" et attribution de livreur
    $('#form-set-shipping').on('submit',function(e){
        e.preventDefault();
        $("#modal-set-shipping-confirm-btn").addClass('disabled');
        $("#modal-set-shipping-confirm-btn").addClass('running');
        var set_shipping_data = $(this).serialize();
        console.log( set_shipping_data );
        var type = 'normal';
        if( $('#form-set-shipping').hasClass('quick-order') ){
          type = 'quick';
        }
        console.log( type );
        set_order_delivrery(set_shipping_data, type);
    });

    //
    //Cliquer sur le bouton pour rejetter une commande
    $('#order-list tbody').on('click', '.set-rejected-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);
        var cmd_id = $(this).attr('cmd-id');

        console.log( cmd_id );
        var montant_ht = $('#order-list tbody .'+cmd_id+' .montant_ht').html();
        var frais_livraison = $('#order-list tbody .'+cmd_id+' .frais_livraison').html();
        var montant_ttc = $('#order-list tbody .'+cmd_id+' .montant_ttc').html();

        $("#form-reject-order :input[name='cmd_montant_ht']").val(montant_ht);
        $("#form-reject-order :input[name='cmd_frais_livraison']").val(frais_livraison);
        $("#form-reject-order :input[name='cmd_montant_ttc']").val(montant_ttc);
        $("#form-reject-order :input[name='cmd_id']").val(cmd_id);

        $('#modal-reject-order').modal('show');
        
        return false;
    });

    //validation du formulaire de rejet de la commande
    $('#form-reject-order').on('submit',function(e){
        e.preventDefault();
        $("#modal-reject-order-confirm-btn").addClass('disabled');
        $("#modal-reject-order-confirm-btn").addClass('running');
        var reject_order_data = $(this).serialize();
        var type = 'normal';
        if( $('#form-reject-order').hasClass('quick-order') ){
          type = 'quick';
        }
        console.log( type );
        reject_order(reject_order_data, type);
    });

    /*********** METTRE UN FORMULAIRE POUR LE REJET AFIN D'ECRIRE LE MOTIF DU REJET ***********/

    //Cliquer sur le bouton pour restaurer une commande
    $('#order-list tbody').on('click', '.set-restore-btn', function(e){ // 
        e.preventDefault();
        var self = $(this);        
        var cmd_id = $(this).attr('cmd-id');
        var type = 'normal';
        if( $(this).hasClass('quick-order') ){
          type = 'quick';
        }

         Swal({
          title: 'Êtes vous sure ?',
          text: 'Vous vous apprêter à restaurer la commande '+cmd_id,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0aa89e',
          cancelButtonColor: '#d33',
          confirmButtonText: 'OK',
          cancelButtonText: 'Annuler'
        }).then((result) => {
          if (result.value) {
            //console.log(self);
            restore_order(cmd_id, self, type);            
          }
        });        
        return false;
    });


    //AFFICHER MODAL POUR SUPPRIMER COMMANDES
    $('#order-list tbody ').on('click','.delete-order-btn',function(){
        
        var cmd_id = $(this).attr('cmd-id');
        console.log( cmd_id );
        var montant_ht = $('#order-list tbody .'+cmd_id+' .montant_ht').html();
        var frais_livraison = $('#order-list tbody .'+cmd_id+' .frais_livraison').html();
        var montant_ttc = $('#order-list tbody .'+cmd_id+' .montant_ttc').html();

        $("#form-delete-order :input[name='cmd_montant_ht']").val(montant_ht);
        $("#form-delete-order :input[name='cmd_frais_livraison']").val(frais_livraison);
        $("#form-delete-order :input[name='cmd_montant_ttc']").val(montant_ttc);
        $("#form-delete-order :input[name='cmd_id']").val(cmd_id);
        $("#form-delete-order :input[name='password']").val('');

        $('#modal-delete-order').modal('show');
              
    });

    //validation du formulaire de paramétrage de la commande à "livrer" et attribution de livreur
    $('#form-delete-order').on('submit',function(e){
        e.preventDefault();
        $("#modal-delete-order-confirm-btn").addClass('disabled');
        $("#modal-delete-order-confirm-btn").addClass('running');
        var delete_order_data = $(this).serialize();
        var type = 'normal';
        if($('#form-delete-order').hasClass('quick-order')){
          type = 'quick';
        }
        //console.log( delete_order_data );
        delete_order(delete_order_data, type);
    });


    /* Function pour rechercher les */
    function search_orders(filter_data){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToSearchOrders,
            data: filter_data,
            success: function (data, textStatus, jqXHR) {
               
               $(' #order-list tbody ').hide().html( data.result.html_list_cmd ).fadeIn(1000);
               $(' #list-cmd-pagination ').html( data.result.html_pagination ); 
               console.log(data);
               if(!filter_data.pagination){
                    
                    if( $("#cmd_search_form_btn").hasClass('disabled') ){
                        $("#cmd_search_form_btn").removeClass('disabled');
                        $("#cmd_search_form_btn").removeClass('running');
                    }
                    $('.total_cmd_montant').hide().html( data.result.total_cmd.montant ).fadeIn(1000);
                    $('.total_cmd_nbre').hide().html( data.result.total_cmd.nbre ).fadeIn(1000);

                    $('.total_cmd_livrees_montant').hide().html( data.result.total_cmd_livrees.montant ).fadeIn(1000);
                    $('.total_cmd_livrees_nbre').hide().html( data.result.total_cmd_livrees.nbre ).fadeIn(1000);

                    $('.total_cmd_pending_montant').hide().html( data.result.total_cmd_pending.montant ).fadeIn(1000);
                    $('.total_cmd_pending_nbre').hide().html( data.result.total_cmd_pending.nbre ).fadeIn(1000);

                    $('.total_cmd_on_road_montant').hide().html( data.result.total_cmd_on_road.montant ).fadeIn(1000);
                    $('.total_cmd_on_road_nbre').hide().html( data.result.total_cmd_on_road.nbre ).fadeIn(1000);

                    $('.total_cmd_rejected_montant').hide().html( data.result.total_cmd_rejected.montant ).fadeIn(1000);
                    $('.total_cmd_rejected_nbre').hide().html( data.result.total_cmd_rejected.nbre ).fadeIn(1000);

                    $('.total_cmd_cancelled_montant').hide().html( data.result.total_cmd_cancelled.montant ).fadeIn(1000);
                    $('.total_cmd_cancelled_nbre').hide().html( data.result.total_cmd_cancelled.nbre ).fadeIn(1000);

                    // $('.total_produit_stock_off').hide().html( data.result.stat.produits_stock_off ).fadeIn(1000);
                    // $('.total_never_cmd').hide().html( data.result.stat.produits_non_cmd ).fadeIn(1000);
                    // $('.total_non_actif').hide().html( data.result.stat.produits_non_actif ).fadeIn(1000);
               }
               $('[data-toggle="tooltip"]').tooltip();
               
               $('#extract-excel-btn').attr('href', data.result.link_for_extract);

            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              if( $("#cmd_search_form_btn").hasClass('disabled') ){
                    $("#cmd_search_form_btn").removeClass('disabled');
                    $("#cmd_search_form_btn").removeClass('running');
               }  
              
              $('#errorForm').prepend(jqXHR.responseJSON['error_html']);
            }
        });
    }

    /*Function rejet de commande*/
    function delete_order(delete_order_data, type){
        // console.log(delete_order_data);
        var UrlToSend = '';       
        if( type === 'normal' ){
          UrlToSend=linkToDeleteOrder;
        }else{
          UrlToSend=linkToDeleteQuickOrder;
        }

        $.ajax({
            type: "POST",
            dataType: "json",
            url: UrlToSend,
            data: delete_order_data,
            success: function (data, textStatus, jqXHR) {
               console.log(data);

               //Arrete le spinner du boutnon de validation du formulaire
                    $("#modal-delete-order-confirm-btn").removeClass('disabled');
                    $("#modal-delete-order-confirm-btn").removeClass('running');
                               
                // //supprimer la ligne de commande
                // $("#order-list tbody ."+data.cmd_id+" .set-shipping-btn").remove();
                var password = '';
                $("#form-delete-order :input[name='password']").val(password);
                $('#modal-delete-order').modal('hide');

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    //supprimer la ligne de commande
                    $("#order-list tbody ."+data.cmd_id).fadeOut(700);
                  }
                });
            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              $("#modal-delete-order-confirm-btn").removeClass('disabled');
              $("#modal-delete-order-confirm-btn").removeClass('running');
              //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
              if(jqXHR.responseJSON.error === 'oui'){
                    // $('#confirm-order-modal').hide();
                    // $('#modal-delete-order').modal('hide');
                    Swal({
                      type: 'error',
                      title: jqXHR.responseJSON.error_text,
                      text: jqXHR.responseJSON.error_text_second
                    });
                    //return html_status_initial;
              }

            }
        });

    }


    /*Function rejet de commande*/
    function restore_order(cmd_id, self, type){
        // console.log(cmd_id);
        var UrlToSend = '';
        if (type === 'normal'){
          UrlToSend = linkToRestoreOrder;
        }else{
          UrlToSend = linkToRestoreQuickOrder;
        } 
        $.ajax({
            type: "POST",
            dataType: "json",
            url: UrlToSend,
            data: {cmd_id:cmd_id},
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
                //mettre a jour l'intitulé du statut de la commande
               $('#order-list tbody .'+data.cmd_id+' .cmd-status').html('EN ATTENTE');           

               // mettre a jour la couleur du statut (style)
               if( $("#order-list tbody ."+data.cmd_id+" .cmd-status").hasClass('style-default') ){
                    $("#order-list tbody ."+data.cmd_id+" .cmd-status").removeClass('style-default') 
                    $("#order-list tbody ."+data.cmd_id+" .cmd-status").addClass('style-info')
                }

               //  //mettre a jour les bouton d'actions
                    
                    //remplacer bouton "arreter livraison" par "rejeter"
                    $("#order-list tbody ."+data.cmd_id+" .set-restore-btn").attr('data-original-title', 'Rejetter la commande');
                    $("#order-list tbody ."+data.cmd_id+" .set-restore-btn").html('<i class="fa fa-times-circle-o"></i>');
                    //Ajouter class pour laction du bouton
                    $("#order-list tbody ."+data.cmd_id+" .set-restore-btn").addClass('set-rejected-btn');
                    $("#order-list tbody ."+data.cmd_id+" .set-restore-btn").removeClass('set-restore-btn');

                    //Ajouter bouton liver
                    $("#order-list tbody ."+data.cmd_id+" .set-rejected-btn").before( data.btn_rejected_html );
                    $('[data-toggle="tooltip"]').tooltip();

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    $("#order-list tbody ."+data.cmd_id).fadeOut(250).fadeIn(250).fadeOut(250).fadeIn(250);
                  }
                });
            },
            error: function(jqXHR) {
              console.log(jqXHR.responseText);
              //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
              if(jqXHR.responseJSON.error === 'oui'){
                    //$('#confirm-order-modal').hide();
                    Swal({
                      type: 'error',
                      title: jqXHR.responseJSON.error_text,
                      text: jqXHR.responseJSON.error_text_second
                    });
                    //return html_status_initial;
              }

            }
        });

    }

    /*Function rejet de commande*/
    function reject_order( reject_order_data, type ){
        // console.log(reject_order_data);
        var UrlToSend = '';
        if (type === 'normal'){
          UrlToSend = linkToRejectOrder;
        }else{
          UrlToSend = linkToRejectQuickOrder;
        }        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: UrlToSend,
            data: reject_order_data,
            success: function (data, textStatus, jqXHR) {
               // console.log(data);
                //mettre a jour l'intitulé du statut de la commande
               $('#order-list tbody .'+data.cmd_id+' .cmd-status').html('REJETÉE');           

               // mettre a jour la couleur du statut (style)
               if( $("#order-list tbody ."+data.cmd_id+" .cmd-status").hasClass('style-info') ){
                    $("#order-list tbody ."+data.cmd_id+" .cmd-status").removeClass('style-info') 
                    $("#order-list tbody ."+data.cmd_id+" .cmd-status").addClass('style-default')
                }

                //mettre a jour les bouton d'actions
                    //supprimer bouton liver
                    $("#order-list tbody ."+data.cmd_id+" .set-shipping-btn").remove();

                    //remplacer bouton "rejeter" par "restauration de commande"
                    $("#order-list tbody ."+data.cmd_id+" .set-rejected-btn").attr('data-original-title', 'Restaurer la commande');
                    $("#order-list tbody ."+data.cmd_id+" .set-rejected-btn").html('<i class="md md-settings-backup-restore"></i>');
                    //palce la classe permetant de selectionner l'action d'arreter une livraison
                    $("#order-list tbody ."+data.cmd_id+" .set-rejected-btn").addClass('set-restore-btn');
                    $("#order-list tbody ."+data.cmd_id+" .set-rejected-btn").removeClass('set-rejected-btn');
                    $('[data-toggle="tooltip"]').tooltip();

                    var rejected_message = '';
                    $("#form-reject-order :input[name='rejected_message']").val(rejected_message);
                    //Arrete le spinner du boutnon de validation du formulaire
                    $("#modal-reject-confirm-btn").removeClass('disabled');
                    $("#modal-reject-confirm-btn").removeClass('running');
                    //cacher la fenetre modal du formulaire du rejet
                    $('#modal-reject-order').modal('hide');

               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    $("#order-list tbody ."+data.cmd_id).fadeOut(250).fadeIn(250).fadeOut(250).fadeIn(250);
                    // console.log(self);
                    // self.parent().siblings("td.command-status").html( data.error_html );
                    // self.hide();
                  }
                });
            },
            error: function(jqXHR) {
                console.log(jqXHR.responseText);
                var rejected_message = '';
                $("#form-reject-order :input[name='rejected_message']").val(rejected_message);
                //Arrete le spinner du boutnon de validation du formulaire
                $("#modal-reject-confirm-btn").removeClass('disabled');
                $("#modal-reject-confirm-btn").removeClass('running');
                //cacher la fenetre modal du formulaire du rejet
                $('#modal-delete-order').modal('show');
              //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
                if(jqXHR.responseJSON.error === 'oui'){
                    //$('#confirm-order-modal').hide();
                    Swal({
                      type: 'error',
                      title: jqXHR.responseJSON.error_text,
                      text: jqXHR.responseJSON.error_text_second
                    });
                    //return html_status_initial;
                }

            }
        });

    }

    //Function ajax pour paramétrage de la commande à "livrer" et attribution de livreur
    function set_order_delivrery(set_shipping_data, type){
        var UrlToSend = '';
        if (type === 'normal'){
          UrlToSend = linkToSetOrderDelivrery;
        }else{
          UrlToSend = linkToSetQuickOrderDelivrery;
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            url: UrlToSend,
            data: set_shipping_data,
            success: function (data, textStatus, jqXHR) {
               $('#modal-set-shipping').modal('hide'); 
               console.log(data);

               //mettre a jour l'intitulé du statut de la commande
               $('#order-list tbody .'+data.cmd_id+' .cmd-status').html('EN LIVRAISON');           

               // mettre a jour la couleur du statut (style)
               if( $("#order-list tbody ."+data.cmd_id+" .cmd-status").hasClass('style-info') ){
                    $("#order-list tbody ."+data.cmd_id+" .cmd-status").removeClass('style-info') 
                    $("#order-list tbody ."+data.cmd_id+" .cmd-status").addClass('style-warning')
                }

                //mettre a jour les bouton d'actions
                    //supprimer bouton liver
                    $("#order-list tbody ."+data.cmd_id+" .set-shipping-btn").remove();

                    //remplacer bouton "rejeter" par "arreter livraison"
                    $("#order-list tbody ."+data.cmd_id+" .set-rejected-btn").attr('data-original-title', 'Arrêter la livraison');
                    $("#order-list tbody ."+data.cmd_id+" .set-rejected-btn").html('<i class="fa fa-pause"></i>');
                    $('[data-toggle="tooltip"]').tooltip();
                    //palce la classe permetant de selectionner l'action d'arreter une livraison
                    $("#order-list tbody ."+data.cmd_id+" .set-rejected-btn").addClass('set-stop-shipping-btn');
                    $("#order-list tbody ."+data.cmd_id+" .set-rejected-btn").removeClass('set-rejected-btn');
                    // $('#order-list ').attr('filter-data-status', status);

                    //Arrete le spinner du boutnon de validation du formulaire
                    $("#modal-set-shipping-confirm-btn").removeClass('disabled');
                    $("#modal-set-shipping-confirm-btn").removeClass('running');

               //afficher la notification de succès
               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    if (type === 'quick'){
                      $('#order-list tbody .'+data.cmd_id+' .montant_ht').html(data.montant_ht);
                      $('#order-list tbody .'+data.cmd_id+' .frais_livraison').html(data.frais_livraison);
                      $('#order-list tbody .'+data.cmd_id+' .montant_ttc').html(data.montant_total);
                    }
                    
                    $("#order-list tbody ."+data.cmd_id).fadeOut(250).fadeIn(150).fadeOut(250).fadeIn(150).fadeOut(250).fadeIn(150);                
                  }
                });
               
            },
            error: function(jqXHR) {
                $("#modal-set-shipping-confirm-btn").removeClass('disabled');
                $("#modal-set-shipping-confirm-btn").removeClass('running');  
                // console.log(jqXHR.responseText);
                Swal({
                      type: 'error',
                      title: jqXHR.responseJSON.error_text,
                      text: jqXHR.responseJSON.error_text_second
                    });          
            }
        });
    }

    //Function ajax pour paramétrage de la commande à "livrer" et attribution de livreur
    function set_stop_order_delivrery(set_stop_shipping_data, type){
        var UrlToSend = '';
        if (type === 'normal'){
          UrlToSend = linkToSetStopOrderDelivrery;
        }else{
          UrlToSend = linkToSetStopQuickOrderDelivrery;
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            url: UrlToSend,
            data: set_stop_shipping_data,
            success: function (data, textStatus, jqXHR) {
               $('#modal-set-stop-shipping').modal('hide'); 
              //  console.log(data);

               //mettre a jour l'intitulé du statut de la commande
               $('#order-list tbody .'+data.cmd_id+' .cmd-status').html('EN ATTENTE');           

               // // mettre a jour la couleur du statut (style)
               if( $("#order-list tbody ."+data.cmd_id+" .cmd-status").hasClass('style-warning') ){
                    $("#order-list tbody ."+data.cmd_id+" .cmd-status").removeClass('style-warning') 
                    $("#order-list tbody ."+data.cmd_id+" .cmd-status").addClass('style-info')
                }

               //  //mettre a jour les bouton d'actions
                    
                    //remplacer bouton "arreter livraison" par "rejeter"
                    $("#order-list tbody ."+data.cmd_id+" .set-stop-shipping-btn").attr('data-original-title', 'Rejetter la commande');
                    $("#order-list tbody ."+data.cmd_id+" .set-stop-shipping-btn").html('<i class="fa fa-times-circle-o"></i>');
                    $('[data-toggle="tooltip"]').tooltip();

                    //Ajouter class pour laction du bouton
                    $("#order-list tbody ."+data.cmd_id+" .set-stop-shipping-btn").addClass('set-rejected-btn');
                    $("#order-list tbody ."+data.cmd_id+" .set-stop-shipping-btn").removeClass('set-stop-shipping-btn');

               //Ajouter bouton liver
                    $("#order-list tbody ."+data.cmd_id+" .set-rejected-btn").before( data.btn_rejected_html );

               //      // $('#order-list ').attr('filter-data-status', status);
                    $("#modal-set-stop-shipping-confirm-btn").removeClass('disabled');
                    $("#modal-set-stop-shipping-confirm-btn").removeClass('running');

               //afficher la notification de succès
               Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#0aa89e',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    $("#order-list tbody ."+data.cmd_id).fadeOut(250).fadeIn(250).fadeOut(250).fadeIn(250);                
                  }
                });
               
            },
            error: function(jqXHR) {
                $("#modal-set-stop-shipping-confirm-btn").removeClass('disabled');
                $("#modal-set-stop-shipping-confirm-btn").removeClass('running');  
                // console.log(jqXHR.responseText);
                Swal({
                      type: 'error',
                      title: jqXHR.responseJSON.error_text,
                      text: jqXHR.responseJSON.error_text_second
                    });          
            }
        });
    }

    
    /*GRAPHE DES COMMANDES TABLEAU DE BORD*/
    function orderCharts(){
        var period = 'month';
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToStatOrder,
            data: {period:period},
            success: function (dataAjax, textStatus, jqXHR) {
               // console.log(dataAjax);
               /*config for number chart*/
               var config = {
                        type: 'line',
                        data: {
                            labels: dataAjax.result.days_list_formated,
                            datasets: [{
                                label: 'Nombre de commandes',
                                backgroundColor: window.chartColors.red,
                                borderColor: window.chartColors.red,
                                data: dataAjax.result.count_list,
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            title: {
                                display: false,
                                text: 'Nombre de commandes sur les 7 derniers jours'
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Jours'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Nombre'
                                    }
                                }]
                            }
                        }
                    };
               //display charts for number
               var ctx = document.getElementById('canvasNumber').getContext('2d');
                window.myLine = new Chart(ctx, config);

                /*config for amount chart*/
                var config_two = {
                        type: 'bar',
                        data: {
                            labels: dataAjax.result.days_list_formated,
                            datasets: [{
                                label: 'Montant de commandes',
                                backgroundColor: window.chartColors.green,
                                borderColor: window.chartColors.green,
                                data: dataAjax.result.amount_list,
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            title: {
                                display: false,
                                text: 'Nombre de commandes sur les 7 derniers jours'
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Jours'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Montant'
                                    }
                                }]
                            }
                        }
                    };

                //display charts for number
                var ctx_two = document.getElementById('canvasAmount').getContext('2d');
                window.myLineTwo = new Chart(ctx_two, config_two);


                // console.log(config_two);
                // console.log(config);
            },
            error: function(jqXHR) {
              // console.log(jqXHR);
                            
              //console.log(data);
            }
        });
    }


    /*GRAPHE DES CLIENTS TABLEAU DE BORD*/
    function customerCharts(){
        var verif = true;
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToStatCustomer,
            data: {verif:verif},
            success: function (dataAjax, textStatus, jqXHR) {
               console.log(dataAjax);
               $("#stat-total-users").html(dataAjax.result.total_nbre_customers);

               var config = {
                                type: 'doughnut',
                                data: {
                                    datasets: [{
                                        data: [
                                            dataAjax.result.total_nbre_customers_with_order,
                                            dataAjax.result.total_nbre_customers_without_order
                                        ],
                                        backgroundColor: [
                                            window.chartColors.orange,
                                            window.chartColors.red
                                        ],
                                        label: 'Dataset 1'
                                    }],
                                    labels: [
                                        'Clients avec commandes',
                                        'Clients sans commandes'
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Graphe des clients avec ou sans commandes.'
                                    },
                                    animation: {
                                        animateScale: true,
                                        animateRotate: true
                                    }
                                }
                            };

                var ctx = document.getElementById('canvasCustomers').getContext('2d');
                window.myDoughnut = new Chart(ctx, config);
               
            },
            error: function(jqXHR) {
              console.log(jqXHR);
                            
              //console.log(data);
            }
        });
    }

    /*STAT DASHBOARD PRODUCTS*/
    function statProductsDashboard(){
        var verif = true;
        $.ajax({
            type: "POST",
            dataType: "json",
            url: linkToStatProducts,
            data: {verif:verif},
            success: function (dataAjax, textStatus, jqXHR) {
               console.log(dataAjax.result.list_produits_html);
               $("#product-list-stat-container").fadeIn(500).html(dataAjax.result.list_produits_html);
            },
            error: function(jqXHR) {
              console.log(jqXHR);                            
              //console.log(data);
            }
        });

    }






















//experience
function dataload(){

    var wrapProd = document.getElementById('list_produits');
    //console.log(wrapProd);
    if(wrapProd==null || wrapProd===false){

    }else{
        var productDataIsDisplay = $('#list_produits').attr('product-data-display'); // est ce que la div produits a des produits affichés ?
        var contentHeightProd = wrapProd.offsetHeight;
        var yOffset = window.pageYOffset;
        var y = yOffset + window.innerHeight;

        //console.log("hauteur page : "+yOffset);
        // console.log("hauteur page Inner : "+y);
        //console.log("Hauteur list_produits : "+contentHeightProd);
        //console.log(wrapProd.getClientRects());
        if(yOffset>=wrapProd.getBoundingClientRect().y && productDataIsDisplay=="false"){
            console.log("OK");
            search_products();
        }
    }
      
}

dataload();

window.onscroll = dataload;

$('.commerce-ordering select').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    console.log(valueSelected);
    $('#list_produits').attr('product-data-order', valueSelected);
    search_products();
    console.log($('.pagination'));
});

//console.log($('.pagination a .page-numbers'));
$('.pagination ').on('click', '.page-numbers', function (e) {
    e.preventDefault();
    var numero = $(this).attr('numero');
    console.log(numero);
    $('#list_produits').attr('product-data-number-page', numero);
    search_products();
    //return false;
});

var productsRelatedContainer = document.getElementById('products-related-container');

if(productsRelatedContainer!=null && productsRelatedContainer!==false){
    //console.log(productsRelatedContainer);
    
    var productRelatedDisplay = $('#products-related-container').attr('product-display');
    if(productRelatedDisplay=="false"){
            console.log("OK");
            search_products_related();
    }

    
}

//console.log(document.readyState);

/*Ajout au panier*/
$('.add-to-cart-btn').on('click', function(e){
    e.preventDefault();
    var tokenProduit = $(this).attr('id-product');
    //console.log(tokenProduit);
    add_to_cart(tokenProduit,1);
    return false;
});

$('#list_produits ').on('click','.add-to-cart-btn', function(e){
    e.preventDefault();
    var tokenProduit = $(this).attr('id-product');
    //console.log(tokenProduit);
    add_to_cart(tokenProduit,1);
    return false;
});

$('#products-related-container ').on('click','.add-to-cart-btn', function(e){
    e.preventDefault();
    var tokenProduit = $(this).attr('id-product');
    //console.log(tokenProduit);
    add_to_cart(tokenProduit,1);
    return false;
});

// $('.quantity').on('click', '.qty-plus', function(e){
//     e.preventDefault();
//     var inputQuantity = $('.quantite-product-detail').attr('value');
//     parseInt(inputQuantity);
//     console.log( $('.quantite-product-detail').val() );
//     console.log( $('.quantite-product-detail') );
// });



//page product detail ajout au panier
$("#produit-detail-form").on('submit', function(e){
    e.preventDefault();
    var tokenProduit = $('.token-product-detail').attr('value');
    var nbreProduit = $('.quantite-product-detail').val();
    console.log( tokenProduit );
    console.log( nbreProduit );

    add_to_cart(tokenProduit,nbreProduit); 

    return false;
});

//MODIFICATION DE PANIER
$("#cart-content-panier").on('submit',function(e){
    e.preventDefault();
    //console.log(linkToUpdateToCart);
    update_cart($(this).serialize());
    
    //console.log(linkToUpdateToCart);
    return false;
});

//SUPPRIMER PRODUIT DE PANIER
$('.table').on('click', '.remove-product-cart', function(e){ // j'ai essayer avec un id sur un form mais ça pas marché, l'element n'etait pas retrouvé
    e.preventDefault();
    var tokenProduit = $(this).attr('id-product');
    //console.log(tokenProduit);
     Swal({
      title: 'Êtes vous sure ?',
      text: 'Voulez vous retirer ce produit de votre panier ?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#2ecc71',
      cancelButtonColor: '#d33',
      confirmButtonText: 'OK',
      cancelButtonText: 'Annuler'
    }).then((result) => {
      if (result.value) {
        delete_to_cart(tokenProduit,"panier");
      }
    });
    return false;
});

//SUPPRIMER PRODUIT DE PANIER depuis le recap panier dans lentete

$('.widget-shopping-cart-content').on('click', '.remove-product-cart', function(e){ // j'ai essayer avec un id sur un form mais ça pas marché, l'element n'etait pas retrouvé
    e.preventDefault();
    var tokenProduit = $(this).attr('id-product');
    //console.log(tokenProduit);
     Swal({
      title: 'Êtes vous sure ?',
      text: 'Voulez vous retirer ce produit de votre panier ?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#2ecc71',
      cancelButtonColor: '#d33',
      confirmButtonText: 'OK',
      cancelButtonText: 'Annuler'
    }).then((result) => {
      if (result.value) {
        
        var view = "header-panier";
        if (document.querySelector('#cart-content-panier') !== null) { // verifie si on est pas sur la page de panier
            console.log( $('#cart-content-panier') );
            view = "panier";
        }
        delete_to_cart(tokenProduit,view);
      }
    });
    return false;
});

//Shipping
$('#select-shipping-destination').on( 'change', function(){
    console.log( $('#select-shipping-destination .'+this.value).attr('shipping-amount') );
    var amount = $('#select-shipping-destination .'+this.value).attr('shipping-amount');

    $('#frais-livraison').attr('montant-livraison',amount);
    $('#frais-livraison').html(amount+' F');

    var shipping_fees = parseInt( $('#frais-livraison').attr('montant-livraison') );
    var sous_total_cart = parseInt( $('#sous-total-vue-panier').attr('sous-total-cart') );
    var total_amount_cart = parseInt(sous_total_cart) + shipping_fees;
    $('#total-vue-panier').html(total_amount_cart+' F CFA'); ////modifier le total montant du panier

    var Token = this.value;
    console.log(Token);
    set_shipping_destination(Token); // parametre les frais de livraison et la destination dans la session

});


//ENVOYER MESSAGE CONTACT
$(".contact-form").on('submit', function(e){
    e.preventDefault();
    var form_contact_data = $(this).serialize();
    console.log(form_contact_data);
    sendMessages(form_contact_data);
    return false;
});

//Valider la commande
$(".checkout-payment").on('click', '#commandeur-btn', function(e){
    e.preventDefault();
    //console.log($('#shipping-form').serialize());
    
    var error = false;
    $('#shipping-form input, #shipping-form select, #shipping-form textarea').each(function(){
        //console.log(this.name+' = '+this.value);
        if( this.name != 'email' && this.name != 'description_lieu_livraison' && this.value == ''){
            if(this.name !== '' && this.value == ''){
                var HtmlError ='<div class="col-sm-12 alert alert-danger alert-dismissible " role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>';
                HtmlError += '</button><span class=""> Le champs ' + this.name + ' ne pas être vide.</span></div>';
                console.log(HtmlError);
                $('.shipping-info .error-text').html(HtmlError);
                error = true;
                return false;
            }            
        }

    });
    if(!error){
        //var amount = $('#select-shipping-destination .'+this.value).attr('shipping-amount');
        var amount_order = parseInt( $('#total-vue-panier').html() );
        $('.order-info .order-amount').html(amount_order+ ' F CFA');

        var shipping_name= $('#shipping-form input[name="nom"]').val()  + ' ' + $('#shipping-form input[name="prenoms"]').val() ;
        var shipping_tel= $('#shipping-form input[name="tel"]').val();
        var shipping_email= $('#shipping-form input[name="email"]').val();
        var shipping_commune= $('#shipping-form select option:selected').text();
        var shipping_quartier= $('#shipping-form input[name="quartier"]').val();
        var shipping_decript= $('#shipping-form textarea').val();

        $('.shipping-confirmation-details .shipping-name').html(shipping_name);
        $('.shipping-confirmation-details .shipping-tel').html(shipping_tel);
        $('.shipping-confirmation-details .shipping-email').html(shipping_email);
        $('.shipping-confirmation-details .shipping-commune').html(shipping_commune);
        $('.shipping-confirmation-details .shipping-quartier').html(shipping_quartier);

        $('.shipping-confirmation-details .shipping-detail-lieu').html(shipping_decript);

        $('#confirm-order-modal').modal('show');
        console.log( shipping_decript );
    }
    
});

/*click sur bouton confirmation de commande*/
$('#confirm-order-modal').on('click','#confirm-command-btn',function(){
    var shipping_quartier= $('#shipping-form input[name="quartier"]').val();
    var shipping_decript= $('#shipping-form textarea').val();
    //console.log($('#shipping-form').serialize())
    var shipping_form = $('#shipping-form').serialize();
    $('#confirm-order-modal').hide();
    place_order( shipping_form );
});

/*Click pour modifier ses infos persos*/
$('.user-data-info-box-contain').on('click','.user-data-info-action',function(){
    var user_sexe = $('.user-data-info-box-contain span.user-data-info.sexe ').html().trim().toLowerCase();
    var user_name = $('.user-data-info-box-contain span.user-data-info.nom ').html();
    var user_lastname = $('.user-data-info-box-contain span.user-data-info.prenoms ').html();
    var user_tel = $('.user-data-info-box-contain span.user-data-info.tel ').html();
    var user_email = $('.user-data-info-box-contain span.user-data-info.email ').html();
    console.log( user_sexe+' '+user_tel+' '+user_lastname );

    if(user_sexe === 'homme'){
        $("#opt1").attr('checked', true);
    }else{
        $("#opt2").attr('checked', true);
    }
    $('#modal-update-info-perso #name').val(user_name);
    $('#modal-update-info-perso #lastname').val(user_lastname);
    $('#modal-update-info-perso #tel').val(user_tel);
    $('#modal-update-info-perso #email').val(user_email);

    $('#modal-update-info-perso').modal('show');
});


$('#form-update-info-perso').on('submit',function(e){
    e.preventDefault();
    var form_user_info_data = $(this).serialize();
    console.log( form_user_info_data );
    update_personnal_infos(form_user_info_data);
});

/*AFFICHER MOT DE PASSE Form modif mot de passe*/
$('#show-password-checbox').on('change',function(e){
    
    var old_password = document.getElementById('old_password');
    var new_password = document.getElementById('new_password');
    var confirm_new_password = document.getElementById('confirm_new_password');
    console.log( document.getElementById('show-password-checbox').checked );
    if( document.getElementById('show-password-checbox').checked ){
        
        old_password.type="text";
        new_password.type="text";
        confirm_new_password.type="text";
    }else{
        old_password.type="password";
        new_password.type="password";
        confirm_new_password.type="password";
    }
});

/*AFFICHER MOT DE PASSE Form connexion*/
$('#show-password-checbox-login').on('change',function(e){
    var login_password = document.getElementById('login_password');
    //console.log( document.getElementById('show-password-checbox-login').checked );
    if( document.getElementById('show-password-checbox-login').checked ){        
        login_password.type="text";
    }else{
        login_password.type="password";
    }
});

/*MODIFICATION DE MOT DE PASSE*/
$('#form-update-password').on('submit',function(e){
    e.preventDefault();
    var form_update_password = $(this).serialize();
    //update_personnal_infos(form_update_password);
    Swal({
      title: 'Êtes vous sure ?',
      text: 'Vous êtes sur le point de modifier votre mot de passe.',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#2ecc71',
      cancelButtonColor: '#d33',
      confirmButtonText: 'OK',
      cancelButtonText: 'Annuler'
    }).then((result) => {
      if (result.value) {
        //console.log( form_update_password );
        update_password(form_update_password);
      }
    });
    return false;

});

//Cliquer sur le bouton pour annuler une commande
$('table.list-commands').on('click', '.annuler-commande', function(e){ // j'ai essayer avec un id sur un form mais ça pas marché, l'element n'etait pas retrouvé
    e.preventDefault();
    var self = $(this);
    console.log(self);
    var tokenCommande = $(this).attr('token-command');
    var html_status_initial = $(this).parent().siblings("td.command-status").html();
    console.log(tokenCommande);
     Swal({
      title: 'Êtes vous sure ?',
      text: 'Voulez allez annuler cette commande.',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#2ecc71',
      cancelButtonColor: '#d33',
      confirmButtonText: 'OK',
      cancelButtonText: 'Annuler'
    }).then((result) => {
      if (result.value) {
        cancelled_order(tokenCommande, self);
        //console.log(html_status);
        //console.log( $(this).parent().siblings("td.command-status").html() );
        //$(this).parent().siblings("td.command-status").html( html_status );
      }
    });
    console.log('OK 2');
    return false;
});

/*Function annulation commande*/
function cancelled_order(token, self){
    
    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToCancelledOrder,
        data: {tokenCommande:token},
        success: function (data, textStatus, jqXHR) {
           console.log(data);       
           Swal({
              title: data.error_text,
              text: data.error_text_second,
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#2ecc71',
              cancelButtonColor: '#d33',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.value) {
                //location.reload(true);
                //return data.error_html; // retourne le html du nouveau statut de la commande
                console.log(self);
                self.parent().siblings("td.command-status").html( data.error_html );
                self.hide();
              }
            });
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
          //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
          if(jqXHR.responseJSON.error === 'oui'){
                //$('#confirm-order-modal').hide();
                Swal({
                  type: 'error',
                  title: jqXHR.responseJSON.error_text,
                  text: jqXHR.responseJSON.error_text_second
                });
                //return html_status_initial;
          }

        }
    });

}

/*Function modification mot de passe*/
function update_password(form_update_password){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToUpdatePassword,
        data: form_update_password,
        success: function (data, textStatus, jqXHR) {
           
           console.log(data);
           Swal({
              title: data.error_text,
              text: data.error_text_second,
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#2ecc71',
              cancelButtonColor: '#d33',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.value) {
                location.reload(true);
              }
            });
           
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
          $('#form-update-password .error-text').html(jqXHR.responseJSON.error_html);
        }
    });
}

/*Function modification infos personnelles*/
function update_personnal_infos(form_user_info_data){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToUpdateInfosUser,
        data: form_user_info_data,
        success: function (data, textStatus, jqXHR) {
           $('#modal-update-info-perso').modal('hide'); 
           console.log(data);
           Swal({
              title: data.error_text,
              text: data.error_text_second,
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#2ecc71',
              cancelButtonColor: '#d33',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.value) {
                location.reload(true);
              }
            });
           
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
          $('#form-update-info-perso .error-text').html(jqXHR.responseJSON.error_html);
        }
    });
}

/*Function validation commande*/
function place_order(ShippingForm){
    //console.log( quartier, derciption_livraison, linkToOrder );
    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToOrder,
        data: ShippingForm,
        success: function (data, textStatus, jqXHR) {
           console.log(data);
           
           Swal({
              title: data.error_text,
              text: data.error_text_second,
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#2ecc71',
              cancelButtonColor: '#d33',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.value) {
                location.reload(true);
              }
            });
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
          //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
          if(jqXHR.responseJSON.error === 'oui'){
                //$('#confirm-order-modal').hide();
                Swal({
                  type: 'error',
                  title: jqXHR.responseJSON.error_text,
                  text: jqXHR.responseJSON.error_text_second
                });

          }

        }
    });

}

/*Function format */
function formatAmount(amount){
    //var number = 15000; //Put your number
    var numstring = amount.toString();

    if(numstring.length > 3){
        var thpos = -3;
        var strgnum = numstring.slice(0, numstring.length+thpos);
        var strgspace = (" " + numstring.slice(thpos));
        numstring = strgnum + strgspace;
    }
    var amountFormated = numstring;
    return amountFormated;
}

/*Fonction parametrage lieu livraison*/
function set_shipping_destination(tokenDestination){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToShippingDest,
        data: {tokenDestination:tokenDestination},
        success: function (data, textStatus, jqXHR) {
           console.log(data);
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
          //$('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
        }
    });
}

/*Fonction d'envoi de messages ou preocupation*/
function sendMessages(formData){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToAddMessage,
        data: formData,
        success: function (data, textStatus, jqXHR) {
           //console.log(data);
           Swal({
              title: data.error_text,
              text: data.error_text_second,
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#2ecc71',
              cancelButtonColor: '#d33',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.value) {
                location.reload(true);
              }
            });
           
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
          $('.contact-form .error-text').html(jqXHR.responseJSON.error_html);
        }
    });
}

/*Function de suppression de produit du panier*/
function delete_to_cart(tokenProduit,vue="header-panier"){
    console.log('Oui je veux suprimer ' + tokenProduit);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToDeleteToCart,
        data: {tokenProduit:tokenProduit},
        success: function (data, textStatus, jqXHR) {
           console.log(data);
           if(data.error === 'non'){
            //console.log(data.error_text);
                $('.mini-cart-icon').attr('data-count', data.cart.total_nbre);
                $('.mini-cart-total').html(data.cart.total_amount+' F');
                $('.widget-shopping-cart-content .total .amount').html(data.cart.total_amount+' F');

                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#2ecc71',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    // verifier si le panier est vide et actualiser la page
                    if(data.cart.IsEmpty === true){
                        location.reload(true); //actualiser la page
                    }
                    /////panier page/////
                    if(vue === "panier"){
                        $('.table .'+tokenProduit).fadeOut(500, function() {  //suppression de la ligne produit
                            if( $(this).hasClass('cart-item-info-responsive') ){
                                $(this).removeClass('cart-item-info-responsive'); //supprimer la classe pour la ligne responsivité
                            }
                            $(this).remove(); //suppression de la ligne produit
                        });
                        
                        $('#sous-total-vue-panier').html(data.cart.total_amount+' F'); //modifier le sous total du panier
                        
                        var shipping_fees = parseInt( $('#frais-livraison').attr('montant-livraison') );
                        var total_amount_cart = parseInt(data.cart.total_amount) + shipping_fees;
                        $('#total-vue-panier').html(total_amount_cart+' F'); ////modifier le total montant du panier
                    }
                    /////panier entete////
                    // supprimer (ou cacher) la ligne du produit
                    $('.widget-shopping-cart-content .'+tokenProduit).fadeOut(500, function() {  //suppression de la ligne produit
                            $(this).remove(); //suppression de la ligne produit
                    }); 

                  }
                });

           }           
           //$('#products-related-container').html(data.produits_liste_html).fadeIn(500); 
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
          //console.log(jqXHR.responseJSON);
          if(jqXHR.responseJSON.error === 'oui'){
                Swal({
                  type: 'error',
                  title: jqXHR.responseJSON.error_text,
                  text: jqXHR.responseJSON.error_text_second
                });
          }

        }

    });
}


/* Fonction modification de panier */
function update_cart(products){ // $products est le seriliaze d'un formulaire
    console.log(products);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToUpdateToCart,
        data: products,
        success: function (data, textStatus, jqXHR) {
           
           if(data.error === 'non'){
            //console.log(data.error_text);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#2ecc71',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    location.reload(true);
                  }
                });
           }           
           //$('#products-related-container').html(data.produits_liste_html).fadeIn(500); 
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
          //console.log(jqXHR.responseJSON);
          if(jqXHR.responseJSON.error === 'oui'){
                Swal({
                  type: 'error',
                  title: jqXHR.responseJSON.error_text,
                  text: jqXHR.responseJSON.error_text_second
                });
          }
        }
    });

}

/*Fonction d'ajout au panier*/
function add_to_cart(tokenProduit,nbreProduit){
    console.log(tokenProduit+" "+ nbreProduit);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToAddToCart,
        data: {tokenProduit:tokenProduit,nbreProduit:nbreProduit},
        success: function (data, textStatus, jqXHR) {
           console.log(data.cart);
           if(data.cart.IsEmpty === true){ // Verifie si le panier est vide et initialise son contenu
                $('.cart-list ').html('');
           }
           
           if(data.cart.product.isNewInCart === true){
            var newProductCart_html = '<li class="'+data.cart.product.token+'" id-product="'+data.cart.product.token+'"><a href="#" class="remove">×</a>';
                    newProductCart_html +=' <a href="'+data.cart.product.link_to_details+'">';
                        newProductCart_html +=' <img src="'+data.cart.product.link_to_image+'" alt="" /> '+data.cart.product.nom+' &nbsp;';
                    newProductCart_html +=' </a>';
                    newProductCart_html +=' <span class="quantity"><span class="nbre-cart-product">'+data.cart.product.qtite_cart+'</span> x <span class="amount-cart-product">'+data.cart.product.prix_qtite_unit+'</span> F</span>';
                newProductCart_html +=' </li>';
                //console.log(newProductCart_html);
                $('.cart-list ').prepend(newProductCart_html);
           }else{
                //console.log("ancien produit");
                //console.log($('.'+data.cart.product.token+' .quantity .nbre-cart-product').html());
                $('.'+data.cart.product.token+' .quantity .nbre-cart-product').html(data.cart.product.qtite_cart);
           }

           $('.mini-cart-icon').attr('data-count', data.cart.total_nbre);
           $('.mini-cart-total').html(data.cart.total_amount+' F');
           $('.widget-shopping-cart-content .total .amount').html(data.cart.total_amount+' F');

           if(data.error === 'non'){
            //console.log(data.error_text);
            //location.reload(true);
                Swal({
                  title: data.error_text,
                  text: data.error_text_second,
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#2ecc71',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.value) {
                    //location.reload(true);
                  }
                });
           }
           
           //$('#products-related-container').html(data.produits_liste_html).fadeIn(500); 
        },
        error: function(jqXHR) {
          //console.log(jqXHR.responseText);
          console.log(jqXHR.responseText);
          if(jqXHR.responseJSON.error === 'oui'){
                Swal({
                  type: 'error',
                  title: jqXHR.responseJSON.error_text,
                  text: jqXHR.responseJSON.error_text_second
                });
          }

        }
    });
}

/* Fonction de recuperation de produit relatif a un produit particulier*/
function search_products_related(){

    var productDataCategory = $('#products-related-container').attr('product-data-category'); // filtre category

    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToProductRelated,
        data: {productDataCategory:productDataCategory},
        success: function (data, textStatus, jqXHR) {
           //console.log(data);
           if(data.productDataDisplay==true){
                $('#products-related-container').attr('product-display','true');
           }
           $('#products-related-container').html(data.produits_liste_html).fadeIn(500);
           
        },
        error: function(jqXHR) {
          //console.log(jqXHR.responseText);
          //alert('<div>'+jqXHR.responseText+'</div>');
          console.log(jqXHR);
        }
    });
}


function search_products(){

    var productDataSearch = $('#list_produits').attr('product-data-search'); // critere de recherce
    var productDataCategory = $('#list_produits').attr('product-data-category'); // filtre category
    var productDataNumberPage= $('#list_produits').attr('product-data-number-page'); //numero de la page courante
    var productDataOrder= $('#list_produits').attr('product-data-order'); // ordonnancement du plus... au moins...



    $.ajax({
        type: "POST",
        dataType: "json",
        url: linkToProductList,
        data: {productDataSearch:productDataSearch,productDataCategory:productDataCategory,productDataNumberPage:productDataNumberPage,productDataOrder:productDataOrder},
        success: function (data, textStatus, jqXHR) {
           console.log(data);
           if(data.productDataDisplay==true){
                $('#list_produits').attr('product-data-display','true');
                $('#list_produits').attr('product-data-search', data.productDataSearch);
                $('#list_produits').attr('product-data-category', data.productDataCategory);
                $('#list_produits').attr('product-data-number-page', data.productDataNumberPage);
                $('#list_produits').attr('product-data-order', data.productDataOrder);

                //productDataIsDisplay='true';
                
                $('.pagination').fadeIn(50).html(data.pagination_html);
           }
           $('#list_produits').fadeIn(500).html(data.produits_liste_html);
           $('.product-nombre-low').html(data.firstElement);
           $('.product-found').html(data.lastElement);
           $('.product-total').html(data.nombreProduits);
           //
           //window.location.replace(UrlToEspacePerso);
           //location.reload(true);
        },
        error: function(jqXHR) {
          // $('#errorLoginForm').prepend(jqXHR.responseJSON['error_html']);
          // $("#login-button-valide").val("Patientez...");
          //$('#list_produits').prepend(jqXHR.responseText);
          console.log(jqXHR.responseText);
          //console.log(data);
        }
    });
}

// for (var product in data.cart.products_list) {
           //      if (data.cart.products_list.hasOwnProperty(product)) {
           //          //console.log(product);
           //      }
           //  }

           //  Object.keys(data.cart.products_list).forEach(function(key) {
           //      console.log(data.cart.products_list[key].nom);
           //  });

})(window.jQuery);
