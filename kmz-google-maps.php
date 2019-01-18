<?php
/**
 * Plugin Name: KMZ Static Google Maps
 * Description: Shortcode for display Static Google Map. Example <code>[map center="city, region, country" width="600" height="300" zoom="13" mlabel="" mcolor="" mlat="" mlng=""]Description of the map[/map]</code>
 * Author: Vladimir Kamuz
 * Author URI: https://wpdev.pp.ua
 * Plugin URI: https://github.com/kamuz/wp-google-maps
 * Licence: GPL2
 * Text Domain: kmzgooglemaps
 */

add_shortcode('map', 'kmz_google_map');

function kmz_google_map($atts, $content){
    $atts = shortcode_atts(
        array(
            'center' => 'Kiev, Ukraine',
            'width' => 500,
            'height' => 400,
            'zoom' => 10,
            'content' => !empty($content) ? "<h2>  $content </h2>" : "<h2>Google Map</h2>",
            'mlabel' => 'K',
            'mcolor' => 'green',
            'mlat' => '50.4513',
            'mlng' => '30.5254',
        ),
        $atts
    );

    $atts['size'] = $atts['width'] . 'x' . $atts['height'];

    extract($atts);

    $map = $content;
    $map .= '<img src="https://maps.googleapis.com/maps/api/staticmap?center=' . $center . '&zoom=' . $zoom . '&size=' . $size . '&markers=color:' . $mcolor . '|label:' . $mlabel . '|' . $mlat . ',' . $mlng . '&key=AIzaSyAP1lvNVYgHVwxMGa0pjlscCxWHJu8er2U" alt="' . $content . '">';
    return $map;
}