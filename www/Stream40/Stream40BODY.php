<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                      *** Stream40BODY.php ***

// ****************************************************************************
// * Stream                  Принять и записать в базу видеопоток изображений *
// ****************************************************************************

// v1.0.0, 09.03.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 09.03.2025

// ------------------------------------------------------------------- BODY ---

echo "<body>";
if(!empty($_POST['src']))
{
   //echo 'in';
   //MakeStream($SiteHost,$_POST['src'],$_POST['time'],$_POST['frame']);
   
   echo '***';
   //echo $_POST['src'];
   //echo (rawurldecode($_POST['src']));
   
   echo str_replace(' ', '+', $_POST['src']);
   
   
   //ViewHeaders3();
   echo '***';
   
} 
echo "</body>";

function MakeStream($SiteHost,$src,$time,$frame)
{
   // Подключаем объект для работы с базой данных моего хозяйства
   require_once "../Common.php";  
   require_once "../TKvizzyMaker/KvizzyMakerClass.php";
   $Kvizzy=new ttools\KvizzyMaker($SiteHost);
   // Подключаемся к базе данных
   $pdo=$Kvizzy->BaseConnect();
   // Записываем изображение в базу данных
   $mess=$Kvizzy->InsertImgStream($pdo,$src,$time,$frame);
   echo $mess;
   echo 'out';
}

function getRequestHeaders()
{
   $headers = array();
   foreach($_SERVER as $key => $value) 
   {
      if (substr($key, 0, 5) <> 'HTTP_') 
      {
         continue;
      }
      $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
      $headers[$header] = $value;
   }
   return $headers;
}

function ViewHeaders1()
{
   $headers = getRequestHeaders();
   foreach ($headers as $header => $value) 
   {
      echo "$header: $value <br />\n";
   }
}

function ViewHeaders2()
{
   $headers = apache_request_headers();
   foreach ($headers as $header => $value) 
   {
      echo "$header: $value <br />\n";
   } 
}

function ViewHeaders3()
{
   foreach (getallheaders() as $name => $value) 
   {
      echo "$name: $value\n";
   }
}


// <!-- --> ********************************************** Stream40BODY.php ***
