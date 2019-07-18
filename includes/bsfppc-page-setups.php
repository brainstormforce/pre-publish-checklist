<?php
/**
 * The Pre Publish Checklist Sub-menu Display.
 *
 * @since      1.0.0
 * @package    BSF
 * @author     Brainstorm Force.
 */

/**
 * 
 *
 * @since  1.0.0
 * @return void
 */
/**
 * Main Frontpage.
 *
 * @since  1.0.0
 * @return void
 */

if ( ! class_exists( 'BSFPPC_Pagesetups_' ) ) :

class BSFPPC_Pagesetups_ {

    private static $instance;
    /**
     *  Initiator
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * Constructor
     */
    public function __construct() {

        add_action('add_meta_boxes', array($this,'bsfppc_add_custom_meta_box'));
        add_action( 'admin_menu', array($this,'bsf_ppc_settings_page') );
        add_action('wp_ajax_bsfppc_ajax_change', array( $this,'bsfppc_meta_box_ajax_handler') , 1 );
        add_action('wp_ajax_nopriv_bsfppc_ajax_change',array( $this,'bsfppc_meta_box_ajax_handler'), 1 );
        

    }
   

        public function bsf_ppc_settings_page() {
            add_submenu_page(
                'options-general.php',
                'Pre-publish Checklist',
                'Pre-publish Checklist',
                'manage_options',
                'bsf_ppc',
                array($this,'bsf_ppc_page_html')
            );
        }
       
        public function bsf_ppc_page_html() {
            require_once BSF_PPC_ABSPATH.'includes/bsfppc-frontend.php';
        }

        public function bsfppc_add_custom_meta_box()
            {   
 

                $screens = ['post', 'page'];
                foreach ($screens as $screen) {
                    add_meta_box(
                        'bsfppc_custom_meta_box',           // Unique ID
                        'Pre-Publish Checklist',  // Box title
                        array($this , 'bsfppc_custom_box_html'),  // Content callback, must be of type callable
                        $screen,
                        'side',
                        'high'
                    );
                }
            }
        

        public function bsfppc_custom_box_html() { 

                wp_enqueue_script( 'bsfppc_backend_checkbox_js' );
                wp_enqueue_script( 'bsfppc_backend_tooltip_js' );
                wp_enqueue_style( 'bsfppc_backend_css' );
                global $post;        
                $bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
                    if( !empty( $bsfppc_checklist_item_data ) ) {
                          $value = get_post_meta($post->ID, '_bsfppc_meta_key', true);

                            foreach( $bsfppc_checklist_item_data as $key) { ?>
                            <input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value= "<?php echo $key; ?>" <?php
                            foreach( $value as $keychecked) {
                            checked($keychecked, $key);
                        } ?> >
                            <?php
                            echo $key;
                            echo "<br/>";                     
                        }   
                
                      ?>
                        <div class="thickbox">
                            <div class="popup-overlay">
                                Creates the popup content
                                <div class="popup-content">
                                    <p> Please check all the checkboxes before publishing or you can publish anyway </p>
                                    <button id="close" class="components-button is-button is-default">Publish anyway !</button>    
                                </div>
                            </div>
                        </div><?php
                     }
                 else{
                    echo "Please create a list to display here from Settings->Pre-Publish-Checklist";
                 }
            }  

            
            public function bsfppc_meta_box_ajax_handler() {  
        if (isset($_POST['bsfppc_field_value'])) {
            $bsfppcpost =$_POST['bsfppc_post_id'];
            var_dump($bsfppcpost);
                    update_post_meta(
                        $post_id =  $bsfppcpost ,
                        '_bsfppc_meta_key',
                        $_POST['bsfppc_field_value']
                    );
                    
                } 
                echo "sucess";   
            die;
        
    }                       

}
BSFPPC_Pagesetups_::get_instance();
endif;