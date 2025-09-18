<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * KwinFlat/Leaflet                Создать карту с Leaflet для отслеживания *
// *                                                     треков и загрузки GPX *
// ****************************************************************************

// v1.0.10, 18.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 07.08.2025

echo '<!DOCTYPE html>';  // определили разметку HTML5
echo '<html lang="ru">'; // назначили русский язык для сайта
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';

// Реестр образцов запросов на Leafgpx
// https://probatv.ru/Leafgpx                    - общий запрос трассировки всех треков
// https://probatv.ru/Leafgpx/?ctrl=203          - запрос трассировки трека 203 контроллера 'Sim900 в автомобиле' 
// https://probatv.ru/Leafgpx/?gpx=204           - запрос загрузки файла gpx 'Виртуального контроллера'

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

require_once '../iniMenu.php'; 

?>
<head>
   <title> Карта отслеживания треков и загрузки GPX </title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="../gpx/js/leaflet171.css" />
   <script src="../gpx/js/leaflet171.js"></script>
   <script src="../gpx/js/gpxtve.js"></script>
   <?php   
   // Подключаем jQuery
   echo '<script src="/jQuery/jquery-1.11.1.min.js"></script>';
   echo '
      <link rel="stylesheet" type="text/css" href="/jQuery/jquery-ui.min.css">
      <script src="/jQuery/jquery-ui.min.js"></script>
   ';
   // Подключаем SmartMenus
   echo '<script src="/SmartMenus/jquery.smartmenus.min.js"></script>';
   echo '<script src="/SmartMenus/MakeSmartMenu.js"></script>';
   echo '<link rel="stylesheet" href="/SmartMenus/sm-core-css.css">';
   echo '<link rel="stylesheet" href="/SmartMenus/sm-doortry-mobi.css">';
   // Подключаем обработку страницы
   echo '<script src="Leafgpx.js"></script>';
   // Разворачиваем смартменю
   echo '<script> MakeSmartMenu(); </script>';
   ?>
   <style>
     #ozhid {display:flex;}
     .vtimer {color: blue; margin-top:0;}
     /*  #map { height: 500px; } */
   </style>
</head>

<body>
<?php
  // Размещаем гамбургер-меню
  echo '<div id="gamburg">';
    GpxMenu($urlHome); 
  echo '</div>';
  // Для размещения карты создаем элемент-контейнер (как правило, тег <div>) и задаём его размеры
  echo '
    <div id = "map" style = "width:900px; height:580px;"></div>
    <div id="ozhid">
      <p id="timerEnd" class="vtimer"></p>-<p id="timerBeg" class="vtimer"></p>[<p id="delta" class="vtimer">0</p>]
    </div>
  ';
  // Определяем контекст нужной страницы
  $gpx=prown\getComRequest('gpx');
  $ctrl=prown\getComRequest('ctrl');
  // Центруем (по умолчанию-Петрозаводск) и выводим карту для трассировки трека
  if ($gpx==NULL) SimpleTrackMap($ctrl);
  // Создаем карту для загрузки файла gps и загружаем файл          
  else LoadGpsFile($urlHome,$gpx);
?>
</body>
</html>
<?php

// ****************************************************************************
// *      Отцентрировать (по умолчанию - Петрозаводск) и вывести карту для    *
// *                              трассировки трека                           *
// ****************************************************************************
function SimpleTrackMap($ctrl)
{
  if ($ctrl==NULL) $ctrl=204;
  // $lat=61.783270; $long=33.808963;  $zoom=10;  // Центр в Матросах
  $lat=61.8021;   $long=34.3296;    $zoom=11;     // Центр в Петрозаводске
  // $lat=61.846308; $long=33.206584; $zoom=10;   // Центр в Эссойле
  echo "
  <script>
  SimpleTrackMap(".$lat.",".$long.",".$zoom.",".$ctrl.");
  </script>
  ";
}
// ****************************************************************************
// *         Создать карту для загрузки файла gps и загрузить файл            *
// ****************************************************************************
function LoadGpsFile($urlHome,$gpx)
{
   // !!! Для подключения файлов gpx в IIS следует установить MIME-тип "gpx", как text/xml
   // const url = 'https://mpetazzoni.github.io/leaflet-gpx/demo.gpx';
   // echo "const url = '"."http://localhost:100"."/gpx/mp20230923.gpx';";
   // echo "const url = '".$urlHome."/gpx/mp20230923.gpx';";
   echo "
   <script>
   const url = '".$urlHome."/gpx/track20250810.gpx';
   </script>
   ";
   
   ?>
   <script type="module">
   const mapgpx = L.map('map');
   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap',
      maxZoom: 20,
      minZoom: 2,
      tileSize: 512,
      zoomOffset: -1
   }).addTo(mapgpx);

   // Определяем цвет трека
   const options = 
   {
      async: true,
      polyline_options: { color: 'red' },
   };
   // Загружаем gpx-файл
   const gpx = new L.GPX(url, options).on('loaded', (e) => {
      mapgpx.fitBounds(e.target.getBounds());
   }).addTo(mapgpx);
   </script>
   <?php
}

?> <!-- --> <?php // ******************************************** index.php ***
