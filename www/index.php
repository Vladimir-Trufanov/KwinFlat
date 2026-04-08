<?php
// PHP7/HTML5, EDGE/CHROME                                    *** index.php ***

// ****************************************************************************
// *  KwinFlat                                         KwinFlat-близкий всем! *
// ****************************************************************************

// v4.0.2, 19.04.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2016 tve                               Дата создания: 14.08.2016

// task=NULL     - ознакомление гостя с умным хозяйством [Meet40]
// task=update40 - главная страница администратора

//echo "Privet";

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

   // Определяем страницу сайта
   $task=prown\getComRequest('task');
   //if      ($task==NULL)       $task='Meet40';
   //else if ($task=='update40') 
   $task='Update40';
   //else $task='Meet40';

   // ---------------------------------------------------------------- INIT ---
   // Выполняем начальную инициализацию переменных, определяем константы,
   // создаем классы для начального заполнения разметки
   require_once 'iniMem.php'; 
   require_once 'iniMenu.php'; 
   
   // Начинаем разметку страниц сайта c кодировкой UTF8
   echo '<!DOCTYPE html>'; // определили разметку HTML5
   echo '<html lang="ru">'; // назначили русский язык для сайта
   echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
   // ------------------------------------------------------- HEAD and LAST ---
   // Указываем индивидуальные данные страниц сайта для поисковых систем 
   // и пользователей, подключаем персональные стили для настольных и мобильных 
   // версий страниц сайта
   echo "<head>";
   // Добавляем мета-тег для яндекс-вебмастера
   echo "<meta name=\"yandex-verification\" content=\"b2eb9e02a692ce99\" />";
   // Выводим данные о favicon
   echo '
   <link rel="manifest" href="manifest.json">
   <link rel="apple-touch-icon" sizes="180x180" href="/favicon260x260/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="/favicon260x260/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="/favicon260x260/favicon-16x16.png">
   <link rel="mask-icon" href="/favicon260x260/safari-pinned-tab.svg" color="#5bbad5">
   <link rel="shortcut icon" href="/favicon260x260/favicon.ico">
   <meta name="msapplication-TileColor" content="#da532c">
   <meta name="msapplication-config" content="/favicon260x260/browserconfig.xml">
   <meta name="theme-color" content="#ffffff">
   ';
   // Подключаем jQuery
   echo '<script src="/jQuery/jquery-1.11.1.min.js"></script>';
   echo '
      <link rel="stylesheet" type="text/css" href="/jQuery/jquery-ui.min.css">
      <script src="/jQuery/jquery-ui.min.js"></script>
   ';
   // Определяем общие стили
   echo '<link href="/Home.css" rel="stylesheet">';
   // Обобщаем мобильную версию сайта
   if ($SiteDevice=='Mobile')
   {
      echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
   }

   // Подключаем SmartMenus
   echo '<script src="SmartMenus/jquery.smartmenus.min.js"></script>';
   echo '<script src="SmartMenus/MakeSmartMenu.js"></script>';
   echo '<link rel="stylesheet" href="SmartMenus/sm-core-css.css">';
   echo '<link rel="stylesheet" href="SmartMenus/sm-kwinflat-desktop.css">';
   //echo '<link rel="stylesheet" href="/SmartMenus/sm-kwinflat-mobi.css">';

   /*
   // Делаем страницу для смартфона
   if ($SiteDevice==Mobile) 
   {   
     //echo '<script>alert("Mobile");</script>';
     echo '<link href="Styles/MobiStyles.css" rel="stylesheet">';
     echo '<link rel="stylesheet" href="SmartMenus/sm-kwinflat-mobi.css">';
   }
   // Делаем страницу для компьютера
   else 
   {   
     echo '<link href="Styles/Styles.css" rel="stylesheet">';
     echo '<link href="Styles/ApiPogoda.css" rel="stylesheet">';
     echo '<link rel="stylesheet" href="SmartMenus/sm-kwinflat.css">';
   }
   */
   //
   if ($task=='Update40') require_once 'Update40/Update40HEAD.php';
   else require_once 'Meet40/Meet40HEAD.php';
   echo "</head>";
   // ---------------------------------------------------------------- BODY ---
   // Разбираем параметры запроса, запускаем общую оболочку и страницы сайта
   echo '<body>'; 
   
   // 1.
   if ($task=='Update40') require_once 'Update40/Update40BODY.php';
   else require_once 'Meet40/Meet40BODY.php';
   
   // 2.
   //phpinfo();
   
   // 3.
   //$file = 'Arduino.txt';
   //$file = 'fil1.jpg';
   //$img  = '***'.base64_encode(file_get_contents($file)).'***';
   //echo $img."<br>\nrttyy\n";
   
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

