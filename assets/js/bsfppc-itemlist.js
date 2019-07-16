

console.log('hi');
var max_fields      = 10; 
var wrapper         = jQuery( '.input_fields_wrap' ); 
var add_button      = jQuery( '.add_field_button '); 
    
var x = 1; 
jQuery(add_button).click(function(e){ 
	
	console.log('hi');
    e.preventDefault();
    if(x < max_fields){ 
        x++; 
        jQuery(wrapper).append('<div><input type="text" name="bsfppc_checklist_item[]" required/> <td><p class="remove_field"><span class="dashicons dashicons-dismiss"></span></p></div></td>'); //add input box
    }
});
    
jQuery(wrapper).on("click",".remove_field", function(e){ 
    jQuery(this).parent('div').remove(); x--;
    console.log('hi');
});