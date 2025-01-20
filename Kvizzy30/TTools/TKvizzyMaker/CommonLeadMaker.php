<?php
                                         
// PHP7/HTML5, EDGE/CHROME                         *** CommonLeadMaker.php ***

// ****************************************************************************
// * KwinFlat/State                    Блок общих функций класса TKvizzyMaker *
// *                             для базы данных json-сообщений страницы Lead *
// *                                                                          *
// * v1.0.0, 20.01.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  20.01.2025 *
// ****************************************************************************

// _CreateLeadTables($pdo);                  - Создать таблицу базы данных Lead
 
// ****************************************************************************
// *                       Создать таблицу базы данных Lead                   *
// ****************************************************************************
function _CreateLeadTables($pdo)
{
   // Создаём таблицу включения/выключения режима работы контрольного светодиода Led33
   $sql='CREATE TABLE Lmp33 ('.
      'isEvent    INTEGER,'.    // 1 - произошла смена режима, 0 - пришло подтверждение от контроллера
      'Mode       INTEGER,'.    // команда: 1 - включить режим, 0 - выключить
      'SendTime   INTEGER,'.    // время в секундах (c начала эпохи) отправки сообщения
      'ReceivTime INTEGER,'.    // время получения ответа в секундах
      'sjson      VARCHAR)';    // {"led33":[{"regim":0}]} - выключить режим; {"led33":[{"regim":1}]} - включить
   $st = $pdo->query($sql);
   // Добавляем первую и единственную запись Lmp33
   $statement = $pdo->prepare("INSERT INTO [Lmp33] ".
      "([isEvent],[Mode],[SendTime],[ReceivTime],[sjson]) VALUES ".
      "(:isEvent, :Mode, :SendTime, :ReceivTime, :sjson);");
   $statement->execute([
      "isEvent"    => 0,
      "Mode"       => 1,
      "SendTime"   => time(),
      "ReceivTime" => time(),
      "sjson"      => '{"led33":[{"regim":1}]}',
   ]);
   // Создаём таблицу длительность цикла "горит - не горит" (мсек) контрольного светодиода Led33
   $sql='CREATE TABLE Time33 ('.
      'isEvent    INTEGER,'.    // 1 - отправлена команда смены длительности, 0 - пришло подтверждение от контроллера
      'Time       INTEGER,'.    // новая длительность цикла "горит - не горит" (мсек)
      'SendTime   INTEGER,'.    // время в секундах (c начала эпохи) отправки сообщения
      'ReceivTime INTEGER,'.    // время получения ответа в секундах
      'sjson      VARCHAR)';    // {"led33":[{"time":1007}]}
   $st = $pdo->query($sql);
   // Добавляем первую и единственную запись Time33
   $statement = $pdo->prepare("INSERT INTO [Time33] ".
      "([isEvent],[Time],[SendTime],[ReceivTime],[sjson]) VALUES ".
      "(:isEvent, :Time, :SendTime, :ReceivTime, :sjson);");
   $statement->execute([
      "isEvent"    => 0,
      "Time"       => 1007,
      "SendTime"   => time(),
      "ReceivTime" => time(),
      "sjson"      => '{"led33":[{"time":1007}]}',
   ]);
   // Создаём таблицу процента времени свечения в цикле контрольного светодиода Led33
   $sql='CREATE TABLE Light33 ('.
      'isEvent    INTEGER,'.    // 1 - отправлена команда по времени свечения в цикле, 0 - пришло подтверждение от контроллера
      'Light      INTEGER,'.    // новая длительность цикла "горит - не горит" (мсек)
      'SendTime   INTEGER,'.    // время в секундах (c начала эпохи) отправки сообщения
      'ReceivTime INTEGER,'.    // время получения ответа в секундах
      'sjson      VARCHAR)';    // {"led33":[{"light":10}]}
   $st = $pdo->query($sql);
   // Добавляем первую и единственную запись Light33
   $statement = $pdo->prepare("INSERT INTO [Light33] ".
      "([isEvent],[Light],[SendTime],[ReceivTime],[sjson]) VALUES ".
      "(:isEvent, :Light, :SendTime, :ReceivTime, :sjson);");
   $statement->execute([
      "isEvent"    => 0,
      "Light"      => 10,
      "SendTime"   => time(),
      "ReceivTime" => time(),
      "sjson"      => '{"led33":[{"light":10}]}',
   ]);
}
// ****************************************************************************
// *         Выбрать запись режима работы контрольного светодиода Led33       *
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

// *************************************************** CommonLeadMaker.php ***

