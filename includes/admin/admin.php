<?php
/**
 * Global admin related items and functionality.
 *
 * @package    MusicDistro
 * @author     Jordan Pakrosnis
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2017, Jordan Pakrosnis / JpakMedia LLC
 */


/**
 * Helper function to determine if viewing a MusicDistro
 * related admin page.
 *
 * @since 1.0.0
 * @return boolean
 */
function musicdistro_is_admin_page() {

    $post_type = get_post_type();

    if ( is_admin() && $post_type == MusicDistro()->arrangement->cpt_slug ) {
        return true;
    }

    return false;
}



/**
 * Load scripts for all MusicDistro-related admin screens
 *
 * @since 1.0.0
 */
function musicdistro_admin_scripts() {

    if ( ! musicdistro_is_admin_page() ) {
        return;
    }

    wp_enqueue_media();


    $dir    = ( defined( 'MD_DEVELOPMENT' ) && MD_DEVELOPMENT ) ? '/src' : '';
    $suffix = ( defined( 'MD_DEVELOPMENT' ) && MD_DEVELOPMENT ) ? '' : '.min';

    // main admin scripts
    wp_enqueue_script(
        'musicdistro-admin',
        MD_PLUGIN_URL . "assets/js{$dir}/admin{$suffix}.js",
        array( 'jquery' ),
        MD_VERSION,
        true
    );

    // select2
    wp_enqueue_script(
        'select2',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
        array( 'jquery' ),
        false, true
    );
    wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' );
}

add_action( 'admin_enqueue_scripts', 'musicdistro_admin_scripts' );



/**
 * Add body class to MusicDistro admin pages for easy reference.
 *
 * @since 1.3.9
 * @param string $classes
 * @return string
 */
function musicdistro_admin_body_class( $classes ) {

	if ( ! musicdistro_is_admin_page() ) {
		return $classes;
	}

	return "$classes musicdistro-admin-page";
}

add_filter( 'admin_body_class', 'musicdistro_admin_body_class', 10, 1 );
