<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Ex1Yandex                  ----Изучить работу с тайловыми картами яндекса            *
// ****************************************************************************

// v1.0.0, 13.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 13.09.2025

?>
<html>
<head>
	<title>L.Yandex example</title>
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
	<script src="https://api-maps.yandex.ru/2.1/?lang=en_RU&amp;apikey=9f703858-3bcf-46fb-847f-798ac6dc1798" type="text/javascript"></script>
  <!--
  <script src="https://tiles.api-maps.yandex.ru/v1/tiles/?x=0&y=0&z=0&lang=ru_RU&l=map&apikey=9f703858-3bcf-46fb-847f-798ac6dc1798"></script>
  -->
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

	var map = L.map('map', {
		center: center,
		zoom: 10,
		zoomAnimation: true
	});

	map.attributionControl
		.setPosition('bottomleft')
		.setPrefix('');

	function traffic () {
		// https://tech.yandex.ru/maps/jsbox/2.1/traffic_provider
		var actualProvider = new ymaps.traffic.provider.Actual({}, { infoLayerShown: true });
		actualProvider.setMap(this._yandex);
	}

	var baseLayers = {
		'Yandex map': L.yandex() // 'map' is default
			.addTo(map),
		'Yandex map + Traffic': L.yandex('map')
			.on('load', traffic),
		'Yandex satellite':  L.yandex({ type: 'satellite' }), // type can be set in options
		'Yandex hybrid':     L.yandex('hybrid'),
		'OSM': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		})
	};

	var overlays = {
		'Traffic': L.yandex('overlay')
			.on('load', traffic)
        };

	L.control.layers(baseLayers, overlays, {collapsed: false}).addTo(map);
	var marker = L.marker(center, { draggable: true }).addTo(map);
	map.locate({ setView: true, maxZoom: 14 })
		.on('locationfound',function (e) {
			marker.setLatLng(e.latlng);
		});
</script>
 
</body>
</html>
<?php

?> <!-- --> <?php // ******************************************** index.php ***
