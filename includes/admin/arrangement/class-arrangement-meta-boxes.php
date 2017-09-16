<?php
/**
 * Arrangement meta boxes
 *
 * @package    MusicDistro
 * @author     Jordan Pakrosnis
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2017, Jordan Pakrosnis / JpakMedia LLC
*/
class MusicDistro_Arrangement_Meta_Boxes {

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
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
    }


    /**
     * Register all the meta boxes for the Arrangment
     * custom post type
     *
     * @since 1.0.0
     */
    public function add_meta_boxes() {
    
        // bands and parts
        add_meta_box(
            'musicdistro_bands_parts',
            __( 'Bands & Parts', 'musicdistro' ),
            // array( $this, 'render_bands_parts' ),
            'MusicDistro_Meta_Box_Bands_Parts::output',
            MusicDistro()->arrrangement->cpt_slug,
            'normal', 'high'
        );

        // tempo
        // add_meta_box_

    }
}