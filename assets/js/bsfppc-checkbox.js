
$(document).ready(
    function () {
        
        var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
        var $bsfppc_checkboxes_length = $('#checkbox[type="checkbox"]').length;
        // console.log($bsfppc_checkboxes_length);
        
        var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
        // console.log(countCheckedbsfppc_checkboxes);
        // console.log( $('#checkbox[type="checkbox"]'));
        $(
            function () {
                /*the function showInfo is executed on mouseover and mouseout*/
                $('.dashicons-warning').live(
                    'mouseover mouseout', function (event) {
                        showInfo(event, this);
                    }
                );
            }
        );
        function showInfo(event, button)
        {
            if (event.type == "mouseover") {

                var offset = $(button).offset();
                var topOffset = $(button).offset().top - $(window).scrollTop();

                $(".bsfppc-info").css(
                    {

                        position: "fixed",
                        top: (topOffset + 35) + "px",
                        left: (offset.left - 180) + "px",
                    }
                );
            } else {
                $('.bsfppc-info').css(
                    {
                        'left': -9999
                    }
                );
            }
        }
        

        $bsfppc_checkboxes.on(
            'change', function () {

                if ($(this).prop("checked") == true) {
                    var bsfppc_post_id = $("#post_ID").val()
                    $.post(
                        bsfppc_meta_box_obj.url, {
                            action: 'bsfppc_ajax_add_change',
                            bsfppc_field_value: $(this).attr('value'),
                            bsfppc_post_id: bsfppc_post_id
                        }, function ( data ) {
                            if (data === 'sucess') {
                               
                            } else if (data === 'failure') {
                                
                            } else {
                                
                            }
                        } 
                    );
                } else if ($(this).prop("checked") == false ) {
                    
                    var bsfppc_post_id = $("#post_ID").val()
                    $.post(
                        bsfppc_meta_box_obj.url, {
                            action: 'bsfppc_ajax_delete_change',
                            bsfppc_field_value: $(this).attr('value'),
                            bsfppc_post_id: bsfppc_post_id
                        }, function (data) {
                            if (data === 'sucess') {
                               
                            } else if (data === 'failure') {
                                
                            } else {
                               
                            }
                        }
                    );
                }
            }
        );

 setTimeout(

            function () {
        
                if (bsfppc_radio_obj.option != 3 && ($bsfppc_checkboxes_length != countCheckedbsfppc_checkboxes) ){
                 
                    // console.log('checkednooooooooooooooooooooooooooooooooooo');

                     if ($('.editor-post-publish-panel__toggle').length == 1) {
                        // console.log('publish wlaa');
// console.log(($('.edit-post-header__settings').children('.editor-post-switch-to-draft').length == 0 ));
                                    // console.log("berrsdxsd");
                                    // console.log(($('.edit-post-header__settings').children('.editor-post-save-draft').length == 0));
                                   $('.editor-post-publish-panel__toggle').attr('style', 'display:none');

                                } else if ($('.editor-post-publish-button').length == 1) {
                                    // console.log('updatew wlaa');

                                    $('.editor-post-publish-button').attr('style', 'display:none');

                                }
                    if(  $('.edit-post-header__settings').children('.editor-post-save-draft').length != 0  ){
                        // console.log('new page');
                        $('.edit-post-header__settings').children(':eq(1)').after('<button type="button" class="components-button  is-button is-primary bsfppc-publish" id="bsfppc-publish">Publish...</button>');
                    }
                    else if ( $('.edit-post-header__settings').children('.editor-post-switch-to-draft').length == 1 ) {

                         // console.log('edit page');
                        $('.edit-post-header__settings').children(':eq(1)').after('<button type="button" class="components-button  is-button is-primary bsfppc-publish" id="bsfppc-update">Update</button>');
                    }
                    else if ( $('.edit-post-header__settings').children('.editor-post-switch-to-draft').length == 0 ) {

                         // console.log('add new post');
                        $('.edit-post-header__settings').children(':eq(1)').after('<button type="button" class="components-button  is-button is-primary bsfppc-publish" id="bsfppc-publish">Publish...</button>');
                    }

                }
        },10
    );

        if (bsfppc_radio_obj.option == 1 || bsfppc_radio_obj.option == 2 ){
        $bsfppc_checkboxes.change(
            function () {
                // console.log('hello  in change functiom');
                var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
                var $bsfppc_checkboxes_length = $('#checkbox[type="checkbox"]').length;
                var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
                if($bsfppc_checkboxes_length == countCheckedbsfppc_checkboxes ){
                        // console.log('checked condition');
                        // console.log('publish button length');
                        // console.log($('.editor-post-publish-panel__toggle').length);
                        // console.log('update button length');
                        // console.log($('.editor-post-publish-button').length);

                    if ($('.editor-post-publish-panel__toggle').length == 1) {
                        // console.log('checked condition for publish button');
                               
                        $('.edit-post-header__settings').children($('#bsfppc-publish').attr('style', 'display:none'));
                        $('.editor-post-publish-panel__toggle').attr('style', 'display:inline-flex');

                    } else if ($('.editor-post-publish-button').length == 1) {

                        // console.log('checked condition for update button');
                        $('.edit-post-header__settings').children(':eq(2)').after($('#bsfppc-update').attr('style', 'display:none'));
                        $('.editor-post-publish-button').attr('style', 'display:inline-flex');

                    }

                }else if($bsfppc_checkboxes_length != countCheckedbsfppc_checkboxes ){
                    // console.log('not checked condition');
                    if ($('.editor-post-publish-panel__toggle').length == 1) {
                        // console.log('publishaksbjbha');
                            $('.editor-post-publish-panel__toggle').attr('style', 'display:none');
                            // console.log($('#bsfppc-publish').length == 0);
                            $('.edit-post-header__settings').children(':eq(2)').after($('#bsfppc-publish').attr('style','display:inline-flex'));
                            if($('#bsfppc-publish').length == 0 ){
                                // console.log('in adding button');
                               $('.edit-post-header__settings').children(':eq(2)').after('<button type="button" class="components-button  is-button is-primary bsfppc-publish" id="bsfppc-publish">Publish...</button>');
                            }

                    } else if ($('.editor-post-publish-button').length == 1) {
                        // console.log('upadte');
                        // console.log($('#bsfppc-update').length);

                            $('.editor-post-publish-button').attr('style', 'display:none');
                            
                            $('.edit-post-header__settings').children(':eq(2)').after($('#bsfppc-update').attr('style','display:inline-flex'));
                            if($('#bsfppc-update').length == 0 ){
                                // console.log('adding button of not there');
                               $('.edit-post-header__settings').children(':eq(2)').after('<button type="button" class="components-button  is-button is-primary bsfppc-publish" id="bsfppc-update">Update</button>');
                            }




                    }
                }
            });
        }
        //Do nothing--------------
        else if (bsfppc_radio_obj.option == 3) {
            var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
            var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
            $bsfppc_checkboxes.change(
                function () {
                    var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
                    if ($bsfppc_checkboxes.length == countCheckedbsfppc_checkboxes) {
                        // all bsfppc_checkboxes are check
                        $('.dashicons-warning').hide();
                        if ($('.editor-post-publish-panel__toggle').length == 1) {
                            $('.editor-post-publish-panel__toggle').prop('title', 'All items checked ! You are good to publish');

                        } else if ($('.editor-post-publish-button').length == 1) {
                            $('.editor-post-publish-button').prop('title', 'All items checked ! You are good to publish');

                        }
                    } else if($bsfppc_checkboxes.length != countCheckedbsfppc_checkboxes)  {
                        // all bsfppc_checkboxes are not yet checked 
                        $('.dashicons-warning').show();
                        if ($('.editor-post-publish-panel__toggle').length == 1) {
                            $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist some items still remaining ');
                        } else if ($('.editor-post-publish-button').length == 1) {
                            $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist some items still remaining !');
                        }
                    }
                }
            );
        }

        if(bsfppc_radio_obj.option == 2){
           // console.log('warn user option');
        $(document).on('click', "#bsfppc-update", function () {
              // console.log(' warn clicked up[date] user option');

             $('.bsfppc-modal-warn').attr('style','display:block');

           });

        $(document).on('click', "#bsfppc-publish", function () {
             // console.log(' warn clicked publish  user option');
             $('.bsfppc-modal-warn').attr('style','display:block');
           
           });


         
        }else if(bsfppc_radio_obj.option == 1){
             // console.log(' prevent prevent user option');
        $(document).on('click', "#bsfppc-update", function () {
            // console.log(' prevent update button clicked');
             $('.bsfppc-modal-prevent').attr('style','display:inline-block');
           
           });


        $(document).on('click', "#bsfppc-publish", function () {
            // console.log('prevent publish button clicked');
             $('.bsfppc-modal-prevent').attr('style','display:block');
           
           });
         $(document).on('click',".bsfppc-popup-option-okay", function () {
             $('.bsfppc-modal-prevent').attr('style','display:none');
           
           });
        }
        
         $(document).on('click',".bsfppc-popup-options-publishanyway", function () {
              $('.bsfppc-modal-warn').attr('style','display:none');
             if ($('.editor-post-publish-panel__toggle').length == 1) {
                         // console.log('checked condition for publish button');
                               
                        $('.edit-post-header__settings').children($('#bsfppc-publish').attr('style', 'display:none'));
                        $('.editor-post-publish-panel__toggle').attr('style', 'display:inline-flex');
                        $('.editor-post-publish-panel__toggle').trigger('click', 'publish'); 

                    } else if ($('.editor-post-publish-button').length == 1) {

                        // console.log('checked condition for update button');
                        $('.edit-post-header__settings').children(':eq(2)').after($('#bsfppc-update').attr('style', 'display:none'));
                        $('.editor-post-publish-button').attr('style', 'display:inline-flex');
                        $('.editor-post-publish-button').trigger('click', 'update'); 

                    }        

                 
           });
          $(document).on('click',".bsfppc-popup-option-dontpublish", function () {
             $('.bsfppc-modal-warn').attr('style','display:none');
           
           });

    }

);