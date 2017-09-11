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
    public $cpt_slug = MD_CPT_PREFIX . 'band';


    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_taxonomy' ) );
    }


    /**
     * Registers band taxonomy
     *
     * @since 1.0.0
     */
    public function register_taxonomy() {

    }
}