<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                        *** UpSiteBODY.php ***

// ****************************************************************************
// * KwinFlat                                    Разобрать параметры запроса, *
// *                                         запустить оболочки страниц сайта *
// ****************************************************************************

// v2.0.1, 17.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// ------------------------------------------------------------------- BODY ---

echo '<div id="Left">';
   echo '<div id="Header">';
   ?>
   <img id="kwf" src="../Images/Kwinflat.jpg" alt="Kwinflat-близкий всем!" />
   <?php
   echo '</div>';

   echo '<div id="Article">';
   // Размещаем поле контроля значений датчиков, состояний устройств и 
   // контроллеров, а также управления ими
   require_once("Update/Update.php"); 
   echo '</div>';

   echo '<div id="Footer">';
      echo '<div id="FooterTop">';
      require_once 'Rusakov/RusakovLead.php';
      
      /* до 2025-03-18
      $ip='127.0.0.1';
      $port=7775;
      $echoserver='echo-server.php';
      require_once 'LeadSocket.php';
      */
      
      /* до 2025-03-15
      echo '<pre>';
      echo '$browser='.$browser.'<BR>';
      echo '$version='.$version.'<BR>';
      echo '$platform='.$platform.'<BR>';
      echo '$device_type='.$device_type.'<BR>';
      echo '</pre>';
      */
      echo '</div>';    // id="FooterTop"
      
      // Определяем поле демонстрации поступающих json-сообщений
      echo '<div id="tickers">';
      echo '</div>';    // id="tickers"
  
   echo '</div>';       // id="Footer"
echo '</div>';          // id="Left"

echo '<div id="Right">';
// Показываем текущее время и время с начала сессии
echo '
  <div id="anytime">
  <p id="currentTime"></p>
  <p id="sessiontime"></p>
  </div>
';
echo '<br>';
//echo '<p><img id="img" src="/Controller/imgDigits/png9.png"/></p>';
echo '<p><img id="img" src="/Controller/imgMulti/run20.png"/></p>';

// Показываем последнее поступившее сообщение от контроллера
?>
   <p id="myTime"> </p>
   <p id="myDate"> </p>
   <p id="cycle">  </p>
   <p id="sjson">  </p>
   <p id="status"> </p>
<?php
// Размещаем див сообщений от аякс-запросов
echo '<div id="DialogWind">';
echo '</div>';

echo '</div>'; // id="Right"

// <!-- --> ************************************************ UpSiteBODY.php ***

