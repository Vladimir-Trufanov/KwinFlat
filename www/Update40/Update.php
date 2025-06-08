<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                            *** Update.php ***

// ****************************************************************************
// * KwinFlat                 Обновить значения датчиков, состояния устройств *
// *                                         и контроллеров на странице сайта *
// ****************************************************************************

// v1.1.0, 05.05.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 05.10.2024

?>
<div id="lead">
   
   <div id=shsh>
     
   <div id="shlmp" class="shled4">
      <p class="pshled4"></p>
   </div>
   
   <div id="shlight" class="shled4" onclick="onLed4('pilight','light',0,100)" title="От 0% до 100%">
      <p class="pshled4">ГОРИТ (%)</p>
   </div>
   <div id="shnolight">
      <p>НЕТ</p>
   </div>
   <div id="shtime" class="shled4" onclick="onLed4('pitime','time',100,100000)" title="От 100 до 100 тысяч мсек">
      <p class="pshled4">ПЕРИОД (мсек)</p>
   </div>
   <div id="shspot" class="shled4">
   </div>
   </div>

   <div id="lplp">
   <div id="lmp" class="cled4">
      <p class="cp4">Led4</p>
   </div>
   
   <?php
   echo '
   <div id="light" class="cled4">
      <p id="pilight" class="cp4">'.$jlight.'</p>'.'
   </div>
   <div id="nolight" class="cled4">
      <p id="pinolight" class="cp4">'.(100-$jlight).'</p>'.'
   </div>
   <div id="time" class="cled4">
      <p id="pitime" class="cp4">'.$jtime.'</p>'.'
   </div>
   ';
   ?>
   <div id="spot" class="cled4">
   &#128161; 
   </div>
   </div>
   
   <?php
   // Подключаем меню регулирования интервалов подачи сообщений от контроллера
   require_once 'intrv.php';
   ?>

</div>
<?php

// <!-- --> **************************************************** Update.php ***
