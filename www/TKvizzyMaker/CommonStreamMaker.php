<?php
                                         
// PHP7/HTML5, EDGE/CHROME                        *** CommonStreamMaker.php ***

// ****************************************************************************
// * KwinFlat/Stream                   Блок общих функций класса TKvizzyMaker *
// *                                      по хранению и обработке изображений *
// *                                                                          *
// * v1.0.1, 01.04.2025                            Автор:       Труфанов В.Е. *
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
      "image"   => "data:image/jpeg;base64,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",
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
// *             Выбрать запись из таблицы базы данных State по Led33         *
// ****************************************************************************
function _SelImgStream($pdo)
{
   try 
   {
      $pdo->beginTransaction();

      $cSQL='SELECT time,frame FROM StreamPoint';
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      if (count($table)>0)
      {
         $time=$table[0]['time']; $frame=$table[0]['frame'];
         $cSQL='SELECT image FROM Stream WHERE time ='.$time.' AND frame='.$frame.' LIMIT 1';
         $stmt = $pdo->query($cSQL);
         $table = $stmt->fetchAll();
         if (count($table)>0) $image=$table[0]['image']; 
         else $image='1-image';    
      } 
      else $image='2-image';    
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      $image=$e->getMessage();
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $image;
}

// ************************************************** CommonStreamMaker.php ***

