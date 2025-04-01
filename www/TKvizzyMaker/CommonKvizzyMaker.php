<?php namespace ttools; 
                                         
// PHP7/HTML5, EDGE/CHROME                        *** CommonKvizzyMaker.php ***

// ****************************************************************************
// * KwinFlat/TTools                   Блок общих функций класса TKvizzyMaker *
// *                                          для базы данных моего хозяйства *
// *                                                                          *
// * v2.0, 04.10.2024                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  13.11.2022 *
// ****************************************************************************

// _BaseConnect($basename,$username,$password)                                  - Открыть соединение с базой данных    
// _BaseFirstCreate($basename,$username,$password,$aCharters)                   - Создать резервную копию базы данных и заново построить новую базу данных
// _CreateTables($pdo)                                                          - Создать таблицы базы данных и выполнить начальное заполнение  

// ****************************************************************************
// *      Создать таблицы базы данных и выполнить начальное заполнение        *
// ****************************************************************************
function _CreateTables($pdo)
{
   try 
   {
      $pdo->beginTransaction();
      // Включаем действие внешних ключей
      $sql='PRAGMA foreign_keys=on;';
      $st = $pdo->query($sql);
      
      /*
      // Создаём таблицу подсистем моего хозяйства
      $sql='CREATE TABLE SubSystems ('.
         'idsys     INTEGER PRIMARY KEY NOT NULL UNIQUE,'.  // идентификатор подсистемы
         'namesys   VARCHAR NOT NULL UNIQUE)';              // название подсистемы
      $st = $pdo->query($sql);
      // Заполняем таблицу подсистем
      $aSubSystems=[
         [ 1,'В квартире'],
         [ 2,'На даче'],
      ];
      $statement = $pdo->prepare("INSERT INTO [SubSystems] ".
         "([idsys],[namesys]) VALUES ".
         "(:idsys, :namesys);");
      $i=0;
      foreach ($aSubSystems as [$idsys,$namesys])
      $statement->execute([
         "idsys"   => $idsys,
         "namesys" => $namesys
      ]);
      
      // Создаём таблицу типов контроллеров
      $sql='CREATE TABLE ControllersType ('.
         'tidctrl     INTEGER PRIMARY KEY NOT NULL UNIQUE,'.  // идентификатор типа контроллера
         'typectrl    VARCHAR NOT NULL UNIQUE)';              // тип контроллера
      $st = $pdo->query($sql);
      // Заполняем таблицу типов контроллеров
      $aControllersType=[
         [ 1,'Esp32-CAM'],
         [ 2,'Arduino Pro Mini'],
         [ 3,'Esp01'],
      ];
      $statement = $pdo->prepare("INSERT INTO [ControllersType] ".
         "([tidctrl],[typectrl]) VALUES ".
         "(:tidctrl, :typectrl);");
      $i=0;
      foreach ($aControllersType as [$tidctrl,$typectrl])
      $statement->execute([
         "tidctrl"  => $tidctrl,
         "typectrl" => $typectrl
      ]);
      
      // Создаём таблицу мест размещения контроллеров, оборудования и датчиков
      $sql='CREATE TABLE Places ('.
         'idplace    INTEGER PRIMARY KEY NOT NULL UNIQUE,'.            // идентификатор места размещения
         'idsys      INTEGER NOT NULL REFERENCES SubSystems(idsys),'.  // идентификатор подсистемы
         'nameplace  VARCHAR NOT NULL UNIQUE)';                        // место размещения
      $st = $pdo->query($sql);
      // Заполняем таблицу мест размещения
      $aPlaces=[
         [ 101,1,'На площадку из гостиной'],
         [ 102,1,'На дорогу с балкона'],
         [ 201,2,'Во двор дачи'],
         [ 202,2,'С дачи на дорогу'],
         [ 203,2,'На стене веранды'],
      ];
      $statement = $pdo->prepare("INSERT INTO [Places] ".
         "([idplace],[idsys],[nameplace]) VALUES ".
         "(:idplace, :idsys, :nameplace);");
      $i=0;
      foreach ($aPlaces as [$idplace,$idsys,$nameplace])
      $statement->execute([
         "idplace"   => $idplace,
         "idsys"     => $idsys,
         "nameplace" => $nameplace
      ]);
      // Создаем индекс по подсистеме и месту размещения
      $sql='CREATE INDEX IF NOT EXISTS iSysPlace ON Places (idsys,idplace)';
      $st = $pdo->query($sql);
      // Создаём таблицу контроллеров
      $sql='CREATE TABLE Controllers ('.
         'idctrl    INTEGER PRIMARY KEY NOT NULL UNIQUE,'.                   // идентификатор контроллера
         'tidctrl   INTEGER NOT NULL REFERENCES ControllersType(tidctrl),'.  // идентификатор типа контроллера
         'idplace   INTEGER NOT NULL REFERENCES Places(idplace),'.           // идентификатор места размещения
         'namectrl  VARCHAR NOT NULL UNIQUE)';                               // тип контроллера и место размещения
      $st = $pdo->query($sql);
      // Заполняем таблицу контроллеров
      $aControllers=[
         [ 201,1,201,'Esp32-CAM во двор дачи'],  
         [ 202,3,203,'Esp01 на стене веранды'],  
       ];
      $statement = $pdo->prepare("INSERT INTO [Controllers] ".
         "([idctrl],[tidctrl],[idplace],[namectrl]) VALUES ".
         "(:idctrl, :tidctrl, :idplace, :namectrl);");
      $i=0;
      foreach ($aControllers as [$idctrl,$tidctrl,$idplace,$namectrl])
      $statement->execute([
         "idctrl"    => $idctrl,
         "tidctrl"   => $tidctrl,
         "idplace"   => $idplace,
         "namectrl"  => $namectrl
      ]);
            
      // Создаём таблицу типов устройств
      $sql='CREATE TABLE DevicesType ('.
         'tiddev     INTEGER PRIMARY KEY NOT NULL UNIQUE,'.  // идентификатор типа устройства
         'typedev    VARCHAR NOT NULL UNIQUE)';              // тип устройства
      $st = $pdo->query($sql);
      // Заполняем таблицу типов устройств
      $aDevicesType=[
         [ 1,'inLed'],       // светодиод c обратной логикой
         [ 2,'Led'],         // светодиод
         [ 3,'Core32'],      // ядро Esp32
      ];
      $statement = $pdo->prepare("INSERT INTO [DevicesType] ".
         "([tiddev],[typedev]) VALUES ".
         "(:tiddev, :typedev);");
      $i=0;
      foreach ($aDevicesType as [$tiddev,$typedev])
      $statement->execute([
         "tiddev"  => $tiddev,
         "typedev" => $typedev
      ]);
      // Создаём таблицу устройств
      $sql='CREATE TABLE Devices ('.
         'iddev      INTEGER PRIMARY KEY NOT NULL UNIQUE,'.              // идентификатор устройства
         'idctrl     INTEGER NOT NULL REFERENCES Controllers(idctrl),'.  // идентификатор контроллера
         'tiddev     INTEGER NOT NULL REFERENCES DevicesType(tiddev),'.  // идентификатор типа устройства
         'namedev    VARCHAR NOT NULL UNIQUE)';                          // название устройства и и родительский контроллер
      $st = $pdo->query($sql);
      // Заполняем таблицу устройств
      $aDevices=[
         [ 1,201,1,'Led04 на ESP32-CAM'],         
         [ 2,201,1,'Led33 на ESP32-CAM'],                       
      ];
      $statement = $pdo->prepare("INSERT INTO [Devices] ".
         "([iddev],[idctrl],[tiddev],[namedev]) VALUES ".
         "(:iddev, :idctrl, :tiddev, :namedev);");
      $i=0;
      foreach ($aDevices as [$iddev,$idctrl,$tiddev,$namedev])
      $statement->execute([
         "iddev"   => $iddev,
         "idctrl"  => $idctrl,
         "tiddev"  => $tiddev,
         "namedev" => $namedev
      ]);
            
      // Создаём таблицу типов датчиков
      $sql='CREATE TABLE SensorsType ('.
         'tidsens    INTEGER PRIMARY KEY NOT NULL UNIQUE,'.  // идентификатор типа датчика
         'typesens   VARCHAR NOT NULL UNIQUE)';              // тип датчика
      $st = $pdo->query($sql);
      // Заполняем таблицу типов датчиков
      $aSensorsType=[
         [ 1,'DHT11'],         
         [ 2,'DHT22'],       
      ];
      $statement = $pdo->prepare("INSERT INTO [SensorsType] ".
         "([tidsens],[typesens]) VALUES ".
         "(:tidsens, :typesens);");
      $i=0;
      foreach ($aSensorsType as [$tidsens,$typesens])
      $statement->execute([
         "tidsens"  => $tidsens,
         "typesens" => $typesens
      ]);
      // Создаём таблицу датчиков
      $sql='CREATE TABLE Sensors ('.
         'idsens     INTEGER PRIMARY KEY NOT NULL UNIQUE,'.               // идентификатор датчика
         'idctrl     INTEGER NOT NULL REFERENCES Controllers(idctrl),'.   // идентификатор контроллера
         'tidsens    INTEGER NOT NULL REFERENCES SensorsType(tidsens),'.  // идентификатор типа датчика
         'namesens   VARCHAR NOT NULL UNIQUE)';                           // название датчика и и родительский контроллер
      $st = $pdo->query($sql);
      // Заполняем таблицу устройств
      $aDevices=[
         [ 1,201,1,'DHT11 на ESP32-CAM'],         
         [ 2,201,2,'DHT22 на ESP32-CAM'],                       
      ];
      $statement = $pdo->prepare("INSERT INTO [Sensors] ".
         "([idsens],[idctrl],[tidsens],[namesens]) VALUES ".
         "(:idsens, :idctrl, :tidsens, :namesens);");
      $i=0;
      foreach ($aDevices as [$idsens,$idctrl,$tidsens,$namesens])
      $statement->execute([
         "idsens"   => $idsens,
         "idctrl"   => $idctrl,
         "tidsens"  => $tidsens,
         "namesens" => $namesens
      ]);
      */
      
      // Создаём таблицы базы данных State
      _CreateStateTables($pdo);
      _CreateLeadTables($pdo);
      _CreateStreamTables($pdo);
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
// *                     Открыть соединение с базой данных                    *
// ****************************************************************************
function _BaseConnect($basename,$username,$password)
{
   // Получаем спецификацию файла базы данных материалов
   $filename=$basename.'.db3';
   // Создается объект PDO и файл базы данных
   $pathBase='sqlite:'.$filename; 
   // Подключаем PDO к базе
   //$pdo = new \PDO($pathBase,$username,$password);
   //$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
   $pdo = new \PDO(
      $pathBase, 
      $username,
      $password,
      array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
   );
   return $pdo;
}

// ****************************************************************************
// * Создать резервную копию базы данных и заново построить новую базу данных *
// ****************************************************************************
function _BaseFirstCreate($basename,$username,$password) 
{
   // Получаем спецификацию файла базы данных 
   $filename=$basename.'.db3';
   // Проверяем существование и удаляем файл копии базы данных 
   $filenameOld=$basename.'-copy.db3';
   UnlinkFile($filenameOld);
   \prown\ConsoleLog('Проверено существование и удалена копия базы данных: '.$filenameOld);  
   // Создаем копию базы данных
   if (file_exists($filename)) 
   {
      if (rename($filename,$filenameOld))
      {
         \prown\ConsoleLog('Получена копия базы данных: '.$filenameOld);  
      }
      else
      {
         \prown\ConsoleLog('Не удалось переименовать базу данных: '.$filename);
      }
   } 
   else 
   {
      \prown\ConsoleLog('Прежней версии базы данных '.$filename.' не существует');
   }
   // Проверяем существование и удаляем файл базы данных 
   UnlinkFile($filename);
   \prown\ConsoleLog('Проверено существование и удалён старый файл базы данных: '.$filename);  
   // Создается объект PDO и файл базы данных
   $pdo=_BaseConnect($basename,$username,$password);
   \prown\ConsoleLog('Создан объект PDO и файл базы данных');
   // Создаём таблицы базы данных
   _CreateTables($pdo);
   \prown\ConsoleLog('Созданы таблицы и выполнено начальное заполнение'); 
}

// ************************************************** CommonKvizzyMaker.php ***
