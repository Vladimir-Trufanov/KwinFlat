<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * State40                             Зарегистрировать изменения состояний *
// *                                           устройств и показаний датчиков *
// ****************************************************************************

// v3.0.0, 21.04.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// Инициализируем рабочее пространство: корневой каталог сайта и т.д.
require_once '../iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteHost     = $_WORKSPACE[wsSiteHost];     // Каталог хостинга

define("pathPhpPrown",  $SiteHost.'/TPhpPrown/TPhpPrown'); 
define("pathPhpTools",  $SiteHost.'/TPhpTools/TPhpTools'); 
require_once pathPhpPrown."/CommonPrown.php";

// ---------------------------------------------------------------- BODY ---
// Разбираем параметры запроса, запускаем общую оболочку и страницы сайта
echo '<body>'; 
require_once 'State40BODY.php';
echo '</body>'; 

// <!-- --> ***************************************************** index.php ***
