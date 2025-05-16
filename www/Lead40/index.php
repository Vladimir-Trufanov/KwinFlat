<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                             *** index.php ***

// ****************************************************************************
// * Lead40                      Обработать изменения управляющих json-команд *
// ****************************************************************************

// v3.1.1, 07.05.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// https://probatv.ru/Lead40/?cycle=3&sjson={"common":0}

// Реестр образцов управляющих json-команд
// 0-s_COMMON, '"common":0'                                                               // запрос изменений
// 1-s_MODE4,  '"led4":{"light":10,"time":2000}'                                          // режим работы вспышки
// 2-s_INTRV,  '"intrv":{"mode4":7007,"img":1001,"tempvl":3003,"lumin":2002,"bar":5005}'  // интервалы подачи сообщений от контроллера

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
   // Трассируем поступающий json
   // echo('sjsonX='.getComRequest('sjson'));
   // echo('cycleX='.getComRequest('cycle'));
   
   // Если поступил запрос по наличию изменений управляющих json-команд
   if (getComRequest('sjson')=='{"common":0}')
   {
      // Подключаем объект для работы с базой данных моего хозяйства
      $Kvizzy=new ttools\KvizzyMaker($SiteHost);
      // Подключаемся к базе данных
      $pdo=$Kvizzy->BaseConnect();
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
      else $sjson='{}';
      // Возвращаем результат
      // {"led4":{"light":25,"time":1996},"intrv":{"mode4":6900,"img":1001,"tempvl":3003,"lumin":2002,"bar":5005}}
      echo $sjson;
   }
   // Подтверждаем изменение и отмечаем текущий режим работы вспышки
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
}

// <!-- --> ***************************************************** index.php ***
