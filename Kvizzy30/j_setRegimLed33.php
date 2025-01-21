<?php
// PHP7/HTML5, EDGE/CHROME                          *** j_setRegimLed33.php ***

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
define ("LmpRegim",    $_POST['LmpRegim']);
// Формируем json-строку по режиму
if (LmpRegim==1) $sjson='{"led33":[{"regim":1}]}'; 
else $sjson='{"led33":[{"regim":0}]}';
// Подгружаем нужные модули библиотек
require_once pathPhpPrown."/CommonPrown.php";
// Подключаем объект для работы с базой данных моего хозяйства
require_once "Common.php";  
require_once "TTools/TKvizzyMaker/KvizzyMakerClass.php";
$Kvizzy=new ttools\KvizzyMaker(SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();
// Выбираем параметры ответа
$isEvent=1;
$messa=$Kvizzy->UpdateModeLMP33($pdo,$isEvent,$sjson);
/*
$isEvent=$table['isEvent']; 
$Mode=$table['Mode']; 
$SendTime=$table['SendTime']; 
$ReceivTime=$table['ReceivTime']; 
$sjson=$table['sjson'];
// Возвращаем сообщение
$message='{"isEvent":'.$isEvent.',"Mode":"'.$Mode.'","SendTime":'.$SendTime.',"ReceivTime":'.$ReceivTime.',"sjson":'.$sjson.'}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');
echo $message;
*/
//echo 'Привет!';
echo $sjson;
exit;

// **************************************************** j_setRegimLed33.php ***
