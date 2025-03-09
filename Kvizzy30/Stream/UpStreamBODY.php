<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                      *** UpStreamBODY.php ***

// ****************************************************************************
// * Stream                  Принять и записать в базу видеопоток изображений *
// ****************************************************************************

// v1.0.0, 09.03.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 09.03.2025

// ------------------------------------------------------------------- BODY ---

echo "<body>";
   MakeStream($SiteHost);
echo "</body>";

function MakeStream($SiteHost)
{
   // Подключаем объект для работы с базой данных моего хозяйства
   require_once "../Common.php";  
   require_once "../TTools/TKvizzyMaker/KvizzyMakerClass.php";
   $Kvizzy=new ttools\KvizzyMaker($SiteHost);
   // Подключаемся к базе данных
   $pdo=$Kvizzy->BaseConnect();
   // Выбираем параметры ответа
   //$table=$Kvizzy->SelChange($pdo);
   //$isEvent=$table['isEvent']; 
   //$sjson=$table['sjson'];
   //if ($isEvent<0) echo '<p>{}</p>';
   //else echo '<p>'.$sjson.'</p>';
   echo 'Привет из Stream';
}

// <!-- --> ********************************************** UpStreamBODY.php ***
