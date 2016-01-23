<?php
/*
Plugin Name: Generic Template Widget
Plugin URI:  http://devrix.com
Description: A generic template widget plugin.
Version:     1.0
Author:      DevriX
Author URI:  http://devrix.com
Text Domain: dxgtw
*/

define( 'GEN_PATH', dirname( __FILE__ ) );
define( 'GEN_TEMP_PATH_INCLUDES', dirname( __FILE__ ) . '/inc' );
define( 'GEN_FOLDER', basename( GEN_PATH ) );
define( 'GEN_TEMP_URL', plugins_url() . '/' . GEN_FOLDER );
define( 'GEN_TEMP_URL_INCLUDES',  plugins_url() . '/' . GEN_FOLDER . '/inc' );
define( 'GEN_TEXT_DOMAIN', 'dxgtw' );

class Generic_Template {

	/*
	 * Initialize everything
	 */
	public function __construct() {
		// adding scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'gt_admin_scripts' ) );

		// add the generic template widget
		add_action( 'widgets_init', array( $this, 'gt_add_widget' ) );

		// adding pages
		add_action( 'load-customize.php', array( $this, 'gt_output_wp_editor_widget_html' ) );
		add_action( 'widgets_admin_page', array( $this, 'gt_output_wp_editor_widget_html' ), 100 );

		add_action( 'admin_menu', array( $this, 'register_my_custom_submenu_page') );
	}
	
	public function gt_admin_scripts() {
		if ( is_admin() ) { 
	        wp_register_script('script-js',  GEN_TEMP_URL .'/js/script.js', array( 'wp-color-picker' ), false, true ); 
	        wp_enqueue_script( 'script-js' );

	        wp_enqueue_media();
			wp_enqueue_script( 'media-upload' );

			wp_enqueue_style( 'admin-style-css', GEN_TEMP_URL .'/css/admin-style.css', array(), '1.0', 'screen' );

			wp_enqueue_script( 'wp-editor-widget-js', GEN_TEMP_URL .'/js/admin.js', array( 'jquery' ) );
	    }
	}
	
	public function gt_add_widget() {
		include_once( GEN_TEMP_PATH_INCLUDES . '/generic-template-widget.php' );
	}
	
	public function gt_output_wp_editor_widget_html() {
		?>
		<div id="wp-editor-widget-container">
			<a class="close" href="javascript:WPEditorWidget.hideEditor();" title="<?php esc_attr_e( 'Close', GEN_TEXT_DOMAIN ); ?>"><span class="icon"></span></a>
			<div class="editor">
				<?php
				$settings = array(
					'textarea_rows' => 20,
				);
				wp_editor( '', 'wpeditorwidget', $settings );
				?>
				<p>
					<a href="javascript:WPEditorWidget.updateWidgetAndCloseEditor(true);" class="button button-primary"><?php _e( 'Save and close', GEN_TEXT_DOMAIN ); ?></a>
				</p>
			</div>
		</div>
		<div id="wp-editor-widget-backdrop"></div>
		<?php
	}

	public function register_my_custom_submenu_page() {
		add_options_page(  __( 'Generic Template Help', GEN_TEXT_DOMAIN ), __( 'Generic Template Help', GEN_TEXT_DOMAIN), 'manage_options', 'generic-template-help', array( $this, 'generic_template_help_page' ) );
	}

	public function generic_template_help_page() {		
		include_once( GEN_TEMP_PATH_INCLUDES . '/generic-template-help-page.php' );
	}
}

// Initialize everything
$gt_plugin = new Generic_Template();