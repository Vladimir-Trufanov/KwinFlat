<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * State40                             Зарегистрировать изменения состояний *
// *                                           устройств и показаний датчиков *
// ****************************************************************************

// v3.1.0, 04.05.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// Реестр образцов управляющих json-команд
// 0-s_COMMON, '{\"common\":0}'                                                                           // запрос изменений
// 1-s_MODE4,  '{\"led4\":[{\"light\":10,\"time\":2000}]}'                                                // режим работы вспышки
// 2-s_INTRV,  '{\"intrv\":[{\"mode4\":7007,\"img\":1001,\"tempvl\":3003,\"lumin\":2002,\"bar\":5005}]}'  // интервалы подачи сообщений от контроллера

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
   $Kvizzy=new ttools\KvizzyMaker($SiteHost);
   // Подключаемся к базе данных
   $pdo=$Kvizzy->BaseConnect();
   // Выбираем параметры ответа
   $table=$Kvizzy->SelChange($pdo);
   
   // Если возможно, определяем cтроку запроса, по которому была открыта страница
   if (IsSet($_SERVER['QUERY_STRING'])) $QueryString=$_SERVER['QUERY_STRING'];
   else $QueryString='QueryStringNoExist';

   echo $QueryString."<br>";
   echo 'Количество выбранных записей: '.count($table);

   //$isEvent=$table['isEvent']; 
   //$sjson=$table['sjson'];
   //if ($isEvent<0) echo '<p>{}</p>';
   //else echo '<p>'.$sjson.'</p>';
}

// <!-- --> ***************************************************** index.php ***
