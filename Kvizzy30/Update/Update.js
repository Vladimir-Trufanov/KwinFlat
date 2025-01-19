// JS/HTML5, EDGE/CHROME/YANDEX                               *** Update.js ***

// ****************************************************************************
// * KwinFlat                 Обновить значения датчиков, состояния устройств *
// *                                         и контроллеров на странице сайта *
// ****************************************************************************

// v1.0.3, 17.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 05.10.2024

$(document).ready(function() 
{
   // Создаём поле демонстрации поступающих json-сообщений для 3 последних 
   let tickers = new TTickers(4);
   // Обеспечиваем остановку изменения массива состояний и изменение курсора 
   // при наезде на поле демонстрации поступающих json-сообщений
   // (другие события на странице не останавливаются)
   this.tickCursor=$("#tickers").css('cursor');
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
   // Фиксируем начало запуска сайта
   var valTimeBeg = new Date();
   // Выбираем элемент отражения времени с начала сессии
   var timeElement = document.getElementById('sessiontime');
   // Запускаем вызов ежесекундного (250 мкс) обновления экрана
   const intervalId = setInterval(
   function() 
   {
      // Пересчитываем время с начала сессии
      NewSessionOld(valTimeBeg,timeElement);
      // Обновляем показания и состояния
      UpdateStatus(tickers);
   }
   ,250)
   // Запускаем объект показа текущего времени
   let clock = new TClock({template: 'h:m:s'});
   clock.start();
});
// 
function onShlmp()
{
   console.log("onShlmp");
} 
// ****************************************************************************
// *      Сформировать тег для ввода числа с границами, 1 шаг ввода числа     *
// ****************************************************************************
var diez,bemol,value,min,max;
var bemol2,diez2,val2
function onLed33(diezi,bemoli,mini,maxi)
{
   diez=diezi; bemol=bemoli; min=mini; max=maxi;
   let valuex=$('#'+diez).text();
   $('#'+bemol).html('<input id="inpvalue" class="Inp" type="number" step="1" '+
      'min="'+min.toString()+'" max="'+max.toString()+'" value="'+valuex.toString()+'">'+
      '<button class="Btn" onclick="onbLed33()">Ok</button>');
   $('#'+bemol).css('background','white');
} 
// ****************************************************************************
// *    Принять число, проверить границы, записать в базу через аякс, 2 шаг   *
// ****************************************************************************
function onbLed33()
{
   //console.log(diez+'='+bemol);
   value=$('#inpvalue').val();
   // Контроллируем границы
   if (value<min) value=min
   else if (value>max) value=max;
   //console.log(value.toString());
   $('#'+bemol).html('<p id="'+diez+'" class="cp33">'+value.toString()+'</p>');
   $('#'+bemol).css('background','Silver');
   // Выполняем контроль процентов
   if ((bemol=='light')||(bemol=='nolight')) 
   {
      if (bemol=='light') bemol2='nolight'; else bemol2='light'; 
      if (diez=='pilight') diez2='pinolight'; else diez2='pilight';
      val2=100-value; 
      $('#'+bemol2).html('<p id="'+diez2+'" class="cp33">'+val2.toString()+'</p>');
   }
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
function UpdateStatus(tickers)
{
   getLastStateMess();
   tickers.render(JSON.stringify(sjson));
}
// ****************************************************************************
// *                   Получить последнее json-сообщение на State             *
// ****************************************************************************
function getLastStateMess()
{
   // Выводим в диалог предварительный результат выполнения запроса
   htmlText="Выбрать json-сообщение на State не удалось!";
   // Выполняем запрос
   pathphp="j_getLastStateMess.php";
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
         // Трассируем полный json-ответ
         //DialogWind(message);
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
                  // Трассируем чистое сообщение, без метки
                  // {"myTime":1736962888,"myDate":"25-01-15 08:41:28","cycle":195, "sjson":{"led33":[{"status":"inLOW"}]}}
                  // DialogWind(messa);
                  cycle=parm.cycle;
                  $('#cycle').html("cycle: "+cycle.toString());
                  sjson=parm.sjson;
                  $('#sjson').html ("sjson: "+JSON.stringify(sjson));
                  let myTime=parm.myTime;
                  $('#myTime').html("myTime: "+myTime.toString());
                  let myDate=parm.myDate;
                  $('#myDate').html("myDate: "+myDate);
                  // Парсим sjson
                  parm=JSON.parse(JSON.stringify(sjson));
                  // Выделяем json-подстроку по led33
                  let led33=parm.led33[0];
                  // Парсим led33
                  parm=JSON.parse(JSON.stringify(led33));
                  // Выделяем состояние led33 (горит - не горит)
                  let status=parm.status;
                  // Высвечиваем led33 в соответствии с состоянием
                  $('#status').html(status);
                  if (status=="inHIGH") $('#spot').css('background','SandyBrown');
                  else $('#spot').css('background','LightCyan');
               }
            }
            // Обрабатываем ошибку в JSON-ответе 
            catch (err) 
            {
               console.log("Ошибка в JSON-ответе\n"+Error(err)+":\n"+messa);
               DialogWind("Ошибка в JSON-ответе<br>"+Error(err)+":<br>"+messa);
            }
         }
      }
   });
}
// ****************************************************************************
// *                 Вывести диалоговое сообщение от ошибке                   *
// ****************************************************************************
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
// ****************************************************************************
// *                           Класс показа текущего времени                  *
// ****************************************************************************
class TClock 
{
   // Создать объект показа текущего времени
   constructor({template}) 
   {
      this.template = template;
   }
   // Обновить время на странице
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
      // Внести на страницу новое значение времени 
      $('#currentTime').html (output);
   }
   // Остановить отсчет времени
   stop() 
   {
      clearInterval(this.timer);
   }
   // Начать отсчет времени
   start() 
   {
      this.render();
      this.timer = setInterval(() => this.render(), 1000);
   }
}
// ****************************************************************************
// *  Класс трассировки последних поступивших json-сообщений от контроллера   *
// ****************************************************************************
class TTickers 
{
   // Создать объект трассировки
   constructor(count) 
   {
      this.count = count;        // количество ячеек трассировки сообщений
      this.ARRY = new Array();   // массив трассируемых сообщений
      this.HTML = '';            // выводимый html-текст
      this.isRender='yes';       // "разрешено движение сообщений в трассировке"
   }
   // Запретить движение сообщений в трассировке при наезде курсора на ячейки трассировки
   noRender()
   {
      this.isRender='no';
   }
   // Разрешитьо движение сообщений в трассировке при съезде курсора с ячеек трассировки
   yesRender()
   {
      this.isRender='yes';
   }
   // Создать ячейки трассировки и выполнить начальное заполнение ячеек
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
      $('#tickers').html(this.HTML);
   }
   // Принять очередное сообщение и обновить ячейки трассировки
   render(input) 
   {
      // Если ещё ячеек трассировки нет, создаем их
      if (this.ARRY.length<1) this.create();
      // Реагируем только на изменённый вход
      if (input != this.ARRY[0])
      {
         if (this.isRender=='yes')
         {
            for (let i=this.count-1; i>0; i--) this.ARRY[i]=this.ARRY[i-1]; 
            this.ARRY[0]=input;
            for (let i=0; i<this.count; i++) $('#tick'+i).html(this.ARRY[i]);
         }
      }
   }
}

// ************************************************************** Update.js ***
