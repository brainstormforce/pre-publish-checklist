jQuery(document).ready(
    function() {
        var ppc_publish_flag = 0;
        var ppc_checkboxes = jQuery('.ppc_checkboxes[type="checkbox"]');
        var ppc_checkboxes_length = jQuery('.ppc_checkboxes[type="checkbox"]').length;
        var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
        var ppc_percentage_completed = (countCheckedppc_checkboxes / ppc_checkboxes_length) * 100;
        jQuery('.ppc-percentage').attr('style', 'width:' + ppc_percentage_completed + '%');
        jQuery(".ppc-percentage-value").html(Math.round(ppc_percentage_completed) + "%");

        //function to be executed when the itemlist changes.
        var ppc_checkbox_function = function() {
            var ppc_checkboxes = jQuery('.ppc_checkboxes[type="checkbox"]');
            var ppc_checkboxes_length = jQuery('.ppc_checkboxes[type="checkbox"]').length;
            var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
            if (ppc_checkboxes_length == countCheckedppc_checkboxes) {
                if (jQuery('.editor-post-publish-panel__toggle').length == 1) {
                    jQuery('.edit-post-header__settings').children(jQuery('#ppc-update').attr('style', 'display:none'));
                    jQuery('.edit-post-header__settings').children(jQuery('#ppc-publish').attr('style', 'display:none'));
                    jQuery('.editor-post-publish-panel__toggle').attr('style', 'display:inline-flex');
                } else if (jQuery('.editor-post-publish-button').length == 1) {
                    jQuery('.edit-post-header__settings').children(':eq(2)').after(jQuery('#ppc-update').attr('style', 'display:none'));
                    jQuery('.editor-post-publish-button').attr('style', 'display:inline-flex');
                }
            } else if (ppc_checkboxes_length != countCheckedppc_checkboxes) {
                if (jQuery('.editor-post-publish-panel__toggle').length == 1) {
                    jQuery('#ppc-update').attr('style', 'display:none');
                    jQuery('.editor-post-publish-panel__toggle').attr('style', 'display:none');
                    jQuery('.edit-post-header__settings').find('.editor-post-publish-panel__toggle').after(jQuery('#ppc-publish').attr('style', 'display:inline-flex'));
                    if (jQuery('#ppc-publish').length == 0) {
                        jQuery('.edit-post-header__settings').find('.editor-post-publish-panel__toggle').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-publish">Publish...</button>');
                    }
                } else if (jQuery('.editor-post-publish-button').length == 1) {
                    jQuery('.editor-post-publish-button').attr('style', 'display:none');
                    jQuery('.edit-post-header__settings').find('.editor-post-publish-button').after(jQuery('#ppc-update').attr('style', 'display:inline-flex'));
                    if (jQuery('#ppc-update').length == 0) {
                        jQuery('.edit-post-header__settings').children(':eq(2)').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-update">Update</button>');
                    }
                }
            }
        }
        //Strikethrough the checked item.
        jQuery(".ppc_checkboxes").each(function() {
            if (jQuery(this).prop("checked") == true) {
                jQuery(this).next().addClass("ppc-checklist-checked");
            } else if (jQuery(this).prop("checked") == false) {
                jQuery(this).next().removeClass("ppc-checklist-checked");
            }
        });
        jQuery(document).on('click', ".ppc_checkboxes", function() {
            jQuery(this).attr("name", "Delete");
            if (jQuery(this).prop("checked") == true) {
                jQuery(this).next().addClass("ppc-checklist-checked");

            } else if (jQuery(this).prop("checked") == false) {
                jQuery(this).next().removeClass("ppc-checklist-checked");
            }
        });

        jQuery(document).on('click', '.editor-post-switch-to-draft', function() {
            jQuery('#ppc_update').attr('style', 'display:none');
            jQuery('#ppc_publish').attr('style', 'display:inline-block');

        });
        //Change the progress bar length with respect to checked item.
        ppc_checkboxes.change(
            function() {
                var ppc_checkboxes = jQuery('.ppc_checkboxes[type="checkbox"]');
                var ppc_checkboxes_length = jQuery('.ppc_checkboxes[type="checkbox"]').length;
                var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
                var ppc_checked_checkboxes = ppc_checkboxes.filter(':checked');
                ppc_percentage_completed = (countCheckedppc_checkboxes / ppc_checkboxes_length) * 100;
                jQuery('.ppc-percentage').attr('style', 'width:' + ppc_percentage_completed + '%');
                jQuery(".ppc-percentage-value").html(Math.round(ppc_percentage_completed) + "%");
            });
        ppc_checkboxes.on(
            'change',
            function() {
                if (jQuery(this).prop("checked") == true) {
                    var ppc_post_id = jQuery("#post_ID").val();
                    jQuery.post(
                        ppc_meta_box_obj.url, {
                            action: 'ppc_ajax_add_change',
                            ppc_key_value: jQuery(this).attr('value'),
                            ppc_post_id: ppc_post_id,
                            ppc_field_value: jQuery(this).next().html(),
                            ppc_security: ppc_error_level.security
                        }
                    );
                } else if (jQuery(this).prop("checked") == false) {
                    var ppc_post_id = jQuery("#post_ID").val()
                    jQuery.post(
                        ppc_meta_box_obj.url, {
                            action: 'ppc_ajax_delete_change',
                            ppc_key_value: jQuery(this).attr('value'),
                            ppc_post_id: ppc_post_id,
                            ppc_security: ppc_error_level.security
                        }
                    );
                }
            }
        );
        if (jQuery('#publish').length !== 1) {
            setTimeout(
                function() {
                    if (ppc_error_level.option != 3 && (ppc_checkboxes_length != countCheckedppc_checkboxes)) {
                        if (jQuery('.editor-post-publish-panel__toggle').length == 1) {
                            jQuery('.editor-post-publish-panel__toggle').attr('style', 'display:none');
                        } else if (jQuery('.editor-post-publish-button').length == 1) {
                            jQuery('.editor-post-publish-button').attr('style', 'display:none');
                        }
                        if (jQuery('.edit-post-header__settings').find('.editor-post-save-draft').length != 0) {
                            jQuery('.edit-post-header__settings').find('.editor-post-publish-panel__toggle').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-publish">Publish...</button>');
						} else if (jQuery('.edit-post-post-status').find('.editor-post-switch-to-draft').length == 1) { // After 6.3 Switch to draft button is moved to post status panel.
							jQuery('.edit-post-header__settings').find('.editor-post-publish-button').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-update">Update</button>');
						} else if (jQuery('.edit-post-header__settings').find('.editor-post-switch-to-draft').length == 1) {
                            jQuery('.edit-post-header__settings').find('.editor-post-publish-button').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-update">Update</button>');
                        } else if (jQuery('.edit-post-header__settings').find('.editor-post-switch-to-draft').length == 0) {
                            jQuery('.edit-post-header__settings').find('.editor-post-publish-panel__toggle').after('<button type="button" class="components-button  is-button is-primary ppc-publish" id="ppc-publish">Publish...</button>');
                        }
                    }
                }, 10
            );
            if (ppc_error_level.option == 1 || ppc_error_level.option == 2) {
                ppc_checkboxes.change(ppc_checkbox_function);
            }
            //Do nothing--------------
            else if (ppc_error_level.option == 3) {
                var ppc_checkboxes = jQuery('.ppc_checkboxes[type="checkbox"]');
                var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
                ppc_checkboxes.change(
                    function() {
                        var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
                        var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
                        if (ppc_checkboxes.length == countCheckedppc_checkboxes) {
                            //all checkboxes are checked
                            if (jQuery('.editor-post-publish-panel__toggle').length == 1) {
                                jQuery('.editor-post-publish-panel__toggle').prop('title', 'All items checked ! You are good to publish');
                            } else if (jQuery('.editor-post-publish-button').length == 1) {
                                jQuery('.editor-post-publish-button').prop('title', 'All items checked ! You are good to publish');
                            }
                        } else if (ppc_checkboxes.length != countCheckedppc_checkboxes) {
                            // All ppc_checkboxes are not yet checked                                
                            if (jQuery('.editor-post-publish-panel__toggle').length == 1) {
                                jQuery('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist some items still remaining ');
                            } else if (jQuery('.editor-post-publish-button').length == 1) {
                                jQuery('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist some items still remaining !');
                            }
                        }
                    }
                );
            }
        } else {
            //Conditions for classic editor.
            if (ppc_error_level.option == 1 || ppc_error_level.option == 2) {
                jQuery(document).on('click', "#publish", function(e) {
                    var ppc_checkboxes = jQuery('.ppc_checkboxes[type="checkbox"]');
                    var countCheckedppc_checkboxes = ppc_checkboxes.filter(':checked').length;
                    if (ppc_checkboxes.length == countCheckedppc_checkboxes) {
                        return true;
                    } else {
                        if (ppc_publish_flag == 0) {

                            if (ppc_error_level.option == 2) {
                                jQuery('.ppc-modal-warn').attr('style', 'display:block');
                            } else if (ppc_error_level.option == 1) {

                                jQuery('.ppc-modal-prevent').attr('style', 'display:block');
                            }
                            return false;
                        } else if (ppc_publish_flag == 1) {

                            ppc_publish_flag == 0;
                            return true;
                        }
                    }
                });
            }
        }
        if (ppc_error_level.option == 2) {
            jQuery(document).on('click', "#ppc-update", function() {
                jQuery('.ppc-modal-warn').attr('style', 'display:block');
            });
            jQuery(document).on('click', "#ppc-publish", function() {
                jQuery('.ppc-modal-warn').attr('style', 'display:block');
            });
        } else if (ppc_error_level.option == 1) {
            jQuery(document).on('click', "#ppc-update", function() {
                jQuery('.ppc-modal-prevent').attr('style', 'display:inline-block');
            });
            jQuery(document).on('click', "#ppc-publish", function() {
                jQuery('.ppc-modal-prevent').attr('style', 'display:block');
                var content = jQuery("#ppc_custom_meta_box").html();
            });
        }
        jQuery(document).on('click', ".ppc-popup-options-publishanyway", function() {
            jQuery('.ppc-modal-warn').attr('style', 'display:none');
            if (jQuery('.editor-post-publish-panel__toggle').length == 1) {
                jQuery('#ppc-publish').attr('style', 'display:none');
                jQuery('#ppc-update').attr('style', 'display:none');
                jQuery('.editor-post-publish-panel__toggle').attr('style', 'display:inline-flex');
                jQuery('.editor-post-publish-panel__toggle').trigger('click', 'publish');
            } else if (jQuery('.editor-post-publish-button').length == 1) {
                jQuery('#ppc-update').attr('style', 'display:none');
                jQuery('.editor-post-publish-button').attr('style', 'display:inline-flex');
                jQuery('.editor-post-publish-button').trigger('click', 'update');
                jQuery('.editor-post-publish-button').attr('style', 'display:none');
                jQuery('#ppc-update').attr('style', 'display:inline-block');
            } else {
                ppc_publish_flag = 1;
                jQuery('.ppc-modal-warn').attr('style', 'display:none');
                jQuery('#publish').trigger('click', 'publish');
            }
        });
        jQuery(document).on('click', ".ppc-popup-option-dontpublish", function() {
            jQuery('.edit-post-sidebar__panel-tab').first().trigger('click', 'publish');
            if (jQuery('#ppc_custom_meta_box').attr("class") == 'postbox closed') {
                jQuery('#ppc_custom_meta_box').attr('class', 'postbox');
            }
            jQuery('.ppc-modal-warn').attr('style', 'display:none');
            document.querySelector('#ppc_custom_meta_box').scrollIntoView({
                behavior: 'smooth',
                block: "end",
                inline: "nearest"
            });
            jQuery("#ppc_custom_meta_box").scrollTop += 50;
            jQuery('#ppc_custom_meta_box').focus();
            jQuery('#ppc_custom_meta_box').addClass('ppc-metabox-background');
            setTimeout(function() {
                jQuery('#ppc_custom_meta_box').removeClass('ppc-metabox-background');
            }, 1000)
        });
        jQuery(document).on('click', ".ppc-popup-option-okay", function() {
            jQuery('.edit-post-sidebar__panel-tab').first().trigger('click', 'publish');
            if (jQuery('#ppc_custom_meta_box').attr("class") == 'postbox closed') {
                jQuery('#ppc_custom_meta_box').attr('class', 'postbox');
            }
            jQuery('.ppc-modal-prevent').attr('style', 'display:none');
            document.querySelector('#ppc_custom_meta_box').scrollIntoView({
                behavior: 'smooth',
                block: "end",
                inline: "nearest"
            });
            jQuery('#ppc_custom_meta_box').addClass('ppc-metabox-background');
            setTimeout(function() {
                jQuery('#ppc_custom_meta_box').removeClass('ppc-metabox-background');
            }, 1000)
        });
    }
);