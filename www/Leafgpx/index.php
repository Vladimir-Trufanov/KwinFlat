<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * KwinFlat/Leaflet                Создать карту с Leaflet для загрузки GPX *
// ****************************************************************************

// v1.0.8, 24.08.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 07.08.2025

echo '<!DOCTYPE html>'; // определили разметку HTML5
echo '<html lang="ru">'; // назначили русский язык для сайта
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';

// Инициализируем рабочее пространство: корневой каталог сайта и т.д.
require_once '../iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();

/*
$SiteRoot     = $_WORKSPACE[wsSiteRoot];     // Корневой каталог сайта
$SiteAbove    = $_WORKSPACE[wsSiteAbove];    // Надсайтовый каталог
$SiteHost     = $_WORKSPACE[wsSiteHost];     // Каталог хостинга
$SiteDevice   = $_WORKSPACE[wsSiteDevice];   // 'Computer' | 'Mobile' | 'Tablet'
$UserAgent    = $_WORKSPACE[wsUserAgent];    // HTTP_USER_AGENT
$TimeRequest  = $_WORKSPACE[wsTimeRequest];  // Время запроса сайта
$RemoteAddr   = $_WORKSPACE[wsRemoteAddr];   // IP-адрес запроса сайта
$SiteName     = $_WORKSPACE[wsSiteName];     // Доменное имя сайта
$PhpVersion   = $_WORKSPACE[wsPhpVersion];   // Версия PHP
$SiteProtocol = $_WORKSPACE[wsSiteProtocol]; // HTTP или HTTPS
*/
$urlHome      = $_WORKSPACE[wsUrlHome];      // Начальная страница сайта 
/*
$RootDir      = $_WORKSPACE[wsRootDir];      // Каталог корня сайта, в котором выполняется текущий скрипт
$RootUrl      = $_WORKSPACE[wsRootUrl];      // Путь и имя выполняемого скрипта
$RemoteHost   = $_WORKSPACE[wsRemoteHost];   // Удаленный хост, с которого пользователь просматривает текущую страницу
$HttpReferer  = $_WORKSPACE[wsHttpReferer];  // Адрес страницы, с которой браузер пользователя перешёл на текущую страницу
*/

?>
<head>
   <title> Мои карты с LeafletJS </title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="../gpx/js/leaflet171.css" />
   <script src="../gpx/js/leaflet171.js"></script>
   <script src="../gpx/js/gpxtve.js"></script>

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
      attribution: '&copy; OpenStreetMap',
      maxZoom: 20,
      minZoom: 2,
      tileSize: 512,
      zoomOffset: -1
   }).addTo(map);
<?php

// !!! Для подключения файлов gpx в IIS следует установить MIME-тип "gpx", как text/xml
// const url = 'https://mpetazzoni.github.io/leaflet-gpx/demo.gpx';
// echo "const url = '"."http://localhost:100"."/gpx/mp20230923.gpx';";
//echo "const url = '".$urlHome."/gpx/mp20230923.gpx';";
echo "const url = '".$urlHome."/gpx/track20250810.gpx';";

?>
   const options = 
   {
      async: true,
      polyline_options: { color: 'red' },
   };

   const gpx = new L.GPX(url, options).on('loaded', (e) => {
      map.fitBounds(e.target.getBounds());
   }).addTo(map);
   
   // Создаем полилинию
   var latlngs = [
     [61.846308, 33.206584],
     [61.934839, 33.655948],
     [61.833141, 32.929247],
     [61.846308, 33.206584]
   ];
   
   //var polyline = L.polyline(latlngs, {color: 'red'});
   //polyline.addTo(map);

   /*
   
   latlngs = [
     [61.846308, 33.206584],
     [61.856308, 33.216584]
   ];
   polyline = L.polyline(latlngs, {color: 'blue'});
   polyline.addTo(map);
   */

   </script>
</body>
</html>
<?php

?> <!-- --> <?php // ******************************************** index.php ***
