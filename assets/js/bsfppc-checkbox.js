
$( document ).ready( function(){

    var $checkboxes = $( '#checkbox[type="checkbox"]' );
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;


    if( bsfppc_radio_obj.option!=3 && bsfppc_radio_obj.data.length!=0 ){
        setTimeout(function() {
              $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
              $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist please check all the items to publish or update' );
             
        }, 10); 
        setTimeout(function() {
              $( '.editor-post-publish-button' ).prop( 'disabled', true );
              $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist please check all the items to publish or update' );
        }, 10);
    }
    console.log(bsfppc_radio_obj.option);
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
                    $( '.editor-post-publish-panel__toggle' ).prop( 'title', 'All items checked ! You are good to publish' );
                     
                } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button').prop( 'disabled', false );
                      $('.editor-post-publish-button').prop( 'title', 'All items checked ! You are good to publish' );
                } 
            }
            else{
                // all checkboxes are not yet checked 
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
                if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                    $( '.editor-post-publish-panel__toggle' ).prop( 'title', 'All items checked ! You are good to publish' );
                     $(".popup, .popup-content").css("visibility", "hidden");
                } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button' ).prop( 'disabled', false );
                    $( '.editor-post-publish-button' ).prop( 'title', 'All items checked ! You are good to publish' );
                     $( ".popup, .popup-content" ).css( "visibility", "hidden" );
                } 
            }
            else{
                // all checkboxes are not yet checked 
                if( $( '.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', true );
                    $( '.editor-post-publish-panel__toggle' ).prop('title', 'Pre-Publish-Checklist please check all the items to publish or update or you can publish anyway' );
                    $( ".popup, .popup-content" ).css("visibility", "visible");
                    $( "#close" ).on( "click", function(){
                            $( '.editor-post-publish-panel__toggle' ).prop( 'disabled', false );
                    });
                }
                else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $( '.editor-post-publish-button' ).prop( 'disabled', true );
                    $( '.editor-post-publish-button' ).prop( 'title', 'Pre-Publish-Checklist please check all the items to publish or update or you can publish anyway' );
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
                    $( '.editor-post-publish-panel__toggle' ).prop( 'title', 'All items checked ! You are good to publish' );
                     
                } else if( $( '.editor-post-publish-button' ).length == 1 ) {
                      $('.editor-post-publish-button').prop( 'title', 'All items checked ! You are good to publish' );
                } 
            }
            else{
                // all checkboxes are not yet checked 
                if( $('.editor-post-publish-panel__toggle' ).length == 1 ) {
                    $('.editor-post-publish-panel__toggle').prop('title', 'Pre-Publish-Checklist some items still remaining !' );
                }
                else if( $( '.editor-post-publish-button' ).length == 1 ) {
                    $('.editor-post-publish-button').prop('title', 'Pre-Publish-Checklist some items still remaining !' );
                }
            }
        });
    }

}); 
    