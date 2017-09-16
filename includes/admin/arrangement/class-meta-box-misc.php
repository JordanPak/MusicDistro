<?php
/**
 * Meta box for tempo, recording file, score,
 * and other misc. arrangement options
 *
 * @package    MusicDistro
 * @author     Jordan Pakrosnis
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2017, Jordan Pakrosnis / JpakMedia LLC
*/
class MusicDistro_Meta_Box_Misc {

	/**
	 * Custom post type slug
	 *
	 * @var string
	 * @since 1.0.0
	 */
	// public $cpt_slug = MD_CPT_PREFIX . 'arrangement';


	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
	}


	/**
	 * Add the meta box
	 *
	 * @since 1.0.0
	 */
	public function add_meta_box() {
	
		add_meta_box(
			'musicdistro_misc',     				    // ID
			__( 'Arrangement Options', 'musicdistro' ),	// title
			array( $this, 'render_meta_box' ),	    	// callback
			MusicDistro()->arrrangement->cpt_slug,  	// post type
			'side'					                   	// position
		);
	}


	/**
	 * Render the meta box
	 *
	 * @param object  $post  the current post object
	 * @since 1.0.0
	 */
	public function render_meta_box( $post ) {
        
        /**
         * Output the fields
         *
         * @since 1.0.0
         */
        // do_action( 'musicdistro_meta_box_misc_fields', $post->ID );

        // set nonce
        // wp_nonce_field( basename( __FILE__ ), 'musicdistro_meta_box_misc_nonce' );
	}
}
