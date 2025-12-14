// JS/HTML5, EDGE/CHROME/YANDEX                                *** State.js ***

// ****************************************************************************
// * KwinFlat          Оттрассировать обращения контроллеров к странице State *
// ****************************************************************************

// v1.0.1, 14.12.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 12.12.2025

//console.log('State.js');

// Запускаем вызов четвертьсекундной (250 мсек) трассировки
const IntTraceState = setInterval(function(){TraceState()},1250);

// ****************************************************************************
// *                   -----Получить последнее json-сообщение на State             *
// ****************************************************************************
function TraceState()
{
  console.log('TraceState');
  // Выводим в диалог предварительный результат выполнения запроса
  htmlText="Выбрать json-сообщение на State не удалось!";
  // Выполняем запрос
  pathphp="../j_getLastStateMess.php";
  // Делаем запрос последнего json-сообщения на State 
  $.ajax({
    url: pathphp,
    type: 'POST',
    data: {pathTools:pathPhpTools,pathPrown:pathPhpPrown,sh:SiteHost},
    // Выводим ошибки при выполнении запроса в PHP-сценарии
    error: function (jqXHR,exception) {/*DialogWind(SmarttodoError(jqXHR,exception))*/},
    // Обрабатываем ответное сообщение
    success: function(message)
    {
      // Трассируем полный json-ответ
      console.log(message);
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
        // console.log(messa)
        
        // Строим try catch, чтобы поймать ошибку в JSON-ответе
        try 
        {
          parm=JSON.parse(messa);
          // Если ошибка SQL-запроса
          if (parm.cycle<0) 
          {
            if (parm.cycle==-1) 
              DialogWind(
              "Пересоздана таблица базы данных State.<br>"+
              "Сообщений от контроллера ещё не поступало!<br>"+
              "Можно проверить виртуальный контроллер.");
            else
              DialogWind(parm.cycle+': '+parm.sjson);
          }
          // Выводим результаты выполнения (параметры ответа)
          // (отрабатываем распарсенный ответ)
          else
          {
            // Трассируем чистое сообщение, без метки
            // {"myTime":1736962888,"myDate":"25-01-15 08:41:28","cycle":195, "sjson":{"led33":[{"status":"inLOW"}]}}
            // DialogWind(messa);
            ctrl=parm.ctrl;
            $('#ctrl').html("ctrl: "+ctrl.toString());
            num=parm.num;
            $('#num').html("num: "+num.toString());
            cycle=parm.cycle;
            $('#cycle').html("cycle: "+cycle.toString());
            sjson=parm.sjson;
            $('#sjson').html ("sjson: "+JSON.stringify(sjson));
            let myTime=parm.myTime;
            $('#myTime').html("myTime: "+myTime.toString());
            let myDate=parm.myDate;
            $('#myDate').html("myDate: "+myDate);
            / *    
            // Парсим и обрабатываем sjson
            if ((JSON.stringify(sjson)==s33_LOW)||(JSON.stringify(sjson)==s33_HIGH))
            {
              parm=JSON.parse(JSON.stringify(sjson));
              // Выделяем json-подстроку по led33
              let led33=parm.led33[0];
              // Парсим led33
              parm=JSON.parse(JSON.stringify(led33));
              // Выделяем состояние led33 (горит - не горит)
              let status=parm.status;
              // Высвечиваем led33 в соответствии с состоянием
              //$('#status').html(status);
              //if (status=="inHIGH") $('#spot').css('background','SandyBrown');
              //else $('#spot').css('background','LightCyan');
            }
            else if (JSON.stringify(sjson)==s33_MODE0)
            {
              console.log('s33_MODE0: '+s33_MODE0);
              //ram.set("LmpMode",0);  // 0 - выключен режим 
            }
            else
            {
              console.log('sjson: '+JSON.stringify(sjson));
            }
            * /
            //alert(JSON.stringify(sjson));
          }
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

// ************************************************************ Update40.js ***
