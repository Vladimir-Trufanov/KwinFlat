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
// *              в базу данных с частотой 2 изображения в секунду            *
// ****************************************************************************
var CalcImg=0; CalcImgOld=0;
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
  if (CtrlImg) 
  {
    CalcImg++;
    if (CalcImg-CalcImgOld>1)
    {
      console.log("CalcImg: "+CalcImg);
      CalcImgOld=CalcImg;
      // Запускаем выборку и отправку изображения
      getFileForStream();
      //sendImage();
    }
  }
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
  console.log("nTime: "+nTime);
  if (nTime==nTimeOld) 
  {
    nFrame=nFrame+1;
  }
  else
  {
    nTimeOld=nTime; nFrame=0;
  }
  // Выбираем изображение
  //let ImgOnStream=getFileForStream();
  
  
  //let ImgOnStream=btoa("StreamByStream");
  //console.log(atob(ImgOnStream));
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
      // Трассируем полный json-ответ
      console.log(message);
      //DialogWind(message);
      /*   
      // Вырезаем из запроса чистое сообщение
      let Fresh=FreshLabel(message);
      // Если чистое сообщение не вырезалось, считаем, что это ошибка и
      // диагностируем её
      if (Fresh=='NoFresh')
      {
        console.log(message);
        DialogWind(message);
      }
      // Иначе считаем, что ответ на запрос пришел и можно
      // парсить сообщение
      else 
      {
        messa=Fresh;
        // DialogWind(messa);
        // Строим try catch, чтобы поймать ошибку в JSON-ответе
        try 
        {
          parm=JSON.parse(messa);
          // Если ошибка SQL-запроса (SelectLed33)
          if (parm.cycle<0) 
          {
            if (parm.cycle==-1) 
              DialogWind(
              'Создана таблица базы данных State.\n'+
              'Сообщений от контроллера ещё не поступало!');
            else
              DialogWind(parm.cycle+': '+parm.sjson);
          }
          // Выводим результаты выполнения (параметры ответа)
          // (отрабатываем распарсенный ответ)
          else
          {
            // Обновляем параметры хранилища
            // {"isEvent":0,"Mode":"1","SendTime":1737365180,"ReceivTime":1737365180,"sjson":{"led33":[{"regim":1}]}}
            ram.set("LmpEvent",      parm.isEvent);    // 1 - прошла команда смены режима, 0 - пришло подтверждение от контроллера
            ram.set("LmpMode",       parm.Mode);       // 1 - включен режим, 0 - выключен режим (состояние в момент запроса)
            ram.set("LmpSendTime",   parm.SendTime);   // время в секундах (c начала эпохи) отправки сообщения
            ram.set("LmpReceivTime", parm.ReceivTime); // время получения ответа в секундах
            // Парсим sjson
            let parmi=JSON.parse(JSON.stringify(parm.sjson));
            // Выделяем json-подстроку по led33
            let led33=parmi.led33[0];
            // Парсим led33
            parmi=JSON.parse(JSON.stringify(led33));
            ram.set("LmpRegim",parmi.regim); // указание по режиму в последней команде (1 - включить режим, 0 - выключить)
            / *
            console.log("LmpEvent =",     ram.get("LmpEvent"),':',     typeof ram.get("LmpEvent"));
            console.log("LmpMode =",      ram.get("LmpMode"),':',      typeof ram.get("LmpMode"));
            console.log("LmpSendTime =",  ram.get("LmpSendTime"),':',  typeof ram.get("LmpSendTime"));
            console.log("LmpReceivTime =",ram.get("LmpReceivTime"),':',typeof ram.get("LmpReceivTime"));
            console.log("LmpRegim =",     ram.get("LmpRegim"),':',     typeof ram.get("LmpRegim"));
            *
          }
          // Обновляем изображения управляющих элементов контрольного светодиода 
          // по данным хранилища      
          ViewLed33();
        }
        // Обрабатываем ошибку в JSON-ответе 
        catch (err) 
        {
          console.log("Ошибка в JSON-ответе\n"+Error(err)+":\n"+messa);
          DialogWind("Ошибка в JSON-ответе<br>"+Error(err)+":<br>"+messa);
        }
      }
      */
    }
  });
}
// Выбираем изображение
function getFileForStream()
{
  return runMultipartDigits();
}

function runMultipartDigits() 
{
  var req = new XMLHttpRequest();
  // асинхронный запрос
  req.open("GET","Controller/multipartDigits.php?r="+Math.random(), true);
  req.onload = function(event) 
  {
    console.log('Запрос загружен!');
    var result = event.target.responseText;
    user = JSON.parse(result);
    let num=user.img[0];
    let src=user.img[1];
    // 
    sendImage(src);
  }
  req.onreadystatechange = function() 
  {
    //console.log('Состояние изменилось!');
  }
  req.send(null);
  console.log('Всем привет!');
}


// ********************************************************** Controller.js ***
