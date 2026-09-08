<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                      *** Update40HEAD.php ***

// ****************************************************************************
// * KwinFlat                        Подготовить стили и скрипты обслуживания *
// *                                          главной страницы администратора *
// ****************************************************************************

// v4.0.0, 29.03.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// ---------------------------------------------------------- HEAD and LAST ---
// Подключаем переменные и константы JavaScript, соответствующие определениям в PHP
require_once "iniPhpJS.php"; 
// Активируем обнаружение ориентации устройства          
activateOrient($SignaUrl,$SignaPortraitUrl,$c_Orient);
// Настраиваем стили на устройство
//cssDivPosition($SiteDevice,$c_Orient);

// Подключаем js и CSS
echo '<script src="CommonTools.js"></script>';
echo '<script src="Update40/Update40.js"></script>';
echo '<script src="Update40/Update40led4.js"></script>';

?> <style> <?php   
if ($SiteDevice=='Mobile' and $c_Orient==oriPortrait) 
{   
echo '  
#LeftAndRight
{
  display:flex;
  flex-direction:column;
  height:97%;
}
';
echo '  
#Left
{
   background:LightYellow;
   width:100%;
   height:60%;
   /*background:transparent;*/ 
   z-index:1;
}
#Right
{
   background:LightCyan;
   width:100%;
   height:40%;
   z-index:1;
}
';
}
// Делаем страницу для компьютера
else 
{   
echo '  
#LeftAndRight
{
  display:flex;
  flex-direction:row;
  height:97%;
}
';
echo '  
#Left
{
   background:LightYellow;
   width:67%;
   height:100%;
   /*background:transparent;*/ 
   z-index:1;
}
#Right
{
   background:LightCyan;
   width:33%;
   height:100%;
   z-index:1;
}
';
}


?> </style> <?php   



if ($SiteDevice=='Mobile') 
{   
  echo '<link href="Update40/Update40mobi.css" rel="stylesheet">';
}
// Делаем страницу для компьютера
else 
{   
  echo '<link href="Update40/Update40.css" rel="stylesheet">';
}

echo '<link href="Update40/intrv.css" rel="stylesheet">';
echo '<script src="Controller/Controller.js"></script>';
echo '<link href="Update40/FlipOnHover/FlipOnHover.css" rel="stylesheet">';
// Разворачиваем смартменю
echo '<script> MakeSmartMenu(); </script>';
// end ------------------------------------------------------ HEAD and LAST ---

// <!-- --> ********************************************** Update40HEAD.php ***
