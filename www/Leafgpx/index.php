<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * KwinFlat/Leaflet                Создать карту с Leaflet для отслеживания *
// *                                                    треков и загрузки GPX *
// ****************************************************************************

// v1.0.12, 02.10.2025                                Автор:      Труфанов В.Е.
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
*/
$SiteHost     = $_WORKSPACE[wsSiteHost];     // Каталог хостинга
/*
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

define("pathPhpPrown",  $SiteHost.'/TPhpPrown/TPhpPrown'); 
define("pathPhpTools",  $SiteHost.'/TPhpTools/TPhpTools'); 

// Подключаем меню
require_once '../iniMenu.php'; 
// Подключаем переменные и константы JavaScript, соответствующие определениям в PHP
require_once "../iniPhpJS.php";  
// Подключаем объект для работы с базой данных моего хозяйства
require_once "../TKvizzyMaker/KvizzyMakerClass.php";

?>
<head>
  <title> Карта отслеживания треков и загрузки GPX </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <?php   
   // Подключаем jQuery
   echo '<script src="/jQuery/jquery-1.11.1.min.js"></script>';
   echo '
      <link rel="stylesheet" type="text/css" href="/jQuery/jquery-ui.min.css">
      <script src="/jQuery/jquery-ui.min.js"></script>
   ';
   // Подключаем модули для работы с OSM и Яндекс-картами
   echo '
  <link rel="stylesheet" href="../gpx/js/leaflet171.css" />
  <script src="../gpx/js/leaflet171.js"></script>
  <script src="../gpx/js/gpxtve.js"></script>
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=4e879c33-becb-4f85-8a6e-8f468e8dedeb" type="text/javascript"></script>
	<script src="../layer/tile/Yandex.js"></script>
	<style>
		.leaflet-bottom {bottom:20px}
		.leaflet-control-attribution{margin-bottom:-10px !important}
	</style>
  ';
  // Подключаем SmartMenus
  echo '<script src="/SmartMenus/jquery.smartmenus.min.js"></script>';
  echo '<script src="/SmartMenus/MakeSmartMenu.js"></script>';
  echo '<link rel="stylesheet" href="/SmartMenus/sm-core-css.css">';
  echo '<link rel="stylesheet" href="/SmartMenus/sm-kwinflat-desktop.css">';
  //echo '<link rel="stylesheet" href="/SmartMenus/sm-kwinflat-mobi.css">';
  // Подключаем обработку страницы
  echo '<script src="/CommonTools.js"></script>';
  echo '<script src="Leafgpx.js"></script>';
  echo '<link rel="stylesheet" href="Leafgpx.css">';
  // Разворачиваем смартменю
  echo '<script> MakeSmartMenu(); </script>';
  ?>
  <style>
    #ozhid {display:flex;}
    .vtimer {color: blue; margin-top:0;}
  </style>
</head>

<body>
<?php
  //echo '<script>alert("Определяем контекст нужной страницы");</script>';
  // Определяем контекст нужной страницы
  $gpx=prown\getComRequest('gpx');
  $idctrl=prown\getComRequest('ctrl');
  if ($idctrl!=NULL) $MenuTitle=pageMapCtrl;  // "Отслеживание координат"
  else if ($gpx!=NULL) $MenuTitle=pageMapGpx; // "Загрузка файлов .gpx"
  else $MenuTitle=pageMapStart;               // "Карта отслеживания треков и загрузки GPX"

  // Размещаем гамбургер-меню
  echo '<h2 id="pagename">'.$MenuTitle.'</h2>';
  echo '<div id="gamburg">';
    GpxMenu($urlHome); 
  echo '</div>';
  // Для размещения карты создаем элемент-контейнер (как правило, тег <div>) и задаём его размеры
  echo '
    <div id = "map"></div>
    <div id="ozhid">
      <p id="timerEnd" class="vtimer"></p>-<p id="timerBeg" class="vtimer"></p>[<p id="delta" class="vtimer">0</p>]
    </div>
  ';
  // Загружаем карту
  require_once "../Leafgpx/Leafgpx.php";
?>
</body>
</html>
<?php

?> <!-- --> <?php // ******************************************** index.php ***
