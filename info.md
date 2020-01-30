# Создание Wordpress плагина для добавления статической Google карты

Мы реализуем плагин, который будет выводить статическую карту Google через шорткод WordPress. Документация [Maps Static API
](https://developers.google.com/maps/documentation/maps-static/).

Нам нужно генерировать строку вида:

```
https://maps.googleapis.com/maps/api/staticmap?center=Brooklyn+Bridge,New+York,NY&zoom=13&size=600x300&maptype=roadmap
&markers=color:blue%7Clabel:S%7C40.702147,-74.015794&markers=color:green%7Clabel:G%7C40.711614,-74.012318
&markers=color:red%7Clabel:C%7C40.718217,-73.998284
&key=YOUR_API_KEY
```

Это взято с документации, а можно испробовать уже реальный пример:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Static Google Map</title>
</head>
<body>
    <img src="https://maps.googleapis.com/maps/api/staticmap?center=Kiev,Ukraine&zoom=10&size=600x400&maptype=roadmap
&markers=color:blue|label:L|50.4447,30.5292&markers=color:green|label:F|50.4577,30.5235
&markers=color:red|label:M|50.4266,30.5631
&key=AIzaSyAP1lvNVYgHVwxMGa0pjlscCxWHJu8er2U" alt="Google Map Kiev">
</body>
</html>
```

За основу взяты координаты некоторых примечательностей Киева:

```txt
50.4513° N, 30.5254° E
Khreschatyk, Kiev, Coordinates
50.4447° N, 30.5292° E
Lypky, Kiev, Coordinates
50.4266° N, 30.5631° E
The Motherland Monument, Coordinates 
50.4577° N, 30.5235° E
Kiev Funicular, Coordinates
```

Создадим шорткод через `add_shortcode()` и при зададим необходимые параметры через `shortcode_attr()`.

*wp-content/plugins/kmz-google-maps/kmz-google-maps.php*

```php
<?php
/**
 * Plugin Name: KMZ Static Google Maps
 * Description: Shortcode for display Static Google Map. Example <code>[map center="city, region, country" width="600" height="300" zoom="13" mlabel="" mcolor="" mlat="" mlng=""]Description of the map[/map]</code>
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
            'width' => 500,
            'height' => 400,
            'zoom' => 10,
            'content' => !empty($content) ? "<h2> $content </h2>" : "<h2>Google Map</h2>",
            'mlabel' => 'K',
            'mcolor' => 'green',
            'mlat' => '50.4513',
            'mlng' => '30.5254',
        ),
        $atts
    );
}
```

Теперь нам нужно сформировать ту строку, которая сгенерирует нам карту.

```php
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
```

Для размера карты, мы для простоты создали отдельную переменную `$size`.

Давайте сначала выведем шорткод без параметров для проверки дефолтных значений:

```txt
[map]
```

И если всё нормально, попробуем со значениями:

```
[map center="Kiev Funicular" width="400" height="400" zoom="16" mlabel="F" mcolor="red" mlat="50.4577" mlng="30.5235"]Kiev Funicular[/map]
```