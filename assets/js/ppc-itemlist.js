jQuery(document).ready(function() {
    var add_button = jQuery('.add_field_button ');
    var ppc_drag_contents = [];
    var ppc_spinner = jQuery('.ppc-add-spinner');
    var input_feilds = jQuery('#add_item_text_feild[type="text"]');
    
    function ppc_sortable(){ 

            var url_string = window.location.href; //window.location.href.
            var url = new URL(url_string);
            var c = url.searchParams.get("type");
            console.log(c);

         jQuery('#ppc-ul').sortable({
            update: function() {
                jQuery('.ppc-spinner').addClass("is-active");
                jQuery(this).sortable("disable");
                var ppc_drag_contents = {};
                var ppc_item_drag_var = jQuery('.ppc-drag-feilds');
                ppc_item_drag_var.each(function() {
                    ppc_item_key = jQuery(this).attr('$ppc_item_key');
                    ppc_drag_contents[ppc_item_key] = jQuery(this).attr('value');

                });
                jQuery.post( 
                    ppc_add_delete_obj.url , {
                    action: 'ppc_checklistitem_drag',
                    ppc_order: ppc_drag_contents,
                    ppc_current_type: c,
                    ppc_security : ppc_add_delete_obj.security
                },
                function(data) { 
                        jQuery('#ppc-ul').sortable("enable");
                        jQuery('.ppc-spinner').removeClass("is-active");
                }
                );
            },
            placeholder: "ppc-dashed-placeholder"
        });
    }
    ppc_sortable( jQuery('#ppc-ul') );
    //Ajax trigger for adding an element in the array of checklist.
    jQuery(document).on('click', "#ppc-Savelist", function() {


        var url_string = window.location.href; //window.location.href
        var url = new URL(url_string);
        var c = url.searchParams.get("type");

        // console.log(c);

        ppc_sortable( jQuery('#ppc-ul') );
        ppc_spinner.addClass("is-active");
        var ppc_input_item = jQuery('.ppc-item-input').val();
        var ppc_item_drag_var = [];
        var ppc_drag_contents = [];
        var ppc_item_drag_var = jQuery('.ppc-drag-feilds');
        ppc_item_drag_var.each(function() {
            ppc_drag_contents.push(jQuery(this).attr('value'));
        });
        if (jQuery.inArray(ppc_input_item, ppc_drag_contents) !== -1) {
            var ppc_item_exists = 1;    
        } else {
            var ppc_item_exists = 0;
        }
        if (jQuery('.ppc-item-input').val().replace(/ /g, '').length !== 0 && ppc_item_exists == 0) {
            jQuery('.ppc-empty-list').attr('style', 'display:none');
            jQuery.post(ppc_add_delete_obj.url, {
                    action: 'ppc_checklistitem_add',
                    ppc_item_content: jQuery('.ppc-item-input').attr('value'),
                    ppc_current_type: c,
                    ppc_security : ppc_add_delete_obj.security
                },
                function(data) {
                     ppc_sortable( jQuery('#ppc-ul') );
                    if (jQuery('.ppc-ul')[0]) {
                        jQuery(".ppc-ul").html(data);
                        ppc_spinner.removeClass("is-active");
                        jQuery('.ppc-item-input').val("");
                        jQuery('ul.ppc-ul li:last-child').children().css('background-color', '#f7fcfe');
                        jQuery('ul.ppc-ul li:last-child').css('background-color', '#f7fcfe');
                     setTimeout(function(){
                        jQuery('ul.ppc-ul li:last-child').children().css('background-color', '#fff');
                        jQuery('ul.ppc-ul li:last-child').css('background-color', '#fff');
                        },1000)
                    } else {
                        data = '<ul id="ppc-ul" class="ppc-ul">' + data + '</ul>';
                        jQuery(".ppcdragdrop").html(data);
                        ppc_spinner.removeClass("is-active");
                        jQuery('.ppc-item-input').val("");
                        jQuery('ul.ppc-ul li:last-child').children().css('background-color','#f7fcfe');
                        jQuery('ul.ppc-ul li:last-child').css('background-color', '#f7fcfe');
                     setTimeout(function(){
                        jQuery('ul.ppc-ul li:last-child').children().css('background-color', '#fff');
                        jQuery('ul.ppc-ul li:last-child').css('background-color', '#fff');
                        },2000)
                    }
                });
            jQuery("#ppc-ul").sortable("refresh");            
        } else {
            jQuery(".ppc-hide-empty-warning").css("visibility", "visible");
            if (ppc_item_exists == 1) {
                jQuery(".ppc-list-waring-description").html('List item already exists');
                ppc_spinner.removeClass("is-active");
            } else {
                jQuery(".ppc-list-waring-description").html('List item cannot be empty');
                ppc_spinner.removeClass("is-active");
            }
            setTimeout(function() {
                jQuery(".ppc-hide-empty-warning").css("visibility", "hidden");
            }, 2000);
        }
    });
    //Ajax trigger for deleting an element in the array of checklist.
    jQuery(document).on('click', '.ppcdelete', function() {

        var url_string = window.location.href; //window.location.href
            var url = new URL(url_string);
            var c = url.searchParams.get("type");
            console.log(c);
        if (jQuery(this).prop("name") == 'Delete') {        
            var ppc_txt;
            var ppc_delete_flag = confirm("Are you sure to delete this checklist item?");
            if (ppc_delete_flag == true) {
                jQuery('.ppc-spinner').addClass("is-active");
                jQuery(this).parents('li:first').remove();
                console.log(jQuery(this).prevUntil(".dashicons-menu-alt2", ".ppc-drag-feilds").attr('$ppc_item_key'));
                jQuery.post(ppc_add_delete_obj.url, {
                    action: 'ppc_checklistitem_delete',
                    delete: jQuery(this).prevUntil(".dashicons-menu-alt2", ".ppc-drag-feilds").attr('$ppc_item_key'),
                    ppc_current_type: c,
                    ppc_security : ppc_add_delete_obj.security
                }, function( response ) {
                     if (response.success) {
                        jQuery('.ppc-spinner').removeClass("is-active");
                        }                    
                });      
            } else {
                ppc_txt = "You pressed Cancel!";
            }
        } else if (jQuery(this).prop("name") == 'Save') {


            jQuery(this).prevUntil(".dashicons-menu-alt2", ".ppc-drag-feilds").attr('style', 'width:80%');
            jQuery(this).prev().attr('style', 'display:inline-block');
            if (jQuery(this).prevUntil(".dashicons-menu-alt2", ".ppc-drag-feilds").val().replace(/ /g, '').length !== 0) {
                jQuery(this).attr("name", "Delete");
                jQuery(this).html('<span class="dashicons dashicons-trash ppc-delete-dashicon"></span>Delete');
                jQuery(this).prevUntil(".dashicons-menu-alt2", ".ppc-drag-feilds").attr('readonly', true);
                if (jQuery(this).val() != jQuery(this).prevUntil(".dashicons-menu-alt2", ".ppc-drag-feilds").val()) {
                    jQuery(this).attr("value", jQuery(this).prev().val());
                    jQuery('.ppc-spinner').addClass("is-active");
                    console.log(jQuery(this).prevUntil(".dashicons-menu-alt2", ".ppc-drag-feilds").attr('$ppc_item_key'));
                    jQuery.post(ppc_add_delete_obj.url, {               //url
                        action: 'ppc_checklistitem_edit',       
                        ppc_current_type: c,
                        ppc_edit_value: jQuery(this).prevUntil(".dashicons-menu-alt2", ".ppc-drag-feilds").val(),
                        ppc_edit_key: jQuery(this).prevUntil(".dashicons-menu-alt2", ".ppc-drag-feilds").attr('$ppc_item_key'),
                        ppc_security : ppc_add_delete_obj.security
                    }, function(data) {
                        jQuery('.ppc-spinner').removeClass("is-active");
                    });
                }
            }            
            jQuery("#ppc-ul").sortable("enable");
        } else if (jQuery(this).prev().val().length == 0) {

            jQuery(".ppc-hide-cover").css("visibility", "visible");
            setTimeout(function() {
                jQuery(".ppc-hide-cover").css("visibility", "hidden");
            }, 2000);
        }
        if (jQuery(".ppc-drag-feilds").length == 0) {

            jQuery('.ppc-empty-list').attr('style', 'display:block');
        } else if (jQuery(".ppc-drag-feilds").length !== 0) {

            jQuery('.ppc-empty-list').attr('style', 'display:none');
        }
    });
    //function to trigger on click of edit button.
    jQuery(document).on('click', '.ppcedit', function() {
        jQuery(".ppc-drag-feilds").each(function() {
            jQuery(this).attr('style', 'cursor:default');
        })
        jQuery(this).attr('style', 'display:none');
        jQuery(this).prev().attr('style', 'width:87%');
        jQuery("#ppc-ul").sortable("disable");
        jQuery(this).prev().removeAttr('readonly');
        jQuery(this).prev().focus();
        jQuery(this).parent('.ppc-li').find(".ppcdelete").html('<span class="dashicons dashicons-portfolio"></span> Save');
        jQuery(this).parent('.ppc-li').find(".ppcdelete").attr("name", "Save");
    });

    if (jQuery(".ppc-drag-feilds").length == 0) {
        jQuery('.ppc-empty-list').attr('style', 'display:block');
    } else if (jQuery(".ppc-drag-feilds").length !== 0) {
        jQuery('.ppc-empty-list').attr('style', 'display:none');
    }

});