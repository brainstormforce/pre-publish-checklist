<?php
/**
 * The Read meter Main frontend.
 *
 * @since      1.0.0
 * @package    BSF
 * @author     Brainstorm Force.
 */
?>
<h1>Pre-publish-checklist</h1>

<?php
$active_tab = 'bsfppc_general_settings';

if ( isset( $_GET['tab'] ) ) {

    if ( 'bsfppc_general_settings' === $_GET['tab'] ) {

        $active_tab = 'bsfppc_general_settings';

    } elseif ( 'bsfppc-checklist' === $_GET['tab'] ) {

        $active_tab = 'bsfppc-checklist';

    }
     elseif ( 'bsfppc-user-manual' === $_GET['tab'] ) {

        $active_tab = 'bsfppc-user-manual';

    }
}
    
?>

<h2 class="nav-tab-wrapper">
<a href="?page=bsf_ppc&tab=bsfppc_general_settings" class="nav-tab tb 
    <?php
    if ( 'bsfppc_general_settings' === $active_tab ) {
                    echo 'nav-tab-active';
    }
    ?>
    "><?php esc_attr_e( 'General Settings', 'Pre-publish-checklist' ); ?></a>


        <a href="?page=bsf_ppc&tab=bsfppc-checklist" class="nav-tab tb 
        <?php
        if ( 'bsfppc-checklist' === $active_tab ) {
                        echo 'nav-tab-active';
        }
        ?>
        "><?php esc_attr_e( 'Checklist', 'Pre-publish-checklist' ); ?></a>

        <a href="?page=bsf_ppc&tab=bsfppc-user-manual" class="nav-tab tb 
        <?php
        if ( 'bsfppc-user-manual' === $active_tab ) {
                        echo 'nav-tab-active';
        }
        ?>
        "><?php esc_attr_e( 'Getting Started', 'Pre-publish-checklist' ); ?></a>
</h2>

<?php

if ( isset( $_GET['tab'] ) ) {

    if ( 'bsfppc_general_settings' === $_GET['tab'] ) {
      
        require_once 'bsfppc-frontend.php';

    }
    elseif ('bsfppc-checklist' === $_GET['tab']) {
        require_once 'bsfppc-checklist.php';   
    }
    elseif ('bsfppc-user-manual' === $_GET['tab']) {
        require_once 'bsfppc-user-manual.php';   
    }
}else {

    require_once 'bsfppc-frontend.php';
}

