<?php
                                         
// PHP7/HTML5, EDGE/CHROME                         *** CommonStateMaker.php ***

// ****************************************************************************
// * KwinFlat/State                    Блок общих функций класса TKvizzyMaker *
// *                            для базы данных json-сообщений страницы State *
// *                                                                          *
// * v4.4.11, 15.04.2026                           Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  07.01.2025 *
// ****************************************************************************

// _CreateStateTables($pdo);                                          - Создать таблицы базы данных State
// _InsertTrkpt($pdo,$idctrl,$time,$lat,$lon,$color,$ele);            - Вставить данные по точке трека  
// _SelectLastMess($pdo);                                             - Выбрать запись из таблицы последнего полученного json-сообщения  
// _SelectNumCtrl($pdo,$idctrl,$num);                                 - Выбрать последнее сообщение заданного типа от указанного контроллера
// _UpdateLastMess($pdo,$myTime,$myDate,$idctrl,$num,$cycle,$sjson);  - Обновить запись в таблице последнего полученного json-сообщения  
// _UpdateNumCtrl($pdo,$idctrl,$num,$sjson);                          - Обновить последние сообщения каждого типа, то есть по номеру, от каждого контроллера                      *
// _SelState($pdo);                                                   - Выбрать управляющие значения экрана и показания датчиков
// _setStateElem($pdo,$Name,$Value);                                  - Записать в базу данных изменение управляющего элемента изображения 
 
// ****************************************************************************
// *                       Создать таблицы базы данных State                  *
// ****************************************************************************
function _CreateStateTables($pdo)
{
   // Создаём таблицу последнего полученного json-сообщения на State
   $sql='CREATE TABLE LastMess ('.
      'myTime    INTEGER PRIMARY KEY NOT NULL UNIQUE,'.             // абсолютное время в секундах с начала эпохи UNIX
      'myDate    VARCHAR NOT NULL UNIQUE,'.                         // date("y-m-d h:i:s");
      'idctrl    INTEGER NOT NULL REFERENCES Controllers(idctrl),'. // идентификатор контроллера
      'num       INTEGER NOT NULL,'.                                // номер управляющей json-команды (тип json-сообщения) 
      'cycle     INTEGER NOT NULL,'.                                // цикл выдачи контроллером json-сообщения
      'sjson     VARCHAR NOT NULL)';                                // json-сообщение
   $st = $pdo->query($sql);
   // Добавляем первую и единственную запись
   $statement = $pdo->prepare("INSERT INTO [LastMess] ".
      "([myTime],[myDate],[idctrl],[num],[cycle],[sjson]) VALUES ".
      "(:myTime, :myDate, :idctrl, :num, :cycle, :sjson);");
   $statement->execute([
      "myTime" => time(),
      "myDate" => date("y-m-d H:i:s"),
      "idctrl" => 201,
      "num"    => 2,
      "cycle"  => 111,
      "sjson"  => '{"intrv":{"mode4":7007,"img":1001,"tempvl":3003,"lumin":2002,"bar":5005}}',
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
      "num"    => 2,
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

   // Создаём таблицу однодневных треков от зарегистрированных контроллеров
   $sql='CREATE TABLE Tracks ('.
      'idctrl    INTEGER NOT NULL REFERENCES Controllers(idctrl),'. // идентификатор контроллера
      'time      TEXT,'.                                            // "2026-04-12T06:54:44+00:00" или "2025-08-10T08:05:16Z" 
      'lat       TEXT,'.                                            // "61.8449408188" - широта
      'lon       TEXT,'.                                            // "34.3792157248" - долгота
      'color     TEXT,'.                                            // "red" или "#FF0000" - цвет линии, приходящей к точке 
      'ele       REAL)';                                            // 84.73 - высота в метрах
   $st = $pdo->query($sql);
   // Формируем запрос по добавлению записи
   $statement = $pdo->prepare("INSERT INTO [Tracks] ".
      "([idctrl],[time],[lat],[lon],[color],[ele]) VALUES ".
      "(:idctrl, :time, :lat, :lon, :color, :ele);");
   // Добавляем записи для контроллера 203='Sim900 в автомобиле'
   // <trkpt lat="61.8432667013" lon="34.3725032452"><ele>71.76</ele><time>2025-08-10T07:31:51Z</time></trkpt>
   // <trkpt lat="61.8439234234" lon="34.3724057637"><ele>75.60</ele><time>2025-08-10T07:35:32Z</time><color>red</color></trkpt>
   // <trkpt lat="61.8438809272" lon="34.3723446596"><ele>77.52</ele><time>2025-08-10T07:35:55Z</time></trkpt>
   // <trkpt lat="61.8449408188" lon="34.3792157248"><ele>84.73</ele><time>2025-08-10T07:50:04Z</time><color>#FF0000</color></trkpt>
   // <trkpt lat="61.8432667013" lon="34.3725032452"><ele>71.76</ele><time>2025-08-10T08:05:16Z</time></trkpt>
   $statement->execute([
      "idctrl" => 203,
      "time"   => '2025-08-10T07:31:51Z',
      "lat"    => '61.8432667013',
      "lon"    => '34.3725032452',
      "color"  => 'blue',
      "ele"    => 71.76,
   ]);
   $statement->execute([
      "idctrl" => 203,
      "time"   => '2025-08-10T07:35:32Z',
      "lat"    => '61.8439234234',
      "lon"    => '34.3724057637',
      "color"  => 'red',
      "ele"    => 75.60,
   ]);
   $statement->execute([
      "idctrl" => 203,
      "time"   => '2025-08-10T07:35:55Z',
      "lat"    => '61.8438809272',
      "lon"    => '34.3723446596',
      "color"  => 'blue',
      "ele"    => 77.52,
   ]);
   $statement->execute([
      "idctrl" => 203,
      "time"   => '2025-08-10T07:50:04Z',
      "lat"    => '61.8449408188',
      "lon"    => '34.3792157248',
      "color"  => '#FF0000',
      "ele"    => 84.73,
   ]);
   $statement->execute([
      "idctrl" => 203,
      "time"   => '2025-08-10T08:05:16Z',
      "lat"    => '61.8432667013',
      "lon"    => '34.3725032452',
      "color"  => 'blue',
      "ele"    => 71.76,
   ]);
   // Добавляем записи для контроллера 204='Виртуальный контроллер'
   //   <trkpt lat="54.932862108889" lon="9.8606242161401">
   //     <ele>0</ele>
   //     <time>2026-04-08T17:55:30+00:00</time>
   //   </trkpt>
   //   <trkpt lat="54.832932373209" lon="9.7609220868149">
   //     <ele>10</ele>
   //     <time>2026-04-08T17:56:30+00:00</time>
   //   </trkpt>
   //   <trkpt lat="54.932862108889" lon="9.8606242161401">
   //     <ele>0</ele>
   //     <time>2026-04-08T17:58:30+00:00</time>
   //   </trkpt>
   $statement->execute([
      "idctrl" => 204,
      "time"   => '2026-04-08T17:55:30+00:00',
      "lat"    => '54.932862108889',
      "lon"    => '9.8606242161401',
      "color"  => 'blue',
      "ele"    => 0,
   ]);
   $statement->execute([
      "idctrl" => 204,
      "time"   => '2026-04-08T17:56:30+00:00',
      "lat"    => '54.832932373209',
      "lon"    => '9.7609220868149',
      "color"  => 'blue',
      "ele"    => 10,
   ]);
   $statement->execute([
      "idctrl" => 204,
      "time"   => '2026-04-08T17:58:30+00:00',
      "lat"    => '54.932862108889',
      "lon"    => '9.8606242161401',
      "color"  => 'blue',
      "ele"    => 0,
   ]);
   // Создаем индекс по контроллеру и времени точки
   $sql='CREATE INDEX IF NOT EXISTS iCtrlTime ON Tracks (idctrl,time)'; 
   $st = $pdo->query($sql);
}
// ****************************************************************************
// *                       Вставить данные по точке трека                     *
// ****************************************************************************
function _InsertTrkpt($pdo,$idctrl,$time,$lat,$lon,$color,$ele)
{
   try 
   {
      $pdo->beginTransaction();
      // Формируем запрос по добавлению записи
      $statement = $pdo->prepare("INSERT INTO [Tracks] ".
        "([idctrl],[time],[lat],[lon],[color],[ele]) VALUES ".
        "(:idctrl, :time, :lat, :lon, :color, :ele);");
      // Добавляем запись
      $statement->execute([
        "idctrl" => $idctrl,
        "time"   => $time,
        "lat"    => $lat,
        "lon"    => $lon,
        "color"  => $color,
        "ele"    => $ele,
      ]);
      $pdo->commit();
      $messa='Ok';
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      // Если в транзакции, то делаем откат изменений
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $messa;
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
      $cSQL='SELECT myTime,myDate,cycle,idctrl,num,sjson FROM LastMess';
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      if (count($table)>0) $table=[
         "myTime"=>$table[0]['myTime'], "myDate"=>$table[0]['myDate'],
         "idctrl"=>$table[0]['idctrl'], "num"   =>$table[0]['num'],
         "cycle" =>$table[0]['cycle'],  "sjson" =>$table[0]['sjson']];
      else $table=[
         "myTime"=>time(), "myDate"=> date("y-m-d h:i:s"), 
         "idctrl"=>-2,     "num"   => -2,
         "cycle" =>-2,     "sjson" => 'sjson2'];
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      $table=[
         "myTime"=>time(), "myDate"=> date("y-m-d h:i:s"),
         "idctrl"=>-3,     "num"   => -3,
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
function _UpdateLastMess($pdo,$myTime,$myDate,$idctrl,$num,$cycle,$sjson)
{
   try 
   {
      $pdo->beginTransaction();
      $statement = $pdo->prepare("UPDATE [LastMess] ".
         "SET [myTime]=:myTime,[myDate]=:myDate,[idctrl]=:idctrl,[num]=:num,[cycle]=:cycle,[sjson]=:sjson;");
      $statement->execute([
         "myTime" => $myTime,
         "myDate" => $myDate,
         "idctrl" => $idctrl,
         "num"    => $num,
         "cycle"  => $cycle,
         "sjson"  => $sjson
      ]);
      $pdo->commit();
      $messa='Ok'; // "все сработало без ошибок"
   } 
   catch (Exception $e) 
   {
      $messa=$e->getMessage();
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $messa;
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

