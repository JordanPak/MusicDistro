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
	 * All bands transient
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public $t_all_bands = MD_T_PREFIX . 'all_bands';


	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_taxonomy' ) );
		add_action( 'edited_terms', array( $this, 'reset_all_bands' ), 10, 2 );
	}

	public function reset_all_bands( $term_id, $taxonomy ) {
		// d( 'YO WHATUP G' );
		delete_transient( $this->t_all_bands );
		error_log( 'LOOK AT THIS' );
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
			'hierarchical'               => true,
			'public'                     => true,
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
		

		/**
		 * Grab all, using transient if it's there
		 */
		$transient = get_transient( $this->t_all_bands );

		if ( $transient ) {
			return $transient;
		}

		$bands = get_terms( array(
			'taxonomy'		=> $this->tax_slug,
			'hide_empty'	=> false,
			'parent'		=> 0,
		));
		set_transient( $this->t_all_bands, $bands );
		return $bands;
	}
}
