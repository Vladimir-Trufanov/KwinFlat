<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                            *** Update.php ***

// ****************************************************************************
// * KwinFlat                 Обновить значения датчиков, состояния устройств *
// *                                         и контроллеров на странице сайта *
// ****************************************************************************

// v1.0, 05.10.2024                                   Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 05.10.2024

?>
<script>
$(document).ready(function() 
{
  // Фиксируем начало запуска сайта
  var valTimeBeg = new Date();
  // Выбираем элемент отражения времени с начала сессии
  var timeElement = document.getElementById('currentTime');
  // Запускаем вызов ежесекундного (990 мкс) обновления экрана
  const intervalId = setInterval(
  function() 
  {
    // Выбираем элемент отражения времени с начала сессии
    //var timeElement = document.getElementById('currentTime');
    // Трассируем запуск обработки таймера
    console.log('Я выполняюсь почти каждую секунду');
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
  ,990)
});

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

</script>
<?php

// Размещаем див с отражением времени с начала сессии
// или текста 'Нет базы', когда аякс-запрос не отрабатывается
echo '
  <div id="sessiontime">
  <p id="currentTime"></p>
  </div>
';

// <!-- --> **************************************************** Update.php ***
