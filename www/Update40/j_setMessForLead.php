<?php
// PHP7/HTML5, EDGE/CHROME                         *** j_setMessForLead.php ***

// ****************************************************************************
// * KwinFlat                                Записать в базу данных изменения *
// *                               интервалов подачи сообщений от контроллера *
// *                                                                          *
// * v2.0.0, 04.05.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  04.05.2025 *
// ****************************************************************************
// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);
define ("SiteHost",    $_POST['sh']);
define ("num",         $_POST['postNum']);
define ("sjson",       $_POST['postJson']);
// Подгружаем нужные модули библиотек
require_once pathPhpPrown."/CommonPrown.php";
// Подключаем объект для работы с базой данных моего хозяйства
require_once "../Common.php";  
require_once "../TKvizzyMaker/KvizzyMakerClass.php";
$Kvizzy=new ttools\KvizzyMaker(SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();
// Выбираем параметры ответа
//$messa=$Kvizzy->UpdateModeLMP33($pdo,action);
$messa='j_setMessForLead.php';
// Возвращаем сообщение
$message=\prown\makeLabel($messa,'ghjun5','ghjun5');
echo $message;
exit;

// *************************************************** j_setMessForLead.php ***
