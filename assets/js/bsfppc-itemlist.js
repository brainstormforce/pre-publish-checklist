jQuery(document).ready(function() {
    var add_button = jQuery('.add_field_button ');
    var bsfppc_item_content = [];
    var bsfppc_drag_contents = [];
    var input_feilds = jQuery('#add_item_text_feild[type="text"]');

 
    jQuery('#bsfppc-ul').sortable({
        update: function() {
            jQuery('.bsfppc-spinner').addClass("is-active");
            bsfppc_drag_contents = [];

            jQuery(this).sortable("disable");
            var bsfppc_item_drag_var = [];
            var bsfppc_item_drag_var = jQuery('.bsfppc-drag-feilds');
            bsfppc_item_drag_var.each(function() {
                bsfppc_drag_contents.push(jQuery(this).attr('value'));
            });

            jQuery.post(bsfppc_add_delete_obj.url, {
                action: 'bsfppc_checklistitem_drag',
                bsfppc_item_drag_var: bsfppc_drag_contents
            }, function(data) {
                if (data === 'sucess') {
                    jQuery('#bsfppc-ul').sortable("enable");
                    jQuery('.bsfppc-spinner').removeClass("is-active");
                }
            });
        },
        placeholder: "dashed-placeholder"
    });
    //Ajax trigger for adding an element in the array 
    jQuery(document).on('click', "#bsfppc-Savelist", function() {
        jQuery('.bsfppc-add-spinner').addClass("is-active");
        var bsfppc_input_item = jQuery('.bsfppc-item-input').val()
        var bsfppc_item_drag_var = [];
        var bsfppc_item_drag_var = jQuery('.bsfppc-drag-feilds');
        bsfppc_item_drag_var.each(function() {

            bsfppc_drag_contents.push(jQuery(this).attr('value'));
        });
        if (jQuery.inArray(bsfppc_input_item, bsfppc_drag_contents) !== -1) {
            var bsfppc_item_exists = 1;
            

        } else {
            var bsfppc_item_exists = 0;
        }
        if (jQuery('.bsfppc-item-input').val().replace(/ /g, '').length !== 0 && bsfppc_item_exists !== 1) {
            
            jQuery('.bsfppc-empty-list').attr('style', 'visibility:hidden');
            jQuery.post(bsfppc_add_delete_obj.url, {
                    action: 'bsfppc_checklistitem_add',
                    bsfppc_item_content: jQuery('.bsfppc-item-input').attr('value')
                },
                function(data) {
                    if (jQuery('.bsfppc-ul')[0]) {
                        jQuery(".bsfppc-ul").html(data);
                        jQuery('.bsfppc-add-spinner').removeClass("is-active");
                        jQuery('.bsfppc-item-input').val("");
                                            jQuery("ul.bsfppc-ul li:last-child").addClass("bsfppc-new-list-item");
                     setTimeout(function(){
                             jQuery('ul.bsfppc-ul li:last-child').removeClass('bsfppc-new-list-item');
                        },1000)
                    } else {
                        data = '<ul id="bsfppc-ul" class="bsfppc-ul">' + data + '</ul>';
                        jQuery(".bsfppcdragdrop").html(data);
                        jQuery('.bsfppc-add-spinner').removeClass("is-active");
                        jQuery('.bsfppc-item-input').val("");
                         jQuery("ul.bsfppc-ul li:last-child").animate("bsfppc-new-list-item");
                        jQuery("ul.bsfppc-ul li:last-child").addClass("bsfppc-new-list-item");
                     setTimeout(function(){
                             jQuery('ul.bsfppc-ul li:last-child').removeClass('bsfppc-new-list-item');
                        },2000)
                    }
                });

            jQuery("#bsfppc-ul").sortable("refresh");


            
        } else {
            jQuery(".bsfppc-hide-empty-warning").css("visibility", "visible");
            if (bsfppc_item_exists == 1) {
                jQuery(".bsfppc-list-waring-description").html('List item already exists');
                jQuery('.bsfppc-add-spinner').removeClass("is-active");
            } else {
                jQuery(".bsfppc-list-waring-description").html('List item cannot be empty');
                jQuery('.bsfppc-add-spinner').removeClass("is-active");
            }
            setTimeout(function() {
                jQuery(".bsfppc-hide-empty-warning").css("visibility", "hidden");
            }, 2000);
        }
    });

    //Ajax trigger for deleting an element in the array
    jQuery(document).on('click', '.bsfppcdelete', function() {

        if (jQuery(this).prop("name") == 'Delete') {
        
            var bsfppc_txt;
            var bsfppc_delete_flag = confirm("Are you sure you want to Delete ");
            if (bsfppc_delete_flag == true) {
                jQuery('.bsfppc-spinner').addClass("is-active");
                jQuery(this).parents('li:first').remove();
                jQuery.post(bsfppc_add_delete_obj.url, {
                    action: 'bsfppc_checklistitem_delete',
                    delete: jQuery(this).prevUntil(".dashicons-menu-alt2", ".bsfppc-drag-feilds").val()
                }, function(data) {
                    if (data === 'sucess') {
                        jQuery('.bsfppc-spinner').removeClass("is-active");

                    } else {
                        jQuery('.bsfppc-spinner').removeClass("is-active");

                    }
                });
                
                
            } else {
                bsfppc_txt = "You pressed Cancel!";
            }
        } else if (jQuery(this).prop("name") == 'Save') {
            jQuery(this).prevUntil(".dashicons-menu-alt2", ".bsfppc-drag-feilds").attr('style', 'width:80%');
            jQuery(this).prev().attr('style', 'display:inline-block');

            if (jQuery(this).prevUntil(".dashicons-menu-alt2", ".bsfppc-drag-feilds").val().replace(/ /g, '').length !== 0) {
                
                jQuery(this).attr("name", "Delete");
                jQuery(this).html('<span class="dashicons dashicons-trash bsfppc-delete-dashicon"></span>Delete');
                jQuery(this).prevUntil(".dashicons-menu-alt2", ".bsfppc-drag-feilds").attr('readonly', true);
                if (jQuery(this).val() != jQuery(this).prevUntil(".dashicons-menu-alt2", ".bsfppc-drag-feilds").val()) {
                    jQuery('.bsfppc-spinner').addClass("is-active");
                    jQuery.post(bsfppc_add_delete_obj.url, {
                        action: 'bsfppc_checklistitem_edit',
                        bsfppc_edit_value: jQuery(this).prevUntil(".dashicons-menu-alt2", ".bsfppc-drag-feilds").val(),
                        bsfppc_prev_value: jQuery(this).val()
                    }, function(data) {
                        if (data === 'sucess') {

                            
                        }
                        jQuery('.bsfppc-spinner').removeClass("is-active");
                    });

                }
            }
            jQuery(this).attr("value", jQuery(this).prev().val());
            jQuery("#bsfppc-ul").sortable("enable");

        } else if (jQuery(this).prev().val().length == 0) {
            jQuery(".bsfppc-hide-cover").css("visibility", "visible");
            setTimeout(function() {
                jQuery(".bsfppc-hide-cover").css("visibility", "hidden");
            }, 2000);
        }
        if (jQuery(".bsfppc-drag-feilds").length == 0) {
            jQuery('.bsfppc-empty-list').attr('style', 'visibility:visible');
        } else if (jQuery(".bsfppc-drag-feilds").length !== 0) {
            jQuery('.bsfppc-empty-list').attr('style', 'visibility:hidden');
        }
    });

    jQuery(document).on('click', '.bsfppcedit', function() {
        jQuery(".bsfppc-drag-feilds").each(function() {
            jQuery(this).attr('style', 'cursor:default');
        })
        jQuery(this).attr('style', 'display:none');
        jQuery(this).prev().attr('style', 'width:88%');
        jQuery("#bsfppc-ul").sortable("disable");
        jQuery(this).prev().removeAttr('readonly');
        jQuery(this).prev().focus();
        jQuery(this).parent('.bsfppc-li').find(".bsfppcdelete").html('<span class="dashicons dashicons-portfolio"></span> Save');
        jQuery(this).parent('.bsfppc-li').find(".bsfppcdelete").attr("name", "Save");
    });

    if (jQuery(".bsfppc-drag-feilds").length == 0) {
        jQuery('.bsfppc-empty-list').attr('style', 'visibility:visible');
    } else if (jQuery(".bsfppc-drag-feilds").length !== 0) {
        jQuery('.bsfppc-empty-list').attr('style', 'visibility:hidden');
    }

});