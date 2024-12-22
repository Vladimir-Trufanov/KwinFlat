<?php
// PHP7/HTML5, EDGE/CHROME                          *** State/index.php.php ***

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


// Подключаем задействованные классы
// require_once $SiteHost."/TPhpTools/TPhpTools/TPageStarter/PageStarterClass.php";
require_once($SiteHost.'/TPhpPrown/TPhpPrown/CommonPrown.php');


try 
{
   $parm=prown\getComRequest();
   if ($parm==NULL) $parm='NULL';
   // Выполняем запуск сессии и начальную инициализацию
   //$oStarter = new PageStarter('Main');
   //$oStarter->Message('$parm = '.$parm);
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
   <!-- 
   <article>
   -->
      <?php
         echo '***';
         echo $parm; 
         echo '***<br>'; 
         //$backmessage='State';
         //echo $backmessage.'<br>';
         
         // http://localhost:100/State/?Com={%22nicctrl%22:%22myjoy%22,%22led33%22:[{%22typedev%22:%22inLed%22,%22status%22:%22inHIGH%22}]}
         // http://localhost:100/State/?Com={"nicctrl":"myjoy","led33":[{%22typedev%22:%22inLed%22,%22status%22:%22inHIGH%22}]}

         // $json = '{"name": "John Doe", "age": 30}';
         // Конвертация JSON-строки в PHP-объект
         // $user = json_decode($json);
         // Использование
         // echo $user->name;  // Выведет «John Doe»
         // echo $user->age;  // Выведет 30
 
 
         /*
         $nicctrl = json_decode($parm);
         //echo '$nicctrl->nicctrl = '.$nicctrl->nicctrl.'<br>'; 
         $led33=$nicctrl->led33[0];
         //echo '$led33->typedev = '.$led33->typedev.'<br>'; 
         //echo '$led33->status = '.$led33->status.'<br>'; 
         
         $oStarter->Message('$nicctrl->nicctrl = '.$nicctrl->nicctrl);
         $oStarter->Message('$led33->typedev = '.$led33->typedev);
         $oStarter->Message('$led33->status = '.$led33->status);
         */
         //$oStarter->Message('Привет!');
         
         
      ?>
   <!-- 
   </article>
   <footer>
      Copyright &copy; Владимир Труфанов
   </footer>
   -->
   </body>
   </html>

   <?php
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
?> <!-- --> <?php // ********************************** State/index.php.php ***

