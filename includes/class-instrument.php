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
            


        // register_taxonomy(
        //     MD_CPT_PREFIX . $this->tax_slug,
        //     array( MusicDistro()->arrangement->cpt_slug ),
        //     $args
        // );
    }
}
