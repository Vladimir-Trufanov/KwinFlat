<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * LeafletRusakov      Добавление пользовательских меток и всплывающих окон *
// *                                          на карту c JavaScript и Leaflet *
// ****************************************************************************

/**
 * Объяснение кода.
 * - Инициализация карты: Мы создаём карту с центром на указанных координатах и 
 * устанавливаем масштаб (13).
 * - Добавление слоя OpenStreetMap: Это позволяет загрузить карту с открытыми данными.
 * - Добавление стандартной метки: Используем метод L.marker для размещения метки на карте.
 * - Настройка пользовательской иконки: Используем L.icon для создания уникальной
 * метки с заданным изображением.
 * - Добавление нескольких меток: Используем массив объектов с координатами и 
 * всплывающими окнами, чтобы добавить сразу несколько меток.
 * - Обработка событий: Добавляем обработчик событий на пользовательскую метку, 
 * чтобы сделать её интерактивной.
 * 
**/
 
// v2.0.0, 08.08.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.08.2025

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Карта с пользовательскими метками</title>
  <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" /> --> 
  <link rel="stylesheet" href="leaflet194/leaflet.css" />
  <style>
    #map {
      height: 500px; /* Высота карты */
    }
  </style>
</head>
<body>
  <h1>Карта с пользовательскими метками</h1>
  <div id="map"></div>

  <!-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> -->
  <script src="leaflet194/leaflet.js"></script>
  <script>
    // Инициализация карты
    const map = L.map('map').setView([51.505, -0.09], 13);

    // Слой карты OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data © OpenStreetMap contributors',
      maxZoom: 19,
    }).addTo(map);

    // Добавление стандартной метки
    const marker = L.marker([51.505, -0.09]).addTo(map);
    marker.bindPopup('<b>Это Лондон!</b><br>Столица Великобритании.').openPopup();

    // Пользовательская иконка
    const customIcon = L.icon({
      iconUrl: 'https://example.com/custom-icon.png', // Замените на свой URL
      iconSize: [32, 32], // Размеры иконки
      iconAnchor: [16, 32], // Точка привязки иконки
    });

    // Добавление пользовательской метки
    const customMarker = L.marker([51.51, -0.1], { icon: customIcon }).addTo(map);
    customMarker.bindPopup('Это пользовательская метка!');

    // Событие клика по пользовательской метке
    customMarker.on('click', function () {
      console.log('Метка была нажата!');
    });

    // Добавление нескольких меток
    const locations = [
      { coords: [51.505, -0.09], popup: 'Первая метка' },
      { coords: [51.51, -0.1], popup: 'Вторая метка' },
      { coords: [51.515, -0.11], popup: 'Третья метка' },
    ];

    locations.forEach(location => {
      const marker = L.marker(location.coords).addTo(map);
      marker.bindPopup(location.popup);
    });
  </script>
</body>
</html>

<?php

?> <!-- --> <?php // ******************************************** index.php ***
