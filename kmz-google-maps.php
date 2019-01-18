<?php
/**
 * Plugin Name: KMZ Google Maps
 * Description: Shortcode for display Google Map: [map center="city, region, country" width="600" height="300" zoom="13"]Description of the map[/map]
 * Author: Vladimir Kamuz
 * Author URI: https://wpdev.pp.ua
 * Plugin URL: https://github.com/kamuz/wp-google-maps
 * Licence: GPL2
 * Text Domain: kmzgooglemaps
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

    $map = $content;
    $map .= 
    return $map;
}