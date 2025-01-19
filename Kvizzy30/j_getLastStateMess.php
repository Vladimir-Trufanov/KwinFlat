<?php

// PHP7/HTML5, EDGE/CHROME                       *** j_getLastStateMess.php ***

// ****************************************************************************
// * TArticleMaker     По указанному идентификатору в аякс-запросе определить *
// *            наименование материала, а затем удалить запись из базы данных *
// *                                                                          *
// * v1.0.1, 18.01.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2024 tve                          Дата создания:  13.11.2024 *
// ****************************************************************************
// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);
define ("SiteHost",    $_POST['sh']);
// Подгружаем нужные модули библиотек
require_once pathPhpPrown."/CommonPrown.php";
// Подключаем объект для работы с базой данных моего хозяйства
require_once "Common.php";  
require_once "TTools/TKvizzyMaker/KvizzyMakerClass.php";
$Kvizzy=new ttools\KvizzyMaker($SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();
// Выбираем параметры ответа
$table=$Kvizzy->SelectLed33($pdo);
$myTime=$table['myTime']; 
$myDate=$table['myDate']; 
$cycle=$table['cycle']; 
$sjson=$table['sjson'];
// Возвращаем сообщение
$message='{"myTime":'.$myTime.',"myDate":"'.$myDate.'","cycle":'.$cycle.', "sjson":'.$sjson.'}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');
echo $message;
exit;

// ************************************************* j_getLastStateMess.php ***
