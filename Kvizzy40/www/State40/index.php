<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * State40                             Зарегистрировать изменения состояний *
// *                                           устройств и показаний датчиков *
// ****************************************************************************

// v3.1.0, 04.05.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// Подключаем блок общесайтовых функций
require_once "../iniWorkSpace.php";  
// Подключаем объект для работы с базой данных моего хозяйства
require_once "../TKvizzyMaker/KvizzyMakerClass.php";

$SiteRoot=$_SERVER['DOCUMENT_ROOT'];  // Корневой каталог сайта
$SiteAbove=Above($SiteRoot);          // Надсайтовый каталог
$SiteHost=Above($SiteAbove);          // Каталог хостинга

// Разбираем параметры запроса, запускаем общую оболочку и страницы сайта
echo '<State>'; 

// Рабочий запрос: http://localhost:100/State40/?cycle=1095&sjson={"led4":[{"status":"shimLOW"}]}
// Рабочий запрос: http://localhost:100/State40/?cycle=1095&sjson={"led4":[{"status":"shimHIGH"}]}

// Рабочий запрос: https://probatv.ru/State40/?cycle=1095&sjson={"led4":[{"status":"shimLOW"}]}
// Рабочий запрос: https://probatv.ru/State40/?cycle=1095&sjson={"led4":[{"status":"shimHIGH"}]}

$cycle=getComRequest("cycle");
if ($cycle==NULL) $cycle=-1;
$sjson=getComRequest("sjson");
if ($sjson==NULL) $sjson='{\"led4\":[{\"status\":\"Noparm\"}]}';
$Kvizzy=new ttools\KvizzyMaker($SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();

$myTime = time();
$myDate = date("y-m-d H:i:s");

$Kvizzy->UpdateLed4($pdo,$myTime,$myDate,$cycle,$sjson);
echo $sjson;
/*
// Если сообщение "вспышка включена"
if ($sjson==stripslashes(s4_HIGH))
{
   echo s4_HIGH;
}
// Если сообщение "вспышка ВЫКЛЮЧЕНА"
else if ($sjson==stripslashes(s4_LOW))
{
   echo s4_LOW;
}
// Иначе "режим работы вспышки отключен"
else 
{
   echo s4_MODE0;
   //$action=0;   // пришло подтверждение от контроллера, выключить режим   
   //$messa=$Kvizzy->UpdateModeLMP33($pdo,$action);
}
*/
echo '</State>'; 

// <!-- --> ***************************************************** index.php ***
