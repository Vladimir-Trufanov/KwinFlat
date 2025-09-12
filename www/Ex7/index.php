<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Как отобразить своё местоположение на карте с помощью JavaScript         *
// * https://myrusakov.ru/javascript-map-location-display.html                *
// ****************************************************************************

// --v2.0.0, 12.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 07.08.2025

$lat=61.8021;   $long=34.3296;   $zoom=10;  // Центр в Петрозаводске

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карта с вашим местоположением</title>
    <link rel="stylesheet" href="js/leaflet.css" />
    <script src="js/leaflet.js"></script>

     <script type="text/javascript">
        
        function initMap(latitude, longitude, accuracy) 
        {
           console.log('latitude ',latitude);
           console.log('longitude',longitude);
           console.log('accuracy ',accuracy);
           
           var mapOptions = {center:[latitude,longitude],zoom:18};
           
           var map = new L.map('map',mapOptions);
           L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
           {
             attribution: 'Map data © OpenStreetMap contributors',
             maxZoom: 19,
           }).addTo(map);
           
           // Готовим маркер 'флаг трека'
           var DirFlagIconOptions = 
           {
             iconUrl: 'js/images/DirFlag47x47.png',
             iconSize: [47,47]
           }
           var DirFlagIcon = L.icon(DirFlagIconOptions);
           var DirFlagMarkerOptions = 
           {
             title: 'Мое примерное местоположение',
             clickable: true,
             draggable: false,
             icon: DirFlagIcon
           }
           // Устанавливаем и подписываем маркер
           var DirFlagMarker = L.marker([latitude,longitude], DirFlagMarkerOptions);
           DirFlagMarker.bindPopup('Эссойла, ул.Школьная, 3').openPopup();
           DirFlagMarker.addTo(map);
        }
        
        function showMap() 
        {
            if (navigator.geolocation) 
            {
                navigator.geolocation.getCurrentPosition(
                function (position) 
                {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const accuracy = position.coords.accuracy; // Погрешность в метрах
                    initMap(latitude, longitude, accuracy);
                }, 
                function () 
                {
                    alert("Не удалось получить ваше местоположение.");
                });
            } 
            else 
            {
                alert("Ваш браузер не поддерживает геолокацию.");
            }
        }
        
    </script>
</head>
<body>
    <h1>Карта с вашим местоположением</h1>
    <?php
    // Для размещения карты создаем элемент-контейнер (как правило, тег <div>) и задаём его размеры
    echo '<div id = "map" style = "width:900px; height:580px;"></div>';
    
    /*
    echo "
    <script>
    var mapOptions = {center:[".$lat.",".$long."],zoom:".$zoom."}
    ";
    */

    /*
    echo "
    <script>
    var mapOptions = {center:[".$lat.",".$long."],zoom:".$zoom."}
    ";
    */
    /*
    echo "
    var map = new L.map('map',mapOptions);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data © OpenStreetMap contributors',
    maxZoom: 14,
    }).addTo(map);
    ";
    echo "
    </script>
    ";
    */


    ?>

    <input type="button" value="Показать карту" onclick="showMap()">
    <!--
    <div id="YMapsID" style="width:600px;height:400px; margin-top: 20px;"></div>
     -->
</body>
</html>

<?php

?> <!-- --> <?php // ******************************************** index.php ***
