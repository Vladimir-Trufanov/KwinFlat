<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * KwinFlat/Leaflet         Создать начальную интерактивную карту с Leaflet *
// ****************************************************************************

// v1.0.4, 24.08.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve           sla6en9edged        Дата создания: 07.08.2025

?>
<!DOCTYPE html>
<html>
<head>
   <title> Главная интерактивная карта KwinFlat/Leaflet </title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../gpx/js/leaflet171.css" />
   <script src="../gpx/js/leaflet171.js"></script>
   <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
   <h2 class="heading"> Путешествия и достопримечательности </h2>
   <div id="mymap"> </div>
   <div class="button-group flex-style">
      <div class="component1">
         <button class="map-zoom-out-btn"> Начальный масштаб карты </button>
      </div>
      <div class="component2">
         <select class="select-dropdown" name="dropdown">
            <option> Выбрать известное среди всего </option>
         </select>
         <button class="search-btn"> Поиск </button>
      </div>
   </div>
   <footer class="footer flex-style"> Made Using Leaflet JS | 
      <a href="" target="_blank"> Source Code</a> 
      <a href="" target="_blank"> <img src="assets/github-icon.png" /> </a> 
   </footer>
   <script type="text/javascript" src="script.js"></script>

</body>
</html>

<?php

?> <!-- --> <?php // ******************************************** index.php ***
