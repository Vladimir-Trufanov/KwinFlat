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
   echo '<div id="FooterTop">';
   echo '<pre>';
   echo '$browser='.$browser.'<BR>';
   echo '$version='.$version.'<BR>';
   echo '$platform='.$platform.'<BR>';
   echo '$device_type='.$device_type.'<BR>';
   echo '</pre>';
   echo '</div>';

   ?>
   <div id="tickers">
   <div id="tick1" class="ticker" style="border:solid .1rem DarkGoldenRod">1iДОБРОГО</div>
   <div class="ticker">2iВАМ</div>
   <div class="ticker">3iИ</div>
   <div class="ticker">4iСЧАСТЛИВОГО</div>
   <div class="ticker">5iДНЯ</div>
   <div class="ticker">6i,</div>
   <div class="ticker">7iСЕГОДНЯ</div>
   <div class="ticker">8iИ</div>
   <div class="ticker">9iВСЕГДА</div>
   </div>
   <?php

   echo '</div>';
echo '</div>';

echo '<div id="Right">';

// Размещаем див с отражением времени с начала сессии
// или текста 'Нет базы', когда аякс-запрос не отрабатывается
echo '
  <div id="sessiontime">
  <p id="currentTime"></p>
  </div>
';

echo '$parm='.$parm.'<br>';
echo '$Page='.$Page.'<br>';
echo '<br>';
echo '</div>';


// <!-- --> ************************************************ UpSiteBODY.php ***
