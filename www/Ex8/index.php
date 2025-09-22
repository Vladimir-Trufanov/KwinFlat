<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// *               Ex8. Переключение между картами Osm-Яндекс                 *
// ****************************************************************************

// v1.0.1, 22.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 13.09.2025

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

<script>
	var center = [67.6755, 33.936];

	var map = L.map('map', 
  {
		center: center,
		zoom: 10,
		zoomAnimation: true
	});

	map.attributionControl
		.setPosition('bottomleft')
		.setPrefix('');

	function traffic () 
  {
		// https://tech.yandex.ru/maps/jsbox/2.1/traffic_provider
		var actualProvider = new ymaps.traffic.provider.Actual({}, { infoLayerShown: true });
		actualProvider.setMap(this._yandex);
	}

	var baseLayers = 
  {
		'Yandex map':        L.yandex().addTo(map),            // 'map' по умолчанию
		'Yandex satellite':  L.yandex({ type: 'satellite' }),  // тип может быть указан опционально
		'Yandex hybrid':     L.yandex('hybrid'),
		'OSM':               L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
    {
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		})
	};

	var overlays = 
  {
		'Traffic':L.yandex('overlay').on('load', traffic)
  };

	L.control.layers(baseLayers, overlays, {collapsed: false}).addTo(map);
	var marker = L.marker(center, { draggable: true }).addTo(map);
	map.locate({ setView: true, maxZoom: 19 })
		.on('locationfound',function (e) 
    {
			marker.setLatLng(e.latlng);
		});
</script>
 
</body>
</html>
<?php


?> <!-- --> <?php // ******************************************** index.php ***
