<?php
                                         
// PHP7/HTML5, EDGE/CHROME                         *** CommonStateMaker.php ***

// ****************************************************************************
// * KwinFlat/State                    Блок общих функций класса TKvizzyMaker *
// *                          для базы данных json-сообщений страницы State40 *
// *                                                                          *
// * v2.0.0, 21.04.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  07.01.2025 *
// ****************************************************************************

// _CreateStateTables($pdo);                         - Создать таблицы базы данных State
// _SelectLed4($pdo);                                - Выбрать запись из таблицы базы данных State по Led4
// _UpdateLed4($pdo,$myTime,$myDate,$cycle,$sjson);  - Обновить запись в таблице базы данных State по Led4 
 
// ****************************************************************************
// *                       Создать таблицы базы данных State                  *
// ****************************************************************************
function _CreateStateTables($pdo)
{
   // Создаём таблицу последнего полученного состояния Led4
   $sql='CREATE TABLE Led4 ('.
      'myTime    INTEGER PRIMARY KEY NOT NULL UNIQUE,'.  // абсолютное время в секундах с начала эпохи UNIX
      'myDate    VARCHAR NOT NULL UNIQUE,'.              // date("y-m-d h:i:s");
      'cycle     INTEGER NOT NULL,'.                     // цикл выдачи контроллером json-сообщения
      'sjson     VARCHAR NOT NULL)';                     // json-сообщение
   $st = $pdo->query($sql);
   // Добавляем первую и единственную запись по Led4
   $statement = $pdo->prepare("INSERT INTO [Led4] ".
      "([myTime],[myDate],[cycle],[sjson]) VALUES ".
      "(:myTime, :myDate, :cycle, :sjson);");
   $statement->execute([
      "myTime" => time(),
      "myDate" => date("y-m-d H:i:s"),
      "cycle"  => -1,
      "sjson"  => '{"led4":{"status":"First"}}',
   ]);
}
// ****************************************************************************
// *             Выбрать запись из таблицы базы данных State по Led4          *
// ****************************************************************************
function _SelectLed4($pdo)
{
   try 
   {
      $pdo->beginTransaction();
      $cSQL='SELECT myTime,myDate,cycle,sjson FROM Led4';
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      if (count($table)>0) $table=[
         "myTime"=>$table[0]['myTime'],"myDate"=>$table[0]['myDate'],
         "cycle" =>$table[0]['cycle'], "sjson" =>$table[0]['sjson']];
      else $table=[
         "myTime"=>time(), "myDate"=> date("y-m-d h:i:s"),
         "cycle" =>-2,     "sjson" => 'sjson2'];
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      $table=[
         "myTime"=>time(), "myDate"=> date("y-m-d h:i:s"),
         "cycle" =>-3,     "sjson" => $messa];
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $table;
}
// ****************************************************************************
// *               Обновить запись в таблице базы данных State по Led4        *
// ****************************************************************************
function _UpdateLed4($pdo,$myTime,$myDate,$cycle,$sjson)
{
   try 
   {
      $pdo->beginTransaction();
      $statement = $pdo->prepare("UPDATE [Led4] ".
         "SET [myTime]=:myTime, [myDate]=:myDate, [cycle]=:cycle, [sjson]=:sjson;");
      $statement->execute([
         "myTime" => $myTime,
         "myDate" => $myDate,
         "cycle"  => $cycle,
         "sjson"  => $sjson
      ]);
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      // Если в транзакции, то делаем откат изменений
      if ($pdo->inTransaction()) 
      {
         $pdo->rollback();
      }
      // Продолжаем исключение
     throw $e;
   }
}
// ****************************************************************************
// *                  Добавить запись в таблицу базы данных State             *
// ****************************************************************************
/*
function _AddRecState($pdo,$myTime,$myDate,$cycle,$sjson)
{
   try 
   {
      $pdo->beginTransaction();
      $statement = $pdo->prepare("INSERT INTO [JsonState] ".
         "([myTime],[myDate],[cycle],[sjson]) VALUES ".
         "(:myTime, :myDate, :cycle, :sjson);");
      $statement->execute([
         "myTime" => $myTime,
         "myDate" => $myDate,
         "cycle"  => $cycle,
         "sjson"  => $sjson
      ]);
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      // Если в транзакции, то делаем откат изменений
      if ($pdo->inTransaction()) 
      {
         $pdo->rollback();
      }
      // Продолжаем исключение
     throw $e;
   }
}
*/

// *************************************************** CommonStateMaker.php ***

