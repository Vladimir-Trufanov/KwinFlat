// JS/HTML5, EDGE/CHROME/YANDEX                             *** Update40.js ***

// ****************************************************************************
// * KwinFlat                    Обслужить ознакомительную страницу для гостя *
// ****************************************************************************

// v4.5.1, 09.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 05.10.2024

$(document).ready(function() 
{
  /*
  console.log('SiteHost:  '+SiteHost);
  console.log('urlHome:   '+urlHome);
  console.log('IntStream: '+IntStream);
  */
  // Создаём объект для работы с localStorage
  ram = new TStorage; 
  // Выбираем последнее изображение 24 (или 1 раз за 1024 миллисекунды) раза в секунду
  // console.log('IntStream: '+IntStream);
  setInterval(SelImgStream, IntStream);
  // Создаём поле демонстрации поступающих json-сообщений для 4 последних 
  let tickers = new TTickers(8);
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
  // Выбираем управляющие значения экрана и показания датчиков 
  // и обновляем их на экране                       
  UpdateStatus(tickers)
  // Запускаем вызов четвертьсекундного (250 мсек) обновления дива #lead на экране
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
  
  /*
  // Открываем управляющий див через задержку в 300 мсек 
  const sleep = ms => new Promise(resolve => setTimeout(resolve, ms));
  (async () => 
  {
    // Задержка в 300 мсек перед выводом сообщения и открытием дива
    await sleep(300);
    console.log('Ожидание открытия #lead завершено!');
    $('#lead').css('display','block');
  })(); 
  */ 
  
});
// ****************************************************************************
// *     Выбрать и показать последнее изображение с определённой частотой     *
// ****************************************************************************
  function SelImgStream()
  {
    //console.log('SelImgStream');
    // Выполняем запрос
    pathphp="Update40/j_SelImgStream.php";
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
            //console.log(parm.src); 
          }
          // Если последнее изображение не изменилось,
          // то и не меняем показываемое изображение
          else if (parm.fate==-4) 
          {
            //console.log("Последнее изображение не изменилось"); 
            $('#oldtime').html(ram.get("oldtime"));
            $('#oldframe').html(ram.get("oldframe"));
            //document.getElementById("img").src = parm.src;
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
// *          Выбрать управляющие значения экрана и показания датчиков        *
// *                            и обновить их на экране                       *
// ****************************************************************************
function UpdateStatus(tickers)
{
  // console.log("UpdateStatus");   
  
  // Выводим в диалог предварительный результат выполнения запроса
  htmlText="Выбрать управляющие значения экрана и показания датчиков не удалось!";
  // Выполняем запрос
  pathphp="Update40/j_SelState.php";
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
      // console.log(message);
      
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
        // console.log(messa);
        // Строим try catch, чтобы поймать ошибку в JSON-ответе
        try 
        {
          parm=JSON.parse(messa);
          // Если ошибка SQL-запроса
          if (parm.jlight<0) 
          {
            console.log(parm.jmode4);
            DialogWind(parm.jmode4);
          }
          // Выводим результаты выполнения (параметры ответа)
          // (отрабатываем распарсенный ответ)
          else
          {
            // Трассируем чистое сообщение, без метки
            // {"jlight":10,"jtime":"2010","jevent":0,"jmode4":7000,"jimg":1001,"jtempvl":3003,"jlumin":2002,"jbar":5005}
            //console.log(messa);
            //console.log('parm.jlight='+parm.jlight); 
            // Если изменился процент времени свечения в цикле,
            // то перенастраиваем иммитацию режима работы вспышки
            if (parm.jlight!=oldlight)
            {
              jlight=parm.jlight; $('#pilight').html(jlight.toString());      // процент времени свечения в цикле
              jnolight=100-jlight; $('#nolight').html(jnolight.toString());   // процент времени НЕсвечения в цикле
              // Устанавливаем прежние значения
              oldlight=jlight; oldnolight=jnolight; 
              // Пересчитываем начальные интервалы свечения-несвечения вспышки
              setValueLight();
              // Выключаем вспышку на % НЕгорения в периоде             
              clearTimeout(idLed4Intrv);
              idLed4Intrv=setNoLight(); 
            }
            // Если изменилась длительность периода
            // то перенастраиваем иммитацию режима работы вспышки
            if (parm.jtime!=oldtime)
            {
              jtime=parm.jtime; $('#pitime').html(jtime.toString());            // длительность цикла "горит - не горит" (мсек)   
              oldtime=jtime;
              // Пересчитываем начальные интервалы свечения-несвечения вспышки
              setValueLight();
              // Выключаем вспышку на % НЕгорения в периоде             
              clearTimeout(idLed4Intrv);
              idLed4Intrv=setNoLight(); 
            }
            // Устанавливаем интервалы
            jmode4=parm.jmode4; $('#pmode4').html(jmode4.toString());         // интервал сообщений по режиму работы Led4    
            jimg=parm.jimg; $('#pimg').html(jimg.toString());                 // интервал подачи изображения (мсек)   
            jtempvl=parm.jtempvl; $('#ptempvl').html(jtempvl.toString());     // интервал сообщений о температуре и влажности (мсек)   
            jlumin=parm.jlumin; $('#plumin').html(jlumin.toString());         // интервал сообщений об освещённости камеры (мсек)   
            jbar=parm.jbar; $('#pbar').html(jbar.toString());                 // интервал сообщений по атмосферному давлению (мсек)   

            // Перекрашиваем неподтвержденные изменения по led4
            jevent=parm.jevent;
            if (jevent==0) $('.cled4').css('color','Black'); 
            else $('.cled4').css('color','Tomato'); 
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
  // Выбираем последнее json-сообщение, пришедшее на State и
  // если оно отличается от предыдущего вывода, то показываем
  getLastStateMess(tickers);
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
// *                 Вывести диалоговое сообщение от ошибке                   *
// ****************************************************************************
function DialogWind(htmlText)
{
   $('#DialogWind').html(htmlText);
   delayClose=100;
   $('#DialogWind').dialog
   ({
      width:'auto',
      height:'auto',
      hide:{effect:"explode",delay:delayClose,duration:1000,easing:'swing'},
      title: "Предупреждение или сообщение об ошибке",
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
    this.SIZE = new Array();   // массив размеров сообщений
    this.HTML = '';            // выводимый html-текст
    this.isRender='yes';       // "разрешено движение сообщений в трассировке"
    this.Input='*';            // последнее принятое json-сообщение
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
    // Выполняем начальное заполнение массивов
    for (let i=0; i<this.count; i++) 
    {
      this.ARRY[i]='--'+i+'--';
      this.SIZE[i]=5;
    }
  }
  // Принять очередное сообщение и обновить ячейки трассировки
  render(iinput) 
  {
    if (iinput != this.Input)
    {
      this.Input=iinput;
      // Если ещё ячеек трассировки нет, создаем их
      if (this.ARRY.length<1) this.create();
      // Обновляем ячейки, когда разрешено
      if (this.isRender=='yes')
      {
        // Пересчитываем размер полосы сообщений #tickers
        let eTickers = document.getElementById('tickers');
        let rTickers = eTickers.getBoundingClientRect();  
        var SizeTickers=rTickers.left+rTickers.width;
        // Перемещаем прежние элементы 
        let i;
        for (i=this.count-1; i>0; i--) 
        {
          this.ARRY[i]=this.ARRY[i-1];
          this.SIZE[i]=this.SIZE[i-1];
        } 
        // Переопределяем и формируем нулевой элемент 
        this.ARRY[0]=iinput;
        //console.log(0,this.ARRY[0]);
        this.HTML=
        '<div id="tick'+0+'" class="ticker" style="border:solid .1rem DarkGoldenRod">'+this.ARRY[0]+'</div>';
        // Выводим полученную полоску с 0 сообщением
        $('#tickers').html(this.HTML);
        // Запоминаем размер нулевого элемента
        let eTick = document.getElementById('tick'+0);
        let rTick = eTick.getBoundingClientRect();  
        this.SIZE[0]=rTick.left+rTick.width;
        // Сколько можно, включаем в полоску предыдущие сообщения
        var rSize=this.SIZE[0];
        for (i=1; i<this.count; i++)
        {
          // Если в массиве принятый элемент (размер больше инициированного),
          // то включаем его в расчет
          if (this.SIZE[i]>5)
          {
            rSize=rSize+this.SIZE[i];
            if (rSize<SizeTickers)
            {
              // console.log(i,'this.SIZE['+i+']:',this.SIZE[i]);
              // console.log(i,rSize.toString()+'<'+SizeTickers.toString());
              
              // Переопределяем полосу сообщений  #tickers
              this.HTML=this.HTML+
                '<div id="tick'+i+'" class="ticker">'+this.ARRY[i]+'</div>';
            }
          }
          // Если инициированный элемент, то его исключаем из расчета
          else break;
        }
        // Выводим полученную полоску сообщений
        $('#tickers').html(this.HTML);
        // console.log('this.HTML',this.HTML);
      } 
    }
  }
}
// ****************************************************************************
// *                  Класс работы с хранилищем localStorage                  *
// ****************************************************************************
class TStorage
// 
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
      //DialogWind(message);
      //console.log(message)
      //tickers.render('JSON.stringify(sjson)');
      
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
        console.log(messa)
        
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
            cycle=parm.cycle;
            $('#cycle').html("cycle: "+cycle.toString());
            sjson=parm.sjson;
            $('#sjson').html ("sjson: "+JSON.stringify(sjson));
            let myTime=parm.myTime;
            $('#myTime').html("myTime: "+myTime.toString());
            let myDate=parm.myDate;
            $('#myDate').html("myDate: "+myDate);
            /*    
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
            */
            //alert(JSON.stringify(sjson));
            tickers.render(JSON.stringify(sjson));
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


// ************************************************************ Update40.js ***
