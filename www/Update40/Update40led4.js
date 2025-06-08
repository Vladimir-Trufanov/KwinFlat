// JS/HTML5, EDGE/CHROME/YANDEX                         *** Update40led4.js ***

// ****************************************************************************
// * KwinFlat                            Мигать вспышкой на странице Update40 *
// *                                        в соответствии с заданным режимом *
// ****************************************************************************

// v4.5.0, 08.06.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 29.04.2025

// Инициируем прежние переменные обслуживания процесса мигания
var oldlight=10;           // начальный (прежний) процент времени свечения в цикле
var oldnolight=90;         // начальный (прежний) процент времени НЕсвечения в цикле
var oldtime=2000;          // начальная (прежняя) длительность цикла "горит - не горит" (мсек)   
// Пересчитываем начальные интервалы свечения-несвечения вспышки
var nLight;                // интервал свечения вспышки
var nNoLight;              // интервал НЕ-свечения вспышки
setValueLight();
// Выключаем вспышку на % НЕгорения в периоде             
var idLed4Intrv;           // id функции управления интервалом смены состояния вспышки
var Led4Status;            // текущее состояние вспышки (выключена)
var Led4Intrv;             // начальный интервал до смены состояния вспышки

$(document).ready(function() 
{
  idLed4Intrv=setNoLight();
});
 
// ****************************************************************************
// *              Рассчитать времена свечения и несвечения вспышки            *
// ****************************************************************************
function setValueLight() 
{
  nLight=jtime*jlight/100;  // 2000*10/100=200
  nNoLight=jtime-nLight;    // 2000-200=1800
}
// ****************************************************************************
// *                  Включить вспышку на % горения в периоде                 *
// ****************************************************************************
function setLight() 
{
  Led4Status="shimHIGH"
  $('#spot').css('background',coLight);  
  Led4Intrv=nLight;
  //console.log('nLight='+nLight);
  return setTimeout(vLed4,Led4Intrv);
}
// ****************************************************************************
// *                  Выключить вспышку на % НЕгорения в периоде                 *
// ****************************************************************************
function setNoLight() 
{
  Led4Status="shimLOW"
  $('#spot').css('background',conolight);  
  Led4Intrv=nNoLight;
  //console.log('nNoLight='+nNoLight);
  return setTimeout(vLed4,Led4Intrv);
}
// ****************************************************************************
// *  Мигать вспышкой на странице Update40 в соответствии с заданным режимом  *
// ****************************************************************************
function vLed4() 
{
  // Если вспышка горела, выключаем и запускаем отсчет
  if (Led4Status=="shimHIGH") 
  {
    // Обязательно останавливаем предыдущий setTimeout
    clearTimeout(idLed4Intrv);
    // Запускаем новый setTimeout
    idLed4Intrv=setNoLight();
  }
  // Если вспышка НЕ горела, включаем и запускаем отсчет
  else 
  {
    clearTimeout(idLed4Intrv);
    idLed4Intrv=setLight();
  }
}
// ****************************************************************************
// *       Сформировать input-теги для редактирования интервалов сообщений    *
// ****************************************************************************
var pvalue,pmin,pmax;
var namefield;
function onIntrv(pfield,imin,imax)
{
  // console.log('pfield='+pfield);
  pmin=imin; pmax=imax; namefield=pfield;
  pvalue=$('#'+pfield).text();
  $('#'+pfield).html('<input id="idpfield" class="Inp" type="number" step="100" '+
    'min="'+imin.toString()+'" max="'+imax.toString()+'" value="'+pvalue.toString()+'"/>'+
    '<button class="Btn" onclick="onIntrv1()">Ok</button>');
  $('#'+pfield).css('background','white');
} 
// ****************************************************************************
// *     Сформировать input-теги для редактирования режимов работы вспышки    *
// ****************************************************************************
var diez,bemol,value,min,max;
var bemol2,diez2,val2
function onLed4(diezi,bemoli,mini,maxi)
{
  diez=diezi; bemol=bemoli; min=mini; max=maxi;
  let valuex=$('#'+diez).text();
  $('#'+bemol).html('<input id="inpvalue" class="Inp" type="number" step="1" '+
    'min="'+min.toString()+'" max="'+max.toString()+'" value="'+valuex.toString()+'">'+
    '<button class="Btn" onclick="onbLed4()">Ok</button>');
  $('#'+bemol).css('background','white');
} 
// ****************************************************************************
// * Принять значение интервала, проверить границы, записать в базу через аякс 
// ****************************************************************************
function onIntrv1()
{
  let value=$('#idpfield').val();
  // Контроллируем границы
  if (value<pmin) value=pmin
  else if (value>pmax) value=pmax;
  // console.log('value='+value);
  // <p id="ptempvl" class="price">3003</p>
  $('#'+namefield).html('<p id="'+namefield+'" class="price">'+value.toString()+'</p>');
  $('#'+namefield).css('background','transparent');
  // Запоминаем глобальные переменные
  if      (namefield=='pmode4')  jmode4=value 
  else if (namefield=='pimg')    jimg=value 
  else if (namefield=='ptempvl') jtempvl=value 
  else if (namefield=='plumin')  jlumin=value 
  else                           jbar=value; 
  // Формируем json действующих интервалов подачи сообщений от контроллера (мсек) 
  // s_INTRV="intrv":{"mode4":7007,"img":1001,"tempvl":3003,"lumin":2002,"bar":5005} 
  var s_INTRV = '"intrv":{'+
    '"mode4":'+  jmode4.toString()+  ','+
    '"img":'+    jimg.toString()+    ','+
    '"tempvl":'+ jtempvl.toString()+ ','+ 
    '"lumin":'+  jlumin.toString()+  ','+ 
    '"bar":'+    jbar.toString()+    
  '}'; 
  // Записываем в базу данных изменения интервалов подачи сообщений контроллера
  setMessLead(-2,s_INTRV)
  //console.log('s_INTRV='+s_INTRV);
}
// ****************************************************************************
// * Принять значение параметра режима led4, проверить границы, записать в базу  
// ****************************************************************************
function onbLed4()
{
  //console.log(diez+'='+bemol);
  value=$('#inpvalue').val();
  // Контроллируем границы
  if (value<min) value=min
  else if (value>max) value=max;
  //console.log(value.toString());
  $('#'+bemol).html('<p id="'+diez+'" class="cp4">'+value.toString()+'</p>');
  $('#'+bemol).css('background','Silver');
  // Выполняем контроль процентов
  if ((bemol=='light')||(bemol=='nolight')) 
  {
    if (bemol=='light') bemol2='nolight'; else bemol2='light'; 
    if (diez=='pilight') diez2='pinolight'; else diez2='pilight';
    val2=100-value; 
    $('#'+bemol2).html('<p id="'+diez2+'" class="cp4">'+val2.toString()+'</p>');
  }
  // Запоминаем глобальные переменные
  if      (bemol=='light')   
  {
    jlight=value;
    jnolight=100-value;
    setStateElem("jlight",value);
  } 
  else if (bemol=='nolight') 
  {
    jlight=val2;
    jnolight=100-val2;
    setStateElem("jlight",val2);
  } 
  else if (bemol=='time')
  {
    jtime=value;
    setStateElem("jtime",value);
  } 
  else
  {
    jlight=value; 
    setStateElem("jlight",value);
  }
  // Формируем json действующего режима работы вспышки
  // s_MODE4 = '"led4":{"light":10,"time":2000}'   
  var s_MODE4 = '"led4":{'+
    '"light":'+jlight.toString()+','+
    '"time":'+ jtime.toString()+    
  '}'; 
  // Записываем в базу данных изменения режима работы led4
  setMessLead(-1,s_MODE4)
}
// ****************************************************************************
// *     Записать в базу данных изменения состояния управляющих json-команд   *
// ****************************************************************************
function setMessLead(num,sjson)
{
  // Выводим в диалог предварительный результат выполнения запроса
  htmlText="Записать изменения в управляющую json-команду не удалось!";
  // Выполняем запрос
  pathphp="Update40/j_setMessForLead.php";
  // Делаем запрос последнего json-сообщения на State 
  $.ajax({
    url: pathphp,
    type: 'POST',
    data: {pathTools:pathPhpTools,pathPrown:pathPhpPrown,sh:SiteHost,postNum:num,postJson:sjson},
    // Выводим ошибки при выполнении запроса в PHP-сценарии
    error: function (jqXHR,exception) {DialogWind(SmarttodoError(jqXHR,exception))},
    // Обрабатываем ответное сообщение
    success: function(message)
    {
      //console.log(message);
      // Вырезаем из запроса чистое сообщение
      let Fresh=FreshLabel(message);
      // Если чистое сообщение не вырезалось, считаем, что это ошибка и
      // диагностируем её
      if (Fresh=='NoFresh')
      {
        console.log(message);
        DialogWind(message);
      }
      // Иначе считаем, что ответ на запрос пришел, проверяем правильность передачи
      else 
      {
        messa=Fresh;
        //console.log('Fresh='+messa);
        if (messa!=nstOk) DialogWind(message);
      }
    }
  });
}
// ****************************************************************************
// *     Записать в базу данных изменение управляющего элемента изображения   *
// ****************************************************************************
function setStateElem(Name,Value)
{
  // Выводим в диалог предварительный результат выполнения запроса
  htmlText="Записать изменение в управляющего элемента не удалось!";
  // Выполняем запрос
  pathphp="Update40/j_setStateElem.php";
  // Делаем запрос последнего json-сообщения на State 
  $.ajax({
    url: pathphp,
    type: 'POST',
    data: {pathTools:pathPhpTools,pathPrown:pathPhpPrown,sh:SiteHost,postName:Name,postValue:Value},
    // Выводим ошибки при выполнении запроса в PHP-сценарии
    error: function (jqXHR,exception) {DialogWind(SmarttodoError(jqXHR,exception))},
    // Обрабатываем ответное сообщение
    success: function(message)
    {
      //console.log(message);
      // Вырезаем из запроса чистое сообщение
      let Fresh=FreshLabel(message);
      // Если чистое сообщение не вырезалось, считаем, что это ошибка и
      // диагностируем её
      if (Fresh=='NoFresh')
      {
        console.log(message);
        DialogWind(message);
      }
      // Иначе считаем, что ответ на запрос пришел, проверяем правильность передачи
      else 
      {
        messa=Fresh;
        //console.log('Fresh='+messa);
        if (messa!=nstOk) DialogWind(message);
      }
    }
  });
}

// ******************************************************** Update40led4.js ***
