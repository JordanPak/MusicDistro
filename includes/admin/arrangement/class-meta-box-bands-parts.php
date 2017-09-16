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
		add_action( 'musicdistro_meta_box_bands_parts_fields', array( $this, 'render_bands_field' ) );
		add_action( 'musicdistro_meta_box_bands_parts_fields', array( $this, 'render_parts_fields' ) );
	}


	/**
	 * Add the meta box
	 *
	 * @since 1.0.0
	 */
	public function add_meta_box() {

		$screen = MusicDistro()->arrangement->cpt_slug;
	
		add_meta_box(
			'musicdistro_bands_parts',				// ID
			__( 'Bands & Parts', 'musicdistro' ),	// title
			array( $this, 'render_meta_box' ),		// callback
			$screen,								// post type
			'normal', 'high'						// position / priority
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
		do_action( 'musicdistro_meta_box_bands_parts_fields', $post->ID );

		// set nonce
		wp_nonce_field( basename( __FILE__ ), 'musicdistro_meta_box_bands_parts_nonce' );
	}



	/**
	 * Render the bands field
	 *
	 * @param integer  $post_id  current post ID
	 * @since 1.0.0
	 */
	public function render_bands_field( $post_id ) {

		// get bands
		$tax      = MusicDistro()->band->tax_slug;
		$bands    = get_terms( array( 'taxonomy' => $tax, 'hide_empty' => false ) );
		$selected = get_the_terms( $post_id, $tax );
		$selected = wp_get_post_terms( $post_id, $tax, array( 'fields' => 'ids' ) );
		$selected = $selected ?: array();

		// build options
		foreach ( $bands as $i => $band ) {
			$is_selected = in_array( $band->term_id, $selected ) ? ' selected="selected"' : '';
			$bands[ $i ] = "<option value='{$band->term_id}'$is_selected>{$band->name}</option>";
		}
		?>

		<p><label for="md_bands">Bands</label><br />
			<select id="md_bands" name="md_bands[]" multiple="multiple"><?php echo implode( '', $bands ); ?></select>
		</p>

	<?php }



	/**
	 * Render the parts fields
	 *
	 * @param integer  $post_id  current post ID
	 * @since 1.0.0
	 */
	public function render_parts_fields( $post_id ) {
		d( $post_id );
	}
}
