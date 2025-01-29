<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                       *** UpStateBODY.php ***

// ****************************************************************************
// * State                               Зарегистрировать изменения состояний *
// *                                        контроллеров и показаний датчиков *
// ****************************************************************************

// v2.0.4, 29.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2023 tve                               Дата создания: 07.01.2025

// ------------------------------------------------------------------- BODY ---

// Рабочий запрос: http://localhost:100/State/?cycle=195&sjson={"led33":[{"status":"inLOW"}]}
// Рабочий запрос: http://localhost:100/State/?cycle=195&sjson={"led33":[{"status":"inHIGH"}]}

// Реестр json-сообщений на страницу State
define ('s33_HIGH',  '{"led33":[{"status":"inHIGH"}]}');  // "контрольный светодиод включен"
define ('s33_LOW',   '{"led33":[{"status":"inLOW"}]}');   // "контрольный светодиод ВЫКЛЮЧЕН"
define ('s33_MODE0', '{"led33":[{"regim":0}]}');          // "режим контрольного светодиода выключен"


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

if ($sjson==s33_HIGH)
{
   echo s33_HIGH;
}
else if ($sjson==s33_LOW)
{
   echo s33_LOW;
}
else if ($sjson==s33_MODE0)
{
   echo s33_MODE0;
}


/*
$table=SelectLed33($pdo);
echo 'myTime: '.$table['myTime'].'<br>'; 
echo 'myDate: '.$table['myDate'].'<br>'; 
echo 'cycle: ' .$table['cycle']. '<br>'; 
echo 'sjson: ' .$table['sjson']. '<br>'; 
*/

// <!-- --> *********************************************** UpStateBODY.php ***
