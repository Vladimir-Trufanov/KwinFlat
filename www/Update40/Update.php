<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                            *** Update.php ***

// ****************************************************************************
// * KwinFlat                 Обновить значения датчиков, состояния устройств *
// *                                         и контроллеров на странице сайта *
// ****************************************************************************

// v1.0.2, 19.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 05.10.2024

?>
<div id="led33">
   
   <div id=shsh>
   <div id="shlmp" class="shled4" onclick="setRegimLed4()">
      <p class="pshled4">ВКЛЮЧИТЬ РЕЖИМ</p>
   </div>
   <div id="shlight" class="shled4" onclick="onLed4('pilight','light',0,100)" title="От 0% до 100%">
      <p class="pshled4">ГОРИТ (%)</p>
   </div>
   <div id="shnolight" class="shled4" onclick="onLed4('pinolight','nolight',0,100)" title="От 0% до 100%">
      <p class="pshled4">НЕТ</p>
   </div>
   <div id="shtime" class="shled4" onclick="onLed4('pitime','time',100,100000)" title="От 100 до 100 тысяч мсек">
      <p class="pshled4">ПЕРИОД (мсек)</p>
   </div>
   <div id="shspot" class="shled4">
   </div>
   </div>

   <div id=lplp>
   <div id="lmp" class="cled4">
      <p class="cp4">Led4</p>
   </div>
   <div id="light" class="cled4">
      <p id="pilight" class="cp4">10</p>
   </div>
   <div id="nolight" class="cled4">
      <p id="pinolight" class="cp4">90</p>
   </div>
   <div id="time" class="cled4">
      <p id="pitime" class="cp4">1007</p>
   </div>
   <div id="spot" class="cled4" style="background:SandyBrown">
   </div>
   </div>

</div>
<?php

// <!-- --> **************************************************** Update.php ***
