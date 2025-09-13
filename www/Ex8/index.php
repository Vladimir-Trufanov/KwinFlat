<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Как отобразить своё местоположение на карте с помощью JavaScript         *
// * https://myrusakov.ru/javascript-map-location-display.html                *
// ****************************************************************************

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карта с вашим местоположением</title>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
        function initMap(latitude, longitude, accuracy) {
            var map = new ymaps.Map("YMapsID", {
                center: [latitude, longitude],
                zoom: 10,
                controls: ['zoomControl', 'geolocationControl']
            });

            var placemark = new ymaps.Placemark([latitude, longitude], {
                balloonContent: `Вы здесь!<br>Широта: ${latitude}<br>Долгота: ${longitude}<br>Погрешность: ±${accuracy} м`
            }, {
                preset: 'islands#redDotIcon'
            });

            map.geoObjects.add(placemark);
        }

        function showMap() {
            if (navigator.geolocation) 
            {
                navigator.geolocation.getCurrentPosition(function (position) 
                //navigator.geolocation.watchPosition(function (position)
                {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const accuracy = position.coords.accuracy; // Погрешность в метрах
                    initMap(latitude, longitude, accuracy);
                }, function () {
                    alert("Не удалось получить ваше местоположение.");
                });
            } else {
                alert("Ваш браузер не поддерживает геолокацию.");
            }
        }
    </script>
</head>
<body>
    <h1>Карта с вашим местоположением</h1>
    <input type="button" value="Показать карту" onclick="showMap()">
    <div id="YMapsID" style="width:600px;height:400px; margin-top: 20px;"></div>
</body>
</html><?php

?> <!-- --> <?php // ******************************************** index.php ***
