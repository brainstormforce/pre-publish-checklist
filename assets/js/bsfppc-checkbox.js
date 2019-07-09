
$(document).ready(function(){

    var $checkboxes = $('#checkbox[type="checkbox"]');
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
    $checkboxes.change(function(){
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
          var javascriptVariable = false;
 		  
        // $('#count-checked-checkboxes').text(countCheckedCheckboxes);
        // $('#edit-count-checked-checkboxes').val(countCheckedCheckboxes);
        if($checkboxes.length == countCheckedCheckboxes ){
        	// To send if this all checkboxes are check
        	document.cookie ='checked=true';
        	console.log('all checked');
        }
        else{
        	// To send if this all checkboxes are not yet checked 
        	document.cookie ='checked=false';
        	console.log('some remaining');
        }
    });

});



    // alert('please check all the checkboxes');  

    