<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * KINDLING_Admin_Pages Class
 *
 * A general class for About and Credits page.
 *
 * @since 1.0.0
 */
class KINDLING_Admin_Pages {
	private $theme_name;
	private $dir;

	/**
	 * Get things started
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		# Vars
		$info = kindling_get_theme_info();
		$this->theme_name      = $info['name'];
		$this->dir             = $info['dir'];

		# Actions
		add_action( 'admin_menu', 				array( $this, 'admin_menus' ) );
		add_action( 'admin_enqueue_scripts', 	array( $this, 'admin_pages_style' ) );
	}

	/**
	 * Add WP Dash Menu Item(s)
	 *
	 * @since 1.0.0
	 */
	public function admin_menus() {
		# Add Top-Level Menu Item: Kindling
		add_menu_page(
            'Kindling',
            'Kindling',
            'read',
            'kindling-theme-settings',
			array( $this, 'theme_settings_page' ),
            'dashicons-schedule'
        );
	}

	 /**
	 * Render Theme Settings Page
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function theme_settings_page() { ?>
		<section id="theme-settings-page-header">
			<h1> Kindling v<?php echo KINDLING_THEME_VERSION ?> </h1>
		</section>
		<section id="theme-settings-page-content">
			<p> Yup, this works. Put your content here. </p>
			
			<?php # Embed Theme Updater (License Key Input Field) 
				include( KINDLING_INC_DIR .'updater/theme-updater.php' );
				$updater->license_page();
			?>
		</section>
	<?php }

	/**
	 * Load admin pages css
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function admin_pages_style() {
		wp_enqueue_style( 'kindling-admin-pages', KINDLING_INC_DIR_URI . 'admin/admin.min.css', KINDLING_THEME_VERSION );
	}
}
new KINDLING_Admin_Pages();