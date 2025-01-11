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
  
  let clock = new Clock({template: 'h:m:s'});
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
}

class Clock 
{
   constructor({ template }) 
   {
      this.template = template;
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
      $('#tick1').html(output);
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

