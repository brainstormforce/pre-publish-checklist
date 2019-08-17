jQuery(document).ready(function () {
  var add_button = jQuery('.add_field_button ');
  var bsfppc_item_content = [];
  var bsfppc_drag_contents = [];
  var input_feilds = jQuery('#add_item_text_feild[type="text"]');

  //Ajax trigger for adding an element in the array 
     jQuery(document).on('click', "#bsfppc-Savelist", function () {
     if(jQuery('.bsfppc-item-input').val().length !== 0){   
      
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
    var bsfppc_txt;
    var bsfppc_delete_flag = confirm("Are you sure you want to delete ");
    if (bsfppc_delete_flag == true) {
      jQuery(this).parents('li:first').remove();
      console.time('Timer1');
      jQuery.post(bsfppc_add_delete_obj.url, {
        action: 'bsfppc_checklistitem_delete',
        delete: jQuery(this).attr('value')
      }, function (data) {
        if (data === 'sucess') {
          
        } else {
          
        }
      });console.timeEnd('Timer1');
    } else {
      bsfppc_txt = "You pressed Cancel!";
    }
  });

  jQuery(function () {
    jQuery('#bsfppc-ul').sortable({  
      update: function () {
        var bsfppc_item_drag_var = [];
        var bsfppc_item_drag_var = jQuery('.bsfppc-drag-feilds');
        bsfppc_item_drag_var.each(function () {
          bsfppc_drag_contents.push(jQuery(this).attr('value'));
        });
        console.log(bsfppc_drag_contents);
        jQuery.post(bsfppc_add_delete_obj.url, {
          action: 'bsfppc_checklistitem_drag',
          bsfppc_item_drag_var: bsfppc_drag_contents
        }, function (data) {
          if (data === 'sucess') {           
            bsfppc_drag_contents = [];
          } else {
            bsfppc_drag_contents = [];
          }
        });
      },
      cancel: '.bsfppc-alreadyexists-waring-description' ,
      placeholder: "dashed-placeholder"

    });

    jQuery('.bsfppc-ul').disableSelection();
  });






    jQuery(document).on('click', '.bsfppcsave', function () {
    var empty = true;
    jQuery('.bsfppc-drag-feilds').each(function(){
       if(jQuery(this).val().length == 0){
          empty =false;
          return false;
        }
     });
    if(empty == true) {   
    jQuery('.bsfppcsave').css("display", "none");
    jQuery('.bsfppc-drag-feilds').prop("readonly", true);
    var bsfppc_item_drag_var = [];
    var bsfppc_item_drag_var = jQuery('.bsfppc-drag-feilds');
    bsfppc_item_drag_var.each(function () {
      bsfppc_drag_contents.push(jQuery(this).attr('value'));
    });
    console.log(bsfppc_drag_contents);
    jQuery.post(bsfppc_add_delete_obj.url, {
      action: 'bsfppc_checklistitem_drag',
      bsfppc_item_drag_var: bsfppc_drag_contents
    }, function (data) {
      if (data === 'sucess') {
      } else {
        bsfppc_drag_contents = [];
      }
    });
  }else{
      jQuery(".edit-warning").css("display", "inline-block");  
      setTimeout(function() {
      jQuery(".edit-warning").css("display", "none");
      }, 2000);
    }
  });



   jQuery('.bsfppcedit').click(function () {
    jQuery('.bsfppc-drag-feilds' ).removeAttr('readonly');
    jQuery( '.bsfppc-drag-feilds' ).focus();
    jQuery('.bsfppcsave').css("display", "inline-block");

  });




});
