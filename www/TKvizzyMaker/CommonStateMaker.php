<?php
                                         
// PHP7/HTML5, EDGE/CHROME                         *** CommonStateMaker.php ***

// ****************************************************************************
// * KwinFlat/State                    Блок общих функций класса TKvizzyMaker *
// *                          для базы данных json-сообщений страницы State40 *
// *                                                                          *
// * v4.4.3, 05.06.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  07.01.2025 *
// ****************************************************************************

// _CreateStateTables($pdo);                             - Создать таблицы базы данных State
// _SelectLastMess($pdo);                                - Выбрать запись из таблицы последнего полученного json-сообщения  
// _UpdateLastMess($pdo,$myTime,$myDate,$cycle,$sjson);  - Обновить запись в таблице последнего полученного json-сообщения  
// _SelState($pdo);                                      - Выбрать управляющие значения экрана и показания датчиков
// _setStateElem($pdo,$Name,$Value);                     - Записать в базу данных изменение управляющего элемента изображения 
 
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
   // Добавляем первую и единственную запись
   $statement = $pdo->prepare("INSERT INTO [LastMess] ".
      "([myTime],[myDate],[cycle],[sjson]) VALUES ".
      "(:myTime, :myDate, :cycle, :sjson);");
   $statement->execute([
      "myTime" => time(),
      "myDate" => date("y-m-d H:i:s"),
      "cycle"  => -1,
      "sjson"  => '{"led4":{"light":10,"time":2000}}',
   ]);
   
   // Создаём таблицу значений элементов
   $sql='CREATE TABLE State ('.
      'jlight    INTEGER NOT NULL,'.                    // процент времени свечения в цикле 
      'jtime     INTEGER NOT NULL,'.                    // длительность цикла "горит - не горит" (мсек)    
      'jevent    INTEGER NOT NULL,'.                    // 1 - изменилось состояние по Led4, 0 - пришло подтверждение от контроллера  
      'jmode4    INTEGER NOT NULL,'.                    // интервал сообщений по режиму работы Led4 
      'jimg      INTEGER NOT NULL,'.                    // интервал подачи изображения
      'jtempvl   INTEGER NOT NULL,'.                    // интервал сообщений о температуре и влажности
      'jlumin    INTEGER NOT NULL,'.                    // интервал сообщений об освещённости камеры
      'jbar      INTEGER NOT NULL,'.                    // интервал сообщений по атмосферному давлению
      'myTime    INTEGER NOT NULL UNIQUE)';             // абсолютное время в секундах с начала эпохи UNIX
   $st = $pdo->query($sql);
   // Добавляем первую и единственную запись
   $statement = $pdo->prepare("INSERT INTO [State] ".
      "([jlight],[jtime],[jevent],[jmode4],[jimg],[jtempvl],[jlumin],[jbar],[myTime]) VALUES ".
      "(:jlight, :jtime, :jevent, :jmode4, :jimg, :jtempvl, :jlumin, :jbar, :myTime);");
   $statement->execute([
      "jlight"  => 10,
      "jtime"   => 2000,
      "jevent"  => 0,
      "jmode4"  => 7007,
      "jimg"    => 1001,
      "jtempvl" => 3003,
      "jlumin"  => 2002,
      "jbar"    => 5005,
      "myTime"  => time(),
   ]);
}
// ****************************************************************************
// *         Выбрать управляющие значения экрана и показания датчиков         *
// ****************************************************************************
function _SelState($pdo)
{
   try 
   {
      $pdo->beginTransaction();
      $cSQL='SELECT jlight,jtime,jevent,jmode4,jimg,jtempvl,jlumin,jbar,myTime FROM State';
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      if (count($table)<1) 
      $table=array([
         "jlight"=>-2, 
         "myTime"=> time(),
         "jmode4" => 'Не выбралось управляющее выражение!']);
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      $table=array([
         "jlight"=>-3, 
         "myTime"=> time(),
         "jmode4" => $messa]);
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $table;
}
// ****************************************************************************
// *    Записать в базу данных изменение управляющего элемента изображения    *
// ****************************************************************************
function _setStateElem($pdo,$Name,$Value)
{
   //$Name="jlight";
   //$Value=13;
   try 
   {
      $pdo->beginTransaction();
      $cSQL='UPDATE [State] SET ['.$Name.']='.$Value;
      $stmt = $pdo->query($cSQL);
      $pdo->commit();
      $messa='все в порядке'; 
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $messa;
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

// *************************************************** CommonStateMaker.php ***

