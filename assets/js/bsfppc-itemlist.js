
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

// dragg ****************************************************************************************************************
jQuery(document).on('drop','.drag-feilds' , function () { 
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
    });

//*******************************************************************************************************

  jQuery(document).on( 'click' , '.bsfppcsave', function(){ 
     
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



var dragSrcEl = null;

function handleDragStart(e) {
  // Target (this) element is the source node.
  dragSrcEl = this;
  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.outerHTML);
  this.classList.add('dragElem');
}
function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }
  this.classList.add('over');
  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.
  return false;
}

function handleDragEnter(e) {
  // this / e.target is the current hover target.

}

function handleDragLeave(e) {
  this.classList.remove('over');  // this / e.target is previous target element.
}

function handleDrop(e) {
  // this/e.target is current target element.

  if (e.stopPropagation) {
    // e.stopPropagation(); // Stops some browsers from redirecting.
  }

  // Don't do anything if dropping the same column we're dragging.
  if (dragSrcEl != this) {
    // Set the source column's HTML to the HTML of the column we dropped on.
    //alert(this.outerHTML);
    // dragSrcEl.innerHTML = this.innerHTML;
    // this.innerHTML = e.dataTransfer.getData('text/html');
    this.parentNode.removeChild(dragSrcEl);
    var dropHTML = e.dataTransfer.getData('text/html');
    this.insertAdjacentHTML('beforebegin',dropHTML);
    var dropElem = this.previousSibling;
    addDnDHandlers(dropElem);
    
  }
  this.classList.remove('over');
  return false;
}

function handleDragEnd(e) {
  // this/e.target is the source node.
  this.classList.remove('over');

  [].forEach.call(cols, function (col) {
    col.classList.remove('over');
  });
}

function addDnDHandlers(elem) {
  elem.addEventListener('dragstart', handleDragStart, false);
  elem.addEventListener('dragenter', handleDragEnter, false);
  elem.addEventListener('dragover', handleDragOver, false);
  elem.addEventListener('dragleave', handleDragLeave, false);
  elem.addEventListener('drop', handleDrop, false);
  elem.addEventListener('dragend', handleDragEnd, false);
}

jQuery(document).on( 'dragstart' , '#columns .column', function(){ });
var cols = document.querySelectorAll('#columns .column');
[].forEach.call(cols, addDnDHandlers);





});


