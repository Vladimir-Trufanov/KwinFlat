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
   echo '<pre>';
   echo '$browser='.$browser.'<BR>';
   echo '$version='.$version.'<BR>';
   echo '$platform='.$platform.'<BR>';
   echo '$device_type='.$device_type.'<BR>';
   echo '</pre>';
   
   /*
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
   */

   /*
   ?>
   <div class="tickers">
   <div class="ticker">
   <div class="ticker__head">6ДОБРОГО ВАМ ДНЯ!</div>
   <div class="ticker__head">5ДОБРОГО ДНЯ!</div>
   <div class="ticker__head">4ДОБРОГО ВАМ ДНЯ!</div>
   <div class="ticker__head">3ДОБРОГО ВАМ ДНЯ!</div>
   <div class="ticker__head">2ДОБРОГО ВАМ ДНЯ!</div>
   <div class="ticker__head">1ДОБРОГО ВАМ!</div>
   </div>
   </div>
   <?php
   */


   ?>
   <div class="tickers">
   <div class="ticker">
   <div class="ticker__head">fСЕГОДНЯ</div>
   <div class="ticker__head">eСЕГОДНЯ</div>
   <div class="ticker__head">dСЕГОДНЯ</div>
   <div class="ticker__head">cСЕГОДНЯ</div>
   <div class="ticker__head">bСЕГОДНЯ</div>
   <div class="ticker__head">aСЕГОДНЯ</div>
   <div class="ticker__head">9СЕГОДНЯ</div>
   <div class="ticker__head">8СЕГОДНЯ</div>
   <div class="ticker__head">7СЕГОДНЯ</div>
   <div class="ticker__head">6СЕ</div>
   <div class="ticker__head">5ДНЯ</div>
   <div class="ticker__head">4СЧАСТЛИВОГО</div>
   <div class="ticker__head">3И</div>
   <div class="ticker__head">2ВАМ</div>
   <div class="ticker__head">1ДОБРОГО</div>
   </div>
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
