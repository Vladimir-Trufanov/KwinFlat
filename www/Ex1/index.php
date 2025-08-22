<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Leaflet                            Создать интерактивную карту с Leaflet *
// ****************************************************************************

/**
 * Переработанный пример со страницы "LeafletJS - Interacting with Maps using JavaScript"
 * (https://www.geeksforgeeks.org/javascript/leafletjs-interacting-with-maps-using-javascript/) 
 * и привязанного к странице репозитария "Leaflet JS Example Code"
 * (https://github.com/OptimalLearner/Leaflet-JS-Example-Code/tree/master)
**/
 
// v1.0.2, 11.08.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve           sla6en9edged        Дата создания: 07.08.2025

?>
<!DOCTYPE html>
<html>
<head>
   <title> Мои карты с LeafletJS </title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="js/leaflet194.css" />
   <script src="js/leaflet194.js"></script>
   <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
   <h2 class="heading"> Путешествия и достопримечательности </h2>
   <div id="mymap"> </div>
   <div class="button-group flex-style">
      <div class="component1">
         <button class="map-zoom-out-btn"> Map Zoom Out </button>
      </div>
      <div class="component2">
         <select class="select-dropdown" name="dropdown">
            <option> Выбрать известное среди всего </option>
         </select>
         <button class="search-btn"> Search </button>
      </div>
   </div>
   <footer class="footer flex-style"> Made Using Leaflet JS | 
      <a href="" target="_blank"> Source Code</a> 
      <a href="" target="_blank"> <img src="assets/github-icon.png" /> </a> 
   </footer>
   <script type="text/javascript" src="js/script.js"></script>
</body>
</html>

<?php

/*
<!DOCTYPE html>
<html lang="ru">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Проба Leaflet</title>
   <link rel="stylesheet" href="leaflet194/leaflet.css" />
   <style>
      #map { height: 500px; }
      .node { cursor: pointer; }
      .link { stroke: #333; stroke-width: 2px; }
      .tooltip { position: absolute; background: white; padding: 5px; border: 1px solid #ccc; border-radius: 3px; pointer-events: none; }
   </style>
</head>

<body>
   <div id="map"></div>
   <script src="d3js790/d3.v7.min.js"></script>
   <script src="leaflet194/leaflet.js"></script>
   <script>
      // Инициализируем карту, центрированную на Петрозаводск
      const map = L.map('map').setView([61.8021, 34.3296],10);
         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Данные: узлы (города) и связи
        const nodes = [
            { id: "Dacha", lat: 61.702048, lng: 34.154702 },
            { id: "Dom", lat: 61.802094, lng: 34.329613 },
            { id: "BotSad", lat: 61.844252, lng: 34.390658 }
        ];
        const links = [
            { source: "Dacha", target: "Dom" },
            { source: "Dom", target: "BotSad" }
        ];

        // Создаем SVG-слой
        const svgLayer = L.svg();
        svgLayer.addTo(map);
        const svg = d3.select("#map").select("svg");
        const g = svg.select("g");

        // Создаем элемент для всплывающей подсказки
        const tooltip = d3.select("body").append("div").attr("class", "tooltip").style("opacity", 0);

        // Функция обновления графа
        function update() {
            // Отрисовка связей
            g.selectAll(".link")
                .data(links)
                .join("line")
                .attr("class", "link")
                .attr("x1", d => {
                    const sourceNode = nodes.find(n => n.id === d.source);
                    return map.latLngToLayerPoint([sourceNode.lat, sourceNode.lng]).x;
                })
                .attr("y1", d => {
                    const sourceNode = nodes.find(n => n.id === d.source);
                    return map.latLngToLayerPoint([sourceNode.lat, sourceNode.lng]).y;
                })
                .attr("x2", d => {
                    const targetNode = nodes.find(n => n.id === d.target);
                    return map.latLngToLayerPoint([targetNode.lat, targetNode.lng]).x;
                })
                .attr("y2", d => {
                    const targetNode = nodes.find(n => n.id === d.target);
                    return map.latLngToLayerPoint([targetNode.lat, targetNode.lng]).y;
                });

            // Отрисовка узлов
            g.selectAll(".node")
                .data(nodes)
                .join("circle")
                .attr("class", "node")
                .attr("cx", d => map.latLngToLayerPoint([d.lat, d.lng]).x)
                .attr("cy", d => map.latLngToLayerPoint([d.lat, d.lng]).y)
                .attr("r", 6)
                .attr("fill", d => d.id === "Dacha" ? "green" : "red")
                .on("mouseover", function (event, d) {
                    d3.select(this).attr("r", 8);
                    tooltip.transition().duration(200).style("opacity", 0.9);
                    tooltip.html(d.id)
                        .style("left", (event.pageX + 10) + "px")
                        .style("top", (event.pageY - 28) + "px");
                })
                .on("mouseout", function () {
                    d3.select(this).attr("r", 6);
                    tooltip.transition().duration(500).style("opacity", 0);
                });
        }

        // Обновляем при загрузке и взаимодействии
        update();
        map.on("moveend", update);
    </script>
</body>
</html>
<?php
*/

?> <!-- --> <?php // ******************************************** index.php ***
