/**
 * State.js v1.0.0, 2025.01.07
 * Copyright © 2025 tve; Licensed MIT 
**/

$(document).ready(function() 
{
   // Фиксируем начало запуска сайта
   var valTimeBeg = new Date();
   // Выбираем элемент отражения времени с начала сессии
   var timeElement = document.getElementById('currentTime');
   // Запускаем вызов ежесекундного (250 мкс) обновления экрана
   const intervalId = setInterval(
   function() 
   {
      // Выбираем элемент отражения времени с начала сессии
      // var timeElement = document.getElementById('currentTime');
      // Трассируем запуск обработки таймера
      // console.log('Я выполняюсь почти каждую секунду');
      // Делаем аякс-запрос с выборкой изменений показаний датчиков и
      // состояний устройств и контроллеров
      let StatusList=nobase;
      // Если аякс-запрос успешен, то обновляем данные на странице и
      // показываем новое время с начала сессии
      if (StatusList == nobase)
      {
         // Пересчитываем время с начала сессии
         NewSessionOld(valTimeBeg,timeElement);
         // Обновляем показания и состояния
         UpdateStatus();
      }
   }
   ,250)
  
   // Создаём поле демонстрации поступающих json-сообщений для 9 последних 
   let tickers = new TTickers(9);
   // Обеспечиваем остановку изменения массива состояний и изменение курсора 
   // при наезде на поле демонстрации поступающих json-сообщений
   var tickCursor=$("#tickers").css('cursor');
   //console.log("tickCursor=",tickCursor);
   $('#tickers').hover(
      function () 
      {
         tickers.noRender();
         $('#tickers').css('cursor','wait');      
      },
      function () 
      {
         tickers.yesRender();
         $('#tickers').css('cursor',this.tickCursor);      
      }
   );
   //
   tickers.render('Ghbdtn!');
   tickers.render('Ghb3dtn!');
   tickers.render('Ghb4dtn!');
   tickers.render('Ghb56dtn!');
   tickers.render('Ghb78dtn!');
   say(tickers);
   //
   let clock = new TClock({template: 'h:m:s'}, tickers);
   clock.start();
});
 
function onShlmp()
{
   console.log("onShlmp");
} 
function onShlight()
{
   console.log("onShlight");
} 
function onShnolight()
{
   console.log("onShnolight");
} 
function onShtime()
{
   console.log("onShtime");
} 

// ****************************************************************************
// *                     Показать новое время с начала сессии                 *
// ****************************************************************************
function NewSessionOld(valTimeBeg,timeElement)
{
  // Пересчитываем время с начала сессии
  let valTime = new Date();
  let valTimeEnd=new Date(valTime-valTimeBeg);
  // Выбираем пересчитанное время. Так как система подвешивает ко 
  // времени локальное смещение (Москва=3 часа), то в представлении
  // отрезаем часы 
  timeElement.textContent = valTimeEnd.toLocaleTimeString();
  timeElement.textContent = timeElement.textContent.slice(3); 
}

// ****************************************************************************
// *    Обновить на странице состояния датчиков, устройств и контроллеров     *
// ****************************************************************************
function UpdateStatus()
{
   getLastStateMess();
   $('#cycle').html(cycle);
   //$('#tickers').html(sjson);
}

// ****************************************************************************
// *                   Получить последнее json-сообщение на State             *
// ****************************************************************************
function getLastStateMess()
{
   // Выводим в диалог предварительный результат выполнения запроса
   htmlText="Выбрать json-сообщение на State не удалось!";
   // Выполняем запрос
   pathphp="getLastStateMess.php";
   // Делаем запрос на определение наименования раздела материалов
   $.ajax({
      url: pathphp,
      type: 'POST',
      data: {pathTools:pathPhpTools,pathPrown:pathPhpPrown,sh:SiteHost},
      // Выводим ошибки при выполнении запроса в PHP-сценарии
      error: function (jqXHR,exception) {DialogWind(SmarttodoError(jqXHR,exception))},
      // Обрабатываем ответное сообщение
      success: function(message)
      {
         DialogWind(message);
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
            // Строим try catch, чтобы поймать ошибку в JSON-ответе
            try 
            {
               parm=JSON.parse(messa);
               // Если ошибка SQL-запроса (SelectLed33)
               if (parm.cycle<0) 
               {
                  DialogWind(parm.cycle+': '+parm.sjson);
               }
               // Выводим результаты выполнения (параметры ответа)
               // (отрабатываем распарсенный ответ)
               else
               {
                  DialogWind(messa);
                  cycle=parm.cycle;
                  sjson=parm.sjson;
                  DialogWind(cycle);
                  DialogWind(sjson);
               }
            } 
            catch (err) 
            {
               console.log("Ошибка в JSON-ответе\n"+Error(err)+":\n"+messa);
               DialogWind("Ошибка в JSON-ответе<br>"+Error(err)+":<br>"+messa);
            }
         }
      }
   });
}

function DialogWind(htmlText)
{
   $('#DialogWind').html(htmlText);
   delayClose=100;
   $('#DialogWind').dialog
   ({
      width:600,
      hide:{effect:"explode",delay:delayClose,duration:1000,easing:'swing'},
      title: "Запрос json-сообщения на State",
   });
}


class TClock 
{
   constructor({ template },tickers) 
   {
      this.template = template;
      this.tickers = tickers;
   }

   render() 
   {
      let date = new Date();

      let hours = date.getHours();
      if (hours < 10) hours = '0' + hours;

      let mins = date.getMinutes();
      if (mins < 10) mins = '0' + mins;

      let secs = date.getSeconds();
      if (secs < 10) secs = '0' + secs;

      let output = this.template
        .replace('h', hours)
        .replace('m', mins)
        .replace('s', secs);
       
      //console.log(output);
      //$('#tick1').html(output);
      //tickers.render(output);
      this.tickers.render(output);
      //this.tickers.render(String(sjson);
   }

   stop() 
   {
      clearInterval(this.timer);
   }

   start() 
   {
      this.render();
      this.timer = setInterval(() => this.render(), 1000);
   }
}

class TTickers 
{
   constructor(count) 
   {
      this.count = count;
      this.ARRY = new Array();
      this.HTML = '';
      this.isRender='yes';
   }
   
   noRender()
   {
      this.isRender='no';
   }
   yesRender()
   {
      this.isRender='yes';
   }

   create()
   {
      for (let i=0; i<this.count; i++) 
      {
         this.ARRY[i]='--'+i+'--';
         if (i==0)
            this.HTML=this.HTML+
            '<div id="tick'+i+'" class="ticker" style="border:solid .1rem DarkGoldenRod">'+this.ARRY[i]+'</div>';
         else
            this.HTML=this.HTML+
            '<div id="tick'+i+'" class="ticker">'+this.ARRY[i]+'</div>';
      }
      //console.log(this.HTML);
      $('#tickers').html(this.HTML);
   }
   
   render(input) 
   {
      //console.log(this.ARRY.length);
      //console.log(this.count);
      if (this.ARRY.length<1) this.create();
      if (this.isRender=='yes')
      {
         for (let i=this.count-1; i>0; i--) this.ARRY[i]=this.ARRY[i-1]; 
         this.ARRY[0]=input;
         for (let i=0; i<this.count; i++) $('#tick'+i).html(this.ARRY[i]);
      }
   }
}

function say(tickers)
{
   //console.log('this.count');
   tickers.render('this.count');
}

/*
$(document).ready(function() 
{
   onProba();
});
 
function onProba()
{
   console.log("onProba");
   const params = new URLSearchParams(window.location.search);
   params.forEach((value, key) => 
   {
      console.log(key, value);  // Выводит ключи и соответствующие им значения каждого параметра
   });
} 
*/

