<?php
                                         
// PHP7/HTML5, EDGE/CHROME                         *** CommonLeadMaker.php ***

// ****************************************************************************
// * KwinFlat/State                    Блок общих функций класса TKvizzyMaker *
// *                             для базы данных json-сообщений страницы Lead *
// *                                                                          *
// * v2.0.2, 04.05.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  20.01.2025 *
// ****************************************************************************

// _CreateLeadTables($pdo);                  - Создать таблицу базы данных Lead
// _SelChange($pdo)                          - Выбрать изменения состояний управляющих команд  
// _setMessForLead($pdo,$num,$sjson);        - Записать в базу данных изменения состояния управляющих json-команд   
 
// ****************************************************************************
// *                       Создать таблицу базы данных Lead                   *
// ****************************************************************************

// Реестр образцов управляющих json-команд
// 1-s_MODE4, '{\"led4\":[{\"light\":10,\"time\":2000}]}'                                                // режим работы вспышки
// 2-s_INTRV, '{\"intrv\":[{\"mode4\":7007,\"img\":1001,\"tempvl\":3003,\"lumin\":2002,\"bar\":5005}]}'  // интервалы подачи сообщений от контроллера

function _CreateLeadTables($pdo)
{
   // Создаём таблицу состояния управляющих json-команд
   $sql='CREATE TABLE Lead ('.
      'num        INTEGER,'.    // номер управляющей json-команды (1-s4_MODE,2-s_INTRV)
      'isEvent    INTEGER,'.    // 1 - изменилось состояние json-команды, 0 - пришло подтверждение от контроллера
      'SendTime   INTEGER,'.    // время в секундах (c начала эпохи) изменения состояния
      'ReceivTime INTEGER,'.    // время получения подтверждения в секундах
      'sjson      VARCHAR)';    // текущее состояние управляющей json-команды
   $st = $pdo->query($sql);
   // Добавляем начальную запись режима работы вспышки
   $statement = $pdo->prepare("INSERT INTO [Lead] ".
      "([num],[isEvent],[SendTime],[ReceivTime],[sjson]) VALUES ".
      "(:num, :isEvent, :SendTime, :ReceivTime, :sjson);");
   $statement->execute([
      "num"        => 1,
      "isEvent"    => 0,
      "SendTime"   => time(),
      "ReceivTime" => time(),
      "sjson"      => '{\"led4\":[{\"light\":10,\"time\":2000}]}',
   ]);
   // Добавляем начальную запись интервалов подачи сообщений от контроллера
   $statement = $pdo->prepare("INSERT INTO [Lead] ".
      "([num],[isEvent],[SendTime],[ReceivTime],[sjson]) VALUES ".
      "(:num, :isEvent, :SendTime, :ReceivTime, :sjson);");
   $statement->execute([
      "num"        => 2,
      "isEvent"    => 0,
      "SendTime"   => time(),
      "ReceivTime" => time(),
      "sjson"      => '{\"intrv\":[{\"mode4\":7007,\"img\":1001,\"tempvl\":3003,\"lumin\":2002,\"bar\":5005}]}',
   ]);
}
// ****************************************************************************
// *     Записать в базу данных изменения состояния управляющих json-команд   *
// ****************************************************************************
function _setMessForLead($pdo,$num,$sjson)
{
   define ("nstOk", 'все в порядке'); 
   $messa="UPDATE [Lead] SET [isEvent]=:isEvent, [SendTime]=:SendTime, [ReceivTime]=:ReceivTime, [sjson]=:sjson WHERE [num]=:num";
   try 
   {
      $pdo->beginTransaction();
      
      $statement = $pdo->prepare($messa);
      $statement->execute([
         "num"        => $num,
         "isEvent"    => 1,
         "SendTime"   => time(),
         "ReceivTime" => time(),
         "sjson"      => $sjson
      ]);
      $pdo->commit();
      $messa=nstOk; 
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $messa;
}
/*
// ****************************************************************************
// *         Выбрать запись режима работы светодиода Led4      *
// ****************************************************************************
function _SelectLMP33($pdo)
{
   try 
   {
      $pdo->beginTransaction();
      $cSQL='SELECT isEvent,Mode,SendTime,ReceivTime,sjson FROM Lmp33';
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      if (count($table)>0) $table=[
         "isEvent"=>$table[0]['isEvent'],"Mode"=>$table[0]['Mode'],
         "SendTime" =>$table[0]['SendTime'], "ReceivTime" =>$table[0]['ReceivTime'], "sjson" =>$table[0]['sjson']];
      else $table=[
         "isEvent"=>-2, "Mode"=> -2,
         "SendTime"=>time(), "ReceivTime"=> time(),
         "sjson" => 'sjson3'];
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      $table=[
         "isEvent"=>-3, "Mode"=> -3,
         "SendTime"=>time(), "ReceivTime"=> time(),
         "sjson" => $messa];
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $table;
}
// ****************************************************************************
// *        Обновить установку по режиму работы контрольного светодиода       *
// ****************************************************************************
function _UpdateModeLMP33($pdo,$action)
{
   define ("nstOk",        'все в порядке'); 

   // $action=3 - прошла команда смены режима, включить режим
   // $action=2 - прошла команда смены режима, выключить режим
   // $action=1 - пришло подтверждение от контроллера, включить режим
   // $action=0 - пришло подтверждение от контроллера, выключить режим

   // $isEvent - 1 - прошла команда смены режима, 0 - пришло подтверждение от контроллера
   // $sjson [1 - включить режим, 0 - выключить режим]: 
   // {"led4":[{"regim":1}]} - включить режим;  {"led4":[{"regim":0}]} - выключить режим; 

   if ($action==3) {$isEvent=1; $sjson='{"led4":[{"regim":1}]}';}
   else if ($action==2) {$isEvent=1; $sjson='{"led4":[{"regim":0}]}';}
   else if ($action==1) {$isEvent=0; $sjson='{"led4":[{"regim":1}]}';}
   else {$isEvent=0; $sjson='{"led4":[{"regim":0}]}';};
   
   try 
   {
      $pdo->beginTransaction();
      $statement = $pdo->prepare("UPDATE [Lmp33] ".
         "SET [isEvent]=:isEvent, [sjson]=:sjson;");
      $statement->execute([
         "isEvent" => $isEvent,
         "sjson"  => $sjson
      ]);
      $pdo->commit();
      $messa=nstOk; 
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $messa;
}
*/

// ****************************************************************************
// *             Выбрать изменения состояний управляющих команд               *
// ****************************************************************************
function _SelChange($pdo)
{
   try 
   {
      $pdo->beginTransaction();
      $cSQL='SELECT num,isEvent,SendTime,ReceivTime,sjson FROM Lead WHERE isEvent=1';
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      if (count($table)<1) 
      $table=[
         "isEvent"=>-2, "num"=> -2,
         "SendTime"=>time(), "ReceivTime"=> time(),
         "sjson" => ' '];
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      $table=[
         "isEvent"=>-3, "num"=> -3,
         "SendTime"=>time(), "ReceivTime"=> time(),
         "sjson" => $messa];
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $table;
}

// *************************************************** CommonLeadMaker.php ***

