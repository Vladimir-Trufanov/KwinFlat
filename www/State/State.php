<?php
// PHP7/HTML5, EDGE/CHROME                                    *** State.php ***

// ****************************************************************************
// * KwinFlat/State                      Зарегистрировать изменения состояний *
// *                                        контроллеров и показаний датчиков *
// ****************************************************************************

// v1.1, 06.10.2024                                   Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 06.09.2024

// Инициализируем рабочее пространство: корневой каталог сайта и т.д.
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();

$SiteRoot     = $_WORKSPACE[wsSiteRoot];     // Корневой каталог сайта
$SiteAbove    = $_WORKSPACE[wsSiteAbove];    // Надсайтовый каталог
$SiteHost     = $_WORKSPACE[wsSiteHost];     // Каталог хостинга
$SiteDevice   = $_WORKSPACE[wsSiteDevice];   // 'Computer' | 'Mobile' | 'Tablet'
$UserAgent    = $_WORKSPACE[wsUserAgent];    // HTTP_USER_AGENT
$urlHome      = $_WORKSPACE[wsUrlHome];      // Начальная страница сайта 

// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{
   // require_once($SiteHost.'/TPhpPrown/TPhpPrown/CommonPrown.php');
   ?>
   <!DOCTYPE html> 
   <html>

   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
      <title>Зарегистрировать изменения состояний контроллеров и показаний датчиков</title>
      <link rel="shortcut icon" href="/favicon260x260/favicon.ico">
   </head>

   <body>
   <article>
      <?php 
         $backmessage='State';
         echo $backmessage;
      ?>
   </article>
   <footer>
      Copyright &copy; Владимир Труфанов
   </footer>
   </body>
   </html>

   <?php
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
?> <!-- --> <?php // ******************************************** State.php ***

