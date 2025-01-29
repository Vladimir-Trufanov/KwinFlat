<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                       *** UpStateBODY.php ***

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

// Рабочий запрос: http://localhost:100/State/?cycle=195&sjson={"led33":[{"status":"inLOW"}]}
// Рабочий запрос: http://localhost:100/State/?cycle=195&sjson={"led33":[{"status":"inHIGH"}]}

$cycle=prown\getComRequest("cycle");
if ($cycle==NULL) $cycle=-1;
$sjson=prown\getComRequest("sjson");
if ($sjson==NULL) $sjson='{\"led33\":[{\"status\":\"Noparm\"}]}';
// Подключаем объект для работы с базой данных моего хозяйства
require_once "../Common.php";  
require_once "../TTools/TKvizzyMaker/KvizzyMakerClass.php";
$Kvizzy=new ttools\KvizzyMaker($SiteHost);
// Подключаемся к базе данных
$pdo=$Kvizzy->BaseConnect();

$myTime = time();
$myDate = date("y-m-d H:i:s");

$Kvizzy->UpdateLed33($pdo,$myTime,$myDate,$cycle,$sjson);
// Если сообщение "контрольный светодиод включен"
if ($sjson==stripslashes(s33_HIGH))
{
   echo s33_HIGH;
}
// Если сообщение "контрольный светодиод ВЫКЛЮЧЕН"
else if ($sjson==stripslashes(s33_LOW))
{
   echo s33_LOW;
}
// Если сообщение "режим контрольного светодиода выключен"
else if ($sjson==stripslashes(s33_MODE0))
{
   echo s33_MODE0;
   //$action=0;   // пришло подтверждение от контроллера, выключить режим   
   //$messa=$Kvizzy->UpdateModeLMP33($pdo,$action);
}

// <!-- --> *********************************************** UpStateBODY.php ***
