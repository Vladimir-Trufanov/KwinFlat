<?php
// PHP7/HTML5, EDGE/CHROME                                    *** index.php ***

// ****************************************************************************
// * KwinFlat/Dacha                  Страница управления дачными устройствами *
// ****************************************************************************

// v1.0, 06.09.2024                                   Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 06.09.2024

// Инициализируем рабочее пространство: корневой каталог сайта и т.д.
require_once 'iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();

$SiteRoot     = $_WORKSPACE[wsSiteRoot];     // Корневой каталог сайта
$SiteAbove    = $_WORKSPACE[wsSiteAbove];    // Надсайтовый каталог
$SiteHost     = $_WORKSPACE[wsSiteHost];     // Каталог хостинга
$SiteDevice   = $_WORKSPACE[wsSiteDevice];   // 'Computer' | 'Mobile' | 'Tablet'
$UserAgent    = $_WORKSPACE[wsUserAgent];    // HTTP_USER_AGENT
$urlHome      = $_WORKSPACE[wsUrlHome];      // Начальная страница сайта 

// Подключаем модули парсера XML-файлов
include 'simple_html_dom.php';

// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{
   require_once($SiteHost.'/TPhpPrown/TPhpPrown/CommonPrown.php');
   $parm=prown\getComRequest();
   if ($parm==NULL) $parm='NULL';

   ?>
   <!DOCTYPE html> 
   <!-- 
   -->
   <html>

   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
      <title>Дачная страница</title>
      <link rel="stylesheet" type="text/css" href="Dacha.css">
   </head>

   <body>

      <header>
         <div class="header-bg">
         <img src="../Images/Kwinflat.jpg" alt="Kwinflat-близкий всем!" />
         </div>
         <?php
            ReadPositions();
         ?>
      </header>

      <article>
      <h1>ESP32 - Дачная страница</h1>
   
      <?php
      // Если поступила команда "включить вспышку" 
      if ($parm=="led4on")
         echo '<p>LED4 (вспышка) включена</p><a id="LED4on"  class="button button-on"  href="?Com=led4off">ВЫКЛ.</a>';
      // "Выключить вспышку" (или по умолчанию)
      else
         echo '<p>LED4 (вспышка) выключена</p><a id="LED4off" class="button button-off" href="?Com=led4on"> ВКЛ. </a>';
      // Если поступила команда "включить контрольный светодиод" 
      if ($parm=="led33on")
         echo '<p>LED33 - светодиод включен</p><a id="LED33on"  class="button button-on"  href="?Com=led33off">ВЫКЛ.</a>';
      // "Выключить контрольный светодиод" (или по умолчанию)
      else
         echo '<p>LED33 - светодиод выключен</p><a id="LED33off" class="button button-off" href="?Com=led33on"> ВКЛ. </a>';
         
      echo "Всем большой привет с дачной страницы";
      ?>
      </article>

      <footer>
         Copyright &copy; Владимир Труфанов
      </footer>

      <?php
         CreatePositions();
      ?>

   </body>
   </html>

   <?php
}
catch (E_EXCEPTION $e) 
{
   // ПОМНИТЬ(16.02.2019)! Если в коде сайта включается своя обработка исключений,
   // то управление выводом ошибок display_errors на сайте NIC.RU отключается и
   // работает только error_reporting (нужно разрешить обработку всех ошибок)
   
   // Подключаем обработку исключений верхнего уровня
   DoorTryPage($e);
}

// ****************************************************************************
// *                   Сбросить состояния в Positions.xml                     *
// ****************************************************************************
function CreatePositions()
{
   $dom = new DOMDocument('1.0','UTF-8');
   $dom->formatOutput = true;
   
   $root = $dom->createElement('positions');
   $dom->appendChild($root);
   $root->setAttribute('id','root');
   
   $name=$dom->createElement('name','Всем привет!'); 
   $root->appendChild($name);
   
   $sgpa=$dom->createElement('sgpa','181');
   $root->appendChild($sgpa);
   $sgpa->setAttribute('id','sgpa');

   $dom->save('Positions.xml') or die('XML Create Error');
}

// ****************************************************************************
// *                   Сбросить состояния в Positions.xml                     *
// ****************************************************************************
function ReadPositions()
{
   //echo '<p>ReadPositions()</p>';
      $xml = file_get_html('https://kwinflat.ru/Dacha/Positions.xml'); // загружаем данные
   // $xml = file_get_html('http://localhost:100/Dacha/Positions.xml'); // загружаем данные
   // Выводим контекст страницы
   // echo $xml->plaintext;
   
   //
   foreach($xml->find('#sgpa') as $title) 
   {
      // Выводим текст заголовка
      echo '===<br>';
      echo 'sgpa='.$title->plaintext.'<br>';
      echo '===<br>';
   }
}

?>

