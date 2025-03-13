<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                    *** j_SelImgStream.php ***

// ****************************************************************************
// *          Выбрать для показа последнее, принятое, изображение видеопотока *
// ****************************************************************************

// v1.0.0, 13.03.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 13.03.2025

// Инициализируем рабочее пространство: корневой каталог сайта и т.д.
require_once '../iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteHost     = $_WORKSPACE[wsSiteHost];     // Каталог хостинга

define("pathPhpPrown",  $SiteHost.'/TPhpPrown/TPhpPrown'); 
define("pathPhpTools",  $SiteHost.'/TPhpTools/TPhpTools'); 
require_once pathPhpPrown."/CommonPrown.php";
// Подключаем объект для работы с базой данных моего хозяйства
require_once "../Common.php";  
require_once "../TTools/TKvizzyMaker/KvizzyMakerClass.php";
$Kvizzy=new ttools\KvizzyMaker($SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();
// Записываем изображение в базу данных
$mess=$Kvizzy->SelImgStream($pdo);
echo $mess;

// <!-- --> ******************************************** j_SelImgStream.php ***
