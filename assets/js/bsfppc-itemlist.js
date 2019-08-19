jQuery(document).ready(function () {
  var add_button = jQuery('.add_field_button ');
  var bsfppc_item_content = [];
  var bsfppc_drag_contents = [];
  var input_feilds = jQuery('#add_item_text_feild[type="text"]');

  //Ajax trigger for adding an element in the array 
     jQuery(document).on('click', "#bsfppc-Savelist", function () {
      console.log(jQuery('.bsfppc-item-input').val());
     if(jQuery('.bsfppc-item-input').val().replace(/ /g,'').length !== 0  ){   
     // $("#id").val().replace(/ /g,'').length
     jQuery('#bsfppc-ul').sortable();
    jQuery( "#bsfppc-ul" ).sortable( "destroy" );
      jQuery.post(bsfppc_add_delete_obj.url, {
          action: 'bsfppc_checklistitem_add',
          bsfppc_item_content: jQuery('.bsfppc-item-input').attr('value')
        },
        function (data) { 
          if (jQuery('.bsfppc-ul')[0]){
              jQuery(".bsfppc-ul").html(data);
          } else {
            data = '<ul id="bsfppc-ul" class="bsfppc-ul">'+data+'</ul>';
           jQuery(".bsfppcdragdrop").html(data);
          }    
      });
      jQuery('#bsfppc-ul').sortable({
          update: function () {
                  var bsfppc_item_drag_var = [];
                  var bsfppc_item_drag_var = jQuery('.bsfppc-drag-feilds');
                  bsfppc_item_drag_var.each(function () {
                    
                    bsfppc_drag_contents.push(jQuery(this).attr('value'));
                  });console.log(bsfppc_drag_contents);
                      jQuery.post(bsfppc_add_delete_obj.url, {
                      action: 'bsfppc_checklistitem_drag',
                      bsfppc_item_drag_var: bsfppc_drag_contents
                    }, function (data) {
                        if (data === 'sucess') {
                          bsfppc_drag_contents = [];
                        } else if (data === 'failure') {
                          bsfppc_drag_contents = [];
                        } else {
                          bsfppc_drag_contents = [];
                        }
                      });
          }, placeholder: "dashed-placeholder"
      },
      { cancel: '.bsfppc-alreadyexists-waring-description' });
      jQuery('.bsfppc-item-input').val(""); 
    }else{
      jQuery(".bsfppc-hide-cover").css("visibility", "visible");  
      setTimeout(function() {
        jQuery(".bsfppc-hide-cover").css("visibility", "hidden");
      }, 2000);
    }
  });

  //Ajax trigger for deleting an element in the array
  jQuery(document).on('click', '.bsfppcdelete', function () {
    console.log(jQuery(this).prev().val().length);
    // console.log(jQuery(this).prop("name")== 'Delete');
    if(jQuery(this).prop("name") == 'Delete'){
      console.log(jQuery('.bsfppcdelete').html() == 'Delete');
    var bsfppc_txt;
    var bsfppc_delete_flag = confirm("Are you sure you want to Delete ");
    if (bsfppc_delete_flag == true) {
      jQuery(this).parents('li:first').remove();
      jQuery.post(bsfppc_add_delete_obj.url, {
        action: 'bsfppc_checklistitem_delete',
        delete: jQuery(this).attr('value')
      }, function (data) {
        if (data === 'sucess') {
          
        } else {
          
        }
      });
    } else {
      bsfppc_txt = "You pressed Cancel!";
    }
  }
  else if(jQuery(this).prop("name") == 'Save'){

    if(jQuery(this).prev().val().replace(/ /g,'').length !== 0  ){   
      console.log('inside');

      jQuery(this).attr("name" , "Delete");
       jQuery(this).html("Delete");
      jQuery(this).prev().attr('readonly' , true );
        if( jQuery(this).val() != jQuery(this).prev().val() ){
                jQuery.post(bsfppc_add_delete_obj.url, {
                action: 'bsfppc_checklistitem_edit',
                bsfppc_edit_value : jQuery(this).prev().val(),
                bsfppc_prev_value : jQuery(this).val()
              }, function (data) {
                if (data === 'sucess') {
                  
                } else {

               
                  
                }
              });
        }

  }}else if(jQuery(this).prev().val().length == 0){   
     jQuery(".bsfppc-hide-cover").css("visibility", "visible");  
                setTimeout(function() {
                  jQuery(".bsfppc-hide-cover").css("visibility", "hidden");
                }, 2000);
  }
  });

        jQuery('#bsfppc-ul').sortable({
          update: function () {
                  var bsfppc_item_drag_var = [];
                  var bsfppc_item_drag_var = jQuery('.bsfppc-drag-feilds');
                  bsfppc_item_drag_var.each(function () {
                    
                    bsfppc_drag_contents.push(jQuery(this).attr('value'));
                  });console.log(bsfppc_drag_contents);
                      jQuery.post(bsfppc_add_delete_obj.url, {
                      action: 'bsfppc_checklistitem_drag',
                      bsfppc_item_drag_var: bsfppc_drag_contents
                    }, function (data) {
                        if (data === 'sucess') {
                          bsfppc_drag_contents = [];
                        } else if (data === 'failure') {
                          bsfppc_drag_contents = [];
                        } else {
                          bsfppc_drag_contents = [];
                        }
                      });
          }, placeholder: "dashed-placeholder"
      },
      { cancel: '.bsfppc-alreadyexists-waring-description' });

    jQuery(document).on('click', '.bsfppc-drag-feilds', function () {
    jQuery(this).removeAttr('readonly');
    jQuery(this).focus();
    jQuery(this).parent('.bsfppc-li').find(".bsfppcdelete").html("Save");
    jQuery(this).parent('.bsfppc-li').find(".bsfppcdelete").attr("name" , "Save");
   });  
});
