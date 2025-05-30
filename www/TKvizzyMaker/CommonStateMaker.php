<?php
                                         
// PHP7/HTML5, EDGE/CHROME                         *** CommonStateMaker.php ***

// ****************************************************************************
// * KwinFlat/State                    Блок общих функций класса TKvizzyMaker *
// *                          для базы данных json-сообщений страницы State40 *
// *                                                                          *
// * v4.4.0, 30.05.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  07.01.2025 *
// ****************************************************************************

// _CreateStateTables($pdo);                             - Создать таблицы базы данных State
// _SelectLastMess($pdo);                                - Выбрать запись из таблицы последнего полученного json-сообщения  
// _UpdateLastMess($pdo,$myTime,$myDate,$cycle,$sjson);  - Обновить запись в таблице последнего полученного json-сообщения  

 
// ****************************************************************************
// *                       Создать таблицы базы данных State                  *
// ****************************************************************************
function _CreateStateTables($pdo)
{
   // Создаём таблицу последнего полученного json-сообщения на State
   $sql='CREATE TABLE LastMess ('.
      'myTime    INTEGER PRIMARY KEY NOT NULL UNIQUE,'.  // абсолютное время в секундах с начала эпохи UNIX
      'myDate    VARCHAR NOT NULL UNIQUE,'.              // date("y-m-d h:i:s");
      'cycle     INTEGER NOT NULL,'.                     // цикл выдачи контроллером json-сообщения
      'sjson     VARCHAR NOT NULL)';                     // json-сообщение
   $st = $pdo->query($sql);
   // Добавляем первую и единственную запись по Led4
   $statement = $pdo->prepare("INSERT INTO [LastMess] ".
      "([myTime],[myDate],[cycle],[sjson]) VALUES ".
      "(:myTime, :myDate, :cycle, :sjson);");
   $statement->execute([
      "myTime" => time(),
      "myDate" => date("y-m-d H:i:s"),
      "cycle"  => -1,
      "sjson"  => '{"led4":{"light":10,"time":2000}}',
   ]);
}
// ****************************************************************************
// *      Выбрать запись из таблицы последнего полученного json-сообщения     *
// ****************************************************************************
function _SelectLastMess($pdo)
{
   try 
   {
      $pdo->beginTransaction();
      $cSQL='SELECT myTime,myDate,cycle,sjson FROM LastMess';
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
// *      Обновить запись в таблице последнего полученного json-сообщения     *
// ****************************************************************************
function _UpdateLastMess($pdo,$myTime,$myDate,$cycle,$sjson)
{
   try 
   {
      $pdo->beginTransaction();
      $statement = $pdo->prepare("UPDATE [LastMess] ".
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

