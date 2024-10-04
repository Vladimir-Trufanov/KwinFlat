<?php namespace ttools; 
                                         
// PHP7/HTML5, EDGE/CHROME                        *** CommonKvizzyMaker.php ***

// ****************************************************************************
// * KwinFlat/TTools                   Блок общих функций класса TKvizzyMaker *
// *                                          для базы данных моего хозяйства *
// *                                                                          *
// * v2.0, 04.10.2024                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  13.11.2022 *
// ****************************************************************************

// ****************************************************************************
// *      Создать таблицы базы данных и выполнить начальное заполнение        *
// ****************************************************************************
function CreateTables($pdo,$aCharters)
{
   try 
   {
      $pdo->beginTransaction();
      // Включаем действие внешних ключей
      $sql='PRAGMA foreign_keys=on;';
      $st = $pdo->query($sql);
      
      // Создаём таблицу типов контроллеров
      $sql='CREATE TABLE ControllersType ('.
         'tctrlid     INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.  // идентификатор типа контроллера
         'typectrl    VARCHAR NOT NULL UNIQUE)';                     // тип контроллера
      $st = $pdo->query($sql);
      // Заполняем таблицу типов контроллеров
      $aControllersType=[
         [ 'Esp32-CAM'],
         [ 'Arduino Pro Mini'],
      ];
      $statement = $pdo->prepare("INSERT INTO [ControllersType] ".
         "([typectrl]) VALUES ".
         "(:typectrl);");
      $i=0;
      foreach ($aControllersType as [$typectrl])
      $statement->execute([
         "typectrl" => $typectrl
      ]);
      
      
      /*
      // Создаём таблицу идентификаторов типов статей   
      $sql='CREATE TABLE Controllers ('.
         'cid         INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.  // идентификатор контроллера
         'IdCue          INTEGER PRIMARY KEY NOT NULL UNIQUE,'.
         'NameCue        VARCHAR )';
      $st = $pdo->query($sql);
      // Заполняем таблицу идентификаторов типов статей
      // (для правильного формирования тегов, введено понятие раздела без материалов. 
      // Добавление нового раздела в базу данных сопровождается пометкой
      // 'раздел без материалов', при появлении статей в нем метка меняется на 
      // 'раздел')
      $aСues=[
         [ -1, 'Раздел'],
         [  0, 'Статья для сайта = материал'],
      ];
      $statement = $pdo->prepare("INSERT INTO [cue] ".
         "([IdCue], [NameCue]) VALUES ".
         "(:IdCue,  :NameCue);");
      $i=0;
      foreach ($aСues as [$IdCue,$NameCue])
      $statement->execute([
         "IdCue"      => $IdCue, 
         "NameCue"    => $NameCue
      ]);
      // Создаём таблицу материалов (основу для построения меню)  
      $sql='CREATE TABLE stockpw ('.
         'uid         INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.  // идентификатор пункта меню (раздел или статья сайта)
         'pid         INTEGER NOT NULL REFERENCES stockpw(uid),'.    // идентификатор родителя - uid элемента уровнем выше 
         'IdCue       INTEGER NOT NULL REFERENCES cue(IdCue),'.      // указатель раздела статьи
         'NameArt     VARCHAR NOT NULL,'.                            // заголовок материала = статьи сайта
         'Translit    VARCHAR NOT NULL,'.                            // транслит заголовка
         'access      INTEGER NOT NULL,'.                            // доступ к пунктам меню (All/Autor)
         'DateArt     VARCHAR NOT NULL,'.                            // дата статьи сайта/юникод иконки раздела
         'description TEXT,'.                                        // описание статьи
         'keywords    TEXT,'.                                        // ключевые слова статьи
         'Art         TEXT)';                                        // материал = статья сайта
      $st = $pdo->query($sql);
      
      // Заполняем таблицу материалов в начальном состоянии (на 2022-12-20)

      $com3="&lt;p style=&quot;text-align: justify;&quot;&gt;&lt;span style=&quot;font-family: 'comic sans ms', sans-serif;&quot;&gt;&amp;nbsp; ".
      "Физико-математический факультет ПетрГУ (ПГУ им.О.В.Кусинена в моё время) наложил на меня отпечаток. Все в моей голове строится по степеням ".
      "двойки, как-то это управляет моей жизнью и упрощает её (2в0=1, 2в1=2, 2во2=4, 2в3=8, 2в4=16, &amp;hellip;). Теплица на даче одна (или 2, ".
      "в зависимости от уровня благосостояния в стране). В теплице 2 грядки. На грядке два ряда, в каждом ряду по 8, например, томатов. Когда выпекаю ".
      "булочки или пирожки, их получается по 8 или 16. В слоеном тесте получается 256 слоев. Лыж пара, лыжных палок пара (иногда одна лыжа или палка ".
      "ломается).&lt;/span&gt;&lt;/p&gt;".
      "&lt;p style=&quot;text-align: justify;&quot;&gt;&lt;span style=&quot;font-family: 'comic sans ms', sans-serif;&quot;&gt;&amp;nbsp; Но, иногда, ".
      "что-то в голове щёлкает и, начинает работать система со смещением степеней двойки на единицу (2 в степени N + 1: т.е. 9, 17, &amp;hellip;). ".
      "Например, супруга заставляет повесить занавеску и к занавеске дает 20 прищепок, и у меня всегда 3 остаются лишними. Как я вешаю занавески: ".
      "прищепку с правого края, прищепку с левого края. Далее возникает естественное желание повесить занавеску на скрепку по центру. Что я и делаю. ".
      "Далее опять закрепляю два провиса справа и слева от центра, и так далее. И три скрепки остаются &amp;ndash; их некуда закрепить, руки не ".
      "поднимаются.&lt;/span&gt;&lt;/p&gt;".
      "&lt;p style=&quot;text-align: justify;&quot;&gt;&lt;span style=&quot;font-family: 'comic sans ms', sans-serif;&quot;&gt;&amp;nbsp; ".
      "Правда, китайская игровая философия тоже наложила отпечаток. На втором курсе университета китайская философия въехала в голову через ГО ".
      "(это не гражданская оборона на военной кафедре, а вэйци, бадук &amp;ndash; настольная игра из черных и белых камней. После нескольких лет ".
      "этой болезни, все мои дела строятся по принципам этой игры: ярко выраженное стратегическое начало фусеки, как правило, вызывающее ".
      "задержку на старте, собственно само дело, идущее к цели и стремительное (только не зевай) йосе, когда все ясно. Но и здесь, как видно, ".
      "бинарная, двоичная основа. (А про компьютеры и программы, и говорить нечего).&lt;/span&gt;&lt;/p&gt;".
      "&lt;p style=&quot;text-align: justify;&quot;&gt;&amp;nbsp;&lt;/p&gt;";

      $com17='
      Была весна, мы с Ричей уже соскучились по походам. Решили прокатиться по неизведанной дороге в сторону реки Шапшы. 
      "Поехали. 💯 Ура!!!" - так сказал мне дорогой пёсик, уткнувшись своим мокрым носом в нос мой, который тоже стал мокрым.
      "Подожди. Весна! Всё кругом тает." - сказал я.
      "Надо сделать карту, продумать маршрут. Надо приготовить машину, надо собрать кушаньки. Неизвестно докуда доедем, а еще и домой вернуться нужно. 😟"
      Пару часиков заняла подготовка. Заложили контрольные точки в навигатор. Поехали.
      Ехать и мне, и собаке интересно. Здесь мы не были, места неизведанные. Едем, проехали Лососинное, проезжаем Шапшезеро, дальше яма на яме и развилки туда-сюда.
      Едем потихонечку, качаемся, заезжаем в лужи, вспоминаем детство, настроение хорошее, в машине не страшно. Едем, едем, видим впереди ручеек перетекает через дорогу. Решили выйти погулять, размять ноги (или лапы, у кого-что). Вышли, гуляем. 
      Вдруг пёса зарычал. Что такое? А! Следы! Большие!
      "Рича, это мишка. Хватай палку, на всякий случай. Будем его брать!" - сказал я и подумал, лишь бы он нас не взял.
      ';

      // Назначаем массив с начальной структурой основной базы данных
      if ($aCharters=='-'){
      $aCharters=[                                                          
         [ 1, 0,-1, 'ittve.me',                                            '/',                                              acsAll,'20',''],
         [ 2, 1,-1, 'Моя жизнь',                                           'moya-zhizn',                                     acsAll,'20',''],
         [ 3, 2, 0,    'Особенности устройства винтиков в моей голове',    'osobennosti-ustrojstva-vintikov-v-moej-golove',  acsAll,'2010.12.30',$com3],
         [ 4, 1,-1, 'Микропутешествия',                                    'mikroputeshestviya',                             acsAll,'20',''],
         [ 5, 4, 0,    'Киндасово - земля карельского юмора',              'kindasovo-zemlya-karelskogo-yumora',             acsAll,'2010.05.20',''],
         [ 6, 4, 0,    'Гора Сампо. Озеро, светлый лес, тропинка в небо',  'gora-sampo-ozero-svetlyj-les-tropinka-v-nebo',   acsAll,'2010.06.23',''],
         [ 7, 4, 0,    'Падозеро, кладбище заключенных лагеря №517',       'padozero-kladbishche-zaklyuchennyh-lagerya-517', acsAll,'2010.07.03',''],
         [ 8, 4, 0,    'Таёжный зоопарк на озере Сямозеро',                'tayozhnyj-zoopark-na-ozere-syamozero',           acsAll,'2010.07.04',''],
         [ 9, 4, 0,    'Шелтозеро. Так жили вепсы',                        'sheltozero-tak-zhili-vepsy',                     acsAll,'2010.07.10',''],
         [10, 4, 0,    'Полоса 2300 - военный аэродром в Гирвасе',         'polosa-2300-voennyj-aehrodrom-v-girvase',        acsAll,'2010.07.17',''],
         [11, 4, 0,    'Чертов стул, кусочек ботанического сада',          'chertov-stul-kusochek-botanicheskogo-sada',      acsAll,'2010.09.12',''],
         [12, 4, 0,    'Деревянное чудо на холме',                         'derevyannoe-chudo-na-holme',                     acsAll,'2010.10.07',''],
         [13, 1,-1, 'Всякое-разное',                                       'vsyakoe-raznoe',                                 acsAll,'20',''],
         [14, 1,-1, 'В контакте',                                          'v-kontakte',                                     acsAll,'20',''],
         [15, 1,-1, 'Мой мир',                                             'moj-mir',                                        acsAll,'20',''],
         [16, 1,-1, 'Прогулки',                                            'progulki',                                       acsAll,'20',''],
         [17,16, 0,    'Охота на медведя',                                 'ohota-na-medvedya',                              acsAll,'2011.05.06',$com17],
         [18, 1,-1, 'Дополнения к микропутешествиям',                      'dopolneniya-k-mikroputeshestviyam',              acsAll,'20',''],
         [19, 1,-1, 'Перепечатка',                                         'perepechatka',                                   acsAll,'20',''],
         [20, 4, 0,    'Благовещенский Ионо-Яшезерский мужской монастырь', 'iono-yashezerskij-muzhskoj-monastyr',            acsAll,'2010.10.10',''],
         [21, 0,-1, 'ittve.end',                                           '/',                                              acsAll,'20','']
      ];}       
      $statement = $pdo->prepare("INSERT INTO [stockpw] ".
         "([uid], [pid], [IdCue], [NameArt], [Translit], [access], [DateArt], [Art]) VALUES ".
         "(:uid,  :pid,  :IdCue,  :NameArt,  :Translit,  :access,  :DateArt,  :Art);");
      $i=0;
      foreach ($aCharters as
          [$uid,  $pid,  $IdCue,  $NameArt,  $Translit,  $access,  $DateArt,  $Art])
      $statement->execute([
         "uid"      => $uid, 
         "pid"      => $pid, 
         "IdCue"    => $IdCue, 
         "NameArt"  => $NameArt, 
         "Translit" => $Translit, 
         "access"   => $access, 
         "DateArt"  => $DateArt, 
         "Art"      => $Art
      ]);
      // Создаем индекс по транслиту в таблице материалов      
      $sql='CREATE INDEX IF NOT EXISTS iTranslit ON stockpw (Translit)';
      $st = $pdo->query($sql);

      // Создаём таблицу изображений   
      $sql='CREATE TABLE picturepw ('.
         'uid         INTEGER NOT NULL REFERENCES stockpw(uid),'.  // идентификатор пункта меню (раздел или статья сайта)
         'NamePic     VARCHAR NOT NULL,'.                          // заголовок изображения к статье (имя файла без расширения)
         'TranslitPic VARCHAR NOT NULL UNIQUE,'.                   // транслит заголовка изображения
         'Ext         VARCHAR NOT NULL,'.                          // расширение файла заголовка изображения
         'mime_type   TEXT,'.                                      // MIME-тип файла
         'DatePic     DATETIME,'.                                  // дата\время создания изображения
         'SizePic     INTEGER,'.                                   // размер изображения
         'CommPic     TEXT,'.                                      // комментарий к изображению
         'Width       INTEGER,'.                                   // ширина изображения в пикселах
         'Height      INTEGER,'.                                   // высота изображения в пикселах
         'Descript    TEXT,'.                                      // тег Description
         'Pic         BLOB,'.                                      // изображение
         'PRIMARY KEY (uid, TranslitPic))';                                     
      $st = $pdo->query($sql);
      // Создаем индекс по транслиту имени файла без расширения в таблице изображений      
      $sql='CREATE INDEX IF NOT EXISTS iTranslitPic ON picturepw (TranslitPic)';
      $st = $pdo->query($sql);

      // Создаём контрольную таблицу базы данных   
      $sql='CREATE TABLE ctrlpw ('.
         'bid         VARCHAR NOT NULL,'.    // наименование базы данных
         'СommBase    TEXT)';                // комментарий по базе данных
      $st = $pdo->query($sql);
      */
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
function _BaseFirstCreate($basename,$username,$password,$aCharters) 
{
   // Получаем спецификацию файла базы данных 
   $filename=$basename.'.db3';
   // Проверяем существование и удаляем файл копии базы данных 
   $filenameOld=$basename.'-copy.db3';
   _UnlinkFile($filenameOld);
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
   _UnlinkFile($filename);
   \prown\ConsoleLog('Проверено существование и удалён старый файл базы данных: '.$filename);  
   // Создается объект PDO и файл базы данных
   $pdo=_BaseConnect($basename,$username,$password);
   \prown\ConsoleLog('Создан объект PDO и файл базы данных');
   // Создаём таблицы базы данных
   CreateTables($pdo,$aCharters);
   \prown\ConsoleLog('Созданы таблицы и выполнено начальное заполнение'); 
   
   /*
   // Отрабатываем действия при отладке создания базы данных
   if ($aCharters=='-')
   {
      // Выбираем контрольную таблицу для меню из базы данных и удаляем объект
      $stmt = $pdo->query("SELECT * FROM stockpw");
      $table = $stmt->fetchAll();
      unset($pdo);          
      \prown\ConsoleLog('Выбрана таблица материалов из базы данных'); 
      // Формируем массив для представления таблицы
      $arrayl = array(); 
      aRecursLevel($arrayl,$table);
      echo 'Таблица материалов из базы данных: '.$filename; 
      aViewLevel($arrayl);
      \prown\ConsoleLog('Сформирован массив для представления таблицы'); 
      // Формируем массив c указанием путей  
      $array = array();                         // выходной массив
      $array_idx_lvl = array();                 // индекс по полю level
      echo '<br>';  
      echo 'Таблица материалов c указанием путей и транслита из базы данных: '.$filename;
      aRecursPath($array,$array_idx_lvl,$table); 
      aViewPath($array);
      \prown\ConsoleLog('Сформирован массив c указанием путей и транслита');
   } 
   */
}


/*
// _BaseFirstCreate($basename,$username,$password,$aCharters)                 - Создать резервную копию базы данных и заново построить новую базу данных
// aRecursLevel(&$array,$data,$pid=0,$level=0)                                - Сформировать массив для представления таблицы до уровня
// aRecursPath(&$array,&$array_idx_lvl,$data,$pid=0,$level=0,$path="")        - Сформировать массив представления таблицы c указанием путей    
// aViewLevel($array)                                                         - Вывести содержимое массива в первом виде - до уровня 
// aViewPath($array)                                                          - Вывести содержимое массива с путями и транслитом  
// cUidPid($Uid,$Pid,$cLast)                                                  - Обеспечить смещение строк меню при отладке 
// sort_link_th($title,$a,$b,$SignAsc,$SignDesc)                              - Включить ссылку в текущую строку таблицы меню с сортировкой по полям
// SpacesOnLevel($lvl,$cLast,$Uid,$Pid,$otlada)                               - Обеспечить иммитацию пробелов смещения строк меню при отладке 
// CreateTables($pdo,$aCharters)                                              - Создать таблицы базы данных и выполнить начальное заполнение  

// -------------------------------------------------------- ЗАПРОСЫ ПО БАЗЕ ---
// CountPoint($pdo,$ParentID)  - Выбрать число записей по родителю                  
// SelRecord($pdo,$UnID)       - Выбрать запись по идентификатору 
// ****************************************************************************
// *          Сформировать массив для представления таблицы до уровня         *
// *              (по мотивам - https://m.habr.com/ru/post/280944/)           *
// ****************************************************************************
function aRecursLevel(&$array,$data,$pid = 0,$level = 0)
{
   foreach ($data as $row)   
   {
      // Смотрим строки, pid которых передан в функцию,
      // начинаем с нуля, т.е. с корня сайта
      if ($row['pid'] == $pid)   
      { 
         // Собираем строку в ассоциативный массив
         $_row['uid']=$row['uid'];
         $_row['pid']=$row['pid'];
         // Функцией str_pad добавляем точки
         $_row['NameArt']=$_row['NameArt']=str_pad('', $level*3, '.').$row['NameArt']; 
         // Добавляем уровень
         $_row['level']=$level;      
         $_row['IdCue']=$row['IdCue'];
         $_row['access']=$row['access'];
         $_row['Translit']=$row['Translit'];       
         $_row['Name']=$row['NameArt'];       
         // Прибавляем каждую строку к выходному массиву
         $array[]=$_row; 
         // Строка обработана, теперь запустим эту же функцию для текущего uid, то есть
         // пойдёт обратотка дочерней строки (у которой этот uid является pid-ом)
         aRecursLevel($array,$data,$row['uid'],$level + 1);
      }
   }
}
// ****************************************************************************
// *         Сформировать массив представления таблицы c указанием путей      *
// ****************************************************************************
function aRecursPath(&$array,&$array_idx_lvl,$data,$pid=0,$level=0,$path="")
{
   foreach ($data as $row)   
   {
      // Смотрим строки, pid которых передан в функцию,
      // начинаем с нуля, т.е. с корня сайта
      if ($row['pid'] == $pid)   
      { 
         // Собираем строку в ассоциативный массив
         $_row['uid']=$row['uid'];
         $_row['pid']=$row['pid'];
         // Функцией str_pad добавляем точки
         $_row['NameArt']=$_row['NameArt']=str_pad('', $level*3, '.').$row['NameArt']; 
         // Добавляем уровень
         $_row['level']=$level;      
         $_row['IdCue']=$row['IdCue'];
         $_row['path']=$path."/".$row['NameArt'];   // добавляем имя к пути
         $_row['Translit']=$row['Translit'];        // добавляем транслит
         $_row['access']=$row['access'];
         $array[$row['uid']] = $_row;   // Результирующий массив индексируемый по uid
         // Для быстрой выборки по level, формируем индекс
         $array_idx_lvl[$level][$row['uid']] = $row['uid'];
         // Строка обработана, теперь запустим эту же функцию для текущего uid, то есть
         // пойдёт обработка дочерней строки (у которой этот uid является pid-ом)
         aRecursPath($array,$array_idx_lvl,$data,$row['uid'],$level+1,$_row['path']);
      } 
   }
}
// ****************************************************************************
// *           Вывести содержимое массива в первом виде - до уровня           *
// ****************************************************************************
function aViewLevel($array)
{
   echo '<pre>';
   // Выводим шапку
   echo '<table border=2>';
   echo '<tr>';
   echo '<td>UID</td>'; 
   echo '<td>'.str_pad('PID',4," ",STR_PAD_LEFT).'</td>'; 
   echo '<td> NAMEART</td>'; 
   echo '<td>LEVEL</td>'; 
   echo '<td>'.str_pad('IDCUE',6," ",STR_PAD_LEFT).'</td>'; 
   echo '<td>'.' access'.'</td>'; 
   echo '</tr>';        
   // Выводим данные
   foreach ($array as $value)
   {
      echo '<tr>';
      echo '<td>'; 
      echo str_pad($value['uid'],3," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['pid'],4," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['NameArt']; 
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['level'],5," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['IdCue'],6," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      if ($value['access']==acsAutor) echo ' АВТОР';
      else if ($value['access']==acsClose) echo ' Закрыт';
      else echo ' Все';
      echo '</td>'; 
      echo '</tr>';
   }
   echo '</table>';
   echo '</pre>';
}
// ****************************************************************************
// *             Вывести содержимое массива с путями и транслитом             *
// ****************************************************************************
function aViewPath($array)
{
   echo '<pre>';
   // Выводим шапку
   echo '<table border=2>';
   echo '<tr>';
   echo '<td>UID</td>'; 
   echo '<td>'.str_pad('PID',4," ",STR_PAD_LEFT).'</td>'; 
   echo '<td> NAMEART</td>'; 
   echo '<td>LEVEL</td>'; 
   echo '<td> PATH</td>'; 
   echo '<td> TRANSLIT</td>'; 
   echo '<td>'.str_pad('IDCUE',6," ",STR_PAD_LEFT).'</td>'; 
   echo '<td>'.' access'.'</td>'; 
   echo '</tr>';        
   // Выводим данные
   foreach ($array as $value)
   {
      echo '<tr>';
      echo '<td>'; 
      echo str_pad($value['uid'],3," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['pid'],4," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['NameArt']; 
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['level'],5," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['path'];
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['Translit'];
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['IdCue'],6," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      if ($value['access']==acsAutor) echo ' АВТОР';
      else if ($value['access']==acsClose) echo ' Закрыт';
      else echo ' Все';
      echo '</td>'; 
      echo '</tr>';
   }
   echo '</table>';
   echo '</pre>';
}
// ----------------------------------------------------------------------------
function getIconCue($Translit)
{
   if ($Translit=='moya-zhizn') $icon='&#129392;';
   else if ($Translit=='mikroputeshestviya') $icon='&#9978;';
   else if ($Translit=='vsyakoe-raznoe') $icon='&#9994;';
   else if ($Translit=='v-kontakte') $icon='&#128165;';
   else if ($Translit=='moj-mir') $icon='&#10024;';
   else if ($Translit=='perepechatka') $icon='&#9924;';
   else if ($Translit=='progulki') $icon='&#128692;';
   else if ($Translit=='igry') $icon='&#127922;';
   else $icon='&#9925;'; 
   return '<i class="UniIcon">'.$icon.'</i>';
}
// ****************************************************************************
// *   Включить ссылку в текущую строку таблицы меню с сортировкой по полям   *
// ****************************************************************************
function sort_link_th($title,$a,$b,$SignAsc,$SignDesc) 
{
   $sort = @$_GET['Sort'];
   if ($sort == $a) 
   {
      return '<a class="ipvSort" href="?Sort=' . $b . '">' . $title . ' <i>'.$SignAsc.'</i></a>';
   } 
   elseif ($sort == $b) 
   {
      return '<a class="ipvSort" href="?Sort=' . $a . '">' . $title . ' <i>'.$SignDesc.'</i></a>'; 
   } 
   else 
   {
      return '<a class="ipvSort" href="?Sort=' . $a . '">' . $title . '</a>'; 
   }
}
// ****************************************************************************
// *      Создать таблицы базы данных и выполнить начальное заполнение        *
// ****************************************************************************
function CreateTables($pdo,$aCharters)
{
   try 
   {
      $pdo->beginTransaction();
      // Включаем действие внешних ключей
      $sql='PRAGMA foreign_keys=on;';
      $st = $pdo->query($sql);
      // Создаём таблицу идентификаторов типов статей   
      $sql='CREATE TABLE cue ('.
         'IdCue          INTEGER PRIMARY KEY NOT NULL UNIQUE,'.
         'NameCue        VARCHAR )';
      $st = $pdo->query($sql);
      // Заполняем таблицу идентификаторов типов статей
      // (для правильного формирования тегов, введено понятие раздела без материалов. 
      // Добавление нового раздела в базу данных сопровождается пометкой
      // 'раздел без материалов', при появлении статей в нем метка меняется на 
      // 'раздел')
      $aСues=[
         [ -1, 'Раздел'],
         [  0, 'Статья для сайта = материал'],
      ];
      $statement = $pdo->prepare("INSERT INTO [cue] ".
         "([IdCue], [NameCue]) VALUES ".
         "(:IdCue,  :NameCue);");
      $i=0;
      foreach ($aСues as [$IdCue,$NameCue])
      $statement->execute([
         "IdCue"      => $IdCue, 
         "NameCue"    => $NameCue
      ]);
      // Создаём таблицу материалов (основу для построения меню)  
      $sql='CREATE TABLE stockpw ('.
         'uid         INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.  // идентификатор пункта меню (раздел или статья сайта)
         'pid         INTEGER NOT NULL REFERENCES stockpw(uid),'.    // идентификатор родителя - uid элемента уровнем выше 
         'IdCue       INTEGER NOT NULL REFERENCES cue(IdCue),'.      // указатель раздела статьи
         'NameArt     VARCHAR NOT NULL,'.                            // заголовок материала = статьи сайта
         'Translit    VARCHAR NOT NULL,'.                            // транслит заголовка
         'access      INTEGER NOT NULL,'.                            // доступ к пунктам меню (All/Autor)
         'DateArt     VARCHAR NOT NULL,'.                            // дата статьи сайта/юникод иконки раздела
         'description TEXT,'.                                        // описание статьи
         'keywords    TEXT,'.                                        // ключевые слова статьи
         'Art         TEXT)';                                        // материал = статья сайта
      $st = $pdo->query($sql);
      
      // Заполняем таблицу материалов в начальном состоянии (на 2022-12-20)

      $com3="&lt;p style=&quot;text-align: justify;&quot;&gt;&lt;span style=&quot;font-family: 'comic sans ms', sans-serif;&quot;&gt;&amp;nbsp; ".
      "Физико-математический факультет ПетрГУ (ПГУ им.О.В.Кусинена в моё время) наложил на меня отпечаток. Все в моей голове строится по степеням ".
      "двойки, как-то это управляет моей жизнью и упрощает её (2в0=1, 2в1=2, 2во2=4, 2в3=8, 2в4=16, &amp;hellip;). Теплица на даче одна (или 2, ".
      "в зависимости от уровня благосостояния в стране). В теплице 2 грядки. На грядке два ряда, в каждом ряду по 8, например, томатов. Когда выпекаю ".
      "булочки или пирожки, их получается по 8 или 16. В слоеном тесте получается 256 слоев. Лыж пара, лыжных палок пара (иногда одна лыжа или палка ".
      "ломается).&lt;/span&gt;&lt;/p&gt;".
      "&lt;p style=&quot;text-align: justify;&quot;&gt;&lt;span style=&quot;font-family: 'comic sans ms', sans-serif;&quot;&gt;&amp;nbsp; Но, иногда, ".
      "что-то в голове щёлкает и, начинает работать система со смещением степеней двойки на единицу (2 в степени N + 1: т.е. 9, 17, &amp;hellip;). ".
      "Например, супруга заставляет повесить занавеску и к занавеске дает 20 прищепок, и у меня всегда 3 остаются лишними. Как я вешаю занавески: ".
      "прищепку с правого края, прищепку с левого края. Далее возникает естественное желание повесить занавеску на скрепку по центру. Что я и делаю. ".
      "Далее опять закрепляю два провиса справа и слева от центра, и так далее. И три скрепки остаются &amp;ndash; их некуда закрепить, руки не ".
      "поднимаются.&lt;/span&gt;&lt;/p&gt;".
      "&lt;p style=&quot;text-align: justify;&quot;&gt;&lt;span style=&quot;font-family: 'comic sans ms', sans-serif;&quot;&gt;&amp;nbsp; ".
      "Правда, китайская игровая философия тоже наложила отпечаток. На втором курсе университета китайская философия въехала в голову через ГО ".
      "(это не гражданская оборона на военной кафедре, а вэйци, бадук &amp;ndash; настольная игра из черных и белых камней. После нескольких лет ".
      "этой болезни, все мои дела строятся по принципам этой игры: ярко выраженное стратегическое начало фусеки, как правило, вызывающее ".
      "задержку на старте, собственно само дело, идущее к цели и стремительное (только не зевай) йосе, когда все ясно. Но и здесь, как видно, ".
      "бинарная, двоичная основа. (А про компьютеры и программы, и говорить нечего).&lt;/span&gt;&lt;/p&gt;".
      "&lt;p style=&quot;text-align: justify;&quot;&gt;&amp;nbsp;&lt;/p&gt;";

      $com17='
      Была весна, мы с Ричей уже соскучились по походам. Решили прокатиться по неизведанной дороге в сторону реки Шапшы. 
      "Поехали. 💯 Ура!!!" - так сказал мне дорогой пёсик, уткнувшись своим мокрым носом в нос мой, который тоже стал мокрым.
      "Подожди. Весна! Всё кругом тает." - сказал я.
      "Надо сделать карту, продумать маршрут. Надо приготовить машину, надо собрать кушаньки. Неизвестно докуда доедем, а еще и домой вернуться нужно. 😟"
      Пару часиков заняла подготовка. Заложили контрольные точки в навигатор. Поехали.
      Ехать и мне, и собаке интересно. Здесь мы не были, места неизведанные. Едем, проехали Лососинное, проезжаем Шапшезеро, дальше яма на яме и развилки туда-сюда.
      Едем потихонечку, качаемся, заезжаем в лужи, вспоминаем детство, настроение хорошее, в машине не страшно. Едем, едем, видим впереди ручеек перетекает через дорогу. Решили выйти погулять, размять ноги (или лапы, у кого-что). Вышли, гуляем. 
      Вдруг пёса зарычал. Что такое? А! Следы! Большие!
      "Рича, это мишка. Хватай палку, на всякий случай. Будем его брать!" - сказал я и подумал, лишь бы он нас не взял.
      ';

      // Назначаем массив с начальной структурой основной базы данных
      if ($aCharters=='-'){
      $aCharters=[                                                          
         [ 1, 0,-1, 'ittve.me',                                            '/',                                              acsAll,'20',''],
         [ 2, 1,-1, 'Моя жизнь',                                           'moya-zhizn',                                     acsAll,'20',''],
         [ 3, 2, 0,    'Особенности устройства винтиков в моей голове',    'osobennosti-ustrojstva-vintikov-v-moej-golove',  acsAll,'2010.12.30',$com3],
         [ 4, 1,-1, 'Микропутешествия',                                    'mikroputeshestviya',                             acsAll,'20',''],
         [ 5, 4, 0,    'Киндасово - земля карельского юмора',              'kindasovo-zemlya-karelskogo-yumora',             acsAll,'2010.05.20',''],
         [ 6, 4, 0,    'Гора Сампо. Озеро, светлый лес, тропинка в небо',  'gora-sampo-ozero-svetlyj-les-tropinka-v-nebo',   acsAll,'2010.06.23',''],
         [ 7, 4, 0,    'Падозеро, кладбище заключенных лагеря №517',       'padozero-kladbishche-zaklyuchennyh-lagerya-517', acsAll,'2010.07.03',''],
         [ 8, 4, 0,    'Таёжный зоопарк на озере Сямозеро',                'tayozhnyj-zoopark-na-ozere-syamozero',           acsAll,'2010.07.04',''],
         [ 9, 4, 0,    'Шелтозеро. Так жили вепсы',                        'sheltozero-tak-zhili-vepsy',                     acsAll,'2010.07.10',''],
         [10, 4, 0,    'Полоса 2300 - военный аэродром в Гирвасе',         'polosa-2300-voennyj-aehrodrom-v-girvase',        acsAll,'2010.07.17',''],
         [11, 4, 0,    'Чертов стул, кусочек ботанического сада',          'chertov-stul-kusochek-botanicheskogo-sada',      acsAll,'2010.09.12',''],
         [12, 4, 0,    'Деревянное чудо на холме',                         'derevyannoe-chudo-na-holme',                     acsAll,'2010.10.07',''],
         [13, 1,-1, 'Всякое-разное',                                       'vsyakoe-raznoe',                                 acsAll,'20',''],
         [14, 1,-1, 'В контакте',                                          'v-kontakte',                                     acsAll,'20',''],
         [15, 1,-1, 'Мой мир',                                             'moj-mir',                                        acsAll,'20',''],
         [16, 1,-1, 'Прогулки',                                            'progulki',                                       acsAll,'20',''],
         [17,16, 0,    'Охота на медведя',                                 'ohota-na-medvedya',                              acsAll,'2011.05.06',$com17],
         [18, 1,-1, 'Дополнения к микропутешествиям',                      'dopolneniya-k-mikroputeshestviyam',              acsAll,'20',''],
         [19, 1,-1, 'Перепечатка',                                         'perepechatka',                                   acsAll,'20',''],
         [20, 4, 0,    'Благовещенский Ионо-Яшезерский мужской монастырь', 'iono-yashezerskij-muzhskoj-monastyr',            acsAll,'2010.10.10',''],
         [21, 0,-1, 'ittve.end',                                           '/',                                              acsAll,'20','']
      ];}       
      $statement = $pdo->prepare("INSERT INTO [stockpw] ".
         "([uid], [pid], [IdCue], [NameArt], [Translit], [access], [DateArt], [Art]) VALUES ".
         "(:uid,  :pid,  :IdCue,  :NameArt,  :Translit,  :access,  :DateArt,  :Art);");
      $i=0;
      foreach ($aCharters as
          [$uid,  $pid,  $IdCue,  $NameArt,  $Translit,  $access,  $DateArt,  $Art])
      $statement->execute([
         "uid"      => $uid, 
         "pid"      => $pid, 
         "IdCue"    => $IdCue, 
         "NameArt"  => $NameArt, 
         "Translit" => $Translit, 
         "access"   => $access, 
         "DateArt"  => $DateArt, 
         "Art"      => $Art
      ]);
      // Создаем индекс по транслиту в таблице материалов      
      $sql='CREATE INDEX IF NOT EXISTS iTranslit ON stockpw (Translit)';
      $st = $pdo->query($sql);

      // Создаём таблицу изображений   
      $sql='CREATE TABLE picturepw ('.
         'uid         INTEGER NOT NULL REFERENCES stockpw(uid),'.  // идентификатор пункта меню (раздел или статья сайта)
         'NamePic     VARCHAR NOT NULL,'.                          // заголовок изображения к статье (имя файла без расширения)
         'TranslitPic VARCHAR NOT NULL UNIQUE,'.                   // транслит заголовка изображения
         'Ext         VARCHAR NOT NULL,'.                          // расширение файла заголовка изображения
         'mime_type   TEXT,'.                                      // MIME-тип файла
         'DatePic     DATETIME,'.                                  // дата\время создания изображения
         'SizePic     INTEGER,'.                                   // размер изображения
         'CommPic     TEXT,'.                                      // комментарий к изображению
         'Width       INTEGER,'.                                   // ширина изображения в пикселах
         'Height      INTEGER,'.                                   // высота изображения в пикселах
         'Descript    TEXT,'.                                      // тег Description
         'Pic         BLOB,'.                                      // изображение
         'PRIMARY KEY (uid, TranslitPic))';                                     
      $st = $pdo->query($sql);
      // Создаем индекс по транслиту имени файла без расширения в таблице изображений      
      $sql='CREATE INDEX IF NOT EXISTS iTranslitPic ON picturepw (TranslitPic)';
      $st = $pdo->query($sql);

      // Создаём контрольную таблицу базы данных   
      $sql='CREATE TABLE ctrlpw ('.
         'bid         VARCHAR NOT NULL,'.    // наименование базы данных
         'СommBase    TEXT)';                // комментарий по базе данных
      $st = $pdo->query($sql);

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

// -------------------------------------------------------- ЗАПРОСЫ ПО БАЗЕ ---

// ****************************************************************************
// *                       Выбрать число записей по родителю                  *
// ****************************************************************************
function CountPoint($pdo,$ParentID)
{
   $cSQL='SELECT uid FROM stockpw WHERE pid='.$ParentID;
   $stmt = $pdo->query($cSQL);
   $table = $stmt->fetchAll();
   $nCount=count($table);
   if ($nCount==0) $Result='';
   else $Result='<span>'.$nCount.'</span>';
   return $Result; 
}
// ****************************************************** CommonIttveMe.php ***
*/
// ************************************************** CommonKvizzyMaker.php ***
