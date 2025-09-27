// JS/HTML5, EDGE/CHROME/YANDEX                              *** Leafgpx.js ***

// ****************************************************************************
// * KwinFlat/Leaflet             Вспомогательные функции для создания карт с *
// *                              Leaflet, отслеживания треков и загрузки GPX *
// ****************************************************************************

// v1.0.4, 27.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 17.09.2025

// ****************************************************************************
// *                               Загрузить gpx-файл                         *
// ****************************************************************************
function LoadGpx(map)
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
// ****************************************************************************
// *       Создать карту с Leaflet для отслеживания треков и загрузки GPX     *
// ****************************************************************************
function МакеTrackMap(nlat,nlong,nzoom,idctrl,map)   
{

  // Перемещаем и масштабируем карту (по умолчанию в Эссойлу)
  // map.flyTo([61.846308, 33.206584], 10);

  // Создаём объект для работы с localStorage
  ramTrack = new TStorage; 
  //console.log('nlat='+nlat);
  //console.log('nlong='+nlong);
  //console.log('nzoom='+nzoom);
  //console.log('idctrl='+idctrl);
  // 
  var tfirst = new Date();
  timerBeg.textContent = `${fulldec(tfirst.getHours())}:${fulldec(tfirst.getMinutes())}:${fulldec(tfirst.getSeconds())}`;
  // Запускаем трассировку поступающих координат
  var itrkwpt=0;
  intervalTrkWpt=setInterval(function() 
  {
    itrkwpt++;
    ViewTrackNumCtrl(itrkwpt,ramTrack,idctrl);
  }
  ,998)
  
  // **************************************************************************
  // *                 Дополнить однозначные числа ноликом слева              *
  // **************************************************************************
  function fulldec(val)
  {
    if (val<10) return '0'+val
    else return val;
  }

  // **************************************************************************
  // *  Выбрать последнее сообщение заданного типа от указанного контроллера  *
  // *                                 и показать трек                        *
  // **************************************************************************
  function ViewTrackNumCtrl(itrkwpt,ramTrack,idctrl)
  {
    var now = new Date();
    timerEnd.textContent = `${fulldec(now.getHours())}:${fulldec(now.getMinutes())}:${fulldec(now.getSeconds())}`;
    var tdelta=now-tfirst;
    $('#delta').html(Math.round(tdelta/1000)); 
     
    // Выводим в диалог предварительный результат выполнения запроса
    htmlText="Выбрать сообщение заданного типа от контроллера не удалось!";
    // Выполняем запрос
    pathphp="../j_getLastNumCtrl.php";

    //console.log('itrkwpt='+itrkwpt);
    
    // Делаем запрос последнего сообщения по треку от контроллера
    $.ajax({
      url: pathphp,
      type: 'POST',
      data: {pathTools:pathPhpTools,pathPrown:pathPhpPrown,sh:SiteHost,ctrl:idctrl,nnum:5},
      // Выводим ошибки при выполнении запроса в PHP-сценарии
      error: function (jqXHR,exception) {console.log(SmarttodoError(jqXHR,exception))/*DialogWind(SmarttodoError(jqXHR,exception))*/},
      // Обрабатываем ответное сообщение
      success: function(message)
      {
        // Трассируем полный json-ответ
        // DialogWind(message);
        // console.log(message)
        // Вырезаем из запроса чистое сообщение
        let Fresh=FreshLabel(message);
        // Если чистое сообщение не вырезалось, считаем, что это ошибка и
        // диагностируем её
        if (Fresh=='NoFresh')
        {
          console.log(message);
          //DialogWind(message);
        }
        // Иначе считаем, что ответ на запрос пришел и можно
        // парсить сообщение
        else 
        {
          messa=Fresh;
          // DialogWind(messa);
          // console.log(messa)
          // Строим try catch, чтобы поймать ошибку в JSON-ответе
          try 
          {
            // Обрабатываем чистое сообщение, без метки
            // {"myTime":1758128845,"myDate":"25-09-17 08:07:25","sjson":{"trkpt":{"lat":52518694,"lon":13376194}}}
            parm=JSON.parse(messa);
            let sjson=parm.sjson;
            let myTime=parm.myTime;
            let myDate=parm.myDate;
            //console.log(myTime);
            //console.log(myDate);
            //console.log(sjson);
            // Если ошибки SQL-запроса
            if (parm.sjson=='-1') 
            {
              mess='Последней точки трека по контроллеру '+idctrl+' не обнаружено';
              console.log(mess);
              // DialogWind(mess);
            }
            else if (parm.sjson=='-2') 
            {
              mess='Возникло исключение запроса последней точки трека по контроллеру '+idctrl;
              console.log(mess);
              // DialogWind(mess);
            }
            // Выводим результаты выполнения (параметры ответа)
            // (отрабатываем распарсенный ответ)
            else
            {
              //console.log(sjson);
              parm=JSON.parse(JSON.stringify(sjson));
              let trkpt=parm.trkpt;
              //console.log(trkpt);
              parm=JSON.parse(JSON.stringify(trkpt));
            
              // Выбираем прежние значения широты и долготы
              var latold=ramTrack.get("latold",0);
              var lonold=ramTrack.get("lonold",0);
              // Выбираем текущие значения широты и долготы и цвет отрезка
              var latcur=parm.lat/1000000;
              var loncur=parm.lon/1000000;
              var ccolor=parm.color;
              // Выполняем трассирову трека
              //console.log('itrkwpt='+itrkwpt);
              //console.log('latold='+latold);
              //console.log('lonold='+lonold);
              //console.log('latcur='+latcur);
              //console.log('loncur='+loncur);
            
              latlngs = [[latold,lonold],[latcur,loncur]];
              polyline = L.polyline(latlngs,{color:ccolor});
              polyline.addTo(map);
            
              // Сохраняем измененные значения
              ramTrack.set("latold",latcur);   
              ramTrack.set("lonold",loncur);  
            }
          }
          // Обрабатываем ошибку в JSON-ответе 
          catch (err) 
          {
            console.log("Ошибка в JSON-ответе\n"+Error(err)+":\n"+messa);
            //DialogWind("Ошибка в JSON-ответе<br>"+Error(err)+":<br>"+messa);
          }
        }
      }
    });
  }
}

// ************************************************************* Leafgpx.js ***
