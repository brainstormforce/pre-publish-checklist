<?php
/**
 * Pre-Publish Checklist page setups comment
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Pre-Publish Checklist.
 * @author   Display Name <username@brainstormForce.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 */

/*
 * Main Frontpage.
 *
 * @since  1.0.0
 * @return void
 */

if ( ! class_exists( 'PPC_Pagesetups' ) ) :
	/**
	 * Pre-Publish Checklist Loader Doc comment
	 *
	 * PHP version 7
	 *
	 * @category PHP
	 * @package  Pre Publish Check-list
	 * @author   Display Name <username@brainstormForce.com>
	 * @license  http://brainstormforce.com
	 * @link     http://brainstormforce.com
	 */
	class PPC_Pagesetups {

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
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
			add_action( 'admin_init', array( $this, 'ppc_addition_column_name' ) );
			add_action( 'admin_init', array( $this, 'ppc_addition_column_data' ) );
			add_action( 'add_meta_boxes', array( $this, 'ppc_add_custom_meta_box' ) );
			add_action( 'admin_menu', array( $this, 'ppc_settings_page' ) );
			add_action( 'wp_ajax_ppc_ajax_add_change', array( $this, 'ppc_meta_box_ajax_add_handler' ), 1 );
			add_action( 'wp_ajax_ppc_ajax_delete_change', array( $this, 'ppc_meta_box_ajax_delete_handler' ), 1 );
			add_action( 'admin_footer', array( $this, 'ppc_markup' ) );
			add_action( 'restrict_manage_posts', array( $this, 'add_dropdown' ) );
			add_filter( 'pre_get_posts', array( $this, 'posts_filter' ) );
		}

		/**
		 * Add column name hook loop.
		 *
		 * @since 1.1.0
		 */
		public function ppc_addition_column_name() {
			$pst_typ_column_name = get_option( 'ppc_post_types_to_display' );
			foreach ( $pst_typ_column_name as $ppc_post_type_key ) {
				$manage_col_name = 'manage_';
				$ppc_posttype    = apply_filters( 'ppc_column_add', $ppc_post_type_key );
				$ppc_post_column = '_posts_columns';
				$ppc_column_name = $manage_col_name . $ppc_posttype . $ppc_post_column;
				add_action( $ppc_column_name, array( $this, 'ppc_add_column_name_func' ), 10, 1 );
			}
		}
		/**
		 * Add column data hook loop.
		 *
		 * @since 1.1.0
		 */
		public function ppc_addition_column_data() {
			$pst_typ_column_data = get_option( 'ppc_post_types_to_display' );
			foreach ( $pst_typ_column_data as $ppc_col_data_key ) {
				$manage_col_data = 'manage_';
				$posttype_col    = apply_filters( 'ppc_column_data', $ppc_col_data_key );
				$post_column_col = '_posts_custom_column';
				$ppc_column_data = $manage_col_data . $posttype_col . $post_column_col;
				add_action( $ppc_column_data, array( $this, 'ppc_column_data_func' ), 10, 2 );
			}
		}
		/**
		 * Rendered data.
		 *
		 * Rendered data into post column.
		 *
		 * @param string $columns for column.
		 * @param string $post_id for post id.
		 * @since 1.1.0
		 */
		public function ppc_column_data_func( $columns, $post_id ) {
			wp_enqueue_style( 'ppc_backend_css' );
			$ppc_total_checklist_data = PPC_Loader::get_instance()->get_list();
			$ppc_checked_data         = get_post_meta( get_the_ID(), '_ppc_meta_key', true );
			$current_screen_post_type = get_current_screen();
			$ppc_post_val_array       = isset( $ppc_total_checklist_data[ $current_screen_post_type->post_type ] ) ? $ppc_total_checklist_data[ $current_screen_post_type->post_type ] : '';
			switch ( $columns ) {
				case 'ppc_checklist':
					if ( empty( $ppc_post_val_array ) ) {
						echo esc_html( sprintf( __( 'No checklist found.', 'pre-publish-checklist' ) ) );
					} elseif ( isset( $ppc_post_val_array ) && empty( $ppc_checked_data ) ) {
						echo esc_html( sprintf( __( 'Checklist is empty', 'pre-publish-checklist' ) ) );
					} elseif ( isset( $ppc_post_val_array ) && ! empty( $ppc_post_val_array ) && isset( $ppc_checked_data ) && ! empty( $ppc_checked_data ) ) {
						$ppc_result = array_intersect_key( $ppc_post_val_array, $ppc_checked_data );
						if ( isset( $ppc_result ) && ! empty( $ppc_result ) && count( $ppc_post_val_array ) > count( $ppc_result ) ) {
							/* translators: %d: number term */
							echo esc_html( sprintf( __( '%1$d items completed out of %2$d', 'pre-publish-checklist' ), count( $ppc_result ), count( $ppc_post_val_array ) ) );
							echo '<br>';
							?>
						<progress value="<?php echo (int) count( $ppc_result ); ?>" max="<?php echo (int) count( $ppc_post_val_array ); ?>"></progress>
							<?php
						} elseif ( count( $ppc_post_val_array ) === count( $ppc_result ) ) {
							echo esc_html( sprintf( __( 'Checklist is complete', 'pre-publish-checklist' ) ) );
							echo '<br>';
							?>
						<progress value="<?php echo (int) count( $ppc_result ); ?>" max="<?php echo (int) count( $ppc_post_val_array ); ?>"></progress>
							<?php
						}
					}
					break;
			}
		}
		/**
		 * Function to add post column.
		 *
		 * @param string $columns for column.
		 *
		 * @since 1.1.0
		 */
		public function ppc_add_column_name_func( $columns ) {
			$columns = array(
				'cb'            => '<input type="checkbox"/)',
				'title'         => 'Title',
				'author'        => 'Author',
				'categories'    => 'Categories',
				'tags'          => 'Tags',
				'comments'      => '<span class="vers comment-grey-bubble" title="Comments"><span class="screen-reader-text">Comments</span></span>',
				'date'          => 'Date',
				'ppc_checklist' => 'Checklist Status',
			);
			return $columns;
		}
		/**
		 * Dropdown for page.
		 *
		 * @since 1.1.0
		 */
		public function add_dropdown() {
			$ppc_pst_type       = get_option( 'ppc_post_types_to_display' );
			$ppc_checklist_data = PPC_Loader::get_instance()->get_list();
			if ( isset( $ppc_pst_type ) && isset( $ppc_checklist_data ) ) {
				foreach ( $ppc_pst_type as $key ) {
					$ppc_page_data     = isset( $ppc_checklist_data[ $key ] ) ? $ppc_checklist_data[ $key ] : '';
					$current_post_type = get_current_screen();
					if ( $current_post_type->post_type === $key ) {
						?>
						<select class="select_multiple" name="slect_opt" id="slect_opt">
							<option value=""><?php esc_html_e( 'Filter Unchecked...', 'pre-publish-checklist' ); ?></option>
							<?php
							if ( isset( $ppc_page_data ) && is_array( $ppc_page_data ) ) {
								foreach ( $ppc_page_data as $ppc_key => $val ) {
									?>
									<option value="<?php echo esc_attr( $ppc_key ); ?>" class="test"
										<?php if ( isset( $_GET['slect_opt'] ) && wp_verify_nonce( sanitize_key( $_GET['slect_opt'] ) ) ) { ?>
											<?php $type = wp_verify_nonce( sanitize_key( $_GET['slect_opt'] ) ); ?>
										<?php } ?>
										<?php if ( isset( $_GET['slect_opt'] ) ) { ?>
											<?php echo $_GET['slect_opt'] === $ppc_key ? 'selected' : ''; ?>
											<?php } ?>>
											<?php echo esc_attr( wp_unslash( $val ) ); ?>
										</option>
									<?php } ?>
								}	
							</select>
								<?php
							}
					}
				}
			}
		}
		/**
		 * For query.
		 *
		 * @param string $query for querying.
		 *
		 * @since 1.1.0
		 */
		public function posts_filter( $query ) {
			if ( isset( $_GET['slect_opt'] ) && ! empty( $_GET['slect_opt'] ) ) {
				$fil                             = wp_verify_nonce( sanitize_key( $_GET['slect_opt'] ) );
				$value                           = sanitize_key( wp_unslash( $_GET['slect_opt'] ) );
				$meta_query                      = array(
					array(
						'relation' => 'OR',
						array(
							'key'     => '_ppc_meta_key',
							'value'   => $value,
							'compare' => 'NOT LIKE',
						),
						array(
							'key'     => '_ppc_meta_key',
							'compare' => 'NOT EXISTS',
						),
					),
				);
				$query->query_vars['meta_query'] = $meta_query; //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			}
		}
		/**
		 * Function for HTML markup of notification.
		 *
		 * Shows the pop-up of warning a user or preventing a user.
		 *
		 * @since 1.0.0
		 */
		public function ppc_markup() {
			$ppc_screen = get_current_screen();
			// If not edit or add new page, post or custom post type window then return.
			if ( ! isset( $ppc_screen->parent_base ) || ( isset( $ppc_screen->parent_base ) && 'edit' !== $ppc_screen->parent_base ) ) {
				return;
			}
			wp_enqueue_script( 'ppc_backend_checkbox_js' );
			wp_enqueue_style( 'ppc_backend_css' );
			?>
			<div class = "ppc-modal-warn">
				<div id="ppc_notifications" class="ppc-popup-warn">
					<h2><?php esc_html_e( 'Pre-Publish Checklist', 'pre-publish-checklist' ); ?></h2>
					<p class="ppc-popup-description"><?php esc_html_e( 'Your Pre-Publish Checklist is incomplete. What would you like to do?', 'pre-publish-checklist' ); ?></p>
					<div class="ppc-button-wrapper">
						<div class="ppc-popup-option-dontpublish"><?php esc_html_e( "Don't Publish", 'pre-publish-checklist' ); ?></div>
						<div class="ppc-popup-options-publishanyway"><?php esc_html_e( 'Publish Anyway', 'pre-publish-checklist' ); ?></div>
					</div>    
				</div>
			</div>
			<div class = "ppc-modal-prevent">
				<div id="ppc_notifications" class="ppc-popup-prevent">
					<h2><?php esc_html_e( 'Pre-Publish Checklist', 'pre-publish-checklist' ); ?></h2>
					<p class="ppc-popup-description"> <?php esc_html_e( 'Please check all the checklist items before publishing.', 'pre-publish-checklist' ); ?></p>
					<div class="ppc-prevent-button-wrapper">
						<div class="ppc-popup-option-okay"><?php esc_html_e( 'Okay, Take Me to the List!', 'pre-publish-checklist' ); ?></div>
					</div>  	
				</div>
			</div>
			<?php
		}

		/**
		 * Function for adding settings page in admin area
		 *
		 * Displays our plugin settings page in the WordPress
		 *
		 * @since 1.0.0
		 */
		public function ppc_settings_page() {
			add_submenu_page(
				'options-general.php',
				'Pre-Publish Checklist',
				'Pre-Publish Checklist',
				'manage_options',
				'ppc',
				array( $this, 'ppc_page_html' )
			);
		}
		/**
		 * Tabs function
		 *
		 * All the tabs are managed in the file which is included.
		 *
		 * @since 1.0.0
		 */
		public function ppc_page_html() {
			require_once PPC_ABSPATH . 'includes/ppc-tabs.php';
		}
		/**
		 * Add custom meta box
		 *
		 * Display plugin's custom meta box in the meta settings side bar
		 *
		 * @since 1.0.0
		 */
		public function ppc_add_custom_meta_box() {
			$ppc_post_types_to_display = get_option( 'ppc_post_types_to_display' );
			if ( ! empty( $ppc_post_types_to_display ) || false !== $ppc_post_types_to_display ) {
				foreach ( $ppc_post_types_to_display as $screen ) {
					add_meta_box(
						'ppc_custom_meta_box', // Unique ID.
						'Pre-Publish Checklist', // Box title.
						array( $this, 'ppc_custom_box_html' ), // Content callback, must be of type callable.
						$screen,
						'side',
						'high'
					);
				}
			}
		}

		/**
		 * Call back function for HTML markup of meta box.
		 *
		 * This functions contains the markup to be displayed or the information to be displayed in the custom meta box
		 *
		 * @since 1.0.0
		 */
		public function ppc_custom_box_html() {
			$ppc_screen = get_current_screen()->post_type;
			wp_enqueue_script( 'ppc_backend_checkbox_js' );
			wp_enqueue_script( 'ppc_backend_tooltip_js' );
			wp_enqueue_style( 'ppc_backend_css' );
			$ppc_checklist_item_data = PPC_Loader::get_instance()->get_list();
			$value                   = get_post_meta( get_the_ID(), '_ppc_meta_key', true );
			?>
			<?php
			if ( ! empty( $ppc_checklist_item_data[ $ppc_screen ] ) ) {
				?>
				<div class="ppc-percentage-wrapper">
					<span class="ppc-percentage-value"></span>
					<div class="ppc-percentage-background">
						<div class="ppc-percentage"></div>
					</div>
				</div>
				<?php
				foreach ( $ppc_checklist_item_data[ $ppc_screen ] as $ppc_key => $ppc_value ) {
					?>
					<label for="<?php echo esc_attr( $ppc_key ); ?>">
						<div class="ppc-checklist-item-wrapper">
							<input type="checkbox" name="checkbox[]" id="<?php echo esc_attr( $ppc_key ); ?>" class="ppc_checkboxes" value= "<?php echo esc_attr( $ppc_key ); ?>" 
							<?php
							empty( $value ) ? '' : checked( true, array_key_exists( $ppc_key, $value ) );
							?>
							>
							<div class="ppc-checklist"><?php echo esc_attr( $ppc_value ); ?></div></div>
						</label>
						<?php
				}
				?>
					<?php
			} else {
				echo 'Please create a list to display. Click <a href="options-general.php?page=ppc&tab=ppc_general_settings" >here</a>';
			}
		}
		/**
		 * Function for saving the meta box values
		 *
		 * Adds value from metabox chechbox to the wp_post_meta()
		 *
		 * @since 1.0.0
		 */
		public function ppc_meta_box_ajax_add_handler() {
			check_ajax_referer( 'ppc-security-nonce', 'ppc_security' );
			if ( isset( $_POST['ppc_field_value'] ) && isset( $_POST['ppc_post_id'] ) && isset( $_POST['ppc_key_value'] ) && ( current_user_can( 'edit_posts' ) || current_user_can( 'publish_posts' ) ) ) {
				$ppcpost        = sanitize_text_field( wp_unslash( $_POST['ppc_post_id'] ) );
				$ppc_key        = sanitize_text_field( wp_unslash( $_POST['ppc_key_value'] ) );
				$ppc_value      = sanitize_text_field( wp_unslash( $_POST['ppc_field_value'] ) );
				$ppc_check_data = array( $ppc_key => $ppc_value );
				$pre_data       = get_post_meta( $ppcpost, '_ppc_meta_key', true );
				if ( ! empty( $pre_data ) ) {
					$ppc_checklist_add_data = array_merge( $pre_data, $ppc_check_data );
				} else {
					$ppc_checklist_add_data = $ppc_check_data;
				}
				update_post_meta(
					$ppcpost,
					'_ppc_meta_key',
					$ppc_checklist_add_data
				);
				wp_send_json_success( __( 'sucess', 'pre-publish-checklist' ) );
			} else {
				wp_send_json_error( __( 'Sorry, you are not allowed to perform this action', 'pre-publish-checklist' ) );
			}
		}

		/**
		 * Function for deleting the meta box values
		 *
		 * Delete value from post meta using chechbox uncheck from wp_post_meta()
		 *
		 * @since 1.0.0
		 */
		public function ppc_meta_box_ajax_delete_handler() {
			check_ajax_referer( 'ppc-security-nonce', 'ppc_security' );
			if ( isset( $_POST['ppc_key_value'] ) && isset( $_POST['ppc_post_id'] ) && ( current_user_can( 'edit_posts' ) || current_user_can( 'publish_posts' ) ) ) {
				$ppcpost        = sanitize_text_field( wp_unslash( $_POST['ppc_post_id'] ) );
				$ppc_delete_key = sanitize_text_field( wp_unslash( $_POST['ppc_key_value'] ) );
				$pre_data       = get_post_meta( $ppcpost, '_ppc_meta_key', true );
				if ( ! empty( $pre_data ) ) {
					unset( $pre_data[ $ppc_delete_key ] );
				}
				update_post_meta(
					$ppcpost,
					'_ppc_meta_key',
					$pre_data
				);
				wp_send_json_success( __( 'sucess', 'pre-publish-checklist' ) );
			} else {
				wp_send_json_error( __( 'Sorry, you are not allowed to perform this action', 'pre-publish-checklist' ) );
			}
		}
	}
	PPC_Pagesetups::get_instance();
endif;
