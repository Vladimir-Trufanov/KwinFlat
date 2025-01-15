<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                       *** UpStateBODY.php ***

// ****************************************************************************
// * State                               Зарегистрировать изменения состояний *
// *                                        контроллеров и показаний датчиков *
// ****************************************************************************

// v2.0.2, 07.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2023 tve                               Дата создания: 07.01.2025

// ------------------------------------------------------------------- BODY ---
$cycle=prown\getComRequest("cycle");
if ($cycle==NULL) $cycle=-1;
//echo "cycle=".$cycle.'<br>';
$sjson=prown\getComRequest("sjson");
if ($sjson==NULL) $sjson='{\"led33\":[{\"status\":\"Noparm\"}]}';
//echo "sjson=".$sjson.'<br>';

$pdo=StateConnect($SiteHost);
$myTime = time();
$myDate = date("y-m-d h:i:s");
//echo $myTime.' '; 
//echo $myDate; 

//CreateStateTables($pdo);
UpdateLed33($pdo,$myTime,$myDate,$cycle,$sjson);

$table=SelectLed33($pdo);
echo 'myTime: '.$table['myTime'].'<br>'; 
echo 'myDate: '.$table['myDate'].'<br>'; 
echo 'cycle: ' .$table['cycle']. '<br>'; 
echo 'sjson: ' .$table['sjson']. '<br>'; 

// <!-- --> *********************************************** UpStateBODY.php ***
