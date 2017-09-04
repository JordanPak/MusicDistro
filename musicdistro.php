<?php
/**
 * Crunchy Tech
 *
 * @package     musicdistro
 * @author      Jordan Pakrosnis
 * @copyright   2017 JordanPak
 *
 * @wordpress-plugin
 * Plugin Name: MusicDistro
 * Plugin URI:  https://jordanpak.com
 * Description: Enables bands to distribute sheet music and other tools to its members!
 * Version:     1.0.0
 * Author:      Jordan Pakrosnis
 * Author URI:  https://jordanpak.com
 * Text Domain: musicdistro
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Main MusicDistro class.
 *
 * @since 1.0.0
 */
final class MusicDistro {

	/**
	 * The one and only instance of MusicDistro
	 *
	 * @var object
	 * @since 1.0.0
	 */
	private static $instance;


	/**
	 * Plugin version for enqueueing, etc.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $version = '1.0.0';


	/**
	 * @var object|MD_Roles
	 * @since 1.0.0
	 */
	public $roles;



	/**
	 * Main MusicDistro instance.
	 *
	 * @since 1.0.0
	 * @return MusicDistro
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof MusicDistro ) ) {

			self::$instance = new MusicDistro;
			self::$instance->constants();
			self::$instance->includes();
			// self::$instance->roles = new MD_Roles();
		
			add_action( 'plugins_loaded', array( self::$instance, 'objects' ), 10 );
		}

		return self::$instance;
	}


	
	/**
	 * Setup plugin constants.
	 *
	 * @since 1.0.0
	 */
	private function constants() {

		// plugin version
		if ( ! defined( 'MD_VERSION' ) ) {
			define( 'MD_VERSION', $this->version );
		}

		// plugin folder path
		if ( ! defined( 'MD_PLUGIN_DIR' ) ) {
			define( 'MD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// plugin folder URL
		if ( ! defined( 'MD_PLUGIN_URL' ) ) {
			define( 'MD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// plugin root file
		if ( ! defined( 'MD_PLUGIN_FILE' ) ) {
			define( 'MD_PLUGIN_FILE', __FILE__ );
		}
	}



	/**
	 * Include required files.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function includes() {

		// load every time
		$includes = array(
			'functions',
			'class-arrangement',
		);


		// if in admin
		if ( is_admin() ) {
			$includes = array_merge( $includes, array(
				'admin/admin',
			));
		}

		// include stuff
		foreach ( $includes as $include ) {
			require_once MD_PLUGIN_DIR . 'includes/' . $include . '.php';
		}
	}
}



/**
 * The main function that returns MusicDistro
 *
 * @since 0.1.0
 * @return object|MusicDistro the instance of MusicDistro
 */
function MusicDistro() {
	return MusicDistro::instance();
}

// get MusicDistro running
MusicDistro();
