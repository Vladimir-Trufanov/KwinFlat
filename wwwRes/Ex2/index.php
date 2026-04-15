<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Leaflet                    Создать интерактивную карту с D3.js и Leaflet *
// ****************************************************************************

/**
 * Комбинация библиотек D3.js и Leaflet предоставляет мощный инструментарий для
 * создания интерактивных географических визуализаций. Leaflet отвечает за отображение 
 * карт и управление слоями, а D3.js позволяет добавлять кастомные элементы, 
 * такие как маркеры, линии или сложные графы.
 * 
 * https://habr.com/ru/articles/906414/
 * 
 * Интеграция D3.js с Leaflet основана на наложении SVG-слоя на карту и 
 * использовании D3.js для управления этим слоем. Ключевые шаги включают:
 * - Создание карты Leaflet: Инициализация карты с центром в конкретным местом 
 * (Казани) и добавление базового слоя (например, OpenStreetMap).
 * - Добавление SVG слоя: D3.js создает SVG-контейнер, который синхронизируется с картой.
 * - Преобразование координат: Метод latLngToLayerPoint преобразует географические 
 * координаты (широта, долгота) в пиксельные координаты для SVG.
 * - Обновление при взаимодействии: Синхронизация SVG-элементов с картой при 
 * масштабировании или перемещении.
 * 
 * Ниже приведен пример кода, который создает карту, центрированную в Казани, и 
 * отображает граф, состоящий из узлов (городов) и связей между ними. Узлы представляют 
 * Казань и несколько европейских городов, а связи показывают маршруты между ними.
 * 
 * Как работает код
 * 
 * 1. Инициализация карты: карта создается с помощью Leaflet и центрируется в Казани
 * ([55.7963, 49.1064]) с уровнем масштаба 5, чтобы показать регион вокруг города.
 * Используется тайловый слой OpenStreetMap для базовой карты.
 * 2. Данные: массив nodes содержит три города: Казань, Москва и Берлин с их 
 * географическими координатами. Массив links определяет связи между городами 
 * (Казань–Москва, Москва–Берлин).
 * 3. SVG-слой: D3.js создает SVG-элементы (линии для связей и круги для узлов) 
 * на слое, наложенном на карту. Координаты узлов преобразуются из географических 
 * в пиксельные с помощью map.latLngToLayerPoint.
 * 4. Интерактивность: Узлы подсвечиваются при наведении (увеличиваются и меняют размер).
 * Всплывающая подсказка (tooltip) показывает название города при наведении на узел.
 * Казань выделена зеленым цветом, чтобы подчеркнуть ее центральное положение.
 * 5. Обновление: Функция update вызывается при загрузке карты и при любом перемещении/масштабировании, 
 * чтобы синхронизировать позиции SVG-элементов.
 * 
 * Производительность: для больших графов используйте Canvas вместо SVG, чтобы 
 * снизить нагрузку на браузер.
**/
 
// v1.0.0, 07.08.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 07.08.2025

?>
<!DOCTYPE html>
<html lang="ru">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Проба Leaflet c D3.js</title>
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
      // Инициализация карты, центрированной на Казани
      const map = L.map('map').setView([55.7963, 49.1064], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Данные: узлы (города) и связи
        const nodes = [
            { id: "Kazan", lat: 55.7963, lng: 49.1064 },
            { id: "Moscow", lat: 55.7558, lng: 37.6173 },
            { id: "Berlin", lat: 52.5200, lng: 13.4050 }
        ];
        const links = [
            { source: "Kazan", target: "Moscow" },
            { source: "Moscow", target: "Berlin" }
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
                .attr("fill", d => d.id === "Kazan" ? "green" : "red")
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

?> <!-- --> <?php // ******************************************** index.php ***
