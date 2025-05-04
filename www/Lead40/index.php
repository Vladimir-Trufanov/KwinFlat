<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * State40                             Зарегистрировать изменения состояний *
// *                                           устройств и показаний датчиков *
// ****************************************************************************

// v3.0.1, 24.04.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// Подключаем реестр json-сообщений на страницу State40
require_once "../iniWorkSpace.php";  
// Подключаем объект для работы с базой данных моего хозяйства
require_once "../TKvizzyMaker/KvizzyMakerClass.php";

$SiteRoot=$_SERVER['DOCUMENT_ROOT'];  // Корневой каталог сайта
$SiteAbove=Above($SiteRoot);          // Надсайтовый каталог
$SiteHost=Above($SiteAbove);          // Каталог хостинга

// Разбираем параметры запроса, запускаем общую оболочку и страницы сайта

echo "<Lead>";
   MakeAnswer($SiteHost);
echo "</Lead>";

function MakeAnswer($SiteHost)
{
   // Подключаем объект для работы с базой данных моего хозяйства
   /*
   $Kvizzy=new ttools\KvizzyMaker($SiteHost);
   // Подключаемся к базе данных
   $pdo=$Kvizzy->BaseConnect();
   // Выбираем параметры ответа
   $table=$Kvizzy->SelChange($pdo);
   $isEvent=$table['isEvent']; 
   $sjson=$table['sjson'];
   if ($isEvent<0) echo '<p>{}</p>';
   else echo '<p>'.$sjson.'</p>';
   */
   echo 'Привет из Lead';
}

// <!-- --> ***************************************************** index.php ***
