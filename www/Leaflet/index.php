<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Leaflet                            Создать интерактивную карту с Leaflet *
// ****************************************************************************

/**
 * https://www.tutorialspoint.com/leafletjs/leafletjs_quick_guide.htm
 * 
 * Библиотека JavaScript Leaflet позволяет использовать такие слои, как слои 
 * тайлов, WMS, маркеры, всплывающие окна, векторные слои (полилинии, многоугольники, 
 * окружности и т.д.), наложения изображений и GeoJSON.
 * 
 * Вы можете взаимодействовать с картами Leaflet, перетаскивая их, изменяя масштаб 
 * (двойным щелчком или прокруткой колесика мыши), используя клавиатуру, 
 * обработку событий и перетаскивание маркеров.
**/
 
// v1.0.3, 11.08.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 07.08.2025


echo '<!DOCTYPE html>'; // определили разметку HTML5
echo '<html lang="ru">'; // назначили русский язык для сайта
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';

echo '
<head>
   <title> Мои карты с LeafletJS </title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="js/leaflet.css" />
   <script src="js/leaflet.js"></script>
</head>
<body>
   <h2 class="heading"> Путешествия и достопримечательности </h2>
';
// Для размещения карты создаем элемент-контейнер (как правило, тег <div>) и задаём его размеры
echo '<div id = "map" style = "width:900px; height:580px;"></div>';

// Далее:
// - создаём объект mapOptions и определяем начальные параметры карты: center и zoom,
// где center получает объект LatLng, указывающий местоположение, вокруг которого 
// мы хотим расположить карту (это значения широты и долготы), а zoom представляет 
// означает целое число, соответствующее уровню масштабирования карты;

// - cоздаём объект map (карту на странице) с передачей двух параметров: 
// строковой переменной, представляющей идентификатор DOM или экземпляр элемента <div>
// и указывающей на HTML-контейнер для хранения карты и необязательный объектный 
// литерал с параметрами карты;

// - cоздаём экземпляр TileLayer класса - набор определенного типа плиток (слой тайлов). 
// При создании экземпляра необходимо передать шаблон URL-адреса, запрашивающий 
// нужный слой тайлов (карту) у поставщика услуг (в нашем случае Openstreetmap);

// - добавляем слой на карту.

// Традиционный набор тайлов от Openstreetmap
$tilesmap="http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";
$lat=61.8021; $long=34.3296; $zoom=11;

echo "
<script>
  var mapOptions = {center:[".$lat.",".$long."],zoom:".$zoom."}
  var map = new L.map('map',mapOptions);
  var layer = new L.TileLayer('".
  $tilesmap.
  "');
  map.addLayer(layer);
</script>
";


/*
echo "
<script>
  var mapOptions = {center:[61.8021,34.3296],zoom:10}
  var map = new L.map('map',mapOptions);
  var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
  map.addLayer(layer);
</script>
";
*/

?>

<!-- 

<!DOCTYPE html>
<html>
   <head>
      <title>Leaflet sample</title>
      <link rel="stylesheet" href="js/leaflet.css" />
      <script src="js/leaflet.js"></script>
   </head>

   <body>
      <div id = "map" style = "width: 900px; height: 580px"></div>
      <script>
         /*
         // Creating map options
         var mapOptions = {  center: [17.385044, 78.486671],  zoom: 10 }
         
         // Creating a map object
         var map = new L.map('map', mapOptions);
         
         // Creating a Layer object
         var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
         
         // Adding layer to the map  
         map.addLayer(layer);
         */
      </script>

-->

</body>
</html>
<?php

?> <!-- --> <?php // ******************************************** index.php ***
