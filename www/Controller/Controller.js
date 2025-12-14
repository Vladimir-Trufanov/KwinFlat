// JS/HTML5, EDGE/CHROME/YANDEX                           *** Controller.js ***

// ****************************************************************************
// * KwinFlat                     Иммитировать некоторые действия контроллера *
// *                                                           из окна jquiry *
// ****************************************************************************

// v2.0.7, 20.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 01.02.2025

// Готовим переменные обслуживания
// подачи изображений от виртуального контроллера в базу данных
var taskintr;               // текущий интервал подачи изображений
var intervalSrc;            // id функции управления частотой подачи изображений
var intervalGpx;            // id функции передачи координаты туристических точек
var tGpx=performance.now(); // таймер фактических интервалов передачи координат туристических точек

$(document).ready(function() 
{

  // **************************************************************************
  // *                    Подготовить работу контроллера                      *
  // **************************************************************************
  $('#tabContainer').tabs({
    beforeActivate : function(evt) 
    {
     location.hash=$(evt.currentTarget).attr('href');
    },
		show: 'fadeIn',
    hide: 'fadeOut'
  });
  var hash = location.hash; 
	if (hash) 
  { 
		$('#tabContainer').tabs("load", hash);
	} 
  // Выполняем начальное блокирование отправки изображений и
  // передачи координат туристических точек
  LockGpx();
  Lock3();
});
// ****************************************************************************
// *               Вызвать jquery-окно для иммитации контроллера              *
// ****************************************************************************
function ControllerClick()
{ 
  // По текущему состоянию режима окрашиваем фон элементов управления Led4 
  // и текст на них 
  // console.log("ControllerClick");               
  $('#dial').dialog({
    autoOpen: true,
    beforeClose: function(event,ui) 
    {
      // Останавливаем передачу сообщения о смене состояния led4
      LockGpx();
      clearInterval(intervalGpx);
      // Останавливаем отправку изображений
      Lock3();
      clearInterval(intervalSrc);
    },
  	width: 1000,
  });
}
// ****************************************************************************
// *                        Передавать сообщения по URL                       *
// ****************************************************************************
function SendRequestState(url)
{ 
  // Создаём новый XMLHttpRequest-объект
  const Http = new XMLHttpRequest();
  // Настраиваем GET-запрос по URL
  Http.open("GET",url);
  // Отсылаем запрос
  Http.send();
  // Отрабатываем этот код после того, как получим ответ сервера
  Http.onload = function() 
  {
    let status=Http.status;
    let response=Http.response;
    if (status === 200) 
    {
      // При необходимости трассируем ответ страницы State
      console.log('response'); 
      console.log(response); 
      /*
      let lStateJson=isStateJson(response);
      if (!lStateJson)
      {
        console.error("Неправильный ответ, ошибка в коде станицы State:"); 
        console.error(response); 
      }
      */
    } 
    else 
    { 
      if (status === 404)
      {
        console.error("Ошибка загрузки данных 404 - страница не найдена:"); 
      } 
      else
      { 
        console.error("Ошибка загрузки данных: "+status+":"); 
      } 
      console.error(response); 
    }
  };
  // Выводим ошибку, когда запрос совсем не получилось выполнить
  Http.onerror = function() 
  { 
    console.error('Ошибка, запрос совсем не получилось выполнить');
  };
}
// Убедиться, что State принял json-сообщение           
function isStateJson(responseText)
{
  let lStateJson=true;
  let len=responseText.length;
  let bindex = responseText.indexOf("<State>");
  if (bindex<0) lStateJson=false
  else
  {
    let еindex = responseText.indexOf("</State>");
    if (еindex<0) lStateJson=false
  }
  return lStateJson;
}

// ****************************************************************************
// *            Передавать координаты путевых точек через 1 сек               *
// ****************************************************************************
var nCycle=0, nLat=0, nLon=0;  
var Ctrlwpt=false;  

var itrk;    // счетчик цикла
var latlngs; // линия с координатами предыдущей точки и текущей
var latold;  // широта предыдущей точки
var lonold;  // долгота предыдущей точки
var latcur;  // широта текущей точки
var loncur;  // долгота текущей точки
var ccolor;  // цвет линии

// Блокировать передачу координат
function LockGpx()
{ 
  Ctrlwpt=false; 
}
// Передавать координаты путевых точек через 1 сек 
function TestGpx()
{
  //console.log("TestGpx()");               
  clearInterval(intervalGpx);
  Ctrlwpt=true; 
  // Определяем начальные координаты точки и счетчик точек трека
  latcur=61.846308;
  loncur=33.206584;
  // Инициируем индикатор позиций выделения алгоритма формирования точек трека  
  itrk=-5;
  // Запускаем вычерчивание полилинии
  intervalGpx=setInterval(function() 
  {
    // Выводим фактический интервал и обновляем начальное значение
    tGpx=IntEvent('Интервал до передачи точки трека:',tGpx,1,false) 
    // Если разрешено, отрабатываем генерацию точки
    if (Ctrlwpt) 
    {
      nCycle++;
      // Для "шума" добавляем каждое третье сообщение о DHT11 из 20
      let remainder = nCycle % 20;
      if (remainder==3)
      {
        let humi=46; let tempC=248;
        SendRequestState(urlHome+'/State/?cycle='+nCycle+'&num=3&ctrl=204&sjson={"dht11":{"humi":'+humi+',"tempC":'+tempC+'}}');
      }
      // Все остальные интерваля генерируем и отправляем тоску отрезка полилинии
      else
      {
        itrk++;
        // Переносим координаты текущей точки в предыдущую
        latold=latcur;
        lonold=loncur;
        // Генерируем новую точку
        GenTrkpt(itrk);
        //console.log('latcur='+latcur,'loncur='+loncur); 
        // 'Отправляем координаты на сайт' - это на будущее подключение
        var nLat=Math.round(latcur*1000000);
        var nLon=Math.round(loncur*1000000);
        //console.log('nLat='+nLat,'nLon='+nLon);
        //console.log     (urlHome+'/State/?cycle='+nCycle+'&num=5&ctrl=204&sjson={"trkpt":{"lat":'+nLat+',"lon":'+nLon+',"color":"'+ccolor+'"}}'); 
        SendRequestState(urlHome+'/State/?cycle='+nCycle+'&num=5&ctrl=204&sjson={"trkpt":{"lat":'+nLat+',"lon":'+nLon+',"color":"'+ccolor+'"}}');
      }
    }
  }
  ,1000)
}
// ****************************************************************************
// *           Сгенерировать точки трека для демонстрации трассировки         *
// ****************************************************************************
function GenTrkpt(itrk)
{
  // console.log('itrk='+itrk); 

  let delta=0.03000;
  let latdelta=0.01;
  let londelta=0.02;
  ccolor='red';

  // Генерируем начальную точку
  // 'Эссойла, ул.Школьная, 3'
  if (itrk==-4) 
  {
    latcur=61.846308;
    loncur=33.206584;
  }
  // Генерируем вторую точку первой линии треугольника
  // 'СНТ Геолог, 98'
  else if (itrk==-3) 
  {
    latcur=61.934839;
    loncur=33.655948;
  }
  // Для второй линии треугольника
  // 'Новые пески, ул.Центральная, 13'
  else if (itrk==-2) 
  {
    latcur=61.833141;
    loncur=32.929247;
  }
  // Для третьей линии треугольника
  else if (itrk==-1) 
  {
    latcur=61.846308;
    loncur=33.206584;
  }
  // Для начального отрезка
  else if (itrk==0) 
  {
    latcur=61.856308;
    loncur=33.216584;
    ccolor='white';
  }
  else if (itrk<25)
  {
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
  // Вычерчиваем бесконечную спираль
  else
  {
    ccolor='blue';
    inew=itrk-26;
    // Определяем длину линии по номеру "витка спирали"
    lonVitoc=(Math.floor(inew/4)+1)*londelta;
    latVitoc=(Math.floor(inew/4)+1)*latdelta;
    // Определяем шаг в витке спирали
    nStep=(inew % 4);
    // Выводим шаги витков спирали
    //console.log('itrk='+itrk,'latVitoc='+latVitoc,'lonVitoc='+lonVitoc,'nStep='+nStep); 
    if (nStep==0)
    {
      loncur=loncur-lonVitoc;
      latcur=latcur-latVitoc;
    }
    else if (nStep==1)
    {
      loncur=loncur-lonVitoc;
      latcur=latcur+latVitoc;
    }
    else if (nStep==2)
    {
      loncur=loncur+lonVitoc+londelta;
      latcur=latcur+latVitoc;
    }
    else if (nStep==3)
    {
      loncur=loncur+lonVitoc;
      latcur=latcur-latVitoc;
    }
  }
}
// ****************************************************************************
// *               Test2            *
// ****************************************************************************
function Test2()
{ 
   // По текущему состоянию режима окрашиваем фон элементов управления Led4
   // и текст на них 
   console.log("Test2");               
}
// ****************************************************************************
// *           Подать изображение от виртуального контроллера                 *
// *                   через заданный интервал времени                        *
// * 24 кадра/сек (*60) => 1440 кадров/мин (*60) => 86400 кадров/час ~ 4Gb    *
// ****************************************************************************
// Выполнить начальную блокировку отправки контрольных изображений
var CtrlImg=false;  
// Блокировать отправку изображений
function Lock3()
{ 
  CtrlImg=false; 
}
// Запустить отправку изображений             
function Test3(mode)
{ 
  clearInterval(intervalSrc);
  ram.set("mode",mode);   
  // console.log("Запускаем отправку контрольных изображений ["+ram.get("mode")+"]");
  CtrlImg=true; 
  // Готовим подачу цифр 3 раза в секунду
  if (ram.get("mode")==1) taskintr=333;
  // Готовим подачу кадров бегущей девочки 12 раз в секунду
  else if (ram.get("mode")==2) taskintr=84;
  // Готовим подачу фото контроллера 2 раза в секунду
  else taskintr=500;
  // Запускаем функцию управления частотой подачи изображения
  intervalSrc = setInterval(
  function() 
  {
    // Подаём изображение от виртуального контроллера 
    // через заданный интервал времени
    MakeImgStream();
  }
  ,taskintr)
}
// Подать изображение от виртуального контроллера 
// через заданный интервал времени
function MakeImgStream()
{
  //console.log("MakeImgStream");
  if (CtrlImg) 
  {
    // console.log('MakeImgStream: '+ram.get("mode"));
    // Формируем асинхронный запрос с защитой от кэширования (т.е. подвешиваем
    // хвостик к запросу с помощью Math.random)
    var req = new XMLHttpRequest();
    req.open("GET","Controller/multipartDigits.php?mode="+ram.get("mode")+"&r="+Math.random(), true);
    // Определяем обработку ответа на запрос по выборке изображения 
    req.onload = function(event) 
    {
      var result = event.target.responseText;
      user = JSON.parse(result);
      let num=user.img[0];
      let src=user.img[1];
      sendImage(src);
    }
    req.onreadystatechange = function() 
    {
      //console.log('Состояние изменилось!');
    }
    // Отправляем запрос по выборку изображения для подачи в базу данных
    req.send(null);
  }
}
// ****************************************************************************
// * Отправить Base64-изображение на страницу Stream для загрузки в базу данных            
// ****************************************************************************
var nTime=0; var nTimeOld=0; var nFrame=0; var today = new Date();

function sendImage(ImgOnStream)
{
  // Настраиваем параметры фрэйма: время с начала эпохи и номер кадра в секунде
  today = new Date();
  nTime=Math.floor(today.getTime()/1000); // время с начала эпохи
  if (nTime==nTimeOld) 
  {
    nFrame=nFrame+1;
  }
  else
  {
    nTimeOld=nTime; nFrame=0;
  }
  // Выводим в диалог предварительный результат выполнения запроса
  htmlText="Отправить Base64-изображение на страницу Stream не удалось!";
  // Выполняем запрос
  pathphp="Stream40/index.php";
  // Делаем запрос на отправку изображения 
  $.ajax({
    url: pathphp,
    type: 'POST',
    data: {src:ImgOnStream,time:nTime,frame:nFrame},
    // Выводим ошибки при выполнении запроса в PHP-сценарии
    error: function (jqXHR,exception) {DialogWind(SmarttodoError(jqXHR,exception))},
    // Обрабатываем ответное сообщение
    success: function(message)
    {
      //console.log(message);
    }
  });
}

// ********************************************************** Controller.js ***
