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
	 * Nonce name
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $nonce = 'musicdistro_meta_box_bands_parts_nonce';


	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'add_meta_boxes',                          array( $this, 'add_meta_box' ) );
		add_action( 'musicdistro_meta_box_bands_parts_fields', array( $this, 'render_bands_field' ) );
		add_action( 'musicdistro_meta_box_bands_parts_fields', array( $this, 'render_parts_fields' ) );
		add_action( 'save_post',                               array( $this, 'save_meta_box' ),    10, 2 );
		add_action( 'musicdistro_meta_box_save_bands',         array( $this, 'save_field_bands' ), 10, 2 );
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
		wp_nonce_field( basename( __FILE__ ), $this->nonce );
	}



	/**
	 * Get the list of bands/parts fields (without md_ prefix)
	 *
	 * @return array  $fields
	 * @since 1.0.0
	 */
	private function get_field_list() {

		// $prefix = MusicDistro()->cpt_prefix;

		return apply_filters( 'musicdistro_bands_parts_field_list', array(
			'bands',
		));
	}



	/**
	 * Render the bands field
	 *
	 * @param integer  $post_id  current post ID
	 * @since 1.0.0
	 */
	public function render_bands_field( $post_id ) {

		// get bands
		$bands    = MusicDistro()->band->get_bands();
		$selected = MusicDistro()->band->get_bands( $post_id );

		// build options
		foreach ( $bands as $i => $band ) {
			$is_selected = in_array( $band->term_id, $selected ) ? ' selected="selected"' : '';
			$bands[ $i ] = "<option value='{$band->term_id}'$is_selected>{$band->name}</option>";
		}
		?>

		<p><label for="md_bands"><?php echo  __( 'Bands', 'musicdistro' ); ?></label><br />
			<select id="md_bands" name="md_bands[]" multiple="multiple"><?php echo implode( '', $bands ); ?></select>
		</p>

	<?php }



	/**
	 * Render the parts fields
	 *
	 * @param int  $post_id  current post ID
	 * @since 1.0.0
	 */
	public function render_parts_fields( $post_id ) {

		$i = 0;

		// $instruments = wp_get_post_terms( $post_id, 'md_band', array()  );
		$instruments = wp_get_object_terms( $post_id, 'md_band' );
		foreach ( $instruments as $index => &$instrument ) {

			if ( $instrument->parent === 0 ) {
				unset( $instruments[ $index ] );
			}
		}
		d( $instruments );

		for ( $index = 0; $index < 5; $index++ ) {
			?>

			<fieldset>

				<!-- instrument -->
				<label for="md_<?php echo $index; ?>">Instrument</label><br />

				<select id="md_parts_<?php echo $index; ?>" name="md_parts_1[]">

				</select>

			</fieldset>
		<?php }
	}



	/**
	 * Save the fields
	 *
	 * @param int     $post_id  Arrangement post ID
	 * @param object  $post     arrangement post
	 * @since 1.0.0
	 */
	public function save_meta_box( $post_id, $post ) {
		
		// d( $post_id, $post, $_POST );

		// check nonce
		if ( ! isset( $_POST[ $this->nonce ] ) || ! wp_verify_nonce( $_POST[ $this->nonce ], basename( __FILE__ ) ) ) {
			return;
		}

		// don't do on autosave, ajax, or bulk edit
		if ( MD_DOING_AUTOSAVE || MD_DOING_AJAX || isset( $_REQUEST['bulk_edit'] ) ) {
			return;
		}

		// skip revaisions
		if ( isset( $post->post_type ) && 'revision' == $post->post_type ) {
			return;
		}

		// @todo make this work
		// if ( ! current_user_can( 'edit_arrangement', $post_id ) ) {
		// 	return;
		// }

		// get default field list
		$fields = $this->get_field_list();

		/**
		 * Field save loop
		 */
		foreach ( $fields as $field ) {

			// prefixed field name
			$meta_name = MD_CPT_PREFIX . $field;
			
			// check if something was put in
			// if ( ! empty( $_POST[ $meta_name ] ) ) {
				// d( $_POST[ $meta_name ] );
				
				do_action( 'musicdistro_meta_box_save_' . $field, $post_id, $_POST[ $meta_name ] );

				// sanitize and stuff
				// $new = apply_filters( 'musicdistro_meta_box_save_' . $field, $_POST[ $meta_name ] );
				// set meta
				// update_post_meta( $post_id, $meta_name, $new );
			// }

			// delete if nothing
			// else {
			// 	delete_post_meta( $post_id, $meta_name );
			// }
		}


		// d( 'MADE IT!' );
		// die();
	}



	/**
	 * Save bands field
	 *
	 * @param array  $bands  selected band term IDs
	 * @since 1.0.0
	 */
	public function save_field_bands( $post_id, $bands ) {

		// set to empty array of none entered
		$bands = $bands ?: array();

		// change term IDs to ints & sanitize
		$bands = array_map( 'intval', $bands );

		// add what we want
		$chicken = wp_set_object_terms( $post_id, $bands, MusicDistro()->band->tax_slug );
	}
}
