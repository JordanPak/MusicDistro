<?php
/**
 * All the band taxonomy stuff
 *
 * @package    MusicDistro
 * @author     Jordan Pakrosnis
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2017, Jordan Pakrosnis / JpakMedia LLC
*/
class MusicDistro_Band_Handler {

	/**
	 * Taxonomy slug
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public $tax_slug = MD_CPT_PREFIX . 'band';


	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( "init",                      array( $this, 'register_taxonomy' ) );
		add_action( "created_{$this->tax_slug}", array( $this, 'save_instruments_field' ), 10, 1 );

		if ( is_admin() ) {
			add_filter( "manage_edit-{$this->tax_slug}_columns", array( $this, 'edit_taxonomy_columns' ), 10, 1 );
			// add_action( "{$this->tax_slug}_edit_form_fields",    array( $this, 'add_instruments_field' ) );
			add_action( "{$this->tax_slug}_add_form_fields",     array( $this, 'add_instruments_field' ) );
		}
	}


	/**
	 * Add instruments field
	 *
	 * @param object  $tag       current taxonomy term object
	 * @param object  $taxonomy  current taxonomy slug
	 *
	 * @since 1.0.0
	 */
	public function add_instruments_field() {

		$instrument_slug = MusicDistro()->instrument->tax_slug;
		$link            = admin_url( "edit-tags.php?taxonomy=$instrument_slug" );		
		$dropdown_args   = array(
			'hide_empty'	=> 0,
			'taxonomy'		=> $instrument_slug,
			'name'			=> 'md_instruments[]',
			'id'			=> 'md_instruments',
		);
		?>

		<div class="form-field md-instruments-wrap">
			<label for="md_instruments"><?php _e( 'Instruments', 'musicdistro' ); ?></label>
			<?php wp_dropdown_categories( $dropdown_args ); ?>

			<p><a href="<?php echo $link; ?>" target="_blank"><?php _e( 'Add an instrument' ); ?></a></p>
		</div>

	<?php }



	/**
	 * Save the instruments field
	 *
	 * @param int  $term_id  term ID
	 *
	 * @since 1.0.0
	 */
	public function save_instruments_field( $term_id ) {

		// sanity check
		if ( ! isset( $_POST['md_instruments'] ) || empty( $_POST['md_instruments'] ) ) {
			return;
		}

		// sanitize
		$instruments = array_map( 'intval', $_POST['md_instruments'] );

		add_term_meta( $term_id, 'md_instruments', $instruments );
	}



	/**
	 * Manage admin taxonomy columns
	 *
	 * Hide the "Description" column and rename "Count" to
	 * "Arrangements"
	 *
	 * @param  array  $content  band tax columns
	 * @return array  $content  adjusted tax columns
	 *
	 * @since 1.0.0
	 */ 
	public function edit_taxonomy_columns( $content ) {
		
		// hide description
		unset( $content['description']);

		// rename "Count" to "Arrangements"
		$content['posts'] = __( 'Arrangements', 'musicdistro' );

		return $content;
	}


	/**
	 * Registers band taxonomy
	 *
	 * @since 1.0.0
	 */
	public function register_taxonomy() {
			
		$labels = array(
			'name'                       => _x( 'Bands', 'Taxonomy General Name', 'musicdistro' ),
			'singular_name'              => _x( 'Band', 'Taxonomy Singular Name', 'musicdistro' ),
			'menu_name'                  => __( 'Bands', 'musicdistro' ),
			'all_items'                  => __( 'All Bands', 'musicdistro' ),
			'parent_item'                => __( 'Band', 'musicdistro' ),
			'parent_item_colon'          => __( 'Band:', 'musicdistro' ),
			'new_item_name'              => __( 'New Band Name', 'musicdistro' ),
			'add_new_item'               => __( 'Add New Band', 'musicdistro' ),
			'edit_item'                  => __( 'Edit Band', 'musicdistro' ),
			'update_item'                => __( 'Update Band', 'musicdistro' ),
			'view_item'                  => __( 'View Band', 'musicdistro' ),
			'separate_items_with_commas' => __( 'Separate bands with commas', 'musicdistro' ),
			'add_or_remove_items'        => __( 'Add or remove bands', 'musicdistro' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'musicdistro' ),
			'popular_items'              => __( 'Popular Bands', 'musicdistro' ),
			'search_items'               => __( 'Search Bands', 'musicdistro' ),
			'not_found'                  => __( 'Not Found', 'musicdistro' ),
			'no_terms'                   => __( 'No bands', 'musicdistro' ),
			'items_list'                 => __( 'Bands list', 'musicdistro' ),
			'items_list_navigation'      => __( 'Bands list navigation', 'musicdistro' ),
		);

		$capabilities = array(
			'manage_terms'               => 'manage_categories',
			'edit_terms'                 => 'manage_categories',
			'delete_terms'               => 'manage_categories',
			'assign_terms'               => 'edit_posts',
		);

		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
			'rewrite'                    => false,
			'capabilities'               => $capabilities,
			'show_in_rest'               => true,
		);

		register_taxonomy(
			$this->tax_slug,
			array( MusicDistro()->arrangement->cpt_slug ),
			$args
		);
	}


	
	/**
	 * Get some bands (parent items)
	 * 
	 * If a post ID is supplied, this returns an array of
	 * SELECTED bands. Otherwise, ALL top-level terms (bands)
	 * are returned, whether they children (instruments) or
	 * not.
	 *
	 * @param  int    $post_id  arrangement (probably) post ID
	 * @return array            All top-level bands, or bands already set to the post
	 *
	 * @since 1.0.0
	 */
	public function get_bands( $post_id = null ) {

		// grab post's
		if ( $post_id ) {
			return wp_get_post_terms( $post_id, $this->tax_slug, array( 'fields' => 'ids' ) );
		}
		
		// grab all
		$bands = get_terms( array(
			'taxonomy'		=> $this->tax_slug,
			'hide_empty'	=> false,
		));
		return $bands ?: array();
	}
}
