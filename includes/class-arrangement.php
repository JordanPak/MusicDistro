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
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // register arrangement custom post type
        $this->register_cpt();
    }


    /**
     * Registers arrangement custom post type
     *
     * @since 1.0.0
     */
    public function register_cpt() {

    }

}