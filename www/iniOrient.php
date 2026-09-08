<?php 
// PHP7/HTML5, YANDEX|EDGE/CHROME                         *** iniOrient.php ***

// ****************************************************************************
// * kwinflat.ru         Отловить изменения ориентации смартфона (ландшафтной *
// *           на портретную и обратно) для смартфона и постоянно ландшафтной *
// *                                      с последующим выбором данных по CSS *
// ****************************************************************************

// v2.0.0, 08.09.2026                                 Автор:      Труфанов В.Е. 
// Copyright © 2025 tve                               Дата создания: 13.01.2025 

require_once pathPhpPrown."/MakeCookie.php";

define ("oriLandscape", 'landscape'); // ландшафтное расположение устройства
define ("oriPortrait",  'portrait');  // портретное расположение устройства

// Определяем uri вызова страниц с различной ориентацией
$SignaUrl=$_SERVER['SCRIPT_NAME'].'?orient='.oriLandscape;
$SignaPortraitUrl=$_SERVER['SCRIPT_NAME'].'?orient='.oriPortrait;

// ****************************************************************************
// *                 2 фаза: определить ориентацию устройства                 *
// ****************************************************************************
function setOrient($SiteDevice)
{
  if ($SiteDevice=='Mobile') 
  {
    // Если кукиса в БРАУЗЕРЕ УСТРОЙСТВА нет, то устанавливаем $c_Orient и кукис 'сOrient'
    // в первоначальную ориентацию - портретную
    $co_Orient=prown\MakeCookie('cOrient',oriPortrait,tStr,true);  
    // Если передан параметр ориентации, то переустанавливаем $c_Orient и кукис по параметру 
    if (IsSet($_GET["orient"]))
    {
      if ($_GET["orient"]==oriLandscape) $co_Orient=prown\MakeCookie('cOrient',oriLandscape,tStr); 
      if ($_GET["orient"]==oriPortrait)  $co_Orient=prown\MakeCookie('cOrient',oriPortrait,tStr); 
    }
    // Если параметр не передавался, то по умолчанию задаем для смартфона портретт
    else
    {
      $co_Orient=prown\MakeCookie('cOrient',oriPortrait,tStr);
    }
  }
  else                       
  {
    $co_Orient=prown\MakeCookie('cOrient',oriLandscape,tStr);
  } 
  return $co_Orient;     
}
// ****************************************************************************
// *              Активизировать обнаружение ориентации устройства            *
// ****************************************************************************
function activateOrient($SignaUrl,$SignaPortraitUrl)
{
}
// ********************************************************** iniOrient.php *** 
