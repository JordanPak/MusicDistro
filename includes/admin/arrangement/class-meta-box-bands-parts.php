<?php
/**
 * Bands & parts arrangement meta box
 *
 * @package    MusicDistro
 * @author     Jordan Pakrosnis
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2017, Jordan Pakrosnis / JpakMedia LLC
*/
class MusicDistro_Meta_Box_Bands_Parts {

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
			'musicdistro_bands_parts',
			__( 'Bands & Parts', 'musicdistro' ),
			array( $this, 'render_meta_box' ),
			MusicDistro()->arrrangement->cpt_slug,
			'normal', 'high'
		);
	}


	/**
	 * Render the meta box
	 *
	 * @param object  $post  the current post object
	 * @since 1.0.0
	 */
	public function render_meta_box( $post ) {
		d( $post );
	}
}