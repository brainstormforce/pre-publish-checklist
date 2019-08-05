$(document).ready(function () {
    $('.edit-post-header__settings').children(':eq(1)').after('<div class="dashicons dashicons-warning"></div>');
    var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
    var selected = [];
    $(function () {
        /*the function showInfo is executed on mouseover and mouseout*/
        $('.dashicons-warning').live('mouseover mouseout', function (event) {
            showInfo(event, this);
        });
    });

    function showInfo(event, button) {
        if (event.type == "mouseover") {

            var offset = $(button).offset();
            var topOffset = $(button).offset().top - $(window).scrollTop();

         $(".info").css({

                position: "fixed",
                top: (topOffset + 35) + "px",
                left: (offset.left - 160) + "px",
            });
        } else
            $('.info').css({
                'left': -9999
            });
    }
    $bsfppc_checkboxes.on('change', function () {

        if ( $( this ).prop( "checked" ) == true) {
            var bsfppc_post_id = $("#post_ID").val()
            $.post( bsfppc_meta_box_obj.url, {
                action: 'bsfppc_ajax_add_change',
                bsfppc_field_value: $( this ).attr('value'),
                bsfppc_post_id: bsfppc_post_id
            }, function ( data ) {
                if (data === 'sucess') {
                    console.log('done');
                } else if (data === 'failure') {
                    console.log('failure');
                } else {
                    console.log('bsf');
                }
            } );
        } else if ( $( this ).prop( "checked" ) == false ) {
            var bsfppc_post_id = $( "#post_ID" ).val()
            $.post(bsfppc_meta_box_obj.url, {
                action: 'bsfppc_ajax_delete_change',
                bsfppc_field_value: $( this ).attr( 'value' ),
                bsfppc_post_id: bsfppc_post_id
            }, function (data) {
                if (data === 'sucess') {
                    console.log('done');
                } else if (data === 'failure') {
                    console.log('failure');
                } else {
                    console.log('bsf');
                }
            });
        }
    });
    var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
    var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;

    if (bsfppc_radio_obj.option == 2 && ($bsfppc_checkboxes.length !== countCheckedbsfppc_checkboxes)) {
        $(".bsfppc-overlay").css("display", "block");
         $("#close").on("click", function () {
                        $('.dashicons-warning').hide();
                        $(".bsfppc-overlay").css("display", "none");
                        $('.editor-post-publish-button').prop('disabled', false);
                    });
    }

    if (bsfppc_radio_obj.option != 3 && bsfppc_radio_obj.data.length != 0 && ($bsfppc_checkboxes.length !== countCheckedbsfppc_checkboxes)) {
        setTimeout(function () {
            $('.editor-post-publish-panel__toggle').prop('disabled', true);
            // $('.edit-post-header__settings').children(':eq(1)').after('<div class="dashicons dashicons-warning"></div>');

        }, 10);
        setTimeout(function () {
            $('.editor-post-publish-button').prop('disabled', true);
            $('.edit-post-header__settings').children(':eq(1)').after('<div class="dashicons dashicons-warning"></div>');
        }, 10);
    }

    //prevent user from publishing 
    if (bsfppc_radio_obj.option == 1) {
        var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
        var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
        $bsfppc_checkboxes.change(function () {
            var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
            if ($bsfppc_checkboxes.length == countCheckedbsfppc_checkboxes) {
                // all bsfppc_checkboxes are check
                $('.dashicons-warning').hide();
                if ($('.editor-post-publish-panel__toggle').length == 1) {
                    $('.editor-post-publish-panel__toggle').prop('disabled', false);
                    $('.editor-post-publish-panel__toggle').prop('title', 'All items checked ! You are good to publish');
                } else if ($('.editor-post-publish-button').length == 1) {
                    $('.editor-post-publish-button').prop('disabled', false);
                    $('.editor-post-publish-button').prop('title', 'All items checked ! You are good to publish');

                }
            } else {
                // all bsfppc_checkboxes are not yet checked 
                $('.dashicons-warning').show();
                if ($('.editor-post-publish-panel__toggle').length == 1) {
                    $('.editor-post-publish-panel__toggle').prop('disabled', true);
                    $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist please check all the items to publish or update'); 
                } else if ($('.editor-post-publish-button').length == 1) {
                    $('.editor-post-publish-button').prop('disabled', true);
                    $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist please check all the items to publish or update');

                }
            }
        });
    }

    //warn user before publising-------------
    else if (bsfppc_radio_obj.option == 2) {
        var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
        var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
        var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
        var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
        $bsfppc_checkboxes.change(function () {
            var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
            if ($bsfppc_checkboxes.length == countCheckedbsfppc_checkboxes) {
                // all bsfppc_checkboxes are check
                $('.dashicons-warning').hide();
                if ($('.editor-post-publish-panel__toggle').length == 1) {
                    $('.editor-post-publish-panel__toggle').prop('disabled', false);
                    $('.editor-post-publish-panel__toggle').prop('title', 'All items checked ! You are good to publish');
                    $(".bsfppc-overlay").css("display", "none");
                } else if ($('.editor-post-publish-button').length == 1) {
                    $('.editor-post-publish-button').prop('disabled', false);
                    $('.editor-post-publish-button').prop('title', 'All items checked ! You are good to publish');
                    $(".bsfppc-overlay").css("display", "none");
                }
            } else if ($bsfppc_checkboxes.length !== countCheckedbsfppc_checkboxes) {
                // all bsfppc_checkboxes are not yet checked 
                $('.dashicons-warning').show();
                if ($('.editor-post-publish-panel__toggle').length == 1) {
                    $('.editor-post-publish-panel__toggle').prop('disabled', true);
                    $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist please check all the items to publish or update or you can publish anyway');
                    $(".bsfppc-overlay").css("display", "block");
                    $("#close").on("click", function () {
                        $(".bsfppc-overlay").css("display", "none");
                        $('.editor-post-publish-panel__toggle').prop('disabled', false);
                    });
                } else if ($('.editor-post-publish-button').length == 1) {
                    $('.editor-post-publish-button').prop('disabled', true);
                    $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist please check all the items to publish or update or you can publish anyway');
                    $(".bsfppc-overlay").css("display", "block");
                    $("#close").on("click", function () {
                        $(".bsfppc-overlay").css("display", "none");
                        $('.editor-post-publish-button').prop('disabled', false);
                    });
                }
            }
        });
    }
    //Do nothing--------------
    else if (bsfppc_radio_obj.option == 3) {
        var $bsfppc_checkboxes = $('#checkbox[type="checkbox"]');
        var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
        $bsfppc_checkboxes.change(function () {
            var countCheckedbsfppc_checkboxes = $bsfppc_checkboxes.filter(':checked').length;
            if ($bsfppc_checkboxes.length == countCheckedbsfppc_checkboxes) {
                // all bsfppc_checkboxes are check
                $('.dashicons-warning').hide();
                if ($('.editor-post-publish-panel__toggle').length == 1) {
                    $('.editor-post-publish-panel__toggle').prop('title', 'All items checked ! You are good to publish');

                } else if ($('.editor-post-publish-button').length == 1) {
                    $('.editor-post-publish-button').prop('title', 'All items checked ! You are good to publish');

                }
            } else {
                // all bsfppc_checkboxes are not yet checked 
                $('.dashicons-warning').show();
                if ($('.editor-post-publish-panel__toggle').length == 1) {
                    $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist some items still remaining ');
                } else if ($('.editor-post-publish-button').length == 1) {
                    $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist some items still remaining !');
                }
            }
        });
    }
});