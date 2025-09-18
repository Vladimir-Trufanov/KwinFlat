// JS/HTML5, EDGE/CHROME/YANDEX                              *** Leafgpx.js ***

// ****************************************************************************
// * KwinFlat/Leaflet                Создать карту с Leaflet для отслеживания *
// *                                                     треков и загрузки GPX *
// ****************************************************************************

// v1.0.1, 18.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 17.09.2025

function SimpleTrackMap(nlat,nlong,nzoom)   
{
  //console.log('nlat='+nlat);
  //console.log('nlong='+nlong);
  //console.log('nzoom='+nzoom);
  
  // Cоздаём объект mapOptions и определяем начальные параметры карты: center и zoom,
  // где center получает объект LatLng, указывающий местоположение, вокруг которого 
  // мы хотим расположить карту (это значения широты и долготы), а zoom представляет 
  // означает целое число, соответствующее уровню масштабирования карты;

  // Cоздаём объект map (карту на странице) с передачей двух параметров: 
  // строковой переменной, представляющей идентификатор DOM или экземпляр элемента <div>
  // и указывающей на HTML-контейнер для хранения карты и необязательный объектный 
  // литерал с параметрами карты;

  // Cоздаём экземпляр TileLayer класса - набор определенного типа плиток (слой тайлов). 
  // При создании экземпляра необходимо передать шаблон URL-адреса, запрашивающий 
  // нужный слой тайлов (карту) у поставщика услуг (в нашем случае Openstreetmap);

  // Добавляем слой на карту (традиционный набор тайлов от Openstreetmap).

  var mapOptions = {center:[nlat,nlong],zoom:nzoom};
  var map = new L.map('map',mapOptions);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data © OpenStreetMap contributors',
    maxZoom: 19,
  }).addTo(map);

  // Строим ломанную линию (треугольник) из 4 точек
  // (первую точку дважды, второй раз, как последнюю)
   
  // Формируем координаты полилинии
  var latlngs = [
    [61.846308, 33.206584],
    [61.934839, 33.655948],
    [61.833141, 32.929247],
    [61.846308, 33.206584]
  ];
  // Создаем полилинию
  var polyline = L.polyline(latlngs, {color: 'red'});
  // Добавляем полилинию на карту
  polyline.addTo(map);
  // Центрируем полилинию, перемещаем и масштабируем карту 
  map.flyTo([61.846308, 33.206584], 10);
   
  // Запускаем трассировку поступающих координат
  var itrkwpt=0;
  intervalTrkWpt=setInterval(function() 
  {
    itrkwpt++;
    //if (itrk>25) clearInterval(intervalTrk);
    //else 
    SayPoint(itrkwpt);
  }
  ,998)
   
  // latlngs = [[61.846308, 33.206584],[61.856308, 33.216584]];
  // polyline = L.polyline(latlngs, {color: 'blue'});
  // polyline.addTo(map);
   
  //document.querySelector('.search-btn').addEventListener('click', () => {
  //  map.flyTo([61.8021, 34.3296], 8);
  //});
   
  function SayPoint(itrkwpt)
  {
    console.log('itrkwpt='+itrkwpt);
  }
}

// ************************************************************* Leafgpx.js ***
