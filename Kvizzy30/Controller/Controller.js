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
// *               Отправлять в базу данных 2 изображения в секунду           *
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
    }
  }
}

// ********************************************************** Controller.js ***
