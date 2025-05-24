<?php
// PHP7/HTML5, EDGE/CHROME                          *** j_getRegimLed33.php ***

// ****************************************************************************
// * KwinFlat                   Выбрать режима работы контрольного светодиода *
// *                                                                          *
// * v1.0.1, 20.01.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  20.01.2025 *
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
$Kvizzy=new ttools\KvizzyMaker(SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();
// Выбираем параметры ответа
$table=$Kvizzy->SelectLMP33($pdo);
$isEvent=$table['isEvent']; 
$Mode=$table['Mode']; 
$SendTime=$table['SendTime']; 
$ReceivTime=$table['ReceivTime']; 
$sjson=$table['sjson'];
// Возвращаем сообщение
$message='{"isEvent":'.$isEvent.',"Mode":"'.$Mode.'","SendTime":'.$SendTime.',"ReceivTime":'.$ReceivTime.',"sjson":'.$sjson.'}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');
echo $message;
exit;

// **************************************************** j_getRegimLed33.php ***
