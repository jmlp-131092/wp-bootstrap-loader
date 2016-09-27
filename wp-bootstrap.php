<?php
	/*
	Plugin Name: WP Bootstrap
	Plugin URI: http://wp-bootstrap.jmpinto.pt/
	Description: Include Twitter Bootstrap in your theme
	Version: 0.0.1
	Author: jmlp131092
	Author URI: http://www.github.com/jmlp131092
	Text Domain: wpboot
	*/
	define('WPBOOT_PATH', plugin_dir_path( __FILE__ ));
	define('WPBOOT_INC_PATH', plugin_dir_path( __FILE__ ) . '/includes/');
	define('WPBOOT_TEMPLATES_PATH', plugin_dir_path( __FILE__ ) . '/templates/');
	define('WPBOOT_BOOT_PATH', plugin_dir_url( __FILE__ ) . 'resources/bootstrap/');

	include(WPBOOT_INC_PATH . 'class-wp-bootstrap.php');

	function init_wp_bootstrap () {
		wp_enqueue_style( 'wp-bootstrap', WPBOOT_BOOT_PATH . 'css/bootstrap.css', array(), false, 'all' );		wp_enqueue_script( 'wp-bootstrap', WPBOOT_BOOT_PATH . 'js/bootstrap.js', array('jquery'), false, true );
	}
	add_action('wp_enqueue_scripts', 'init_wp_bootstrap');
?>
