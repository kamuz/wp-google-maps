<?php
/**
 * Plugin Name: KMZ Google Maps
 * Description: Shortcode for display Google Map
 * Author: Vladimir Kamuz
 * Plugin URL: https://wpdev.pp.ua
 */

add_shortcode('map', 'kmz_google_map');

function kmz_google_map($attrs, $content){
    $attrs = shortcode_attrs(
        array(
            'center' => 'Kiev, Ukraine',
            'width' => 600,
            'height' => 400,
            'zoom' => 13,
            'content' => !empty($content) ? "<h2>  $content </h2>" : "<h2>Google Map</h2>"
        ),
        $attrs
    );
}