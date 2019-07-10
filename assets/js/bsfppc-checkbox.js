
$( document ).ready( function(){
    console.log(bsfppc_radio_obj.option);
    //prevent user from publishing 
    if( bsfppc_radio_obj.option == 1 ){

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

    //warn user before publising--------------------------------------------------------------------------
    else if( bsfppc_radio_obj.option == 2 ){

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
                if( $('.editor-post-publish-panel__toggle' ).length == 1 ) {
                        $(".editor-post-publish-panel__toggle").on("click", function(){
                            console.log('in block kasakai****???');
                        $(".popup, .popup-content").css("visibility", "visible");
                         $(".popup, .popup-content").on("click", function(){
                            $(".popup, .popup-content").css("display", "none");
                         });
                        });
                }
                else if( $( '.editor-post-publish-button' ).length == 1 ) {
                        $(".editor-post-publish-button").on("click", function(){
                        console.log('in visible kasakai555');
                        
                        $(".popup, .popup-content").css("visibility", "visible"); 
                         $(".popup, .popup-content ").on("click", function(){
                            $(".popup, .popup-content").css("display", "none");
                         });   
                        });
                }
            }
        });
    }
    //Do nothing-------------------------------------------------------------------------------------------------------------------------------------------
    else if( bsfppc_radio_obj.option == 3 ){
        alert( "please make sure you check the checklist before publishing" );
    }

}); 
    