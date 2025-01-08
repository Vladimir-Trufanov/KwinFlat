<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                        *** UpSiteBODY.php ***

// ****************************************************************************
// * KwinFlat                                    Разобрать параметры запроса, *
// *                                         запустить оболочки страниц сайта *
// ****************************************************************************

// v2.0, 05.10.2024                                   Автор:      Труфанов В.Е.
// Copyright © 2023 tve                               Дата создания: 08.10.2023

// ------------------------------------------------------------------- BODY ---

echo '<div id="Left">';
echo '<div id="Header">';
?>
<img id="kwf" src="../Images/Kwinflat.jpg" alt="Kwinflat-близкий всем!" />
<?php
echo '</div>';

echo '<div id="Article">';
// Подгружаем обновление значений датчиков, состояний устройств и контроллеров
require_once("Update/Update.php"); 
echo '</div>';

echo '<div id="Footer">';
/*
echo '<pre>';
echo '$browser='.$browser.'<BR>';
echo '$version='.$version.'<BR>';
echo '$platform='.$platform.'<BR>';
echo '$device_type='.$device_type.'<BR>';
echo '</pre>';
echo '</div>';
echo '</div>';
*/

echo '<div id="Right">';
echo '$parm='.$parm.'<br>';
echo '$Page='.$Page.'<br>';
echo '<br>';
// 5 вариант. 
// https://ru.stackoverflow.com/questions/1533916/Сделать-на-чистом-css-зацикленую-бегущую-строку-без-рывков
?>
<div class="tickers">
  <div class="ticker">
    <h2 class="ticker__head">ДОБРОГО ВАМ ДНЯ!</h2>
    <h2 class="ticker__head">ДОБРОГО ВАМ ДНЯ!</h2>
    <h2 class="ticker__head">ДОБРОГО ВАМ ДНЯ!</h2>
    <h2 class="ticker__head">ДОБРОГО ВАМ ДНЯ!</h2>
    <h2 class="ticker__head">ДОБРОГО ВАМ ДНЯ!</h2>
    <h2 class="ticker__head">ДОБРОГО ВАМ ДНЯ!</h2>
  </div>
</div>
<?php

echo '</div>';



// <!-- --> ************************************************ UpSiteBODY.php ***
