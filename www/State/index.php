<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * State                               Зарегистрировать изменения состояний *
// *                                           устройств и показаний датчиков *
// ****************************************************************************

// v4.5.5, 16.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// 2025-09-04 json-сообщения передаются через параметры запросов и записываются 
//            в базу данных в полном виде (с фигурными скобками в начале и в 
//            завершении json-сообщения)


// Реестр образцов(типов) json-сообщений на State:
// 3 -> s_DHT11,    '{"dht11":{"humi":46,"tempC":248}}'                           // Влажность = 46%, Температура = 24.8°C  
// 4 -> s_GPXwpt,   '{"wpt":{"lat":52518611,"lon":13376111}}'                     // Координаты путевой точки: широта 52.518611, долгота 13.376111
// 5 -> s_GPXtrkpt, '{"trkpt":{"lat":52518611,"lon":13376111}}'                   // Координаты точки трека: широта 52.518611, долгота 13.376111

// Примеры запросов к State от контроллеров:
// --------------------------------------- Путевая точка от Sim900 в автомобиле
// https://probatv.ru/State/?cycle=2&num=4&ctrl=203&sjson={"wpt":{"lat":52518611,"lon":13376111}}   - путевая точка от Sim900 в автомобиле
// https://probatv.ru/State/?cycle=2&num=5&ctrl=204&sjson={"trkpt":{"lat":52518611,"lon":13376111}} - точка трека от виртуального контроллера
// ---------------------------------------------------------------------------- 
// https://probatv.ru/State/?cycle=2&num=-1&ctrl=201&sjson={"intrv":{"mode4":7007,"img":1001,"tempvl":3003,"lumin":2002,"bar":5005}}

// State-запрос: https://probatv.ru/State40/?cycle=2&num=-1&sjson={"led4":{"light":13,"time":2000}}
// State- ответ: <State>sjsonX={"led4":{"light":13,"time":2000}}cycleX=2</State>
// State- время: 524 (мс)

// Реестр образцов управляющих json-команд на Lead
//  0 -> s_COMMON, '"common":0'                                                               // запрос изменений
// -1 -> s_MODE4,  '"led4":{"light":10,"time":2000}'                                          // режим работы вспышки
// -2 -> s_INTRV,  '"intrv":{"mode4":7007,"img":1001,"tempvl":3003,"lumin":2002,"bar":5005}'  // интервалы подачи сообщений от контроллера

// Подключаем реестр json-сообщений на страницу State40
require_once "../iniWorkSpace.php";  
// Подключаем объект для работы с базой данных моего хозяйства
require_once "../TKvizzyMaker/KvizzyMakerClass.php";

$SiteRoot=$_SERVER['DOCUMENT_ROOT'];  // Корневой каталог сайта
$SiteAbove=Above($SiteRoot);          // Надсайтовый каталог
$SiteHost=Above($SiteAbove);          // Каталог хостинга

// Разбираем параметры запроса
echo "<State>";
// Выбираем поступившие параметры
$sjson=getComRequest('sjson');
if ($sjson==NULL) echo '{"exit":100}';
else
{
  $cycle=getComRequest('cycle');
  if ($cycle==NULL) echo '{"exit":200}';
  else
  {
    $num=getComRequest('num');
    if ($num==NULL) echo '{"exit":300}';
    else
    {
      // Обрабатываем параметры запроса и
      // возвращаем исходное json-сообщение или ошибочное
      echo StateAnswer($SiteHost,$sjson,$cycle,$num);
    }
  }
}
echo "</State>";

// ****************************************************************************
// * Обработать параметры запроса и вернуть исходное json-сообщение или ошибочное                   
// ****************************************************************************
function StateAnswer($SiteHost,$sjson,$cycle,$num)
{
  $Result=$sjson;
  // Подключаем объект для работы с базой данных моего хозяйства
  $Kvizzy=new ttools\KvizzyMaker($SiteHost);
  // Подключаемся к базе данных
  $pdo=$Kvizzy->BaseConnect();
  // Обновляем последнее сообщение в базе данных
  $myTime = time();
  $myDate = date("y-m-d H:i:s");
  $Kvizzy->UpdateLastMess($pdo,$myTime,$myDate,$cycle,$sjson);
  // Определяем контроллер
  $idctrl=getComRequest('ctrl');
  if ($idctrl==NULL) $Result='{"exit":400}';
  else
  {
    $messa=$Kvizzy->UpdateNumCtrl($pdo,$idctrl,$num,$sjson); 
    if ($messa!='Ok') $Result='{"exit":401}';
  }
  return $Result;
}

/*
function StateAnswer($SiteHost)
{

   // Если пришло подтверждение режима работы вспышки
   if (getComRequest('num')==-1)   
   {
      // Подключаем объект для работы с базой данных моего хозяйства
      $Kvizzy=new ttools\KvizzyMaker($SiteHost);
      // Подключаемся к базе данных
      $pdo=$Kvizzy->BaseConnect();
      echo $Kvizzy->TestSet($pdo,getComRequest('sjson'),-1); 
   }
   // Иначе пустой ответ
   else echo '{"exit":1}';
   
   / *
   // Если поступил запрос по наличию изменений управляющих json-команд:
   // https://probatv.ru/Lead40/?cycle=3&sjson={"common":0}
   // http://localhost:100/Lead40/?cycle=3&sjson={"common":0}
   if (getComRequest('sjson')=='{"common":0}')
   {
      // Запрашиваем изменения и формируем json-ответ контроллеру
      $table=$Kvizzy->SelChange($pdo);
      // Трассируем, при необходимости, таблицу
      // echo '<pre>'; print_r($table); echo '</pre>';
      $sjson=''; $first=true;
      // Вначале склеиваем все управляющие json-команды
      foreach ($table as $row) 
      {
         // 'num' - номер управляющей json-команды (-1 -> s4_MODE,-2 -> s_INTRV)
         if ($row['num']<0) 
         {
            if ($first) 
            {
               $sjson=$sjson.$row['sjson'];
               $first=false;
            }
            else
            {
               $sjson=$sjson.','.$row['sjson'];
            }
         }
      } 
      // Далее, если были команды формируем json-ответ контроллеру
      if (strlen($sjson)>0)
      {
         $sjson='{'.$sjson.'}';
      }
      // Иначе пустой ответ
      else $sjson='{"exit":1}';
      // Возвращаем результат
      // {"led4":{"light":25,"time":1996},"intrv":{"mode4":6900,"img":1001,"tempvl":3003,"lumin":2002,"bar":5005}}
      echo $sjson;
   }
   else echo '{"exit":2}';
   * /
   
   / *
   // Подтверждаем изменение и отмечаем текущий режим работы вспышки
   // https://probatv.ru/Lead40/?cycle=-1&sjson={"led4":{"light":10,"time":2000}}
   // http://localhost:100/Lead40/?cycle=-1&sjson={"led4":{"light":10,"time":2000}}
   else if (getComRequest('cycle')==-1)   
   {
      echo '-1='.$Kvizzy->TestSet($pdo,getComRequest('sjson'),-1); 
   }
   else if (getComRequest('cycle')==-2)   
   {
      echo '-2: '.getComRequest('sjson');   
   }
   else
   {
      echo '-3: '.getComRequest('sjson');   
   }

   //$isEvent=$table['isEvent']; 
   //$sjson=$table['sjson'];
   //if ($isEvent<0) echo '<p>{}</p>';
   //else echo '<p>'.$sjson.'</p>';
   * /
}
*/

// <!-- --> ***************************************************** index.php ***
