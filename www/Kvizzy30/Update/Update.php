<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                            *** Update.php ***

// ****************************************************************************
// * KwinFlat                 Обновить значения датчиков, состояния устройств *
// *                                         и контроллеров на странице сайта *
// ****************************************************************************

// v1.0.1, 03.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 05.10.2024

require_once 'State/CommonStateMaker.php';


// 4 вариант. 
// https://liondigital.ru/kak-sdelat-begushhuyu-stroku-v-css/
?>
<div class="marquee-container">
  <div class="marquee2">
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
  </div>
</div>
<?php
echo '<br>';
echo '<br>';
echo '<br>';

/*
?>
<div id="led33">

   <div id=shsh>
   <div id="shlmp" class="shled33" onclick="onShlmp()">
      <p class="pshled33">ВКЛЮЧИТЬ РЕЖИМ</p>
   </div>
   <div id="shlight" class="shled33" onclick="onShlight()">
      <p class="pshled33">ГОРИТ (%)</p>
   </div>
   <div id="shnolight" class="shled33" onclick="onShnolight()">
      <p class="pshled33">НЕТ</p>
   </div>
   <div id="shtime" class="shled33" onclick="onShtime()">
      <p class="pshled33">ПЕРИОД (мсек)</p>
   </div>
   <div id="shspot" class="shled33">
      
   </div>
   </div>

   <div id=lplp>
   <div id="lmp" class="cled33">
      <p class="cp33">Led33</p>
   </div>
   <div id="light" class="cled33">
      <p class="cp33">10</p>
   </div>
   <div id="nolight" class="cled33">
      <p class="cp33">90</p>
   </div>
   <div id="time" class="cled33">
      <p class="cp33">1007</p>
   </div>
   <div id="spot" class="cled33" style="background:SandyBrown">
   </div>
   </div>

</div>

<?php

*/

echo '<div id="led4">';
//echo 'led4 <br>';
$pdo=StateConnect($SiteHost);
$table=SelectLed33($pdo);
echo 'myTime: '.$table['myTime'].'<br>'; 
echo 'myDate: '.$table['myDate'].'<br>'; 
//echo 'cycle: ' .$table['cycle']. '<br>'; 
//echo 'sjson: ' .$table['sjson']. '<br>';
//echo '<br>';
echo '</div>';

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
