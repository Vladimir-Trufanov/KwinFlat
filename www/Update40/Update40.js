// JS/HTML5, EDGE/CHROME/YANDEX                             *** Update40.js ***

// ****************************************************************************
// * KwinFlat                    Обслужить ознакомительную страницу для гостя *
// ****************************************************************************

// v4.0.1, 01.04.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 05.10.2024

$(document).ready(function() 
{


  /*
  console.log('SiteHost:  '+SiteHost);
  console.log('urlHome:   '+urlHome);
  console.log('IntStream: '+IntStream);
  */
  
  //$('#pptime').html('1234');
  //$('#ppframe').html('7');

  // Создаём объект для работы с localStorage
  ram = new TStorage; 
  // Выбираем последнее изображение 24 (или 1 раз за 1024 миллисекунды) раза в секунду
  // console.log('IntStream: '+IntStream);
  setInterval(SelImgStream, IntStream);

  /*
   // Защищаем от мелькания UpdateLmp33()
   $('.cled33').css('background','White');
   $('.cled33').css('color','White'); 
   // Создаём поле демонстрации поступающих json-сообщений для 4 последних 
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
   // Инициируем параметры хранилища при первом запуске в браузере:
   
   // Задаем событие по режиму (1 - прошла команда смены режима, 0 - пришло подтверждение от контроллера)
   if (ram.get("LmpEvent")==null)      ram.set("LmpEvent",0); 
   // Определяем состояние режима в момент запроса (1 - включен режим, 0 - выключен режим)     
   if (ram.get("LmpMode")==null)       ram.set("LmpMode",1);  
   // Определяем время в секундах (c начала эпохи) отправки сообщения     
   if (ram.get("LmpSendTime")==null)   ram.set("LmpSendTime",0); 
   // Определяем время получения ответа в секундах  
   if (ram.get("LmpReceivTime")==null) ram.set("LmpReceivTime",0);
   // Определяем указание по режиму в последней команде (1 - включить режим, 0 - выключить) 
   if (ram.get("LmpRegim")==null)      ram.set("LmpRegim",1);      
  */
   
  // Фиксируем начало запуска сайта
  var valTimeBeg = new Date();
  // Выбираем элемент отражения времени с начала сессии
  var timeElement = document.getElementById('sessiontime');
  // Запускаем вызов четвертьсекундного (250 мкс) обновления экрана
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
  //let clock = new TClock({template: 'h:m:s'});
  //clock.start();
  // Обновляем на странице состояния датчиков, устройств и контроллеров 
  UpdateStatus(tickers)
});

  // 

// ****************************************************************************
// *     Выбрать и показать последнее изображение с определённой частотой     *
// ****************************************************************************
  function SelImgStream()
  {
    // console.log('SelImgStream');
    // Выполняем запрос
    pathphp="Controller/j_SelImgStream.php";
    // Выбираем прежние значения времени кадра и его номера в секунде
    ram.get("oldtime",0);
    ram.get("oldframe",0);
    //console.log('pptime: '+ram.get("pptime",0));
    //console.log('ppframe: '+ram.get("ppframe",0));
    // Делаем запрос на отправку изображения 
    $.ajax({
      url: pathphp,
      type: 'POST',
      data: {sh:SiteHost,time:ram.get("oldtime"),frame:ram.get("oldframe")},
      // Выводим ошибки при выполнении запроса в PHP-сценарии
      error: function (jqXHR,exception) {DialogWind(SmarttodoError(jqXHR,exception))},
      // Обрабатываем ответное сообщение
      success: function(message)
      {
        //document.getElementById("img").src = "/Controller/imgDigits/png"+x+".png";
        //message="data:image/jpeg;base64,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";
        //document.getElementById("img").src = message;
        //console.log('src: '+message);

        // Строим try catch, чтобы поймать ошибку в JSON-ответе
        try 
        {
          parm=JSON.parse(message);
          //console.log('parm.time: ' +parm.time);
          //console.log('parm.frame: '+parm.frame);
          // Если JSON-сообщение разобрано, то обрабатываем параметры ответа
          // (отрабатываем распарсенный ответ)
          if (parm.fate==1) 
          {
            ram.set("oldtime",parm.time);   
            $('#oldtime').html(ram.get("oldtime"));
            ram.set("oldframe",parm.frame);   
            $('#oldframe').html(ram.get("oldframe"));
            document.getElementById("img").src = parm.src;
          }
          // Если последнее изображение не изменилось,
          // то и не меняем показываемое изображение
          else if (parm.fate==-4) 
          {
            //console.log(parm.src); 
            $('#oldtime').html(ram.get("oldtime"));
            $('#oldframe').html(ram.get("oldframe"));
          }          
          // Иначе показываем ошибку SQL-запроса SelImgStream
          else
          {
            console.log(parm.src);
            DialogWind(parm.src);
          }
        }
        // Обрабатываем ошибку в JSON-ответе 
        catch (err) 
        {
          DialogWind("Ошибка в JSON-ответе<br>"+Error(err)+":<br>"+message);
        }
      }
    });
  }

// ****************************************************************************
// *    Обновить на странице состояния датчиков, устройств и контроллеров     *
// ****************************************************************************
function UpdateStatus(tickers)
{
  //console.log("UpdateStatus");               
 
  // Выбираем последнее json-сообщение, пришедшее на State и
  // если оно отличается от предыдущего вывода, то показываем
  //getLastStateMess(tickers);
  // Обновляем параметры хранилища по показаниям режима работы 
  // контрольного светодиода в таблице Lead и
  // изображения управляющих элементов контрольного светодиода      
  //getRegimLed33();
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
/*
// ****************************************************************************
// *    Обновляем изображения управляющих элементов контрольного светодиода   *
// *                           по данным хранилища                            *
// ****************************************************************************
function ViewLed33()
{ 
   // По текущему состоянию режима окрашиваем фон элементов управления Led33 
   // и текст на них 
   //console.log("LmpMode",ram.get("LmpMode"));               
   
   if (ram.get("LmpMode")==1) 
   {
      $('.cled33').css('background','Silver');
      $('.cled33').css('color','Black'); 
   }
   else 
   {
      $('.cled33').css('background','FloralWhite');
      $('.cled33').css('color','LightSlateGray'); 
   }
   // Окрашиваем элемент управления режимом
   if (ram.get("LmpEvent")==1) $('#lmp').css('color','red');
   
}
// ****************************************************************************
// *                   Обновить параметры хранилища по показаниям             *
// *                     режима работы контрольного светодиода,               *
// *                   а также изображения управляющих элементов              *
// ****************************************************************************
function getRegimLed33()
{
   // Выводим в диалог предварительный результат выполнения запроса
   htmlText="Выбрать режим работы контрольного светодиода не удалось!";
   // Выполняем запрос
   pathphp="j_getRegimLed33.php";
   // Делаем запрос последнего json-сообщения на State 
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
         // DialogWind(message);
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
                  * /
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
      }
   });
}
// ****************************************************************************
// * Задать изменение режима работы контрольного светодиода в таблице Lead:   *
// ****************************************************************************
function setRegimLed33()
{
   // Action=3 - прошла команда смены режима, включить режим  
   // Action=2 - прошла команда смены режима, выключить режим 
   let Action; 
   // Выводим в диалог предварительный результат выполнения запроса
   htmlText="Задать изменение режима работы контрольного светодиода не удалось!";
   // Выбираем из хранилища текущее состояние режима работы
   let LmpMode=ram.get("LmpMode");
   if (LmpMode==1) Action=2; else Action=3;
   // Выполняем запрос
   pathphp="j_setRegimLed33.php";
   // Делаем запрос последнего json-сообщения на State 
   $.ajax({
      url: pathphp,
      type: 'POST',
      data: {pathTools:pathPhpTools,pathPrown:pathPhpPrown,sh:SiteHost,action:Action},
      // Выводим ошибки при выполнении запроса в PHP-сценарии
      error: function (jqXHR,exception) {DialogWind(SmarttodoError(jqXHR,exception))},
      // Обрабатываем ответное сообщение
      success: function(message)
      {
         // Трассируем полный json-ответ
         // DialogWind(message);
         // Вырезаем из запроса чистое сообщение
         let Fresh=FreshLabel(message);
         // Если чистое сообщение не вырезалось, считаем, что это ошибка и
         // диагностируем её
         if (Fresh=='NoFresh')
         {
            console.log(message);
            DialogWind(message);
         }
         // Иначе считаем, что ответ на запрос пришел и можно смотреть сообщение
         else 
         {
            messa=Fresh;
            // console.log(messa);
            if (messa!=nstOk) DialogWind(messa);
         }
      }
   });
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
// *                   Получить последнее json-сообщение на State             *
// ****************************************************************************
function getLastStateMess(tickers)
{
   // Выводим в диалог предварительный результат выполнения запроса
   htmlText="Выбрать json-сообщение на State не удалось!";
   // Выполняем запрос
   pathphp="j_getLastStateMess.php";
   // Делаем запрос последнего json-сообщения на State 
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
         // DialogWind(message);
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
                  tickers.render(JSON.stringify(sjson));
ÿ   Ḱ˱         }
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
*/
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
/*
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
*/
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
// ****************************************************************************
// *                  Класс работы с хранилищем localStorage                  *
// ****************************************************************************
class TStorage 
{
  // Создать параметры хранилища
  constructor(count) 
  {
    // на 2025-04-04 различаются в хранилище 2 типа переменных: string и number  
  }
  // Записать элемент в хранилище
  set(name,value)
  {
    let tof = typeof value; 
    if (tof === "string") localStorage.setItem(name,value);  
    else localStorage.setItem(name,value.toString());
    localStorage.setItem("tof"+name,tof);
  }
  // Выбрать элемент из хранилища
  get(name,invalue=null)
  {
    let value;
    let svalue = localStorage.getItem(name);
    // При отсутствии элемента в хранилище, возвращаем указанный результат
    if ((invalue!=null)&&(svalue==null)) value=invalue;
    // Иначе выбираем значение элемента из хранилища
    else
    {
      if (svalue==null) value=null
      else
      {
        let tof = localStorage.getItem("tof"+name);
        if (tof==="number") value=Number(svalue);
        else value=svalue;
      }
    }
    return value;
  }
}

// ************************************************************ Update40.js ***
