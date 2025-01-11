<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                            *** Update.php ***

// ****************************************************************************
// * KwinFlat                 Обновить значения датчиков, состояния устройств *
// *                                         и контроллеров на странице сайта *
// ****************************************************************************

// v1.0.1, 03.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 05.10.2024

require_once 'State/CommonStateMaker.php';

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

echo '<div id="led4">';
echo 'led4 <br>';
$pdo=StateConnect($SiteHost);
$table=SelectLed33($pdo);
echo 'myTime: '.$table['myTime'].'<br>'; 
echo 'myDate: '.$table['myDate'].'<br>'; 
echo 'cycle: ' .$table['cycle']. '<br>'; 
echo 'sjson: ' .$table['sjson']. '<br>';
echo '<br>';
echo '</div>';

// <!-- --> **************************************************** Update.php ***
