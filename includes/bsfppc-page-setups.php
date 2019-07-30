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
        add_action('wp_ajax_bsfppc_ajax_add_change', array( $this,'bsfppc_meta_box_ajax_add_handler') , 1 );
        add_action('wp_ajax_nopriv_bsfppc_ajax_add_change',array( $this,'bsfppc_meta_box_ajax_add_handler'), 1 );
        add_action('wp_ajax_bsfppc_ajax_delete_change', array( $this,'bsfppc_meta_box_ajax_delete_handler') , 1 );
        add_action('wp_ajax_nopriv_bsfppc_ajax_delete_change',array( $this,'bsfppc_meta_box_ajax_delete_handler'), 1 );
        add_action('admin_footer' , array( $this,'bsfppc_markup'));       
    }
   
         public function bsfppc_markup() {
             $bsfppc_screen = get_current_screen();
        if ((!empty($_GET['action']) && 'edit' == $_GET['action']) || 'edit.php' == $bsfppc_screen->parent_file || 'post-new.php' == $bsfppc_screen->parent_file){ 
            wp_enqueue_script( 'bsfppc_backend_checkbox_js' ); 
            wp_enqueue_style( 'bsfppc_backend_css' );       
        
           ?>
                  <div id="notifications" class="info">
                       <p class="bsfppc-tooltip">:Pre Publish Checklist: </p>
                       <p> Please ensure that you have checked the list before publishing or updating</p>
                   </div>
            

         <?php } }



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
           
            require_once BSF_PPC_ABSPATH.'includes/bsfppc-tabs.php';
        }

        public function bsfppc_add_custom_meta_box()
            {   
                $bsfppc_post_types_to_display= get_option('bsfppc_post_types_to_display');
                $screens = $bsfppc_post_types_to_display;
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
                            if(!empty($value)) {
                                foreach( $value as $keychecked) {
                                    checked($keychecked, $key);
                                }
                            } ?> >
                            <?php
                            echo $key;
                            echo "<br/>";                     
                        }       
                      ?>
                   
                            <div class="popup-overlay">
                                <div class="popup-content">
                                    <br>
                                    <p class="warning"> Please check all the checkboxes before publishing or you can publish anyway </p>
                                    <button id="close" class="components-button is-button is-default">Publish anyway !</button>    
                                </div>
                            </div>
                        <?php
                     }
                 else{
                    echo "Please create a list to display here from Settings->Pre-Publish-Checklist";
                 }
            }  

//add value from metabox chechbox to the wp_post_meta()
            
        public function bsfppc_meta_box_ajax_add_handler() {  
        if (isset($_POST['bsfppc_field_value'])) {
            $bsfppcpost =$_POST['bsfppc_post_id'];
            $bsfppc_check_data = array($_POST['bsfppc_field_value']);
            $pre_data = get_post_meta( $bsfppcpost, '_bsfppc_meta_key' , true );
            if( ! empty($pre_data)){
               $bsfppc_checklist_add_data = array_merge($pre_data, $bsfppc_check_data);
            }
            else{
                $bsfppc_checklist_add_data = $bsfppc_check_data;
            }

                   update_post_meta(
                        $post_id =  $bsfppcpost ,
                        '_bsfppc_meta_key',
                       $bsfppc_checklist_add_data 
                       
                    ); 
                    echo "sucess";      
                } 
              else{
                echo "failure";
              }   
            die;   
        }  
//delete value from post meta using chechbox uncheck from wp_post_meta()
        public function bsfppc_meta_box_ajax_delete_handler() {  
        if (isset($_POST['bsfppc_field_value'])) {
            $bsfppcpost =$_POST['bsfppc_post_id'];
                $bsfppc_delete =$_POST['bsfppc_field_value'];
                $pre_data = get_post_meta( $bsfppcpost, '_bsfppc_meta_key' , true );
                var_dump($pre_data);  
                if ( ( $key = array_search( $bsfppc_delete , $pre_data ) ) !== false ) {
                                unset($pre_data[$key]);      
                }
                update_post_meta(
                    $post_id =  $bsfppcpost ,
                    '_bsfppc_meta_key',
                    $pre_data        
                );            
        }
        else{
                echo "failure";
            }                    
            die;   
        }                      

}
BSFPPC_Pagesetups_::get_instance();
endif;