<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                      *** Stream40BODY.php ***

// ****************************************************************************
// * Stream                  Принять и записать в базу видеопоток изображений *
// ****************************************************************************

// v1.1.0, 19.04.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 09.03.2025

// ------------------------------------------------------------------- BODY ---

echo "<body>";
if(!empty($_POST['src']))
{
   //echo 'in';
   // Вставляем потерянные при передаче плюсы
   $Frame=str_replace(' ', '+', $_POST['src']);
   // Отправляем данные по изображению в базу данных
   MakeStream($SiteHost,$Frame,$_POST['time'],$_POST['frame']);
   // Трассируем заголовки
   //ViewHeaders();
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
   //echo "out\n";
}

function ViewHeaders()
{
   foreach (getallheaders() as $name => $value) 
   {
      echo "$name: $value\n";
   }
}

// <!-- --> ********************************************** Stream40BODY.php ***
