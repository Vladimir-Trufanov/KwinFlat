<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Leaflet                            Создать интерактивную карту с Leaflet *
// ****************************************************************************

/**
 * Переработанный пример со страницы GitHub "GPX plugin for Leaflet"
 * (https://github.com/mpetazzoni/leaflet-gpx/tree/main?tab=readme-ov-file)
**/
 
// v1.0.6, 22.08.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 07.08.2025


echo '<!DOCTYPE html>'; // определили разметку HTML5
echo '<html lang="ru">'; // назначили русский язык для сайта
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';

/*
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 20,
    minZoom: 2,
    tileSize: 512,
    zoomOffset: -1
  }).addTo(map);

  L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
  {
    attribution: 'Map data &copy; <a href="http://www.osm.org">OpenStreetMap</a>'
  }).addTo(map);
*/

?>
<head>
   <title> Мои карты с LeafletJS </title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="js/leaflet194.css" />
   <script src="js/leaflet194.js"></script>
   <script src="js/gpx212.min.js"></script>

   <style>
      #map { height: 500px; }
   </style>
</head>

<body>
   <div id="map"></div>
   <!-- ... -->
   <script type="module">
   const map = L.map('map');
   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 20,
      minZoom: 2,
      tileSize: 512,
      zoomOffset: -1
   }).addTo(map);

   // URL to your GPX file or the GPX itself as a XML string.
   // const url = 'https://mpetazzoni.github.io/leaflet-gpx/demo.gpx';
   // const url = 'https://probatv.ru/Ex5/demo_mpetazzoni.gpx';
   // const url = 'https://probatv.ru/Ex5/mp20230923.gpx';
   const url = 'https://probatv.ru/Ex5/track20250810.gpx';

   const options = {
      async: true,
      polyline_options: { color: 'red' },
   };

   const gpx = new L.GPX(url, options).on('loaded', (e) => {
      map.fitBounds(e.target.getBounds());
   }).addTo(map);

   </script>
</body>
</html>
<?php

?> <!-- --> <?php // ******************************************** index.php ***
