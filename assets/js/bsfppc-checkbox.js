
$( document ).ready( function(){

    var $checkboxes = $( '#checkbox[type="checkbox"]' );
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;

    if(bsfppc_radio_obj.option!=3){
        setTimeout(function() {
              $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
        }, 10); 
        setTimeout(function() {
              $( '.editor-post-publish-button' ).prop( 'disabled', true );
        }, 10);
    }
    console.log(bsfppc_radio_obj.option);
    //prevent user from publishing 
    if( bsfppc_radio_obj.option == 1 ){
         var newDiv = $('.components-notice-list').text('SUCCESS!!!').appendTo($('.components-notice-list'));
         newDiv.fadeOut(50000);
        if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
           setTimeout(function() {
                  $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
            }, 100); 
        } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                setTimeout(function() {
                      $( '.editor-post-publish-button' ).prop( 'disabled', true );
                }, 100); 
        }
         $( '.editor-post-publish-button' ).prop( 'disabled', true );
        var $checkboxes = $( '#checkbox[type="checkbox"]' );
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        $checkboxes.change(function(){
            var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
            if( $checkboxes.length == countCheckedCheckboxes ){
                // all checkboxes are check
                if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button').prop( 'disabled', false );
                } 
            }
            else{
                // all checkboxes are not yet checked 
                if( $('.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
                }
                else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button' ).prop( 'disabled', true );
                }
            }
        });
    }
    //warn user before publising-------------
    else if( bsfppc_radio_obj.option == 2 ){
    var $checkboxes = $( '#checkbox[type="checkbox"]' );
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
    //prevent user from publishing 
        if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
           setTimeout(function() {
                  $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
            }, 100); 
        } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                setTimeout(function() {
                      $( '.editor-post-publish-button' ).prop( 'disabled', true );
                }, 100); 
        }
         $( '.editor-post-publish-button' ).prop( 'disabled', true );
        var $checkboxes = $( '#checkbox[type="checkbox"]' );
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        $checkboxes.change(function(){
            var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
            if( $checkboxes.length == countCheckedCheckboxes ){
                // all checkboxes are check
                if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                     $(".popup, .popup-content").css("visibility", "hidden");
                } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button').prop( 'disabled', false );
                     $(".popup, .popup-content").css("visibility", "hidden");
                } 
            }
            else{
                // all checkboxes are not yet checked 
                if( $('.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
                    $(".popup, .popup-content").css("visibility", "visible");
                    $("#close").on("click", function(){
                            $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                    });
                }
                else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button' ).prop( 'disabled', true );
                    $(".popup, .popup-content").css("visibility", "visible");
                    $("#close").on("click", function(){
                            $( '.editor-post-publish-button' ).prop( 'disabled', false );
                    });
                }
            }
        }); 
    }
    //Do nothing--------------
    else if( bsfppc_radio_obj.option == 3 ){
      
    }

}); 
    