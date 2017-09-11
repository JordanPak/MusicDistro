<?php
/**
 * All the arrangement goodness and basics.
 *
 * Contains a bunch of helper methods as well.
 *
 * @package    MusicDistro
 * @author     Jordan Pakrosnis
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2017, Jordan Pakrosnis / JpakMedia LLC
*/
class MusicDistro_Arrangement_Handler {

    /**
     * Custom post type slug
     *
     * @var string
     * @since 1.0.0
     */
    public $cpt_slug = MD_CPT_PREFIX . 'arrangement';


    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'init'      , array( $this, 'register_cpt' ) );
        add_action( 'admin_menu', array( $this, 'edit_admin_menu' ) );
    }


    /**
     * Registers arrangement custom post type
     *
     * @since 1.0.0
     */
    public function register_cpt() {

        $labels = array(
            'name'                  => _x( 'Arrangements', 'Post Type General Name', 'musicdistro' ),
            'singular_name'         => _x( 'Arrangement', 'Post Type Singular Name', 'musicdistro' ),
            'menu_name'             => __( 'MusicDistro', 'musicdistro' ),
            'name_admin_bar'        => __( 'Arrangement', 'musicdistro' ),
            'archives'              => __( 'Arrangement Archives', 'musicdistro' ),
            'attributes'            => __( 'Arrangement Attributes', 'musicdistro' ),
            'parent_item_colon'     => __( 'Parent Arrangement:', 'musicdistro' ),
            'all_items'             => __( 'Arrangements', 'musicdistro' ),
            'add_new_item'          => __( 'Add New Arrangement', 'musicdistro' ),
            'add_new'               => __( 'Add New', 'musicdistro' ),
            'new_item'              => __( 'New Arrangement', 'musicdistro' ),
            'edit_item'             => __( 'Edit Arrangement', 'musicdistro' ),
            'update_item'           => __( 'Update Arrangement', 'musicdistro' ),
            'view_item'             => __( 'View Arrangement', 'musicdistro' ),
            'view_items'            => __( 'View Arrangements', 'musicdistro' ),
            'search_items'          => __( 'Search Arrangement', 'musicdistro' ),
            'not_found'             => __( 'Not found', 'musicdistro' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'musicdistro' ),
            'featured_image'        => __( 'Featured Image', 'musicdistro' ),
            'set_featured_image'    => __( 'Set featured image', 'musicdistro' ),
            'remove_featured_image' => __( 'Remove featured image', 'musicdistro' ),
            'use_featured_image'    => __( 'Use as featured image', 'musicdistro' ),
            'insert_into_item'      => __( 'Insert into arrangement', 'musicdistro' ),
            'uploaded_to_this_item' => __( 'Uploaded to this arrangement', 'musicdistro' ),
            'items_list'            => __( 'Arrangements list', 'musicdistro' ),
            'items_list_navigation' => __( 'Arrangements list navigation', 'musicdistro' ),
            'filter_items_list'     => __( 'Filter arrangements list', 'musicdistro' ),
        );

        $capabilities = array(
            'edit_post'             => 'edit_post',
            'read_post'             => 'read_post',
            'delete_post'           => 'delete_post',
            'edit_posts'            => 'edit_posts',
            'edit_others_posts'     => 'edit_others_posts',
            'publish_posts'         => 'publish_posts',
            'read_private_posts'    => 'read_private_posts',
        );


        // CPT arguments, filterable if needed
        $args = apply_filters( 'musicdistro_arrangement_args',
            array(
                'label'                 => __( 'Arrangement', 'musicdistro' ),
                'description'           => __( 'A single arrangement for a band to use: Sheet music, tempo, recording, etc.', 'musicdistro' ),
                'labels'                => $labels,
                'supports'              => array( 'title' ),
                // 'taxonomies'            => array( 'MD_BANDS_KILL', ' MD_ARRANGEMENT_TYPE_KILL' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'menu_icon'             => 'dashicons-media-audio',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => false,
                'can_export'            => true,
                'has_archive'           => false,		
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'rewrite'               => false,
                'capabilities'          => $capabilities,
                'show_in_rest'          => true,
            )
        );

        register_post_type( $this->cpt_slug, $args );
    }



    /**
     * Edit admin menu
     *
     * Remove "Add New" link
     *
     * @since 1.0.0
     */
    public function edit_admin_menu() {

        global $submenu;

        unset( $submenu['edit.php?post_type=' . $this->cpt_slug ][10] );
    }
}