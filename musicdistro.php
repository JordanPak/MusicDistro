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
 * Define and grab our includes
 */
$includes = array(
	'functions',
	'class-case-study',
);
foreach ( $includes as $include ) {
	// require_once 'inc/' . $include . '.php';
}
// require_once 'class-main.php';


/**
 * Start everything up
 */
// MusicDistro::instance();