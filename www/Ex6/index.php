<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Leaflet                       Показывать трек по загружаемым координатам *
// ****************************************************************************

// v2.0.1, 20.09.2025                                 Автор:      Труфанов В.Е.
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

  var itrk;    // счетчик цикла
  var latlngs; // линия с координатами предыдущей точки и текущей
  var latold;  // широта предыдущей точки
  var lonold;  // долгота предыдущей точки
  var latcur;  // широта текущей точки
  var loncur;  // долгота текущей точки
  var ccolor;  // цвет линии

  // Формируем координаты и строим начальный треугольник
  latlngs = [
     [61.846308, 33.206584],
     [61.934839, 33.655948],
     [61.833141, 32.929247],
     [61.846308, 33.206584]
  ];
  var polyline = L.polyline(latlngs, {color: 'red'});
  polyline.addTo(map);
  
  // Строим отрезок
  latold=61.846308;
  lonold=33.206584;
  latcur=61.856308;
  loncur=33.216584;
  latlngs = [[latold,lonold],[latcur,loncur]];
  polyline = L.polyline(latlngs, {color: 'white'});
  polyline.addTo(map);
  // Запускаем вычерчивание полилинии
  itrk=0;
  intervalTrk=setInterval(function() 
  {
    itrk++;
    // Переносим координаты текущей точки в предыдущую
    latold=latcur;
    lonold=loncur;
    // Генерируем новую точку
    genPoint(itrk);
    // Добавляем новую линию
    latlngs = [[latold,lonold],[latcur,loncur]];
    polyline = L.polyline(latlngs,{color:ccolor});
    polyline.addTo(map);
  }
  ,1000)

function genPoint(itrk)
{
  console.log(itrk); 
  if (itrk<25)
  {
    let delta=0.03000;
    let remainder = itrk % 5;
    if (remainder==1)
    {
      latcur=latcur+delta;
      loncur=loncur+delta;
      ccolor='green';
    }
    else if (remainder==2)
    {
      latcur=latcur+delta;
      ccolor='yellow';
    }
    else if (remainder==3)
    {
      latcur=latcur-delta;
      loncur=loncur-delta;
      ccolor='black';
    }
    else if (remainder==4)
    {
      latcur=latcur-delta;
      ccolor='red';
    }
    else if (remainder==0)
    {
      loncur=loncur+delta*2;
      ccolor='white';
    }
  }
  else if (itrk==25)
  {
    latcur=61.846308;
    loncur=33.206584;
    ccolor='white';
  }
}
  
});
</script>
";
?>

</body>
</html>
<?php

?> <!-- --> <?php // ******************************************** index.php ***
