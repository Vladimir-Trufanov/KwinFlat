<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Leaflet                       Показывать трек по загружаемым координатам *
// ****************************************************************************

// v2.0.0, 12.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 07.08.2025

echo '<!DOCTYPE html>';  // определили разметку HTML5
echo '<html lang="ru">'; // назначили русский язык для сайта
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';

echo '
<head>
   <title> Мои карты с LeafletJS </title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="js/leaflet.css" />
   <script src="js/leaflet.js"></script>

   <script src="/jQuery/jquery-1.11.1.min.js"></script>
   <link rel="stylesheet" type="text/css" href="/jQuery/jquery-ui.min.css">
   <script src="/jQuery/jquery-ui.min.js"></script>
</head>

<body>
   <h2 class="heading">Трек по загружаемым координатам</h2>
';
// Для размещения карты создаем элемент-контейнер (как правило, тег <div>) и задаём его размеры
echo '<div id = "map" style = "width:900px; height:580px;"></div>';

// Далее:
// - создаём объект mapOptions и определяем начальные параметры карты: center и zoom,
// где center получает объект LatLng, указывающий местоположение, вокруг которого 
// мы хотим расположить карту (это значения широты и долготы), а zoom представляет 
// означает целое число, соответствующее уровню масштабирования карты;

// - cоздаём объект map (карту на странице) с передачей двух параметров: 
// строковой переменной, представляющей идентификатор DOM или экземпляр элемента <div>
// и указывающей на HTML-контейнер для хранения карты и необязательный объектный 
// литерал с параметрами карты;

// - cоздаём экземпляр TileLayer класса - набор определенного типа плиток (слой тайлов). 
// При создании экземпляра необходимо передать шаблон URL-адреса, запрашивающий 
// нужный слой тайлов (карту) у поставщика услуг (в нашем случае Openstreetmap);

// - добавляем слой на карту (традиционный набор тайлов от Openstreetmap).

$lat=61.846308; $long=33.206584; $zoom=10;  // Центр в Эссойле
echo "
<script>
var mapOptions = {center:[".$lat.",".$long."],zoom:".$zoom."}
";

echo "
var map = new L.map('map',mapOptions);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
attribution: 'Map data © OpenStreetMap contributors',
maxZoom: 19,
}).addTo(map);
";

echo "
</script>
";

// Строим ломанную линию (треугольник) из 4 точек
// (первую точку дважды, второй раз, как последнюю)
echo "
<script>
$(document).ready(function() 
{
  var itrk=0;
  intervalTrk=setInterval(function() 
  {
    itrk++;
    if (itrk>25) clearInterval(intervalTrk);
    else SayPoint(itrk);
  }
  ,1000)


});
</script>

<script>
  // Формируем координаты полилинии
  var latlngs = [
     [61.846308, 33.206584],
     [61.934839, 33.655948],
     [61.833141, 32.929247],
     [61.846308, 33.206584]
  ];
  // Creating a poly line
  var polyline = L.polyline(latlngs, {color: 'red'});
  // Adding to poly line to map
  polyline.addTo(map);

  latlngs = [[61.846308, 33.206584],[61.856308, 33.216584]];
  polyline = L.polyline(latlngs, {color: 'blue'});
  polyline.addTo(map);
  

function SayPoint(itrk)
{
  console.log(itrk); 
  let delta=0.03000;
  //console.log('latlngs[0][0]=61.846308',latlngs[0][0]);
  let remainder = itrk % 5;
  if (remainder==1)
  {
    latlngs[0][0]=latlngs[1][0];
    latlngs[0][1]=latlngs[1][1];
    latlngs[1][0]=latlngs[1][0]+delta;
    latlngs[1][1]=latlngs[1][1]+delta;
    polyline = L.polyline(latlngs, {color: 'green'});
    polyline.addTo(map);
  }
  else if (remainder==2)
  {
    latlngs[0][0]=latlngs[1][0];
    latlngs[0][1]=latlngs[1][1];
    latlngs[1][0]=latlngs[1][0]+delta;
    polyline = L.polyline(latlngs, {color: 'yellow'});
    polyline.addTo(map);
  }
  else if (remainder==3)
  {
    latlngs[0][0]=latlngs[1][0];
    latlngs[0][1]=latlngs[1][1];
    latlngs[1][0]=latlngs[1][0]-delta;
    latlngs[1][1]=latlngs[1][1]-delta;
    polyline = L.polyline(latlngs, {color: 'black'});
    polyline.addTo(map);
  }
  else if (remainder==4)
  {
    latlngs[0][0]=latlngs[1][0];
    latlngs[0][1]=latlngs[1][1];
    latlngs[1][0]=latlngs[1][0]-delta;
    polyline = L.polyline(latlngs, {color: 'red'});
    polyline.addTo(map);
  }
  else if (remainder==0)
  {
    latlngs[0][0]=latlngs[1][0];
    latlngs[0][1]=latlngs[1][1];
    latlngs[1][1]=latlngs[1][1]+delta*2;
    polyline = L.polyline(latlngs, {color: 'blue'});
    polyline.addTo(map);
 }
}

</script>
";
?>

</body>
</html>
<?php

?> <!-- --> <?php // ******************************************** index.php ***
