$( document ).ready( function(){  
    $('.edit-post-header__settings').children(':eq(1)').after('<div class="dashicons dashicons-warning"></div>');
        console.log('helllo');
        var $checkboxes = $( '#checkbox[type="checkbox"]' ); 
        var selected = [];
        $(function(){
    /*the function showInfo is executed on mouseover and mouseout*/
    $('.dashicons-warning').live('mouseover mouseout', function(event) {
        showInfo(event,this);
    });
    });
        $checkboxes.on('change', function () {

            if($(this).prop("checked") == true) {
             var bsfppc_post_id = $("#post_ID").val() 
                $.post( bsfppc_meta_box_obj.url,                   
                       {
                        action: 'bsfppc_ajax_add_change',               
                        bsfppc_field_value: $(this).attr( 'value' ) ,
                        bsfppc_post_id : bsfppc_post_id           
                       }, function ( data ) {                    
                            if (data === 'sucess') { 
                                console.log('done');
                            } else if (data === 'failure') {  
                                console.log('failure');           
                            } else {
                                console.log('bsf');                      
                            }
                        }
                );
            }

            else if($(this).prop("checked") == false ){    
                var bsfppc_post_id = $("#post_ID").val()
                $.post( bsfppc_meta_box_obj.url,                   
                       {
                        action: 'bsfppc_ajax_delete_change',               
                        bsfppc_field_value: $(this).attr( 'value' ) ,
                        bsfppc_post_id : bsfppc_post_id           
                       }, function ( data ) {                    
                            if (data === 'sucess') { 
                                console.log('done');
                            } else if (data === 'failure') {  
                                console.log('failure');           
                            } else {
                                console.log('bsf');                      
                            }
                        }
                );
            }
        });
        var $checkboxes = $( '#checkbox[type="checkbox"]' );
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;

    if( bsfppc_radio_obj.option == 2 || ( $checkboxes.length !== countCheckedCheckboxes ) ){
        $( ".popup-overlay" ).css("display", "block");
    }
 
    if( bsfppc_radio_obj.option!=3 && bsfppc_radio_obj.data.length!=0 && ( $checkboxes.length !== countCheckedCheckboxes) ){
        setTimeout(function() {
            $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
            // $('.edit-post-header__settings').children(':eq(1)').after('<div class="dashicons dashicons-warning"></div>');
                   
        }, 10); 
        setTimeout(function() {
            $( '.editor-post-publish-button' ).prop( 'disabled', true );  
            $('.edit-post-header__settings').children(':eq(1)').after('<div class="dashicons dashicons-warning"></div>');
        }, 10);
    }

    //prevent user from publishing 
    if( bsfppc_radio_obj.option == 1 ){
        var $checkboxes = $( '#checkbox[type="checkbox"]' );
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        $checkboxes.change(function(){
            var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                if( $checkboxes.length == countCheckedCheckboxes ){
                    // all checkboxes are check
                    $('.dashicons-warning').hide();
                    if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                        $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                         $( '.editor-post-publish-panel__toggle' ).prop( 'title', 'All items checked ! You are good to publish' );

                         
                    } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                        $( '.editor-post-publish-button').prop( 'disabled', false );
                           $('.editor-post-publish-button').prop( 'title', 'All items checked ! You are good to publish' );
    
                    } 
                }
                else{
                    // all checkboxes are not yet checked 
                    $('.dashicons-warning').show();
                    if( $('.editor-post-publish-panel__toggle' ).length == 1 ) {
                        $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
                        $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist please check all the items to publish or update' );

                    }
                    else if( $( '.editor-post-publish-button' ).length == 1 ) {
                        $( '.editor-post-publish-button' ).prop( 'disabled', true );
                        $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist please check all the items to publish or update' );

                    }
                }
        });
    }
   
    //warn user before publising-------------
    else if( bsfppc_radio_obj.option == 2 ){
    var $checkboxes = $( '#checkbox[type="checkbox"]' );
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        var $checkboxes = $( '#checkbox[type="checkbox"]' );
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        $checkboxes.change(function(){
            var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
            if( $checkboxes.length == countCheckedCheckboxes ){
                // all checkboxes are check
                $('.dashicons-warning').hide();
                if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                     $( '.editor-post-publish-panel__toggle' ).prop( 'title', 'All items checked ! You are good to publish' );
                     $(".popup-overlay").css("display", "none");
                } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button' ).prop( 'disabled', false );
                     $( '.editor-post-publish-button' ).prop( 'title', 'All items checked ! You are good to publish' );
                     $( ".popup-overlay" ).css( "display", "none" );
                } 
            }
            else  if( $checkboxes.length !== countCheckedCheckboxes ){
                // all checkboxes are not yet checked 
                $('.dashicons-warning').show();
                if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
                    $( '.editor-post-publish-panel__toggle' ).prop('title', 'Pre-Publish-Checklist please check all the items to publish or update or you can publish anyway' );
                    $( ".popup-overlay" ).css("display", "block");
                    $( "#close" ).on( "click", function(){
                            $(".popup-overlay").css("display", "none");
                            $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                    });
                }
                else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button' ).prop( 'disabled', true );
                     $( '.editor-post-publish-button' ).prop( 'title', 'Pre-Publish-Checklist please check all the items to publish or update or you can publish anyway' );
                    $( ".popup-overlay" ).css( "display", "block" );
                    $( "#close" ).on( "click", function(){
                            $(".popup-overlay").css("display", "none"); 
                            $( '.editor-post-publish-button' ).prop( 'disabled', false );
                    });
                }
            }
        }); 
    }
    //Do nothing--------------
    else if( bsfppc_radio_obj.option == 3 ){
      var $checkboxes = $( '#checkbox[type="checkbox"]' );
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        $checkboxes.change(function(){
            var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
            if( $checkboxes.length == countCheckedCheckboxes ){
                // all checkboxes are check
                $('.dashicons-warning').hide();
                if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                     $( '.editor-post-publish-panel__toggle' ).prop( 'title', 'All items checked ! You are good to publish' );
                     
                } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                      $('.editor-post-publish-button').prop( 'title', 'All items checked ! You are good to publish' );

                } 
            }
            else{
                // all checkboxes are not yet checked 
                $('.dashicons-warning').show();
                if( $('.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist some items still remaining ' );
                }
                else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist some items still remaining !' );
                }
            }
        });
    }



function showInfo(event, button)
{
if (event.type=="mouseover"){

var offset = $(button).offset();    
var topOffset = $(button).offset().top- $(window).scrollTop();
  
     $(".info").css({
        position: "fixed",
        top: (topOffset + 35)+ "px",
        left: (offset.left - 160) + "px",   
    });
}
  else
  $('.info').css({'left':-9999});
}


  
});     