<?php 
// PHP7/HTML5, YANDEX/EDGE/CHROME                          *** iniPhpJS.php ***

// ****************************************************************************
// * kwinflat.ru           Организовать межязыковые (PHP-JScript) определения *
// ****************************************************************************

// v4.4.1, 07.06.2025                                Автор:       Труфанов В.Е. 
// Copyright © 2025 tve      sla6en9edged            Дата создания:  13.01.2025 

// Интервал подачи и выборки изображений в потоке
// define ("IntStream", 2048);   //  1 раз за 1024 миллисекунды
// define ("IntStream", 42);     //  24 раза в секунду
define ("IntStream", 84);        //  12 раз в секунду

// Инициализируем общесайтовые константы (здесь стараемся не назначать константу = 0, так как 
// проверка значению "==" может не отличить 0 от NULL)
define ("nstOk",   'все в порядке'); 
define ("nstErr",  'произошла ошибка');  
define ("nstYes",  'объект включён'); 
define ("nstNo",   'объект выключен'); 
define ("vController", nstNo);   // nstNo - вирт.контроллер выключен, nstYes - вирт.контроллер включён

// Определяем параметры текущего режима работы вспышки
$jlight=10;          // процент времени свечения в цикле
$jnolight=100-10;
$jtime=2000;         // длительность цикла "горит - не горит" (мсек)   
$jevent=0;           // пришло подтверждение от контроллера
// Назначаем действующие интервалы подачи сообщений от контроллера (мсек) 
$jmode4=7007;        // режим работы Led4 
$jimg=1001;          // подача изображения    
$jtempvl=3003;       // температура и влажность
$jlumin=2002;        // освещённость камеры
$jbar=5005;          // атмосферное давление

$coLight='Coral';    // цвет горящей вспышки
$conolight='Silver'; // цвет погасшей вспышки

// ****************************************************************************
// *               Объявить переменные и константы JavaScript,                *
// *                   соответствующие определениям в PHP                     *
// ****************************************************************************
function DefineJS($SiteHost,$urlHome,$jlight,$jnolight,$jtime,$jevent,$jmode4,$jimg,$jtempvl,$jlumin,$jbar,$coLight,$conolight)
{
   $define="\n".
   '<script>'."\n".
   'SiteHost="'            .$SiteHost.'";'."\n".
   'urlHome="'             .$urlHome.'";'."\n".
   'pathPhpPrown="'        .pathPhpPrown.'";'."\n".
   'pathPhpTools="'        .pathPhpTools.'";'."\n".

   'IntStream="'           .IntStream.'";'."\n".
   'nstOk="'               .nstOk.'";'."\n".
   'nstErr="'              .nstErr.'";'."\n".
   'nstYes="'              .nstYes.'";'."\n".
   'nstNo="'               .nstNo.'";'."\n".
   'vController="'         .vController.'";'."\n".
   'var jlight="'          .$jlight.'";'."\n".
   'var jnolight="'        .$jnolight.'";'."\n".
   'var jtime="'           .$jtime.'";'."\n".
   'var jevent="'          .$jevent.'";'."\n".
   'var jmode4="'          .$jmode4.'";'."\n".
   'var jimg="'            .$jimg.'";'."\n".
   'var jtempvl="'         .$jtempvl.'";'."\n".
   'var jlumin="'          .$jlumin.'";'."\n".
   'var jbar="'            .$jbar.'";'."\n".
   'var coLight="'         .$coLight.'";'."\n".
   'var conolight="'       .$conolight.'";'."\n".
   '</script>'."\n";
   echo $define;
} 

//  Создаем переменные и константы JavaScript, соответствующие определениям в PHP   
DefineJS($SiteHost,$urlHome,$jlight,$jnolight,$jtime,$jevent,$jmode4,$jimg,$jtempvl,$jlumin,$jbar,$coLight,$conolight);

// Подключаем обнаружение ориентации устройства по завершению загрузки страницы
?> <script>
oriPortrait="<?php echo oriPortrait;?>";
oriLandscape="<?php echo oriLandscape;?>";
xOrient="<?php echo $c_Orient;?>";
$(document).ready(function() 
{
   window.addEventListener('orientationchange',doOnOrientationChange);
   OnOrientationChange(xOrient);
});
// Назначаем uri вызова страниц с различной ориентацией
SignaUrl="<?php echo $SignaUrl;?>";
SignaPortraitUrl="<?php echo $SignaPortraitUrl;?>";
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
</script> <?php
// Настраиваем стили на устройство
//cssDivPosition($SiteDevice,$c_Orient);

// *********************************************************** iniPhpJS.php *** 
