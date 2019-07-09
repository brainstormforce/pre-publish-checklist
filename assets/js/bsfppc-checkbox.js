
$(document).ready(function(){

if($('.editor-post-publish-panel__toggle').length == 1) {
       setTimeout(function() {
          $('.editor-post-publish-panel__toggle').prop('disabled', true);
    }, 100); 
    } else if($('.editor-post-publish-button').length == 1) {
            setTimeout(function() {
              $('.editor-post-publish-button').prop('disabled', true);
        }, 100); 
    }
    var $checkboxes = $('#checkbox[type="checkbox"]');
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
    $checkboxes.change(function(){
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        if($checkboxes.length == countCheckedCheckboxes ){
        	// all checkboxes are check
            if($('.editor-post-publish-panel__toggle').length == 1) {
                $('.editor-post-publish-panel__toggle').prop('disabled', false);
            } else if($('.editor-post-publish-button').length == 1) {
                $('.editor-post-publish-button').prop('disabled', false);
            }
        }
        else{
        	// all checkboxes are not yet checked 
            if($('.editor-post-publish-panel__toggle').length == 1) {
                    $('.editor-post-publish-panel__toggle').prop('disabled', true);
            }
            else if($('.editor-post-publish-button').length == 1) {
                $('.editor-post-publish-button').prop('disabled', true);
            }
    
        }
    });

}); 
    