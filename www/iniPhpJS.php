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

// *********************************************************** iniPhpJS.php *** 
