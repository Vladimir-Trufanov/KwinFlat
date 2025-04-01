<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                      *** Update40BODY.php ***

// ****************************************************************************
// * KwinFlat                                 Главная страница администратора *
// ****************************************************************************

// v4.0.1, 31.03.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// ------------------------------------------------------------------- BODY ---
echo '<div id="LeftAndRight">';
echo '<div id="Left">';
   echo '<div id="Header">';
   echo '
   <img id="kwf" src="../Images/Kwinflat.jpg" alt="Kwinflat-близкий всем!" />
   ';
   // Подключаем кнопку виртуального контроллера
   require_once 'Update40/FlipOnHover/FlipOnHover.html';
   echo '</div>';

   echo '<div id="Article">';
   // Размещаем поле контроля значений датчиков, состояний устройств и 
   // контроллеров, а также управления ими
   //require_once("Update/Update.php"); 
   echo '</div>';

   echo '<div id="Footer">';
      echo '<div id="FooterTop">';
      echo '<pre>';
      echo 'www.probatv.ru = '.gethostbyname('www.probatv.ru').'<BR>';
      echo '$browser       = '.$browser.'<BR>';
      echo '$version       = '.$version.'<BR>';
      echo '$platform      = '.$platform.'<BR>';
      echo '$device_type   = '.$device_type.'<BR>';
      echo '</pre>';
      echo '</div>';    // id="FooterTop"
  
   echo '</div>';       // id="Footer"
echo '</div>';          // id="Left"

echo '<div id="Right">';
   // Показываем текущее время и время с начала сессии
   echo '<div id="anytime">';
   
   echo '
     <p id="currentTime"></p>
     <p id="sessiontime"></p>
   ';
   
   echo '</div>'; // id="anytime" 

   // Показываем текущее изображение
   echo '<div id="Frame">';
   //echo '<p><img id="img" src="/Controller/imgDigits/png9.png"/></p>';
   //echo '<p><img id="img" src="/Controller/imgMulti/run20.png"/></p>';
   echo '<p><img id="img" src="/Controller/imgMulti/run20.png"/></p>';
   echo '</div>'; // id="Frame" 

   // Показываем последнее (ие) поступившее сообщение от контроллера
   echo '<div id="lastmess">';
   echo '
   <p id="myTime"> </p>
   <p id="myDate"> </p>
   <p id="cycle">  </p>
   <p id="sjson">  </p>
   <p id="status"> </p>
   ';
   echo '</div>'; // id="lastmess" 

echo '</div>'; // id="Right"
// Загружаем панель виртуального контроллера   
require_once("Controller/Controller.php"); 
echo '</div>'; // id="LeftAndRight"

// Определяем поле демонстрации поступающих json-сообщений
echo '<div id="tickers">';
echo 'id="tickers"';
echo '</div>';    // id="tickers"

// Размещаем див сообщений от аякс-запросов
echo '<div id="DialogWind">';
echo '</div>';

// <!-- --> ********************************************** Update40BODY.php ***

