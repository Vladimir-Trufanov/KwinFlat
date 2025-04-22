// JS/HTML5, EDGE/CHROME/YANDEX                           *** Controller.js ***

// ****************************************************************************
// * KwinFlat                     Иммитировать некоторые действия контроллера *
// *                                                           из окна jquiry *
// ****************************************************************************

// v2.0.4, 19.04.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 01.02.2025

// Готовим переменные обслуживания
// подачи изображений от виртуального контроллера в базу данных
var taskintr;       // текущий интервал подачи изображений
var intervalSrc;    // id функции управления частотой подачи изображений
var intervalTest1;  // id функции передачи сообщения о смене состояния led4

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
  // Выполняем начальное блокирование отправки изображений
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
      clearInterval(intervalTest1);
      // Останавливаем отправку изображений
      Lock3();
      clearInterval(intervalSrc);
    },
  	width: 1000,
  });
}
// ****************************************************************************
// *            Передавать сообщения о смене состояния led4 через 1 сек.     *
// ****************************************************************************
function SendRequest(url)
{ 
  const Http = new XMLHttpRequest();
  Http.open("GET",url);
  // Определяем обработку ответа на запрос по выборке изображения 
  Http.onload = function(event) 
  {
    var result = event.target.responseText;
    //console.log(result); 
  }
  Http.send();
  /*
  Http.onreadystatechange = (e) => 
  {
    console.log(Http.responseText); 
  }
  */
}
function Test1()
{
  console.log("Test1()");               
  let modeTest1=true;
  intervalTest1=setInterval(function() 
  {
    // console.log("Test1"); 
    // Поочередно посылаем сообщение, зажигая или гася лампочку 
    if (modeTest1)
    {
      SendRequest('http://localhost:100/State40/?cycle=1195&sjson={"led4":[{"status":"shimHIGH"}]}');
      modeTest1=false;
    }
    else
    {
      SendRequest('http://localhost:100/State40/?cycle=1195&sjson={"led4":[{"status":"shimLOW"}]}');
      modeTest1=true;
    }
  }
  ,3000)
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
// Блокировать отправку изображений
function Lock3()
{ 
  CtrlImg=false; 
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
