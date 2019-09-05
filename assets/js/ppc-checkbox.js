$(document).ready(
    function() {
        var ppc_publish_flag = 0;
        var ppc_checkboxes = $('#checkbox[type="checkbox"]');
        var ppc_checkboxes_length = $('#checkbox[type="checkbox"]').length; 
        var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
        var ppc_percentage_completed = (countCheckedppc_checkboxes / ppc_checkboxes_length)*100;
        $('.ppc-percentage').attr('style', 'width:'+ppc_percentage_completed+'%'); 
        jQuery(".ppc-percentage-value").html(Math.round(ppc_percentage_completed)+"%");

        $(".ppc_checkboxes").each(function(){
            if($(this).prop("checked") == true) {
                $(this).next().addClass("ppc-checklist-checked");

            }else if($(this).prop("checked") == false){
                $(this).next().removeClass("ppc-checklist-checked");
            }
        });
        ppc_checkboxes.change(
                        function() {
                            var ppc_checkboxes = $('#checkbox[type="checkbox"]');
                            var ppc_checkboxes_length = $('#checkbox[type="checkbox"]').length;
                            var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
                            var ppc_checked_checkboxes = ppc_checkboxes.filter(':checked');
                            ppc_percentage_completed = (countCheckedppc_checkboxes / ppc_checkboxes_length)*100;
                            $('.ppc-percentage').attr('style', 'width:'+ppc_percentage_completed+'%');
                             $(".ppc-percentage-value").html(Math.round(ppc_percentage_completed)+"%"); 
                         });

        $(document).on('click', ".ppc-hide-checked-item-buttton", function() {
            var ppc_checked_checkboxes = ppc_checkboxes.filter(':checked');
            
            if(ppc_checked_checkboxes.length !== 0 && $(this).prop("name") =="ppc-hide-checked-item" ){
                    
                ppc_checked_checkboxes.each(function(){                
                $(this).parents('.ppc-checklist-item-wrapper').hide();
                });
                $(this).attr("name", "ppc-show-checked-item");
                jQuery(this).html('Show Checked Items');   

            }else if($(this).prop("name") =="ppc-show-checked-item"){
                $(this).attr("name", "ppc-show-checked-item");
                ppc_checked_checkboxes.each(function(){                
                    $(this).parents('.ppc-checklist-item-wrapper').show();
                });
                $(this).attr("name", "ppc-hide-checked-item");
                jQuery(this).html('Hide Checked Items');  
            }
        });

        $(document).on('click', ".ppc_checkboxes", function() {
            jQuery(this).attr("name", "Delete");
            if($(this).prop("checked") == true) {
                $(this).next().addClass("ppc-checklist-checked");

            }else if($(this).prop("checked") == false){
                $(this).next().removeClass("ppc-checklist-checked");
            }

        });
        $(document).on('click', ".editor-post-preview", function() { 
                setTimeout( function() {
                            var ppc_checkboxes = $('#checkbox[type="checkbox"]');
                            var ppc_checkboxes_length = $('#checkbox[type="checkbox"]').length;
                            var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
                            if (ppc_checkboxes_length == countCheckedppc_checkboxes) {


                                if ($('.editor-post-publish-panel__toggle').length == 1) {


                                    $('.edit-post-header__settings').children($('#ppc-publish').attr('style', 'display:none'));
                                    $('.editor-post-publish-panel__toggle').attr('style', 'display:inline-flex');

                                } else if ($('.editor-post-publish-button').length == 1) {


                                    $('.edit-post-header__settings').children(':eq(2)').after($('#ppc-update').attr('style', 'display:none'));
                                    $('.editor-post-publish-button').attr('style', 'display:inline-flex');

                                }

                            } else if (ppc_checkboxes_length != countCheckedppc_checkboxes) {

                                if ($('.editor-post-publish-panel__toggle').length == 1) {

                                    $('.editor-post-publish-panel__toggle').attr('style', 'display:none');

                                    $('.edit-post-header__settings').children(':eq(2)').after($('#ppc-publish').attr('style', 'display:inline-flex'));
                                    if ($('#ppc-publish').length == 0) {

                                        $('.edit-post-header__settings').children(':eq(2)').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-publish">Publish...</button>');
                                    }

                                } else if ($('.editor-post-publish-button').length == 1) {

                                    $('.editor-post-publish-button').attr('style', 'display:none');

                                    $('.edit-post-header__settings').children(':eq(2)').after($('#ppc-update').attr('style', 'display:inline-flex'));
                                    if ($('#ppc-update').length == 0) {

                                        $('.edit-post-header__settings').children(':eq(2)').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-update">Update</button>');
                                    }
                                }
                            }
                    }, 2500
                );
        });    
        ppc_checkboxes.on(
            'change',
            function() {

                if ($(this).prop("checked") == true) {
                    var ppc_post_id = $("#post_ID").val()
                    $.post(
                        ppc_meta_box_obj.url, {
                            action: 'ppc_ajax_add_change',
                            ppc_field_value: $(this).attr('value'),
                            ppc_post_id: ppc_post_id
                        },
                    );
                } else if ($(this).prop("checked") == false) {

                    var ppc_post_id = $("#post_ID").val()
                    $.post(
                        ppc_meta_box_obj.url, {
                            action: 'ppc_ajax_delete_change',
                            ppc_field_value: $(this).attr('value'),
                            ppc_post_id: ppc_post_id
                        },
                    );
                }
            }
        );
    if($('#publish').length !== 1){
                setTimeout(

                    function() {

                        if (ppc_radio_obj.option != 3 && (ppc_checkboxes_length != countCheckedppc_checkboxes)) {


                            if ($('.editor-post-publish-panel__toggle').length == 1) {
                                $('.editor-post-publish-panel__toggle').attr('style', 'display:none');

                            } else if ($('.editor-post-publish-button').length == 1) {


                                $('.editor-post-publish-button').attr('style', 'display:none');

                            }
                            if ($('.edit-post-header__settings').children('.editor-post-save-draft').length != 0) {

                                $('.edit-post-header__settings').children(':eq(1)').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-publish">Publish...</button>');
                            } else if ($('.edit-post-header__settings').children('.editor-post-switch-to-draft').length == 1) {


                                $('.edit-post-header__settings').children(':eq(1)').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-update">Update</button>');
                            } else if ($('.edit-post-header__settings').children('.editor-post-switch-to-draft').length == 0) {


                                $('.edit-post-header__settings').children(':eq(1)').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-publish">Publish...</button>');
                            }

                        }
                    }, 10
                );

                if (ppc_radio_obj.option == 1 || ppc_radio_obj.option == 2) {
                    ppc_checkboxes.change(
                        function() {

                            var ppc_checkboxes = $('#checkbox[type="checkbox"]');
                            var ppc_checkboxes_length = $('#checkbox[type="checkbox"]').length;
                            var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;

                            if (ppc_checkboxes_length == countCheckedppc_checkboxes) {


                                if ($('.editor-post-publish-panel__toggle').length == 1) {


                                    $('.edit-post-header__settings').children($('#ppc-publish').attr('style', 'display:none'));
                                    $('.editor-post-publish-panel__toggle').attr('style', 'display:inline-flex');

                                } else if ($('.editor-post-publish-button').length == 1) {


                                    $('.edit-post-header__settings').children(':eq(2)').after($('#ppc-update').attr('style', 'display:none'));
                                    $('.editor-post-publish-button').attr('style', 'display:inline-flex');

                                }

                            } else if (ppc_checkboxes_length != countCheckedppc_checkboxes) {

                                if ($('.editor-post-publish-panel__toggle').length == 1) {

                                    $('.editor-post-publish-panel__toggle').attr('style', 'display:none');

                                    $('.edit-post-header__settings').children(':eq(2)').after($('#ppc-publish').attr('style', 'display:inline-flex'));
                                    if ($('#ppc-publish').length == 0) {

                                        $('.edit-post-header__settings').children(':eq(2)').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-publish">Publish...</button>');
                                    }

                                } else if ($('.editor-post-publish-button').length == 1) {

                                    $('.editor-post-publish-button').attr('style', 'display:none');

                                    $('.edit-post-header__settings').children(':eq(2)').after($('#ppc-update').attr('style', 'display:inline-flex'));
                                    if ($('#ppc-update').length == 0) {

                                        $('.edit-post-header__settings').children(':eq(2)').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-update">Update</button>');
                                    }
                                }
                            }
                        });
                }
                //Do nothing--------------
                else if (ppc_radio_obj.option == 3) {
                    var ppc_checkboxes = $('#checkbox[type="checkbox"]');
                    var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;

                    ppc_checkboxes.change(
                        function() {
                            var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;

                           
                            var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
                            if (ppc_checkboxes.length == countCheckedppc_checkboxes) {
                                //all checkboxes are checked
                                if ($('.editor-post-publish-panel__toggle').length == 1) {
                                    $('.editor-post-publish-panel__toggle').prop('title', 'All items checked ! You are good to publish');
                                } else if ($('.editor-post-publish-button').length == 1) {
                                    $('.editor-post-publish-button').prop('title', 'All items checked ! You are good to publish');
                                }
                            } else if (ppc_checkboxes.length != countCheckedppc_checkboxes) {
                                // all ppc_checkboxes are not yet checked 
                               
                                if ($('.editor-post-publish-panel__toggle').length == 1) {
                                    $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist some items still remaining ');
                                } else if ($('.editor-post-publish-button').length == 1) {
                                    $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist some items still remaining !');
                                }
                            }
                        }

                    );
                }
            }else{
                //Conditions for classic editor.
                   if (ppc_radio_obj.option == 1 || ppc_radio_obj.option == 2) {
                   
                       $(document).on('click', "#publish", function(e) {
                        var ppc_checkboxes = $('#checkbox[type="checkbox"]');
                        var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;


                        if (ppc_checkboxes.length == countCheckedppc_checkboxes){
                            return true;
                        }
                        else{
                               if(ppc_publish_flag == 0){
                                
                                    if (ppc_radio_obj.option == 2 ) {
                                        $('.ppc-modal-warn').attr('style', 'display:block');
                                    }
                                    else if(ppc_radio_obj.option == 1){
                                         
                                         $('.ppc-modal-prevent').attr('style', 'display:block');
                                    }
                                    return false;
                                }else if(ppc_publish_flag == 1){
                                    
                                    ppc_publish_flag == 0;
                                    return true;
                                }
                        }

                     });
                   }
            }
             
                    if (ppc_radio_obj.option == 2) {

                    $(document).on('click', "#ppc-update", function() {

                        $('.ppc-modal-warn').attr('style', 'display:block');

                    });

                    $(document).on('click', "#ppc-publish", function() {
                        $('.ppc-modal-warn').attr('style', 'display:block');


                    });


                } else if (ppc_radio_obj.option == 1) {

                    $(document).on('click', "#ppc-update", function() {

                        $('.ppc-modal-prevent').attr('style', 'display:inline-block');

                    });


                    $(document).on('click', "#ppc-publish", function() {

                        $('.ppc-modal-prevent').attr('style', 'display:block');

                        var content = $("#ppc_custom_meta_box").html();


                    });

                }

                $(document).on('click', ".ppc-popup-options-publishanyway", function() {
                
                    $('.ppc-modal-warn').attr('style', 'display:none');
                    if ($('.editor-post-publish-panel__toggle').length == 1) {

                        $('.edit-post-header__settings').children($('#ppc-publish').attr('style', 'display:none'));
                        $('.editor-post-publish-panel__toggle').attr('style', 'display:inline-flex');
                        $('.editor-post-publish-panel__toggle').trigger('click', 'publish');

                    } else if ($('.editor-post-publish-button').length == 1) {


                        $('.edit-post-header__settings').children(':eq(2)').after($('#ppc-update').attr('style', 'display:none'));
                        $('.editor-post-publish-button').attr('style', 'display:inline-flex');
                        $('.editor-post-publish-button').trigger('click', 'update');

                    }else {
                        
                        ppc_publish_flag = 1;
                        $('.ppc-modal-warn').attr('style', 'display:none');
                        $('#publish').trigger('click', 'publish');
                    }


                });
                $(document).on('click', ".ppc-popup-option-dontpublish", function() {

                     if( $('#ppc_custom_meta_box').attr("class") == 'postbox closed' ){
                        $('#ppc_custom_meta_box').attr('class','postbox');
                    }

                    $('.ppc-modal-warn').attr('style', 'display:none');
                    document.querySelector('#ppc_custom_meta_box').scrollIntoView({
                        behavior: 'smooth',
                        block: "end",
                        inline: "nearest"
                    });
                    $("#ppc_custom_meta_box").scrollTop += 50;

                    jQuery('#ppc_custom_meta_box').focus();
                    $('#ppc_custom_meta_box').addClass('ppc-metabox-background');
                     setTimeout(function(){
                             $('#ppc_custom_meta_box').removeClass('ppc-metabox-background');
                        },1000)
                });

                $(document).on('click', ".ppc-popup-option-okay", function() {
                    if( $('#ppc_custom_meta_box').attr("class") == 'postbox closed' ){
                        $('#ppc_custom_meta_box').attr('class','postbox');
                    }
                    $('.ppc-modal-prevent').attr('style', 'display:none');
                    document.querySelector('#ppc_custom_meta_box').scrollIntoView({
                        behavior: 'smooth',
                        block: "end",
                        inline: "nearest"                
                    });
                     $('#ppc_custom_meta_box').addClass('ppc-metabox-background');
                     setTimeout(function(){
                             $('#ppc_custom_meta_box').removeClass('ppc-metabox-background');
                        },1000)
                });
    }

);