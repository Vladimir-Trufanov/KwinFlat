<?php

// PHP7/HTML5, EDGE/CHROME                         *** j_getLastNumCtrl.php ***

// ****************************************************************************
// * KwinFlat       Выбрать последнее сообщение заданного типа от контроллера * 
// *                                                                          *
// * v1.0.0, 19.09.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2024 tve                          Дата создания:  19.09.2025 *
// ****************************************************************************
// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);
define ("SiteHost",    $_POST['sh']);
define ("idctrl",      $_POST['ctrl']);
define ("num",         $_POST['nnum']);
// Подгружаем нужные модули библиотек
require_once pathPhpPrown."/CommonPrown.php";
// Подключаем объект для работы с базой данных моего хозяйства
require_once "Common.php";  
require_once "TKvizzyMaker/KvizzyMakerClass.php";
$Kvizzy=new ttools\KvizzyMaker(SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();
// Выбираем параметры ответа
$table=$Kvizzy->SelectNumCtrl($pdo,idctrl,num);
$myTime=$table['myTime']; 
$myDate=$table['myDate']; 
$sjson=$table['sjson'];
// Возвращаем сообщение
$message='{"myTime":'.$myTime.',"myDate":"'.$myDate.'","sjson":'.$sjson.'}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');
echo $message;
exit;

// *************************************************** j_getLastNumCtrl.php ***
