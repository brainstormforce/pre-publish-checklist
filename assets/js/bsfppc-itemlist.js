
jQuery( document ).ready( function(){   


var max_fields      = 10; 
var wrapper         = jQuery( '.input_fields_wrap' ); 
var add_button      = jQuery( '.add_field_button '); 
var item_content 	= [];
var drag_content = [];
var input_feilds = jQuery( '#add_item_text_feild[type="text"]' ); 


var x = 1; 
jQuery(add_button).click(function(e){ 
    e.preventDefault();
    if(x < max_fields){ 
        x++; 
        jQuery(wrapper).append('<div class="bsfppc-dynamicfeild"><input type="text" class="item_input" id="add_item_text_feild" name="bsfppc_checklist_item[]" required/> <td><p class="remove_field"><span class="dashicons dashicons-dismiss"></span></p></div></td>'); //add input box
    }
});
    
jQuery(wrapper).on("click",".remove_field", function(e){ 
    jQuery(this).parent('div').remove(); x--;
    // console.log('hi');
});
 
//Ajax trigger for adding an element in the array 
    jQuery("#Savelist").on('click', function () { 
    	jQuery( '.dragevent' ).load(location.href + document ); 
    	var item_content_var = jQuery('.item_input');  
			 item_content_var.each(function(){
			 	 item_content.push(jQuery(this).attr('value'));			  
			  });

                jQuery.post( bsfppc_add_delete_obj.url,                   
                       {
                        action: 'bsfppc_checklistitem_add',
                        item_content : item_content
                       }, function ( data ) {                    
                            if (data === 'sucess') { 
                            	jQuery( "#columns" ).load(window.location.href + " #columns" );
                                console.log('done');
                            } else if (data === 'failure') {  
                            	jQuery( "#columns" ).load(window.location.href + " #columns" );
                              console.log('failure');           
                            } else {
                              jQuery( "#columns" ).load(window.location.href + " #columns" );
                                console.log('bsf');
                                             
                            }
                        }
                );

            });

  jQuery(document).on( 'click' , '.bsfppcsave', function(){ 
      jQuery('.bsfppcsave').css("display", "none");
      jQuery('.drag-feilds').prop("readonly", true);
      var item_drag_var  =[];
        var item_drag_var   = jQuery('.drag-feilds'); 
         item_drag_var.each(function(){
           drag_content.push(jQuery(this).attr('value'));
          });          
          console.log(drag_content);
                  jQuery.post( bsfppc_add_delete_obj.url,                   
                         {
                          action: 'bsfppc_checklistitem_drag',
                          item_drag_var : drag_content
                         }, function ( data ) {                    
                              if (data === 'sucess') { 
                                  console.log('done');
                                   drag_content=[];
                              } else if (data === 'failure') {  
                                console.log('failure');   
                                 drag_content=[];        
                              } else {
                                  console.log('bsf'); 
                                   drag_content=[];                     
                              }
                          }
                  );
                 
              });

  jQuery('.bsfppcedit').click(function(){
      jQuery('.drag-feilds').removeAttr('readonly');
      jQuery('.bsfppcsave').css("display", "inline-block");

      });
//Ajax trigger for deleting an element in the array
      jQuery(document).on( 'click' , '.bsfppcdelete', function(){ 
                var txt;
                var r = confirm("Are you sure you want to delete ");
                if (r == true) {
                    jQuery(this).parents('li:first').remove();
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
                } else {
                  txt = "You pressed Cancel!";
                }
            });

jQuery(function() {
    jQuery( '.test' ).sortable({
      update: function( ) {
        console.log('Inside drag');
    var item_drag_var  =[];
      var item_drag_var   = jQuery('.drag-feilds'); 
       item_drag_var.each(function(){
         drag_content.push(jQuery(this).attr('value'));
        });          
        console.log(drag_content);
                jQuery.post( bsfppc_add_delete_obj.url,                   
                       {
                        action: 'bsfppc_checklistitem_drag',
                        item_drag_var : drag_content
                       }, function ( data ) {                    
                            if (data === 'sucess') { 
                                console.log('done');
                                 drag_content=[];
                            } else if (data === 'failure') {  
                              console.log('failure');   
                               drag_content=[];        
                            } else {
                                console.log('bsf'); 
                                 drag_content=[];                     
                            }
                        }
                );
        }
    });
    jQuery( '.test' ).disableSelection();
  });



});


