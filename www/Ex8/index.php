<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// *               Ex8. Переключение между картами Osm-Яндекс                 *
// ****************************************************************************

// v1.0.2, 23.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 13.09.2025

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


echo "
<script>
  var nlat,nlon,nzoom,accuracy; 
  nlat=67.6755;
  nlon=33.936;
  nzoom=10;
  accuracy=0;
  
	var center=[nlat,nlon];
	//var center=getlocation();
  console.log('3. nlat='+nlat,'nlon='+nlon);
	var map = L.map('map', 
  {
		center:center,
		zoom:nzoom,
		zoomAnimation:true
	});
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
  
  /*
  function getlocation() 
  {
     var nlatin,nlonin,incenter;
     if (navigator.geolocation) 
     {
        navigator.geolocation.getCurrentPosition(
        function (position) 
        {
           nlatin = position.coords.latitude;
           nlonin = position.coords.longitude;
           accuracy = position.coords.accuracy; // Погрешность в метрах
           console.log('1. nlat='+nlatin,'nlon='+nlonin);
	         incenter=[nlatin,nlonin];
           return incenter;
        }, 
        function () 
        {
           alert(\"Не удалось получить ваше местоположение.\");
        });
     } 
     else 
     {
        alert(\"Ваш браузер не поддерживает геолокацию.\");
     }
     console.log('2. nlat='+nlatin,'nlon='+nlonin);
	   incenter=[nlatin,nlonin];
     return incenter;
  }
  */
  
  
</script>
";

if (permit==tve)
{
echo "
<script>
	map.attributionControl.setPosition('bottomleft').setPrefix('');

	function traffic () 
  {
		// https://tech.yandex.ru/maps/jsbox/2.1/traffic_provider
		var actualProvider = new ymaps.traffic.provider.Actual({}, { infoLayerShown: true });
		actualProvider.setMap(this._yandex);
	}

	var baseLayers = 
  {
		'OSM':               L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
    {
			attribution: '&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors'
		}).addTo(map),
		'Yandex map':        L.yandex(),           
		'Yandex satellite':  L.yandex({type:'satellite'}),  // тип может быть указан опционально
		'Yandex hybrid':     L.yandex('hybrid')
	};

	var overlays = 
  {
		'Traffic':L.yandex('overlay').on('load', traffic)
  };

	L.control.layers(baseLayers, overlays, {collapsed:true}).addTo(map);
	var marker = L.marker(center, {draggable:false}).addTo(map);
	map.locate({setView:true, maxZoom:19})
		.on('locationfound',function (e) 
    {
			marker.setLatLng(e.latlng);
		});
</script>
";
}

else
{
echo "
<script>
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
  {
    attribution: 'Map data © OpenStreetMap contributors',
    maxZoom: 19,
  }).addTo(map);
</script>
";
}


?>
</body>
</html>
<?php

?> <!-- --> <?php // ******************************************** index.php ***