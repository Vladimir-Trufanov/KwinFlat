<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * State                               Зарегистрировать изменения состояний *
// *                                           устройств и показаний датчиков *
// ****************************************************************************

// v2.0.2, 19.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2023 tve                               Дата создания: 08.10.2023

// Инициализируем рабочее пространство: корневой каталог сайта и т.д.
require_once '../iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();

$SiteRoot     = $_WORKSPACE[wsSiteRoot];     // Корневой каталог сайта
$SiteAbove    = $_WORKSPACE[wsSiteAbove];    // Надсайтовый каталог
$SiteHost     = $_WORKSPACE[wsSiteHost];     // Каталог хостинга
$SiteDevice   = $_WORKSPACE[wsSiteDevice];   // 'Computer' | 'Mobile' | 'Tablet'
$UserAgent    = $_WORKSPACE[wsUserAgent];    // HTTP_USER_AGENT
$TimeRequest  = $_WORKSPACE[wsTimeRequest];  // Время запроса сайта
$RemoteAddr   = $_WORKSPACE[wsRemoteAddr];   // IP-адрес запроса сайта
$SiteName     = $_WORKSPACE[wsSiteName];     // Доменное имя сайта
$PhpVersion   = $_WORKSPACE[wsPhpVersion];   // Версия PHP
$SiteProtocol = $_WORKSPACE[wsSiteProtocol]; // HTTP или HTTPS
$urlHome      = $_WORKSPACE[wsUrlHome];      // Начальная страница сайта 
$RootDir      = $_WORKSPACE[wsRootDir];      // Каталог корня сайта, в котором выполняется текущий скрипт
$RootUrl      = $_WORKSPACE[wsRootUrl];      // Путь и имя выполняемого скрипта
$RemoteHost   = $_WORKSPACE[wsRemoteHost];   // Удаленный хост, с которого пользователь просматривает текущую страницу
$HttpReferer  = $_WORKSPACE[wsHttpReferer];  // Адрес страницы, с которой браузер пользователя перешёл на текущую страницу

// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{
   define("pathPhpPrown",  $SiteHost.'/TPhpPrown/TPhpPrown'); 
   define("pathPhpTools",  $SiteHost.'/TPhpTools/TPhpTools'); 
   require_once pathPhpPrown."/CommonPrown.php";
   // ---------------------------------------------------------------- BODY ---
   // Разбираем параметры запроса, запускаем общую оболочку и страницы сайта
   echo '<body>'; 
   require_once 'UpStateBODY.php';
   echo '</body>'; 
}
catch (E_EXCEPTION $e) 
{
   // Подключаем обработку исключений верхнего уровня
   DoorTryPage($e);
}

// <!-- --> ***************************************************** index.php ***
