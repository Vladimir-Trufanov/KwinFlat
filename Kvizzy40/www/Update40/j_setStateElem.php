<?php
// PHP7/HTML5, EDGE/CHROME                           *** j_setStateElem.php ***

// ****************************************************************************
// * KwinFlat                                Записать в базу данных изменение *
// *                                        управляющего элемента изображения *
// *                                                                          *
// * v4.4.0, 05.06.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  05.06.2025 *
// ****************************************************************************

// $Name="jlight";
// $Value=13;

// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);
define ("SiteHost",    $_POST['sh']);
define ("Name",        $_POST['postName']);
define ("Value",       $_POST['postValue']);
// Подгружаем нужные модули библиотек
require_once pathPhpPrown."/CommonPrown.php";
// Подключаем объект для работы с базой данных моего хозяйства
require_once "../Common.php";  
require_once "../TKvizzyMaker/KvizzyMakerClass.php";
$Kvizzy=new ttools\KvizzyMaker(SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();
// Выбираем параметры ответа
$messa=$Kvizzy->setStateElem($pdo,Name,Value);
// Возвращаем сообщение
$message=\prown\makeLabel($messa,'ghjun5','ghjun5');
echo $message;
exit;

// ***************************************************** j_setStateElem.php ***
