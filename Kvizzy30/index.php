<?php
// PHP7/HTML5, EDGE/CHROME                                    *** index.php ***

// ****************************************************************************
// *  KwinFlat30                                       KwinFlat-близкий всем! *
// ****************************************************************************

// v4.0.1, 19.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2016 tve                               Дата создания: 14.08.2016

// Инициализируем рабочее пространство: корневой каталог сайта и т.д.
require_once 'iniWorkSpace.php';
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
   // Подключаем прикладные классы TPhpTools
   // require_once pathPhpTools."/TPageStarter/PageStarterClass.php";
   // require_once pathPhpTools."/TNotice/NoticeClass.php";

   $parm=prown\getComRequest();
   if ($parm==NULL) $parm='NULL';

   // ---------------------------------------------------------------- INIT ---
   // Выполняем начальную инициализацию переменных, определяем константы,
   // создаем классы для начального заполнения разметки
   require_once 'iniMem.php'; 
   // Начинаем разметку страниц сайта c кодировкой UTF8
   echo '<!DOCTYPE html>'; // определили разметку HTML5
   echo '<html lang="ru">'; // назначили русский язык для сайта
   echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
   // ------------------------------------------------------- HEAD and LAST ---
   // Указываем индивидуальные данные страниц сайта для поисковых систем 
   // и пользователей, подключаем персональные стили для настольных и мобильных 
   // версий страниц сайта
   echo "<head>";
   require_once 'UpSiteHEAD.php';
   echo "</head>";
   // ---------------------------------------------------------------- BODY ---
   // Разбираем параметры запроса, запускаем общую оболочку и страницы сайта
   echo '<body>'; 
   require_once 'UpSiteBODY.php';
   //phpinfo();
   echo '</body>'; 
   // Завершаем разметку
   echo '</html>';
}
catch (E_EXCEPTION $e) 
{
   // Подключаем обработку исключений верхнего уровня
   DoorTryPage($e);
}

?> <!-- --> <?php // ******************************************** index.php ***

