
jQuery( document ).ready( function(){  


var max_fields      = 10; 
var wrapper         = jQuery( '.input_fields_wrap' ); 
var add_button      = jQuery( '.add_field_button '); 
var item_content_var      = jQuery('.item_input');   
var item_content 	=[];
var input_feilds = jQuery( '#add_item_text_feild[type="text"]' ); 


var x = 1; 
jQuery(add_button).click(function(e){ 
    e.preventDefault();
    if(x < max_fields){ 
        x++; 
        jQuery(wrapper).append('<div><input type="text" class="item_input" id="add_item_text_feild" name="bsfppc_checklist_item[]" required/> <td><p class="remove_field"><span class="dashicons dashicons-dismiss"></span></p></div></td>'); //add input box
    }
});
     
//Ajax trigger for adding an element in the array 

    jQuery("#Savelist").on('click', function () { 
    	var item_content_var      = jQuery('.item_input');  
			 item_content_var.each(function(){
			 	 item_content.push(jQuery(this).attr('value'));			  
			  });

                jQuery.post( bsfppc_add_delete_obj.url,                   
                       {
                        action: 'bsfppc_checklistitem_add',
                        item_content : item_content
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
            });


//Ajax trigger for deleting an element in the array

    jQuery(".bsfppcdelete").on('click', function () { 
    	jQuery(this).parent('div').remove();
                jQuery.post( bsfppc_add_delete_obj.url,                   
                       {
                        action: 'bsfppc_checklistitem_delete',
                        delete : jQuery(this).attr('value')          
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
            });
});


