<?php

//$bsf_ppc_checklist_item_data = get_option('bsf_ppc_checklist_data');
 function bsf_ppc_add_custom_meta_box()
{
    $screens = ['post', 'page'];
    foreach ($screens as $screen) {
        add_meta_box(
            'wporg_box_id',           // Unique ID
            'Pre-publish checklist',  // Box title
            'bsf_ppc_custom_box_html',  // Content callback, must be of type callable
            $screen,
            'side'                  // Post type
        );
    }
}
add_action('add_meta_boxes', 'bsf_ppc_add_custom_meta_box');


function bsf_ppc_custom_box_html($post)
{

    $bsf_ppc_checklist_item_data = get_option('bsf_ppc_checklist_data');
    ?>
    <?php
    foreach( $bsf_ppc_checklist_item_data as $key) {
 	echo '<input type="checkbox" value="'.$key.'" >';
    echo $key;
    echo "<br/>";
 	}
   
}