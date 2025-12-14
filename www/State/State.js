// JS/HTML5, EDGE/CHROME/YANDEX                                *** State.js ***

// ****************************************************************************
// * KwinFlat          Оттрассировать обращения контроллеров к странице State *
// ****************************************************************************

// v1.0.1, 14.12.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 12.12.2025

//console.log('State.js');

// Инициируем счетчик вызовов трассировки
var iTrace=0;
// Инициируем прежнее обращение контроллеров
var oldMessa="*";
// Запускаем вызов трассировок через 1250 мсек
const IntTraceState = setInterval(function(){TraceState()},1250);

// ****************************************************************************
// *                Выбрать последнее json-сообщение на State                 *
// ****************************************************************************
function TraceState()
{
  console.log('TraceState');
  /*
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
    error: function (jqXHR,exception) {console.log('SmarttodoError(jqXHR,exception);');},
    // Обрабатываем ответное сообщение
    success: function(message)
    {
      // Трассируем полный json-ответ
      // console.log(message);
      // Вырезаем из запроса чистое сообщение
      let Fresh=FreshLabel(message);
      // Если чистое сообщение не вырезалось, считаем, что это ошибка и
      // диагностируем её
      if (Fresh=='NoFresh')
      {
        console.log(message);
      }
      // Иначе считаем, что ответ на запрос пришел и можно
      // парсить сообщение
      else 
      {
        messa=Fresh;
        //console.log(iTrace); 
        //console.log(messa);
        
        if (oldMessa!=messa)
        {        
          // Строим try catch, чтобы поймать ошибку в JSON-ответе
          try 
          {
            parm=JSON.parse(messa);
            // Если ошибка SQL-запроса
            if (parm.cycle<0) 
            {
              if (parm.cycle==-1) 
                console.log(
                "Пересоздана таблица базы данных State.<br>"+
                "Сообщений от контроллера ещё не поступало!<br>"+
                "Можно проверить виртуальный контроллер.");
              else
                console.log(parm.cycle+': '+parm.sjson);
            }
            // Выводим результаты выполнения (параметры ответа)
            // (отрабатываем распарсенный ответ)
            else
            {
              // Трассируем чистое сообщение, без метки
              // {"myTime":1736962888,"myDate":"25-01-15 08:41:28","cycle":195, "sjson":{"led33":[{"status":"inLOW"}]}}
              // console.log(messa);
              ctrl=parm.ctrl;         // console.log("ctrl:  "+ctrl.toString());
              num=parm.num;           // console.log("num:   "+num.toString());
              cycle=parm.cycle;       // console.log("cycle: "+cycle.toString());
              sjson=parm.sjson;       // console.log("sjson: "+JSON.stringify(sjson));
              let myTime=parm.myTime; // console.log("myTime: "+myTime.toString());
              let myDate=parm.myDate; // console.log("myDate: "+myDate);
                                      //console.log('sjson:  '+JSON.stringify(sjson));
              console.log(iTrace+' ['+ctrl.toString()+'] '+myDate+" "+JSON.stringify(sjson));
           }
          }
          // Обрабатываем ошибку в JSON-ответе 
          catch (err) 
          {
            console.log("Ошибка в JSON-ответе\n"+Error(err)+":\n"+messa);
          }
        }
        // Готовим выборку следующего, отличного от предыдущего, обращения контроллера
        iTrace++; oldMessa=messa;
      }
    }
  });
  */
}

// ************************************************************ Update40.js ***
