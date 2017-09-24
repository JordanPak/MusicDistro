<?php
/**
 * Contains various functions that may be potentially used throughout
 * the MusicDistro plugin.
 *
 * @package    MusicDistro
 * @author     JordanPak
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2017, Jordan Pakrosnis / JpakMedia LLC
 */


/**
 * Build an unordered list
 *
 * @param  array   $items    list items
 * @param  string  $classes  class(es) for the <ul>
 *
 * @since 1.0.0
 */
function musicdistro_build_ul( $items, $classes = '' ) {

    $classes = $classes ? ' class="' . $classes . '"' : '';
    $items   = implode( '</li><li>', $items );

    return "<ul$classes><li>$items</li></ul>";
}
