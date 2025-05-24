<?php
// PHP7/HTML5, EDGE/CHROME                          *** j_setRegimLed33.php ***

// ****************************************************************************
// * KwinFlat                   Выбрать режима работы контрольного светодиода *
// *                                                                          *
// * v1.0.2, 22.01.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  20.01.2025 *
// ****************************************************************************
// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);
define ("SiteHost",    $_POST['sh']);
define ("action",      $_POST['action']);
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
$messa=$Kvizzy->UpdateModeLMP33($pdo,action);
// Возвращаем сообщение
$message=\prown\makeLabel($messa,'ghjun5','ghjun5');
echo $message;
exit;

// **************************************************** j_setRegimLed33.php ***
