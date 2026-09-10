<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                      *** Update40HEAD.php ***

// ****************************************************************************
// * KwinFlat                        Подготовить стили и скрипты обслуживания *
// *                                          главной страницы администратора *
// ****************************************************************************

// v4.0.1, 10.09.2026                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// ---------------------------------------------------------- HEAD and LAST ---
// Подключаем переменные и константы JavaScript, соответствующие определениям в PHP
require_once "iniPhpJS.php"; 
// Активируем обнаружение ориентации устройства          
activateOrient($SignaUrl,$SignaPortraitUrl,$c_Orient);

// Подключаем js и CSS
echo '<script src="CommonTools.js"></script>';
echo '<script src="Update40/Update40.js"></script>';
echo '<script src="Update40/Update40led4.js"></script>';
// Переключаем файл стилей
if ($SiteDevice=='Mobile' and $c_Orient==oriPortrait) 
{   
  echo '<link href="Update40/Update40portrait.css" rel="stylesheet">';
}
else 
{   
  echo '<link href="Update40/Update40landscape.css" rel="stylesheet">';
}
echo '<link href="Update40/intrv.css" rel="stylesheet">';
echo '<script src="Controller/Controller.js"></script>';
echo '<link href="Update40/FlipOnHover/FlipOnHover.css" rel="stylesheet">';
// Разворачиваем смартменю
echo '<script> MakeSmartMenu(); </script>';
// Подстраиваем размеры некоторых шрифтов
echo '<style>';
if ($SiteDevice=='Mobile' and $c_Orient==oriPortrait) 
{   
  echo'  
      #plans .plan {font-size:.6rem;}
      #plans .plan:hover {font-size:.7rem;}
  ';
}
else 
{   
  if ($SiteDevice=='Mobile') 
  {   
  echo'  
      #plans .plan {font-size:.8rem;}
      #plans .plan:hover {font-size:.9rem;}
  ';
  }
  else
  {
    echo'  
      #plans .plan {font-size:1rem;}
      #plans .plan:hover {font-size:1.1rem;}
    ';
  }
}
echo '</style>';



echo'  
';

// end ------------------------------------------------------ HEAD and LAST ---

// <!-- --> ********************************************** Update40HEAD.php ***
