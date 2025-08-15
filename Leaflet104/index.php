<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Leaflet                            Создать интерактивную карту с Leaflet *
// ****************************************************************************

/**
 * Рабочие материалы:
 * 
 * LeafletJS - Quick Guide
 * https://www.tutorialspoint.com/leafletjs/leafletjs_quick_guide.htm
 * 
 * Leaflet fog of war
 * https://www.agalera.eu/leaflet-fog-of-war/
**/
 
// v1.0.4, 14.08.2025                                 Автор:      Труфанов В.Е.
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
$lat=61.8021; $long=34.3296; $zoom=10;

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

// Добавляем простой маркер (для того, чтобы отметить на карте одно конкретное место,
// в Leaflet предусмотрены маркеры):
// - создаём экземпляр класса Marker, передав ему объект latlng, представляющий 
// местоположение, которое нужно отметить;
// - привязываем всплывающее окно к маркеру;
// - добавляем объект маркера на карту с помощью метода addTo() класса Marker.

// Замечание: внутри каталога с leaflet.js должен находиться каталог с 
// изначально созданными изображениями для формирования маркера.

// "Егоровы штаны"
// https://yandex.ru/video/preview/3597308546601073229
echo "
<script>
  var marker1 = new L.Marker([61.802094,34.329613]); // 'Dom'
  marker1.bindPopup('Наш хороший дом!').openPopup();
  marker1.addTo(map);
  
  /*
  var marker2 = new L.Marker([61.702048,34.154702]); // 'Dacha'
  marker2.bindPopup('Наша любимая дача!').openPopup();
  marker2.addTo(map);
  */
  
  var marker3 = new L.Marker([61.844252,34.390658]); // 'BotSad'
  marker3.bindPopup('Цветущий ботанический сад!').openPopup();
  marker3.addTo(map);
  
  var marker4 = new L.Marker([61.847725,34.405182]); // 'EShtany'
  marker4.bindPopup('Загадочные Егоровы штаны!').openPopup();
  marker4.addTo(map);
</script>
";

// Создаем собственный маркер
echo "
<script>
  var myiconOptions = {
    iconUrl: 'js/images/kwinflat16x16.png',
    iconSize: [16,16]
  }
  var myIcon = L.icon(myiconOptions);
  var mymarkerOptions = {
    title: 'MyLocation',
    clickable: true,
    draggable: true,
    icon: myIcon
  }
  var mymarker = L.marker([61.802094,34.154702], mymarkerOptions);
  mymarker.bindPopup('Где живет KwinFlat').openPopup();
  mymarker.addTo(map);
</script>
";

// Создаем 2 новых маркера и строим ломанную линию (треугольник) из 4 точек
// (первую точку дважды, второй раз, как последнюю)
echo "
<script>
  // Готовим маркер 'точка локации'
  var LocateArrowIconOptions = 
  {
    iconUrl: 'js/images/LocateArrow50x50.png',
    iconSize: [40,40]
  }
  var LocateArrowIcon = L.icon(LocateArrowIconOptions);
  var LocateArrowMarkerOptions = {
    title: 'Точка локации',
    clickable: true,
    draggable: false,
    icon: LocateArrowIcon
  }
  // Устанавливаем и подписываем маркеры
  var LocateArrowMarker = L.marker([61.846308, 33.206584], LocateArrowMarkerOptions);
  LocateArrowMarker.bindPopup('Эссойла, ул.Школьная, 3').openPopup();
  LocateArrowMarker.addTo(map);
  
  var LocateArrowMarker = L.marker([61.934839, 33.655948], LocateArrowMarkerOptions);
  LocateArrowMarker.bindPopup('СНТ Геолог, 98').openPopup();
  LocateArrowMarker.addTo(map);
  
  var LocateArrowMarker = L.marker([61.833141, 32.929247], LocateArrowMarkerOptions);
  LocateArrowMarker.bindPopup('Новые пески, ул.Центральная, 13').openPopup();
  LocateArrowMarker.addTo(map);
  // Готовим маркер 'флаг трека'
  var DirFlagIconOptions = 
  {
    iconUrl: 'js/images/DirFlag47x47.png',
    iconSize: [47,47]
  }
  var DirFlagIcon = L.icon(DirFlagIconOptions);
  var DirFlagMarkerOptions = 
  {
    title: 'Флаг трека',
    clickable: true,
    draggable: false,
    icon: DirFlagIcon
  }
  // Устанавливаем и подписываем маркер
  var DirFlagMarker = L.marker([61.846308, 33.206584], DirFlagMarkerOptions);
  DirFlagMarker.bindPopup('Эссойла, ул.Школьная, 3').openPopup();
  DirFlagMarker.addTo(map);
  // Создаем полилинию
  var latlngs = [
     [61.846308, 33.206584],
     [61.934839, 33.655948],
     [61.833141, 32.929247],
     [61.846308, 33.206584]
  ];
  // Creating a poly line
  var polyline = L.polyline(latlngs, {color: 'red'});
  // Adding to poly line to map
  polyline.addTo(map);
</script>
";
// 'Точка на карте с регионом' - создаем наложение в виде круга на карте 
echo "
<script>
  // Готовим маркер 'точка на карте'
  var PinMapIconOptions = 
  {
    iconUrl: 'js/images/PinMap38x38.png',
    iconSize: [38,38]
  }
  var PinMapIcon = L.icon(PinMapIconOptions);
  var PinMapMarkerOptions = 
  {
    title: 'Точка на карте',
    clickable: true,
    draggable: false,
    icon: PinMapIcon
  }
  // Размещаем маркер на карте
  var PinMapMarker = L.marker([61.702048,34.154702], PinMapMarkerOptions);
  PinMapMarker.bindPopup('Наша любимая дача!').openPopup();
  PinMapMarker.addTo(map);
  // Cоздаем наложение в виде круга
  var circleCenter = [61.702048,34.154702];  
  // Circle options
  var circleOptions = 
  {
     color: 'red',
     fillColor: '#f03',
     fillOpacity: 0  // круг без заливки
  }
  // Создаем круг радиусом 5 км
  var circle = L.circle(circleCenter, 5000, circleOptions);
  circle.addTo(map); 
</script>
";
// Загружаем файл GPX
echo "
<script>

</script>
";
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
