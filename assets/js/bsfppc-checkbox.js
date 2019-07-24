$( document ).ready( function(){  
console.log('helllo');
        var $checkboxes = $( '#checkbox[type="checkbox"]' ); 
        var selected = [];

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

    if( bsfppc_radio_obj.option!=3 && bsfppc_radio_obj.data.length!=0 && ( $checkboxes.length !== countCheckedCheckboxes) ){
        setTimeout(function() {
            $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
            $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');          
        }, 10); 
        setTimeout(function() {
            $( '.editor-post-publish-button' ).prop( 'disabled', true );
            $('.editor-post-publish-button').append('<span class="dashicons dashicons-warning"></span>');
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
                    if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                        $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                        // $( '.editor-post-publish-panel__toggle' ).prop( 'title', 'All items checked ! You are good to publish' );
                        $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                         
                    } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                        $( '.editor-post-publish-button').prop( 'disabled', false );
                          // $('.editor-post-publish-button').prop( 'title', 'All items checked ! You are good to publish' );
                          $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                    } 
                }
                else{
                    // all checkboxes are not yet checked 
                    if( $('.editor-post-publish-panel__toggle' ).length == 1 ) {
                        $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
                        $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist please check all the items to publish or update' );
                        $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                    }
                    else if( $( '.editor-post-publish-button' ).length == 1 ) {
                        $( '.editor-post-publish-button' ).prop( 'disabled', true );
                        $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist please check all the items to publish or update' );
                        $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
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
                if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                    // $( '.editor-post-publish-panel__toggle' ).prop( 'title', 'All items checked ! You are good to publish' );
                    $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                    $(".popup, .popup-content").css("visibility", "hidden");
                } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button' ).prop( 'disabled', false );
                     // $( '.editor-post-publish-button' ).prop( 'title', 'All items checked ! You are good to publish' );
                     $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                     $( ".popup, .popup-content" ).css( "visibility", "hidden" );
                } 
            }
            else{
                // all checkboxes are not yet checked 
                if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
                    $( '.editor-post-publish-panel__toggle' ).prop('title', 'Pre-Publish-Checklist please check all the items to publish or update or you can publish anyway' );
                    $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                    $( ".popup, .popup-content" ).css("visibility", "visible");
                    $( "#close" ).on( "click", function(){
                            $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                    });
                }
                else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button' ).prop( 'disabled', true );
                    // $( '.editor-post-publish-button' ).prop( 'title', 'Pre-Publish-Checklist please check all the items to publish or update or you can publish anyway' );
                    $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                    $( ".popup, .popup-content" ).css( "visibility", "visible" );
                    $( "#close" ).on( "click", function(){
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
                if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                    // $( '.editor-post-publish-panel__toggle' ).prop( 'title', 'All items checked ! You are good to publish' );
                    $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                     
                } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                      // $('.editor-post-publish-button').prop( 'title', 'All items checked ! You are good to publish' );
                      $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                } 
            }
            else{
                // all checkboxes are not yet checked 
                if( $('.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist some items still remaining ' );
                    $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                }
                else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist some items still remaining !' );
                    $('.editor-post-publish-panel__toggle').append('<span class="dashicons dashicons-warning"></span>');
                }
            }
        });
    }


    $(function(){
/*the function showInfo is executed on mouseover and mouseout*/
$('.editor-post-publish-button').live('mouseover mouseout', function(event) {
    showInfo(event,this);
});
});
function showInfo(event, button)
{
/*if the event is mouseover*/
if (event.type=="mouseover"){
/*get the coordinates of the button element using jquery offset*/
var offset = $(button).offset();    
/*get the top Position of the info element. $(window).scrollTop() is used to calculate the right top coordinate of the button element after the window is scrolled*/
var topOffset = $(button).offset().top- $(window).scrollTop();
  
  /*set the position of the info element*/
     $(".info").css({
        position: "fixed",
        top: (topOffset + 35)+ "px",
        left: (offset.left) + "px",   
    });
}
  else
  /*hide info element on mouseout*/
  $('.info').css({'left':-9999});
}


  
});     