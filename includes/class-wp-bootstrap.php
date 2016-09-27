<?php
	if ( !class_exists('WP_Bootstrap') ) :
		
		class WP_Bootstrap {

			public $settings, $settings_opts, $resources;

			public function __construct () {

				$this->settings = $this->__init_settings();
				$this->resources = array(
					'bootstrap.js' => 'JS',
					'bootstrap.css' => 'CSS',
					'bootstrap.min.js' => 'JS - Minified Version',
					'bootstrap.min.css' => 'CSS - Minified Version',
				);

				add_action( 'admin_notices', array($this, 'need_settings_config_notice__warning'));
				add_action('admin_menu', array( $this, 'settings_page'));

				add_action('admin_enqueue_scripts', array( $this, 'register_wpboot_admin_scripts'));
				add_action('wp_enqueue_scripts', array( $this, 'register_wpboot_frontend_scripts'));
				add_action('init', 'include_navwalker');

			}

			public function include_navwalker () {
				if ( $this->settings['_enable_bootstrap_walker'] == 'yes' && !class_exists('wp_bootstrap_navwalker') ) {
					include(WPBOOT_INC_PATH . 'wp_bootstrap_navwalker.php');
				}
			}

			public function __init_settings() {

				$this->settings_opts = array(
					'_enable_bootstrap_front',
					'_enable_bootstrap_back',
					'_enable_bootstrap_auto_updt',
					'_bootstrap_load_location',
					'_enabled_bootstrap_resources_front',
					'_enabled_bootstrap_resources_back',
					'_enabled_bootstrap_post_types',
					'_enable_bootstrap_walker'
				);

				$settings = array();

				foreach ( $this->settings_opts as $option ) :

					$settings[$option] = get_option($option);

				endforeach;

				return $settings;

			}

			public function settings_page () {
				add_submenu_page(
			        'options-general.php',
			        'WP Bootstrap',
			        'WP Bootstrap',
					'manage_options',
			        __FILE__,
			        array($this, 'settings_page_callback')
				);
			}

			public function settings_page_callback () {
				include(WPBOOT_TEMPLATES_PATH . 'settings.php' );
			}

			public function load_resource ( $resource = FALSE, $location = 'head' ) {

				$location = $location == 'head' ? false : true;
				$resource_type = end(explode('.', $resource)) == 'css' ? 'css' : 'js';

				switch ( $resource_type ) :
					case 'css':
						wp_enqueue_style('wp-bootstrap', WPBOOT_BOOT_PATH . 'css/' . $resource, false, 'all');
					break;
					case 'js':
						wp_enqueue_script('wp-bootstrap', WPBOOT_BOOT_PATH . 'js/' . $resource, array('jquery'), false, $location );
					break;
				endswitch;

			}

			public function enqueue_admin () {
				if ( $this->settings['_enable_bootstrap_back'] == 'yes' ) {
					foreach ( unserialize($this->settings['_enabled_bootstrap_resources_back']) as $resource ) :
						$this->load_resource( $resource, $this->settings['_bootstrap_load_location'] );
					endforeach;
				}
			}

			public function enqueue_frontend () {
				if ( $this->settings['enable_bootstrap_front'] == 'yes' ) {
					foreach ( unserialize($this->settings['_enabled_bootstrap_resources_front']) as $resource ) :
						$this->load_resource( $resource, $this->settings['_bootstrap_load_location'] );
					endforeach;
				}
			}

			public function register_wpboot_admin_scripts () {
				$this->enqueue_admin();
			}

			public function register_wpboot_frontend_scripts () {
				$this->enqueue_frontend();
			}

			public function need_settings_config_notice__warning () {
				if ( get_option('_wp_bootstrap_configured') == 'yes' ) return false;
				?>
					<div class="notice notice-warning is-dismissible">
						<p>
							<?php printf(__( 'Please %sconfigure%s WP Bootstrap.', 'wpboot' ), '<a href="' . get_site_url() .'/wp-admin/options-general.php?page=wp-bootstrap%2Fincludes%2Fclass-wp-bootstrap.php' . '">', '</a>'); ?>
						</p>
					</div>
				<?php
			}

			public function save_settings () {
				if ( is_admin() ) {

					if ( isset($_POST['_enable_bootstrap_back']) && $_POST['_enable_bootstrap_back'] == 'yes' ) {
						update_option('_enable_bootstrap_back', 'yes');
					} else {
						update_option('_enable_bootstrap_back', 'no');
					}

					if ( isset($_POST['_enable_bootstrap_front']) && $_POST['_enable_bootstrap_front'] == 'yes' ) {
						update_option('_enable_bootstrap_front', 'yes');
					} else {
						update_option('_enable_bootstrap_front', 'no');
					}

					if ( isset($_POST['_bootstrap_load_location']) ) {
						update_option('_bootstrap_load_location', $_POST['_bootstrap_load_location']);
					}

					if ( isset( $_POST['_enable_bootstrap_auto_updt']) && $_POST['_enable_bootstrap_auto_updt'] == 'yes' ) {
						update_option('_enable_bootstrap_auto_updt', 'yes');
					} else {
						update_option('_enable_bootstrap_auto_updt', 'no');
					}

					if ( isset($_POST['_enabled_bootstrap_resources_front']) ) {
						update_option('_enabled_bootstrap_resources_front', serialize($_POST['_enabled_bootstrap_resources_front']));
					}

					if ( isset($_POST['_enabled_bootstrap_resources_back']) ) {
						update_option('_enabled_bootstrap_resources_back', serialize($_POST['_enabled_bootstrap_resources_back']));
					}

					if ( isset($_POST['_enabled_bootstrap_post_types']) ) {
						update_option('_enabled_bootstrap_post_types', serialize($_POST['_enabled_bootstrap_post_types']));
					}

					if ( isset($_POST['_enable_bootstrap_walker']) && $_POST['_enable_bootstrap_walker'] == 'yes' ) {
						update_option('_enable_bootstrap_walker', 'yes');
					} else {
						update_option('_enable_bootstrap_walker', 'no');
					}

					if (isset($_POST['submit'])) {
						update_option('_wp_bootstrap_configured', 'yes');
					} else {
						update_option('_wp_bootstrap_configured', 'no');
					}
				}
			}

		}

	$GLOBALS['wp_bootstrap'] = new WP_Bootstrap();

	endif;

?>
