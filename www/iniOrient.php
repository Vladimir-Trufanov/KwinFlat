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
function activateOrient($SignaUrl,$SignaPortraitUrl,$c_Orient)
{
  // Подключаем обнаружение ориентации устройства по завершению загрузки страницы
  ?>
  <script>
  var oriPortrait="<?php echo oriPortrait;?>";
  var oriLandscape="<?php echo oriLandscape;?>";
  var xOrient="<?php echo $c_Orient;?>";
  $(document).ready(function() 
  {
    window.addEventListener('orientationchange',doOnOrientationChange);
    OnOrientationChange(xOrient);
  });
  // Назначаем uri вызова страниц с различной ориентацией
  var SignaUrl="<?php echo $SignaUrl;?>";
  var SignaPortraitUrl="<?php echo $SignaPortraitUrl;?>";
  // Готовим обработку события при изменении положения устройства
  function doOnOrientationChange()
  // http://greymag.ru/?p=175, 07.09.2011. При повороте устройства браузер 
  // отсылает событие orientationchange. Это актуально для обеих операционных 
  // систем. Но подписка на это событие может осуществляться по разному. 
  // При проверке на разных устройствах iPhone, iPad и Samsung GT (Android),
  // выяснилось что в iOS срабатывает следующий вариант установки обработчика: 
  // window.onorientationchange = handler; А для Android подписка осуществляется 
  // иначе: window.addEventListener( 'orientationchange', handler, false ); 
  //
  // Примечание: В обоих примерах handler - функция-обработчик. Текущую ориентацию
  // экрана можно узнать проверкой свойства window.orientation, принимающего одно
  // из следующих значений: 0 — нормальная портретная ориентация, -90 —
  // альбомная при повороте по часовой стрелке, 90 — альбомная при повороте 
  // против часовой стрелки, 180 — перевёрнутая портретная ориентация (пока 
  // только для iPad).
  //         
  // Отследить переворот экрана:
  // https://www.cyberforum.ru/javascript/thread2242547.html, 08.05.2018
  {
    if ((window.orientation==0)||(window.orientation==180))
    {
      window.location=SignaPortraitUrl;
    } 
    if ((window.orientation==90)||(window.orientation==-90))
    { 
      window.location=SignaUrl;
    }
  }
  function OnOrientationChange(xOrient) 
  {
    // console.log(window.orientation);
    // Если фактически портрет, а кукис ландшафт, то перегружаем на портрет
    if ((window.orientation==0)||(window.orientation==180))
    {
      if (xOrient==oriLandscape) window.location=SignaPortraitUrl;
    } 
    // Если фактически альбом, а кукис портрет, то перегружаем на альбом
    if ((window.orientation==90)||(window.orientation==-90)||(window.orientation==undefined))
    { 
      if (xOrient==oriPortrait) window.location=SignaUrl;
    }
  }
  </script> 
  <?php
}

// ********************************************************** iniOrient.php *** 
