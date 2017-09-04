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
 * Version:     0.1.0
 * Author:      Jordan Pakrosnis
 * Author URI:  https://jordanpak.com
 * Text Domain: musicdistro
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Main MusicDistro class.
 *
 * @since 0.1.0
 */
class MusicDistro {

	/**
	 * @var MusicDistro the instance of MusicDistro
	 * @since 0.1.0
	 */
	private static $instance;


	/**
	 * @var object|MD_Roles
	 * @since 0.1.0
	 */
	public $roles;



	/**
	 * Main MusicDistro instance.
	 *
	 * @since 0.1.0
	 * @static
	 * @see MusicDistro()
	 * @return object|MusicDistro the instance of MusicDistro
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof MusicDistro ) ) {

			self::$instance = new MusicDistro;
			self::$instance->setup_constants();

			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

			self::$instance->includes();
			self::$instance->roles = new MD_Roles();
		}

		return self::$instance;
	}



	/**
	 * Throw error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'musicdistro' ), '0.1.0' );
	}


	
	/**
	 * Setup plugin constants.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function setup_constants() {

		// plugin version
		define( 'MD_VERSION', '0.1.0' );

		// plugin folder path
		define( 'MD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// plugin folder URL
		define( 'MD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// plugin root file
		define( 'MD_PLUGIN_FILE', __FILE__ );
	}
}