<?php
/**
 * All the instrument taxonomy stuff
 *
 * @package    MusicDistro
 * @author     Jordan Pakrosnis
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2017, Jordan Pakrosnis / JpakMedia LLC
*/
class MusicDistro_Instrument_Handler {

    /**
     * Taxonomy slug
     *
     * @var string
     * @since 1.0.0
     */
    public $tax_slug = MD_CPT_PREFIX . 'instrument';


    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_taxonomy' ) );
    }


    /**
     * Registers instrument taxonomy
     *
     * @since 1.0.0
     */
    public function register_taxonomy() {
            
        $labels = array(
            'name'                       => _x( 'Instruments', 'Taxonomy General Name', 'musicdistro' ),
            'singular_name'              => _x( 'Instrument', 'Taxonomy Singular Name', 'musicdistro' ),
            'menu_name'                  => __( 'Instruments', 'musicdistro' ),
            'all_items'                  => __( 'All Instruments', 'musicdistro' ),
            'parent_item'                => __( 'Parent Instrument', 'musicdistro' ),
            'parent_item_colon'          => __( 'Parent Instrument:', 'musicdistro' ),
            'new_item_name'              => __( 'New Instrument Name', 'musicdistro' ),
            'add_new_item'               => __( 'Add New Instrument', 'musicdistro' ),
            'edit_item'                  => __( 'Edit Instrument', 'musicdistro' ),
            'update_item'                => __( 'Update Instrument', 'musicdistro' ),
            'view_item'                  => __( 'View Instrument', 'musicdistro' ),
            'separate_items_with_commas' => __( 'Separate instruments with commas', 'musicdistro' ),
            'add_or_remove_items'        => __( 'Add or remove instruments', 'musicdistro' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'musicdistro' ),
            'popular_items'              => __( 'Popular instruments', 'musicdistro' ),
            'search_items'               => __( 'Search Instruments', 'musicdistro' ),
            'not_found'                  => __( 'Not Found', 'musicdistro' ),
            'no_terms'                   => __( 'No instruments', 'musicdistro' ),
            'items_list'                 => __( 'Instruments list', 'musicdistro' ),
            'items_list_navigation'      => __( 'Instruments list navigation', 'musicdistro' ),
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
     * Get some instruments
     *
     * If a band isn't provided, return all instruments.
     * If a band is provided, get the instruments already
     * associated with it. 
     *
     * @param  mixed  $band  band term ID or 'dropdown' for wp_category dropdown with all instruments
     * @return array         all instruments, unless band is specified
     *
     * @since 1.0.0
     */
    public function get_instruments( $band = null ) {

        // get all (in wp_category dropdown)
        if ( $band == 'dropdown' ) {
            return wp_dropdown_categories( array(
                'hide_empty'	=> 0,
                'taxonomy'		=> $this->tax_slug,
                'name'			=> 'md_instruments[]',
                'id'			=> 'md_instruments',
            ));
        }

        // get band's term meta
        elseif ( $band ) {
            $instruments = get_term_meta( $band, 'md_instruments', true );
            return $instruments ?: array();
        }

        // get all
        $instruments = get_terms( array(
            'taxonomy'      => $this->tax_slug,
            'hide_empty'    => false,
        ));
        return $instruments ?: array();
    }
}
