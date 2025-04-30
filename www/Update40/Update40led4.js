// JS/HTML5, EDGE/CHROME/YANDEX                         *** Update40led4.js ***

// ****************************************************************************
// * KwinFlat                            Мигать вспышкой на странице Update40 *
// *                                        в соответствии с заданным режимом *
// ****************************************************************************

// v1.0.0, 29.04.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 29.04.2025

// Готовим переменные обслуживания процесса мигания
var Led4Intrv=3000;        // текущий интервал смены состояния вспышки
var idLed4Intrv;           // id функции управления интервалом смены состояния вспышки
var Led4Status="shimLOW";  // текущее состояние вспышки
var nLight=1000;           // интервал свечения вспышки
var nNoLight=1000;         // интервал НЕ-свечения вспышки

$(document).ready(function() 
{
  // Запускаем мигание вспышки в соответствии с режимом
  setTimeout(vLed4,Led4Intrv);
});
// ****************************************************************************
// *  Мигать вспышкой на странице Update40 в соответствии с заданным режимом  *
// ****************************************************************************
function vLed4() 
{
  //console.log('jlight='+jlight); 
  //console.log('jtime='+jtime); 
  // Рассчитываем времена свечения и несвечения вспышки
  nLight=jtime*jlight/100;  // 2000*10/100=200
  nNoLight=jtime-nLight;    // 2000-200=1800
  
  if (Led4Status=="shimHIGH")
  {
    //console.log('nLight='+nLight); 
    $('#spot').css('background','White');
    Led4Intrv=nLight;
    Led4Status="shimLOW";
  } 
  else 
  {
    //console.log('nNoLight='+nNoLight); 
    $('#spot').css('background','Silver');
    Led4Intrv=nNoLight;
    Led4Status="shimHIGH"
  }
  setTimeout(vLed4,Led4Intrv);
}

// ******************************************************** Update40led4.js ***
