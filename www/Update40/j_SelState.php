<?php

// PHP7/HTML5, EDGE/CHROME                               *** j_SelState.php ***

// ****************************************************************************
// * KwinFlat        Выбрать управляющие значения экрана и показания датчиков *
// *                                                                          *
// * v4.4.0, 02.06.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2024 tve                          Дата создания:  13.11.2024 *
// ****************************************************************************
// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);
define ("SiteHost",    $_POST['sh']);
// Подгружаем нужные модули библиотек
require_once pathPhpPrown."/CommonPrown.php";
// Подключаем объект для работы с базой данных моего хозяйства
require_once "../Common.php";  
require_once "../TKvizzyMaker/KvizzyMakerClass.php";
$Kvizzy=new ttools\KvizzyMaker(SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();
// Выбираем параметры ответа
$table=$Kvizzy->SelState($pdo);

// При ошибках sql-запроса выдаём сообщение об ошибке с пустыми значениями
$jlight=$table[0]['jlight'];
$jmode4=$table[0]['jmode4'];
if ($jlight<0) 
{
   $jtime=$jlight;$jevent=$jlight;$jimg=$jlight;$jtempvl=$jlight;$jlumin=$jlight;$jbar=$jlight; 
}
// Иначе устанавливаем значения по данным таблицы State
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
// Возвращаем json-сообщение
$message=
   '{'.'"jlight":'.$jlight.',"jtime":"'.$jtime.'","jevent":'.$jevent.
   ',"jmode4":'.$jmode4.',"jimg":'.$jimg.',"jtempvl":'.$jtempvl.
   ',"jlumin":'.$jlumin.',"jbar":'.$jbar.'}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');
echo $message;
exit;

// ********************************************************* j_SelState.php ***
