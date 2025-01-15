<?php

// PHP7/HTML5, EDGE/CHROME                                *** deleteArt.php ***

// ****************************************************************************
// * TArticleMaker     По указанному идентификатору в аякс-запросе определить *
// *            наименование материала, а затем удалить запись из базы данных *
// *                                                                          *
// * v1.0, 27.01.2023                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  13.11.2022 *
// ****************************************************************************

// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);
define ("SiteHost",    $_POST['sh']);
// Подгружаем нужные модули библиотек
require_once pathPhpPrown."/CommonPrown.php";
require_once 'State/CommonStateMaker.php';
// Выбираем параметры ответа
$pdo=StateConnect(SiteHost);
$table=SelectLed33($pdo);
$myTime=$table['myTime']; 
$myDate=$table['myDate']; 
$cycle=$table['cycle']; 
$sjson=$table['sjson'];
// Возвращаем сообщение
$message='{"myTime":'.$myTime.',"myDate":"'.$myDate.'","cycle":'.$cycle.', "sjson":"'.$sjson.'"}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');
echo $message;
exit;

// ********************************************************** deleteArt.php ***
