<?php
                                         
// PHP7/HTML5, EDGE/CHROME                        *** CommonStreamMaker.php ***

// ****************************************************************************
// * KwinFlat/Stream                   Блок общих функций класса TKvizzyMaker *
// *                                      по хранению и обработке изображений *
// *                                                                          *
// * v1.0.2, 03.04.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2025 tve                          Дата создания:  10.03.2025 *
// ****************************************************************************
// _CreateStreamTables($pdo);              - Создать таблицу базы данных Stream
// *****_SelChange($pdo);                         - Выбрать изменения состояний     
// *****_SelectLMP33($pdo);                       - Выбрать запись режима работы контрольного светодиода Led33
// *****_UpdateModeLMP33($pdo,$action);           - Обновить установку по режиму работы контрольного светодиода  
 
// ****************************************************************************
// *               Создать таблицы базы данных для страницы Stream            *
// ****************************************************************************
function _CreateStreamTables($pdo)
{
   // Создаём таблицу хранения изображений
   $sql='CREATE TABLE Stream ('.
      'id         INTEGER PRIMARY KEY AUTOINCREMENT,'.   
      'time       INTEGER,'.    // абсолютное время в секундах с начала эпохи
      'frame      INTEGER,'.    // номер кадра (изображения) в секунде
      'image      BLOB)';       // изображение
   $st = $pdo->query($sql);
   // Добавляем первую и единственную запись Stream
   $st = $pdo->prepare("INSERT INTO [Stream] ".
      "([time],[frame],[image]) VALUES ".
      "(:time, :frame, :image);");
   $st->execute([
      "time"    => time(),
      "frame"   => 1,
      // "kwinflat"
      // "image"   => "data:image/jpeg;base64,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",
      // "четверка"
      "image"   => "data:image/png;base64,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",

   
   ]);
   // Создаем индекс по времени и кадру      
   $sql='CREATE INDEX IF NOT EXISTS iTimeFrame ON Stream (time,frame)';
   $st = $pdo->query($sql);

   // Создаём таблицу c указателет на последнее загруженное изображение
   $sql='CREATE TABLE StreamPoint ('.
      'time       INTEGER,'.    // абсолютное время в секундах с начала эпохи
      'frame      INTEGER)';    // номер кадра (изображения) в секунде
   $st = $pdo->query($sql);
   // Добавляем первую и единственную запись StreamPoint
   $st = $pdo->prepare("INSERT INTO [StreamPoint] ".
      "([time],[frame]) VALUES ".
      "(:time, :frame);");
   $st->execute([
      "time"    => time(),
      "frame"   => 1,
   ]);
}
// ****************************************************************************
// *                         Вставить текущее изображение                     *
// *  $src   - base64 изображения                                             *
// *  $time  - время приема изображения в потоке (секунда с начала эпохи)     *
// *  $frame - номер фрейма за текущую секунду                                *
// ****************************************************************************
function _InsertImgStream($pdo,$src,$time,$frame)
{
   try 
   {
      // Записываем фрэйм в базу данных 
      $pdo->beginTransaction();
      $st = $pdo->prepare("INSERT INTO [Stream] ".
         "([time],[frame],[image]) VALUES ".
         "(:time, :frame, :image);");
      $st->execute([
         "time"  => $time,
         "frame" => $frame,
         "image" => $src,
      ]);
      // Отмечаем запись последнего фрэйма
      $st = $pdo->prepare("UPDATE [StreamPoint] ".
         "SET [time]=:time, [frame]=:frame;");
      $st->execute([
         "time"  => $time,
         "frame" => $frame
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
// *      Выбрать данные последнего записанного изображения из базы данных    *
// ****************************************************************************
function _SelImgStream($pdo,$intime,$inframe)
{
   $time=0;    // время приема изображения в потоке (секунда с начала эпохи)     
   $frame=-1;  // номер фрейма за текущую секунду                               
   $src='';    // base64 изображения или сообщение об ошибке                                           
   $fate=0;    // результат (состояние) действий по выборке данных = "0 - неопределенный результат"
   try 
   {
      $pdo->beginTransaction();

      $cSQL='SELECT time,frame FROM StreamPoint';
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      if (count($table)>0)
      {
         $time=$table[0]['time']; $frame=$table[0]['frame'];
         /*
         // Если последнее изображение не изменилось, то отправляем
         // просто сообщение об этом
         if (($intime==$time)&&($inframe==$frame))
         {
           $fate=-4;    
           $src='Последнее принятое изображение не изменилось'; 
         }
         // Если последнее изображение изменилось, то выбираем и готовим его к отправке 
         else
         {
         */
           $cSQL='SELECT image FROM Stream WHERE time ='.$time.' AND frame='.$frame.' LIMIT 1';
           $stmt = $pdo->query($cSQL);
           $table = $stmt->fetchAll();
           // Если изображение выбралось из базы
           if (count($table)>0) 
           {
              $src=$table[0]['image']; 
              $fate=1;    // результат = "1 - изображение найдено в базе данных"
           }
           // Если изображение не найдено
           else 
           {
              $fate=-1;   // результат = "-1 - нет изображения по указанному времени и номеру фрейма"
              $src='Нет изображения по указанному времени ['.$time.'] и номеру фрейма ['.$frame.']'; 
           }
         //}   
      }
      // Если нет таблицы для выборки времени и номера фрейма 
      else 
      {
         $fate=-2;     // результат = "-2 - нет таблицы для выборки времени и номера фрейма"
         $src='Нет таблицы для выборки времени и номера фрейма'; 
      }   
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      $fate=-3;        // результат = "-3 - ошибка выборки последнего записанного изображения"
      $src=$e->getMessage();
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   // Возвращаем данные в виде таблицы
   $tbl=["time"=>$time,"frame"=>$frame,"src"=>$src,"fate"=>$fate];
   return $tbl;
}

// ************************************************** CommonStreamMaker.php ***

