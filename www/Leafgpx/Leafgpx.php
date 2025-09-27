<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                           *** Leafgpx.php ***

// ****************************************************************************
// *                        Подключить OSM или Яндекс карту                   *
// ****************************************************************************

// v1.0.6, 27.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 13.09.2025

define ("tve",    "tve"); 
define ("guest",  "гость"); 
define ("nearby", "близкие"); 
define ("permit", tve); 

// Определяем начальную точку центрирования карты
// - при загрузке gpx карта разместится по путевым точкам;
// - при трассировке трека, карта центрируется при поступлении первой точки трека
$lat=61.8021; $lon=34.3296; $zoom=10;         // Центр в Петрозаводске
//$lat=61.783270; $lon=33.808963;  $zoom=10;  // Центр в Матросах
//$lat=61.846308; $lon=33.206584; $zoom=10;   // Центр в Эссойле

// Определяем контекст нужной страницы
$gpx=prown\getComRequest('gpx');
$idctrl=prown\getComRequest('ctrl');
// Назначаем идентификатор контроллера и имя gpx-файла
if ($idctrl==NULL) 
{
  if ($gpx==NULL) echo 'Не выбран идентификатор контроллера для gpx-файла<br>'; 
  else 
  {
    $gpxfile=$urlHome.'/gpx/track'.$gpx.'.gpx';
    $idctrl=$gpx;
    // Проверяем существование gpx-файла
    if ($gpxfile=='') {} 
    else
    {
      if (!UR_exists($gpxfile)) echo 'GPX-файл для контроллера '.$idctrl.' отсутствует<br>';
    }
  }
}
else
{
  $gpx='NULL'; 
  $gpxfile='';
}
// Трассируем переданные параметры
//echo '$idctrl='.$idctrl.'<br>';
//echo '$gpx='.$gpx.'<br>'; 
//echo '$gpxfile='.$gpxfile.'<br>'; 

// Строим Яндекс и OSM карты 
if (permit==tve) MakeMapTVE($zoom,$lat,$lon,$idctrl,$gpxfile); 
// Строим только OSM карту 
else MakeMapOther($zoom,$lat,$lon,$idctrl,$gpxfile); 


// ****************************************************************************
// *                    Проверить существование файла по URL                  *
// ****************************************************************************
function UR_exists($url)
//https://stackoverflow.com/questions/7684771/how-to-check-if-a-file-exists-from-a-url
{
   $headers=get_headers($url);
   return stripos($headers[0],"200 OK")?true:false;
}

// ****************************************************************************
// *        Построить Яндекс и OSM-карты с возможностью переключения          *
// *   с центром в текущей точке геолокации (если геолокация разрешена) или   *
// *                            в заданной точке                              *
// ****************************************************************************
function MakeMapTVE($nzoom,$nlat,$nlon,$idctrl,$gpxfile) 
{
  echo "<script> var map, nlat=".$nlat.",nlon=".$nlon.",nzoom=".$nzoom.",gpxfile='".$gpxfile."',ctrl=".$idctrl."; </script>"; 
  ?>
  <script>
	  let center=[nlat,nlon];
	  map = L.map('map', 
    {
	    center:center,
	    zoom:nzoom,
	    zoomAnimation:true
    });
    map.attributionControl.setPosition('bottomleft').setPrefix('');
    let baseLayers = 
    {
	    'OSM':             L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
      {
	      attribution: '&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors'
      }).addTo(map),
      'Yandex map':      L.yandex(),           
      'Yandex satellite':L.yandex({type:'satellite'}),  // тип может быть указан опционально
      'Yandex hybrid':   L.yandex('hybrid')
    };

    let overlays = 
    {
      'Traffic':L.yandex('overlay').on('load',traffic)
    };

    L.control.layers(baseLayers,overlays,{collapsed:true}).addTo(map);
    let marker = L.marker(center, {draggable:false}).addTo(map);
    // Центрируем карту по локации
    if (gpxfile=='')
    {
 	    map.locate({setView:true, maxZoom:19}).on('locationfound',function (e) 
      {
		    marker.setLatLng(e.latlng);
      });
      // Выполняем трассировку трека
      МакеTrackMap(nlat,nlon,nzoom,ctrl,map);
    }
    // При необходимости определяем цвет трека и загружаем gpx-файл
    else
    {
      const options = 
      {
        async: true,
        polyline_options: {color:'red'},
      };
      const gpx = new L.GPX(gpxfile, options).on('loaded', (e) => {
        map.fitBounds(e.target.getBounds());
      }).addTo(map);
    }
  
	  function traffic() 
    {
		  // https://tech.yandex.ru/maps/jsbox/2.1/traffic_provider
		  let actualProvider = new ymaps.traffic.provider.Actual({}, { infoLayerShown: true });
		  actualProvider.setMap(this._yandex);
	  }
  </script>
  <?php
}

// ****************************************************************************
// *                             Построить OSM-карту                          *
// *   с центром в текущей точке геолокации (если геолокация разрешена) или   *
// *                              в заданной точке                            *
// ****************************************************************************
function MakeMapOther($nzoom,$nlat,$nlon,$idctrl,$gpxfile) 
{
  echo "<script> var map, nlat=".$nlat.",nlon=".$nlon.",nzoom=".$nzoom.",gpxfile='".$gpxfile."',ctrl=".$idctrl."; </script>"; 
  ?>
  <script>
  
  // Определяем параметры работы функции геолокации  
  const geooptions = 
  {
    enableHighAccuracy:true, // предоставлять более точные данные (вызываем увеличение энергопотребления)
    timeout:Infinity,        // ждать, пока не станет доступно местоположение
    maximumAge:0,            // возвращать данные о последнем местоположении
  };
  // Определяем местоположение и загружаем карту
  if (navigator.geolocation) 
  {
     navigator.geolocation.getCurrentPosition(
     function (position) 
     {
       var nlatin = position.coords.latitude;
       var nlonin = position.coords.longitude;
       var accuracy = position.coords.accuracy; // Погрешность в метрах
       MakeMap(nlatin,nlonin,nzoom); 
     }, 
     function () 
     {
       alert("Не удалось получить ваше местоположение.");
       MakeMap(nlat,nlon,nzoom); 
     },
     geooptions);
  } 
  else 
  {
     alert("Ваш браузер не поддерживает геолокацию.");
     MakeMap(nlat,nlon,nzoom) 
  }
  // Построить OSM-карту с маркером в центре
  function MakeMap(nlat,nlon,nzoom,accuracy) 
  {
    // Готовим пространство под карту с центром и зумом
	  var center=[nlat,nlon];
	  map = L.map('map', 
    {
		  center:center,
		  zoom:nzoom,
		  zoomAnimation:true
	  });
    // Загружаем OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
    {
      attribution: ' © OpenStreetMap contributors',
      maxZoom: 19,
      minZoom: 2,
      tileSize: 512,
      zoomOffset: -1
    }).addTo(map);
    // Готовим маркер 'флаг трека'
    var DirFlagIconOptions = 
    {
      iconUrl: '../gpx/js/images/DirFlag47x47.png',
      iconSize: [47,47]
    }
    var DirFlagIcon = L.icon(DirFlagIconOptions);
    var DirFlagMarkerOptions = 
    {
      title: 'Мы здесь',
      clickable: false,
      draggable: false,
      icon: DirFlagIcon
    }
    // Устанавливаем и подписываем маркер
    var DirFlagMarker = L.marker(center,DirFlagMarkerOptions);
    DirFlagMarker.addTo(map);
    // При необходимости определяем цвет трека и загружаем gpx-файл
    if (gpxfile!='')
    {
      const options = 
      {
        async: true,
        polyline_options: {color:'red'},
      };
      const gpx = new L.GPX(gpxfile, options).on('loaded', (e) => {
        map.fitBounds(e.target.getBounds());
      }).addTo(map);
    }
    // Иначе выполняем трассировку трека
    else
    {
      
      // Перемещаем и масштабируем карту (по умолчанию в Эссойлу)
      //map.flyTo([61.846308, 33.206584], 10);

      МакеTrackMap(nlat,nlon,nzoom,ctrl,map);
    }   
  }
  </script>
  <?php
}

?> <!-- --> <?php // ****************************************** Leafgpx.php ***