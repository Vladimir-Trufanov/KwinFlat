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
      <!-- <link rel="stylesheet" type="text/css" href="Allcss/Reset.css" /> -->
    
      <style>
         html{font-family:Helvetica; display:inline-block; margin:0px auto; text-align: center;}
         body{margin-top:50px;} h1{color:#444444; margin:50px auto 30px;} h3{color:#444444; margin-bottom:50px;}
      
         .button
         {
            display:block; width:80px; background-color:#3498db; border:none; color:white; padding:13px 30px; 
            text-decoration:none; font-size:25px; margin:0px auto 35px; cursor:pointer; border-radius: 4px;
         }
      
         .button-on         {background-color:#3498db;}
         .button-on:active  {background-color:#2980b9;}
         .button-off        {background-color:#34495e;}
         .button-off:active {background-color:#2c3e50;}
      
         p {font-size:14px; color:#888; margin-bottom:10px;}
         
         #DachaStatus 
         {
            display:none;
         }
      </style>
   </head>

   <body>

      <header>
         <div class="header-bg">
         <img src="../Images/Kwinflat.jpg" alt="Kwinflat-близкий всем!" />
         </div>
      </header>

      <article>
      <h1>ESP32 - Дачная страница</h1>
   
      <?php
      // echo 'parm='; echo $parm;
      if ($parm=="led1on")
         echo '<p>Состояние LED1: ВКЛ. </p><a id="LED1on"  class="button button-off" href="?Com=led1off">ВЫКЛ.</a>';
      else
         echo '<p>Состояние LED1: ВЫКЛ.</p><a id="LED1off" class="button button-on"  href="?Com=led1on"> ВКЛ. </a>';

      if ($parm=="led2on")
         echo '<p>Состояние LED2: ВКЛ. </p><a id="LED2on"  class="button button-off" href="?Com=led2off">ВЫКЛ.</a>';
      else
         echo '<p>Состояние LED2: ВЫКЛ.</p><a id="LED2off" class="button button-on"  href="?Com=led2on"> ВКЛ. </a>';
         
      echo "Всем большой привет с дачной страницы";
      ?>
      </article>

      <footer>
         Copyright &copy; Владимир Труфанов
      </footer>
      
      <div id="DachaStatus">
      <?php
      $dom = new DOMDocument('1.0','UTF-8');
      $dom->formatOutput = true;

      $root = $dom->createElement('student');
      $dom->appendChild($root);

      $result = $dom->createElement('result');
      $root->appendChild($result);

      $result->setAttribute('id', 1);
      $result->appendChild( $dom->createElement('name', 'Opal Kole') );
      $result->appendChild( $dom->createElement('sgpa', '8.1') );
      $result->appendChild( $dom->createElement('cgpa', '8.4') );

      echo '<xmp>'. $dom->saveXML() .'</xmp>';
      $dom->save('result.xml') or die('XML Create Error');
      ?>
      </div>

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












/*
  ?page=1&perpage=20

  String ptr = "<!DOCTYPE html> <html>\n";
  ptr +="<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\"><head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=no\">\n";
  ptr +="<title>Управление светодиодом</title>\n";

  ptr +="<style>html { font-family: Helvetica; display: inline-block; margin: 0px auto; text-align: center;}\n";
  ptr +="body{margin-top: 50px;} h1 {color: #444444;margin: 50px auto 30px;} h3 {color: #444444;margin-bottom: 50px;}\n";
  ptr +=".button {display: block;width: 80px;background-color: #3498db;border: none;color: white;padding: 13px 30px;text-decoration: none;font-size: 25px;margin: 0px auto 35px;cursor: pointer;border-radius: 4px;}\n";
  ptr +=".button-on {background-color: #3498db;}\n";
  ptr +=".button-on:active {background-color: #2980b9;}\n";
  ptr +=".button-off {background-color: #34495e;}\n";
  ptr +=".button-off:active {background-color: #2c3e50;}\n";
  ptr +="p {font-size: 14px;color: #888;margin-bottom: 10px;}\n";
  ptr +="</style>\n";
  ptr +="</head>\n";
  ptr +="<body>\n";

  ptr +="<h1>ESP32 Веб сервер</h1>\n";
    ptr +="<h3>Режим станции (STA)</h3>\n";
   if(led1stat)
  {ptr +="<p>Состояние LED1: ВКЛ.</p><a class=\"button button-off\" href=\"/led1off\">ВЫКЛ.</a>\n";}
  else
  {ptr +="<p>Состояние LED1: ВЫКЛ.</p><a class=\"button button-on\" href=\"/led1on\">ВКЛ.</a>\n";}
  if(led2stat)
  {ptr +="<p>Состояние LED2: ВКЛ.</p><a class=\"button button-off\" href=\"/led2off\">ВЫКЛ.</a>\n";}
  else
  {ptr +="<p>Состояние LED2: ВЫКЛ.</p><a class=\"button button-on\" href=\"/led2on\">ВКЛ.</a>\n";}
  ptr +="</body>\n";
  ptr +="</html>\n";
  return ptr;
}
*/
?>

