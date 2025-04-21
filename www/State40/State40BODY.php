<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                       *** State40BODY.php ***

// ****************************************************************************
// * State                               Зарегистрировать изменения состояний *
// *                                        контроллеров и показаний датчиков *
// ****************************************************************************

// v2.0.4, 29.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2023 tve                               Дата создания: 07.01.2025

// ------------------------------------------------------------------- BODY ---

/*
sla6en9edged
browscap=/home/kwinflatht/browscap.ini
browscap=/home/u542632/browscap.ini
*/

// Реестр json-сообщений на страницу State
define ('s4_HIGH',  '{\"led4\":[{\"status\":\"inHIGH\"}]}');  // "вспышка включена"
define ('s4_LOW',   '{\"led4\":[{\"status\":\"inLOW\"}]}');   // "вспышка ВЫКЛЮЧЕНА"
define ('s4_MODE0', '{\"led4\":[{\"regim\":0}]}');            // "режим работы вспышки отключен"

// Рабочий запрос: http://localhost:100/State40/?cycle=1095&sjson={"led4":[{"status":"shimLOW"}]}
// Рабочий запрос: http://localhost:100/State40/?cycle=1095&sjson={"led4":[{"status":"shimHIGH"}]}

// Рабочий запрос: https://probatv.ru/State40/?cycle=1095&sjson={"led4":[{"status":"shimLOW"}]}
// Рабочий запрос: https://probatv.ru/State40/?cycle=1095&sjson={"led4":[{"status":"shimHIGH"}]}

$cycle=prown\getComRequest("cycle");
if ($cycle==NULL) $cycle=-1;
$sjson=prown\getComRequest("sjson");
if ($sjson==NULL) $sjson='{\"led4\":[{\"status\":\"Noparm\"}]}';
// Подключаем объект для работы с базой данных моего хозяйства
require_once "../Common.php";  
require_once "../TKvizzyMaker/KvizzyMakerClass.php";
$Kvizzy=new ttools\KvizzyMaker($SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();

$myTime = time();
$myDate = date("y-m-d H:i:s");

$Kvizzy->UpdateLed4($pdo,$myTime,$myDate,$cycle,$sjson);
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

// <!-- --> *********************************************** UpStateBODY.php ***
