<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                        *** UpLeadBODY.php ***

// ****************************************************************************
// * Lead                                Обеспечить управление контроллерами, *
// *                                 устройствами и датчиками моего хозяйства *
// ****************************************************************************

// v2.0.1, 26.12.2024                                 Автор:      Труфанов В.Е.
// Copyright © 2023 tve                               Дата создания: 08.10.2023

// ------------------------------------------------------------------- BODY ---

echo "<Lead>";
   MakeAnswer($SiteHost);
echo "</Lead>";

function MakeAnswer($SiteHost)
{
   // Подключаем объект для работы с базой данных моего хозяйства
   require_once "../Common.php";  
   require_once "../TTools/TKvizzyMaker/KvizzyMakerClass.php";
   $Kvizzy=new ttools\KvizzyMaker($SiteHost);
   // Подключаемся к базе данных
   $pdo=$Kvizzy->BaseConnect();
   // Выбираем параметры ответа
   $table=$Kvizzy->SelChange($pdo);
   $isEvent=$table['isEvent']; 
   $sjson=$table['sjson'];
   if ($isEvent<0) echo '<p>{}</p>';
   else echo '<p>'.$sjson.'</p>';
   //echo 'Привет из Lead';
}

// <!-- --> ************************************************ UpLeadBODY.php ***
