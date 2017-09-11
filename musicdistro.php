<?php
/**
 * Plugin Name: MusicDistro
 * Plugin URI:  https://jordanpak.com
 * Description: Enables bands to distribute sheet music and other tools to its members!
 * Author:      Jordan Pakrosnis
 * Author URI:  https://jordanpak.com
 * Version:     1.0.0
 * Text Domain: musicdistro
 *
 * MusicDistro is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * @package    MusicDistro
 * @author     Jordan Pakrosnis
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2017, Jordan Pakrosnis / JpakMedia LLC
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
	 * @var string
	 * @since 1.0.0
	 */
	public $version = '1.0.0';


	/**
	 * Custom post type prefix
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public $cpt_prefix = 'md_';


	/**
	 * The arrangement handler instance
	 *
	 * @var object MusicDistro_Arrangement_Handler
	 * @since 1.0.0
	 */
	public $arrangement;


	/**
	 * The band tax handler instance
	 *
	 * @var object MusicDistro_Band_Handler
	 * @since 1.0.0
	 */
	public $band;


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

		// custom post type prefix
		if ( ! defined( 'MD_CPT_PREFIX' ) ) {
			define( 'MD_CPT_PREFIX', $this->cpt_prefix );
		}
	}



	/**
	 * Include required files.
	 *
	 * @since 1.0.0
	 */
	private function includes() {

		// load every time
		$includes = array(
			'functions',
			'class-arrangement',
			'class-band',
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



	/**
	 * Setup objects.
	 *
	 * @since 1.0.0
	 */
	public function objects() {

		// global objects
		$this->arrangement = new MusicDistro_Arrangement_Handler;
		$this->band        = new MusicDistro_Band_Handler;

		// hook now that all of the MusicDistro stuff is loaded
		do_action( 'musicdistro_loaded' );
	}
}



/**
 * The main function that returns MusicDistro
 *
 * @since 1.0.0
 * @return object
 */
function MusicDistro() {
	return MusicDistro::instance();
}

// get MusicDistro running
MusicDistro();
