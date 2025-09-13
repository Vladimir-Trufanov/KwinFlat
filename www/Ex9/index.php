<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Ex9                   Изучить работу с тайловыми картами яндекса            *
// ****************************************************************************

// v1.0.0, 13.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 13.09.2025

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Изучаем работу с тайловыми картами яндекса</title>
  <script>
  function initMap(latitude, longitude, accuracy) 
  {
    /*
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
    */
  }

  function showMap() 
  {
    if (navigator.geolocation) 
    {
      //navigator.geolocation.getCurrentPosition(function(position) 
      navigator.geolocation.watchPosition(function (position)
      {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        const accuracy = position.coords.accuracy; // Погрешность в метрах
        console.log('Широта:     ',latitude);
        console.log('Долгота:    ',longitude);
        console.log('Погрешность:',accuracy,'м.');
        
        initMap(latitude,longitude,accuracy);
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
  <img src="map512x512.png" alt="Описание изображения">
  <img src="https://tiles.api-maps.yandex.ru/v1/tiles/?x=0&y=0&z=0&lang=ru_RU&l=map&apikey=9f703858-3bcf-46fb-847f-798ac6dc1798"
    width="512" height="512" alt="Описание изображения">
  <input type="button" value="Показать карту" onclick="showMap()">
  <div id="YMapsID" style="width:600px;height:400px; margin-top: 20px;"></div>
</body>
</html>

<?php

?> <!-- --> <?php // ******************************************** index.php ***
