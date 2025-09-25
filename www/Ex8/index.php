<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// *               Ex8. Переключение между картами Osm-Яндекс                 *
// ****************************************************************************

// v1.0.3, 24.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 13.09.2025

define ("tve",    "tve"); 
define ("guest",  "гость"); 
define ("nearby", "близкие"); 
define ("permit", guest); 

?>
<html>
<head>
	<title>Ex8. Переключение между картами Osm-Яндекс</title>
  <link rel="stylesheet" href="../gpx/js/leaflet171.css" />
  <script src="../gpx/js/leaflet171.js"></script>
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=4e879c33-becb-4f85-8a6e-8f468e8dedeb" type="text/javascript"></script>
	<script src="../layer/tile/Yandex.js"></script>
	<style>
		.leaflet-bottom { bottom: 20px }
		.leaflet-control-attribution { margin-bottom: -10px !important }
	</style>
</head>
<body>

<div style="width:100%; height:100%" id="map"></div>

<?php

$lat=61.846308; $lon=33.206584; $zoom=10;  // Центр в Эссойле

// Строим Яндекс и OSM карты 
if (permit==tve) MakeMapTVE($zoom,$lat,$lon); 
// Строим только OSM карту 
else MakeMapOther($zoom,$lat,$lon); 

// ****************************************************************************
// *        Построить Яндекс и OSM-карты с возможностью переключения          *
// *   с центром в текущей точке геолокации (если геолокация разрешена) или   *
// *             в заданной точке (по умолчанию - Петрозаводск)               *
// ****************************************************************************
function MakeMapTVE($nzoom,$nlat=61.8021,$nlon=34.3296) 
{
  echo "<script> var nlat=".$nlat.",nlon=".$nlon.",nzoom=".$nzoom."; </script>"; 
  ?>
  <script>
	  let center=[nlat,nlon];
	  let map = L.map('map', 
    {
	    center:center,
	    zoom:nzoom,
	    zoomAnimation:true
    });
    map.attributionControl.setPosition('bottomleft').setPrefix('');
    let baseLayers = 
    {
	    'OSM':             L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
      {
	      attribution: '&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors'
      }).addTo(map),
      'Yandex map':      L.yandex(),           
      'Yandex satellite':L.yandex({type:'satellite'}),  // тип может быть указан опционально
      'Yandex hybrid':   L.yandex('hybrid')
    };

    let overlays = 
    {
      'Traffic':L.yandex('overlay').on('load',traffic)
    };

    L.control.layers(baseLayers,overlays,{collapsed:true}).addTo(map);
    let marker = L.marker(center, {draggable:false}).addTo(map);
 	  map.locate({setView:true, maxZoom:19}).on('locationfound',function (e) 
    {
		  marker.setLatLng(e.latlng);
    });
  
	  function traffic() 
    {
		  // https://tech.yandex.ru/maps/jsbox/2.1/traffic_provider
		  let actualProvider = new ymaps.traffic.provider.Actual({}, { infoLayerShown: true });
		  actualProvider.setMap(this._yandex);
	  }
  </script>
  <?php
}

// ****************************************************************************
// *                             Построить OSM-карту                          *
// *   с центром в текущей точке геолокации (если геолокация разрешена) или   *
// *             в заданной точке (по умолчанию - Петрозаводск)               *
// ****************************************************************************
function MakeMapOther($nzoom,$nlat=61.8021,$nlon=34.3296) 
{
  echo "<script> var nlat=".$nlat.",nlon=".$nlon.",nzoom=".$nzoom."; </script>"; 
  ?>
  <script>
  
  // Определяем параметры работы функции геолокации  
  const geooptions = 
  {
    enableHighAccuracy:true, // предоставлять более точные данные (вызываем увеличение энергопотребления)
    timeout:Infinity,        // ждать, пока не станет доступно местоположение
    maximumAge: 0,           // возвращать данные о последнем местоположении
  };
  // Определяем местоположение и загружаем карту
  if (navigator.geolocation) 
  {
     navigator.geolocation.getCurrentPosition(
     function (position) 
     {
       var nlatin = position.coords.latitude;
       var nlonin = position.coords.longitude;
       var accuracy = position.coords.accuracy; // Погрешность в метрах
       MakeMap(nlatin,nlonin,nzoom); 
     }, 
     function () 
     {
       alert("Не удалось получить ваше местоположение.");
       MakeMap(nlat,nlon,nzoom); 
     },
     geooptions);
  } 
  else 
  {
     alert("Ваш браузер не поддерживает геолокацию.");
     MakeMap(nlat,nlon,nzoom) 
  }
  // Построить OSM-карту с маркером в центре
  function MakeMap(nlat,nlon,nzoom,accuracy) 
  {
    // Готовим пространство под карту с центром и зумом
	  var center=[nlat,nlon];
	  var map = L.map('map', 
    {
		  center:center,
		  zoom:nzoom,
		  zoomAnimation:true
	  });
    // Загружаем OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
    {
      attribution: 'Map data © OpenStreetMap contributors',
      maxZoom: 19,
    }).addTo(map);
    // Готовим маркер 'флаг трека'
    var DirFlagIconOptions = 
    {
      iconUrl: '../gpx/js/images/DirFlag47x47.png',
      iconSize: [47,47]
    }
    var DirFlagIcon = L.icon(DirFlagIconOptions);
    var DirFlagMarkerOptions = 
    {
      title: 'Мы здесь',
      clickable: false,
      draggable: false,
      icon: DirFlagIcon
    }
    // Устанавливаем и подписываем маркер
    var DirFlagMarker = L.marker(center,DirFlagMarkerOptions);
    DirFlagMarker.addTo(map);
  }
  </script>
  <?php
}

?>
</body>
</html>
<?php

?> <!-- --> <?php // ******************************************** index.php ***