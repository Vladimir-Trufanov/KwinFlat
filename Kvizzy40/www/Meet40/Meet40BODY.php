<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                        *** Meet40BODY.php ***

// ****************************************************************************
// * KwinFlat                             Ознакомить гостя с умным хозяйством *
// ****************************************************************************

// v4.0.0, 29.03.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// ------------------------------------------------------------------- BODY ---
echo '<div id="Left">';
   echo '<div id="Header">';
   echo '</div>';

   echo '<div id="Article">';
   // Размещаем поле контроля значений датчиков, состояний устройств и 
   // контроллеров, а также управления ими
   require_once("Meet40.html"); 
   echo '</div>';

   echo '<div id="Footer">';
      echo gethostbyname('www.probatv.ru');
      echo '<pre>';
      echo '$browser='.$browser.'<BR>';
      echo '$version='.$version.'<BR>';
      echo '$platform='.$platform.'<BR>';
      echo '$device_type='.$device_type.'<BR>';
      echo '</pre>';
   echo '</div>';       // id="Footer"
echo '</div>';          // id="Left"

echo '<div id="Right">';
echo '</div>'; // id="Right"
// <!-- --> ************************************************ Meet40BODY.php ***

