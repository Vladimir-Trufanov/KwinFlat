<?php
                                         
// PHP7/HTML5, EDGE/CHROME                         *** CommonStateMaker.php ***

// ****************************************************************************
// * KwinFlat/State                    Блок общих функций класса TKvizzyMaker *
// *                            для базы данных json-сообщений страницы State *
// *                                                                          *
// * v4.4.6, 19.09.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  07.01.2025 *
// ****************************************************************************

// _CreateStateTables($pdo);                             - Создать таблицы базы данных State
// _SelectLastMess($pdo);                                - Выбрать запись из таблицы последнего полученного json-сообщения  
// _UpdateLastMess($pdo,$myTime,$myDate,$cycle,$sjson);  - Обновить запись в таблице последнего полученного json-сообщения  
// _UpdateNumCtrl($pdo,$idctrl,$num,$sjson);             - Обновить последние сообщения каждого типа, то есть по номеру, от каждого контроллера                      *
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

   // Создаём таблицу json-сообщений от зарегистрированных контроллеров на State
   // (последние сообщения каждого типа, то есть по номеру, от каждого контроллера) 
   // Общий вид запроса к State от контроллеров:
   // https://probatv.ru/State/?cycle=2&num=-1&ctrl=201&sjson={"intrv":{"mode4":7007,"img":1001,"tempvl":3003,"lumin":2002,"bar":5005}}
   // https://probatv.ru/State/?cycle=2&num=5&ctrl=203&sjson={"trkpt":{"lat":52518611,"lon":13376111}} - 'Sim900 в автомобиле'
   $sql='CREATE TABLE JSONMESS ('.
      'idctrl    INTEGER NOT NULL REFERENCES Controllers(idctrl),'. // идентификатор контроллера
      'myTime    INTEGER NOT NULL,'.                                // абсолютное время в секундах с начала эпохи UNIX
      'myDate    VARCHAR NOT NULL,'.                                // date("y-m-d h:i:s");
      'num       INTEGER NOT NULL,'.                                // номер управляющей json-команды (тип json-сообщения) 
      'sjson     VARCHAR NOT NULL)';                                // json-сообщение
   $st = $pdo->query($sql);
   // Добавляем первую запись для каждого контроллера
   $statement = $pdo->prepare("INSERT INTO [JSONMESS] ".
      "([idctrl],[myTime],[myDate],[num],[sjson]) VALUES ".
      "(:idctrl, :myTime, :myDate, :num, :sjson);");
   $statement->execute([
      "idctrl" => 201,
      "myTime" => time(),
      "myDate" => date("y-m-d H:i:s"),
      "num"    => -1,
      "sjson"  => '{"intrv":{"mode4":7007,"img":1001,"tempvl":3003,"lumin":2002,"bar":5005}}',
   ]);
   $statement->execute([
      "idctrl" => 203,
      "myTime" => time(),
      "myDate" => date("y-m-d H:i:s"),
      "num"    => 4,
      "sjson"  => '{"wpt":{"lat":52518611,"lon":13376111}}',
   ]);
   $statement->execute([
      "idctrl" => 204,
      "myTime" => time(),
      "myDate" => date("y-m-d H:i:s"),
      "num"    => 3,
      "sjson"  => '{"dht11":{"humi":46,"tempC":248}}',
   ]);
   
   // Создаем индекс по контроллеру и времени сообщения
   // $sql='CREATE INDEX IF NOT EXISTS iCtrlTime ON JSONMESS (idctrl,myTime)'; - пока не используется
   // $st = $pdo->query($sql);
   
   // Создаем индекс по номеру сообщения и контроллеру для использования:
   // - при трассировке трека контроллера
   $sql='CREATE INDEX IF NOT EXISTS iNumCtrl ON JSONMESS (num,idctrl)';
   $st = $pdo->query($sql);
   
   // Создаём таблицу значений элементов для контроллера 'Esp32-CAM во двор дачи'
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
// *    Выбрать последнее сообщение заданного типа от указанного контроллера  * 
// ****************************************************************************
function _SelectNumCtrl($pdo,$idctrl,$num)
{
   /*
   'idctrl    INTEGER NOT NULL REFERENCES Controllers(idctrl),'. // идентификатор контроллера
   'myTime    INTEGER NOT NULL,'.                                // абсолютное время в секундах с начала эпохи UNIX
   'myDate    VARCHAR NOT NULL,'.                                // date("y-m-d h:i:s");
   'num       INTEGER NOT NULL,'.                                // номер управляющей json-команды (тип json-сообщения) 
   'sjson     VARCHAR NOT NULL)';                                // json-сообщение
   */
   try 
   {
      $pdo->beginTransaction();
      $cSQL='SELECT myTime,myDate,num,sjson FROM JSONMESS WHERE idctrl='.$idctrl.' AND num='.$num;
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      if (count($table)>0) $tableRet=["myTime"=>$table[0]['myTime'],"myDate"=>$table[0]['myDate'],"sjson"=>$table[0]['sjson']];
      else $tableRet=["myTime"=>time(),"myDate"=>date("y-m-d h:i:s"),"sjson"=>'-1'];
      //else $tableRet=["myTime"=>time(),"myDate"=>date("y-m-d h:i:s"),"sjson"=>$cSQL];
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      $tableRet=["myTime"=>time(),"myDate"=>date("y-m-d h:i:s"),"sjson"=>'-2'];
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $tableRet;
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
// *        Обновить последние сообщения каждого типа, то есть по номеру,     * 
// *                     от каждого контроллера на State                      *
// ****************************************************************************
function _UpdateNumCtrl($pdo,$idctrl,$num,$sjson)
{
   $isrec=false;    // "запись с контроллером и номером отсутствует"
   $myTime=time();
   $myDate=date("y-m-d h:i:s");
   try 
   {
      $pdo->beginTransaction();
      // Вначале проверяем, есть ли уже запись по номеру и контроллеру
      $cSQL='SELECT sjson FROM JSONMESS WHERE idctrl='.$idctrl.' AND num='.$num;
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      if (count($table)>0) $isrec=true;  
      // Если запись с контроллером и номером есть, то обновляем её
      if ($isrec)
      {
        $cSQL='UPDATE [JSONMESS] SET [myTime]=:myTime, [myDate]=:myDate, [sjson]=:sjson WHERE idctrl='.$idctrl.' AND num='.$num;
        $statement = $pdo->prepare($cSQL);
        $statement->execute([
          "myTime"  => $myTime,
          "myDate"  => $myDate,
          "sjson"   => $sjson
       ]);
      }
      // Если записи с контроллером и номером нет, то вставляем её
      else
      {
        $statement = $pdo->prepare("INSERT INTO [JSONMESS] ".
        "([idctrl],[myTime],[myDate],[num],[sjson]) VALUES ".
        "(:idctrl, :myTime, :myDate, :num, :sjson);");
        $statement->execute([
        "idctrl" => $idctrl,
        "myTime" => $myTime,
        "myDate" => $myDate,
        "num"    => $num,
        "sjson"  => $sjson,
        ]);
      }
      $pdo->commit();
      $messa='Ok';     // "все сработало без ошибок"
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $messa;
}

// *************************************************** CommonStateMaker.php ***

