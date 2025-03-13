// JS/HTML5, EDGE/CHROME/YANDEX                           *** Controller.js ***

// ****************************************************************************
// * KwinFlat                     Иммитировать некоторые действия контроллера *
// *                                                           из окна jquiry *
// ****************************************************************************

// v1.0.0, 01.02.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 01.02.2025

$(document).ready(function() 
{
  // **************************************************************************
  // *                    Подготовить работу контроллера                      *
  // **************************************************************************
  console.log("Controller");    
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
});
// ****************************************************************************
// *               Вызвать jquery-окно для иммитации контроллера              *
// ****************************************************************************
var intervalTest1;    // id функции передачи сообщения о смене состояния led33
function ControllerClick()
{ 
  // По текущему состоянию режима окрашиваем фон элементов управления Led33 
  // и текст на них 
  console.log("ControllerClick");               
  $('#dial').dialog({
    autoOpen: true,
    beforeClose: function(event,ui) 
    {
      // Останавливаем передачу сообщения о смене состояния led33
      clearInterval(intervalTest1);
      // Блокируем отправку изображений
      Lock3();
    },
  	width: 1000,
  });
}
// ****************************************************************************
// *            Передавать сообщения о смене состояния led33 через 1 сек.     *
// ****************************************************************************
function SendRequest(url)
{ 
   const Http = new XMLHttpRequest();
   Http.open("GET",url);
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
   let modeTest1=true;
   intervalTest1=setInterval(function() 
   {
      // console.log("Test1"); 
      // Поочередно посылаем сообщение, зажигая или гася лампочку 
      if (modeTest1)
      {
         SendRequest('http://localhost:100/State/?cycle=195&sjson={"led33":[{"status":"inHIGH"}]}');
         modeTest1=false;
      }
      else
      {
         SendRequest('http://localhost:100/State/?cycle=195&sjson={"led33":[{"status":"inLOW"}]}');
         modeTest1=true;
      }
   }
   ,1000)
}
// ****************************************************************************
// *               Test2            *
// ****************************************************************************
function Test2()
{ 
   // По текущему состоянию режима окрашиваем фон элементов управления Led33 
   // и текст на них 
   console.log("Test2");               
}
// ****************************************************************************
// *              Обновить счетчик тиков для отправки изображений             *
// *         в базу данных с частотой 4 изображения в секунду, так как        *
// *  в Update.js запускается вызов ежесекундного (250 мкс) обновления экрана *
// ****************************************************************************
// Выполняем начальную блокировку отправки контрольных изображений
var CtrlImg=false;  
// Запускаем отправку изображений             
function Test3()
{ 
  console.log("Запускаем отправку контрольных изображений");
  CtrlImg=true; 
}
// Блокируем отправку изображений
function Lock3()
{ 
  CtrlImg=false; 
}
// Отправляем изображения
function UpdateCalcImg()
{
  if (CtrlImg) getFileForStream();
}
// ****************************************************************************
// * Отправить Base64-изображение на страницу Stream для загрузки в базу данных            
// ****************************************************************************
var nTime=0; var nTimeOld=0; var nFrame=0; var today = new Date();

function sendImage(ImgOnStream)
{
  // Настраиваем параметры фрэйма
  today = new Date();
  nTime=Math.floor(today.getTime()/1000); // время с начала эпохи
  //console.log("nTime: "+nTime);
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
  pathphp="Stream/index.php";
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
// Выбираем изображение
function getFileForStream() 
{
  var req = new XMLHttpRequest();
  // асинхронный запрос
  req.open("GET","Controller/multipartDigits.php?r="+Math.random(), true);
  req.onload = function(event) 
  {
    var result = event.target.responseText;
    //console.log('Запрос загружен: '+result);
    user = JSON.parse(result);
    let num=user.img[0];
    let src=user.img[1];
    //console.log('num = '+num);
    //console.log('src = '+src);
    // 
    sendImage(src);
  }
  req.onreadystatechange = function() 
  {
    //console.log('Состояние изменилось!');
  }
  req.send(null);
  // console.log('Всем привет!');
}


// ********************************************************** Controller.js ***
