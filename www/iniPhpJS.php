<?php 
// PHP7/HTML5, YANDEX/EDGE/CHROME                          *** iniPhpJS.php ***

// ****************************************************************************
// * kwinflat.ru           Организовать межязыковые (PHP-JScript) определения *
// ****************************************************************************

// v4.4.0, 29.05.2025                                Автор:       Труфанов В.Е. 
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

/*
// Запрашиваем текущий режим работы вспышки
$table=$Kvizzy->SelLead($pdo,-1);
// Трассируем, при необходимости, таблицу
// echo '<pre>'; print_r($table); echo '</pre>';
// При ошибках sql-запроса выдаём сообщение и устанавливаем начальные значения режима
$isEvent=$table[0]['isEvent'];
$sjson=$table[0]['sjson'];
if ($isEvent<0) 
{
   echo $sjson.'<br>';
   $jlight=10;
   $jtime=2000;
   $jevent=0; // пришло подтверждение от контроллера
}
// Иначе парсим json и назначаем действующий режим работы вспышки
else
{
   $data = json_decode('{'.$sjson.'}',true);
   // echo '<pre>'; print_r($data);  echo '</pre>';   
   $jlight=$data['led4']['light'];
   $jtime=$data['led4']['time'];
   $jevent=$isEvent; // 1 - изменилось состояние json-команды, 0 - пришло подтверждение от контроллера
}
// Назначаем действующие интервалы подачи сообщений от контроллера (мсек) 
$jmode4=7007;   // режим работы Led4 
$jimg=1001;     // подача изображения    
$jtempvl=3003;  // температура и влажность
$jlumin=2002;   // освещённость камеры
$jbar=5005;     // атмосферное давление
*/
// Запрашиваем текущий режим работы вспышки
$table=$Kvizzy->SelState($pdo);
// Трассируем, при необходимости, таблицу
// echo '<pre>'; print_r($table); echo '</pre>';
// При ошибках sql-запроса выдаём сообщение и устанавливаем начальные значения
$jlight=$table[0]['jlight'];
$jmode4=$table[0]['jmode4'];
if ($jlight<0) 
{
   echo $jmode4.'<br>';
   $jlight=10;     // процент времени свечения в цикле
   $jtime=2000;    // длительность цикла "горит - не горит" (мсек)   
   $jevent=0;      // пришло подтверждение от контроллера
   // Назначаем действующие интервалы подачи сообщений от контроллера (мсек) 
   $jmode4=7007;   // режим работы Led4 
   $jimg=1001;     // подача изображения    
   $jtempvl=3003;  // температура и влажность
   $jlumin=2002;   // освещённость камеры
   $jbar=5005;     // атмосферное давление
}
// Иначе устанавливаем начальные значения по данным таблицы State
else
{
   $jlight  = $table[0]['jlight'];
   $jtime   = $table[0]['jtime'];
   $jevent  = $table[0]['jevent'];
   $jmode4  = $table[0]['jmode4'];
   $jimg    = $table[0]['jimg'];
   $jtempvl = $table[0]['jtempvl'];
   $jlumin  = $table[0]['jlumin'];
   $jbar    = $table[0]['jbar'];
}
// ****************************************************************************
// *               Объявить переменные и константы JavaScript,                *
// *                   соответствующие определениям в PHP                     *
// ****************************************************************************
function DefineJS($SiteHost,$urlHome,$jlight,$jtime,$jevent,$jmode4,$jimg,$jtempvl,$jlumin,$jbar)
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
   'var jtime="'           .$jtime.'";'."\n".
   'var jevent="'          .$jevent.'";'."\n".
   'var jmode4="'          .$jmode4.'";'."\n".
   'var jimg="'            .$jimg.'";'."\n".
   'var jtempvl="'         .$jtempvl.'";'."\n".
   'var jlumin="'          .$jlumin.'";'."\n".
   'var jbar="'            .$jbar.'";'."\n".
   '</script>'."\n";
   echo $define;
} 

//  Создаем переменные и константы JavaScript, соответствующие определениям в PHP   
DefineJS($SiteHost,$urlHome,$jlight,$jtime,$jevent,$jmode4,$jimg,$jtempvl,$jlumin,$jbar);

// *********************************************************** iniPhpJS.php *** 
