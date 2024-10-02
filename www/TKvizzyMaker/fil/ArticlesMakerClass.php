<?php namespace ttools; 
                                         
// PHP7/HTML5, EDGE/CHROME                       *** ArticlesMakerClass.php ***

// ****************************************************************************
// * TPhpTools                                   Построитель материалов сайта *
// *                                                                          *
// * v1.1, 05.02.2023                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  03.11.2022 *
// ****************************************************************************

/**
 * Класс ArticlesMaker организовывает базу данных материалов сайта (на примерах
 * материалов сайтов 'ittve.pw' и 'ittve.me', обеспечивает построение и ведение 
 * меню статей.
 * 
 * Для взаимодействия с объектами класса должны быть определены константы:
 *
 * articleSite  - тип базы данных (по сайту)
 * pathPhpTools - путь к каталогу с файлами библиотеки прикладных классов;
 * pathPhpPrown - путь к каталогу с файлами библиотеки прикладных функции
 * stylesdir    - каталог стилей элементов разметки и фонтов
 * imgdir       - каталог файлов служебных для сайта изображений
 * jsxdir       - каталог размещения файлов javascript
 *    
 * Пример создания объекта класса:
 * 
 * // Указываем место размещения библиотеки прикладных функций TPhpPrown
 * define ("pathPhpPrown",$SiteHost.'/TPhpPrown/TPhpPrown');
 * // Указываем место размещения библиотеки прикладных классов TPhpTools
 * define ("pathPhpTools",$SiteHost.'/TPhpTools/TPhpTools');
 * // Указываем каталоги размещения файлов
 * define("stylesdir",'Styles');   // стили элементов разметки и фонты
 * define("imgdir",'Images');      // служебные для сайта файлы изображений
 * 
 * // Cоздаем объект для управления материалами сайта в базе данных
 * $Arti=new ttools\ArticlesMaker($basename,$username,$password,$SiteRoot);
**/

// Свойства:
//
// $kindMessage - объект вывода сообщений. По умолчанию = NULL, что означает,
//    что сообщение выводится через alert. Методом setKindMessage может быть
//    подключен объект класса TNotice, который и будет заниматься выводом всех
//    сообщений

// ------------------------------------------ Путь к каталогу файлов класса ---
define ("TArticlesMakerDir",'ttools/TArticlesMaker');  

// --------------------- Константы для указания типа базы данных (по сайту) ---
define ("tbsIttveme", 'IttveMe'); 
define ("tbsIttvepw", 'IttvePw'); 
// -------------------------------------------------- Доступ к пунктам меню ---
define ("acsAll",   1);      // доступ разрешен всем
define ("acsClose", 2);      // закрыт, статья в разработке
define ("acsAutor", 4);      // только автору-хозяину сайта

// Подгружаем модули функций класса, связанные с конкретным сайтом
if (articleSite==tbsIttveme) require_once("CommonIttveMe.php"); 
elseif (articleSite==tbsIttvepw) require_once("CommonIttvePw.php"); 

// Подгружаем нужные модули библиотеки прикладных функций
require_once pathPhpPrown."/MakeCookie.php";
require_once pathPhpPrown."/iniConstMem.php";

// Подгружаем нужные модули библиотеки прикладных классов
require_once(pathPhpTools."/CommonTools.php");

// ---------------------------------- Режимы работы с материалом и галереей ---
define ('mwgViewing', 'просмотр');   
define ('mwgEditing', 'редактирование');  

class ArticlesMaker
{
   // ----------------------------------------------------- СВОЙСТВА КЛАССА ---
   public $kindMessage;         // Объект вывода сообщений;  
   public $getArti;             // Транслит текущего материала
   public $GalleryMode;         // Режим работы с материалом и галереей
   public $note;                // Объект вывода сообщений

   protected $imgdir;           // Каталог файлов служебных для сайта изображений

   protected $basename;         // База материалов: $_SERVER['DOCUMENT_ROOT'].'/itpw';
   protected $username;         // Логин для доступа к базе данных
   protected $password;         // Пароль
   // ------------------------------------------------------- МЕТОДЫ КЛАССА ---
   public function __construct($basename,$username,$password,$note) 
   {
      // Инициализируем свойства класса
      $this->imgdir      = imgdir; 
      $this->note        = $note; 
      
      $this->basename    = $basename;
      $this->username    = $username;
      $this->password    = $password;
      $this->kindMessage = NULL;
      
      // Изначально устанавливаем режим просмотра для работы с материалом
      $this->GalleryMode=mwgViewing;
      // Выбираем текущий транслит, если есть параметр по просмотру материала
      // и сохраняем кукис транслита 
      if (\prown\getComRequest('arti')<>NULL) 
      $this->getArti=$this->setCurrTranslit(\prown\getComRequest('arti'));   
      // Выбираем текущий транслит, если есть параметр по редактированию
      // материала и сохраняем кукисы транслита.
      //                                     Только в этом случае устанавливаем 
      //                                         режим редактирования материала
      else if (\prown\getComRequest('artim')<>NULL) 
      {
         $this->getArti=$this->setCurrTranslit(\prown\getComRequest('artim'));
         $this->GalleryMode=mwgEditing;
      }
      // Если параметр не передавался, то выбираем из существующего кукиса
      else
      {
         if (isset($_COOKIE['PunktMenu'])) 
            $this->getArti=\prown\MakeCookie('PunktMenu');
         else 
            $this->getArti=NULL; 
      }
      // Выполняем действия на странице до отправления заголовков страницы: 
      // (устанавливаем кукисы и т.д.)                  
      $this->Zero();
      // Трассируем установленные свойства
      //\prown\ConsoleLog('$this->getArti='.$this->getArti); 
   }
   // *************************************************************************
   // *           Спрятать в __destruct обработку клика выбора раздела        *
   // *                    (при назначении новой статьи)                      *
   // *************************************************************************
   public function __destruct() 
   {
   }
   // *************************************************************************
   // *         Назначить заданный транслит текущим и убрать его в кукис      *
   // *************************************************************************
   public function setCurrTranslit($getArti) 
   {
      $CurrTranslit=\prown\MakeCookie('PunktMenu',$getArti,tStr); 
      return $CurrTranslit;
   }
   // *************************************************************************
   // *   Выполнить действия на странице до отправления заголовков страницы:  *
   // *                         (установить кукисы и т.д.)                    *
   // *************************************************************************
   private function Zero()
   {
      // Проверяем, нужно ли заменить файл стилей в каталоге редактирования и,
      // (при его отсутствии, при несовпадении размеров или старой дате) 
      // загружаем из класса 
      CompareCopyRoot('TestBase.php',TArticlesMakerDir);
   }
   // *************************************************************************
   // *       Подключить объект класса TNotice, который будет заниматься      *
   // *                        выводом всех сообщений                         *
   // *************************************************************************
   public function setKindMessage($note)
   {
      $this->kindMessage = $note;
   }
   private function Alert($messa)
   {
      if ($this->kindMessage==NULL) \prown\Alert($messa);
      else $this->kindMessage->Info($messa); 
   }
   // *************************************************************************
   // *        Установить стили пространства редактирования материала         *
   // *************************************************************************
   public function Init()
   {
      // Только в режиме редактирования подключаем удаление старых файлов
      if ($this->GalleryMode==mwgEditing)
      {
         ?> <script> 
         $(document).ready(function() 
         {
            onbeforeunload=(event) => {EraseFiles();};
         })
         </script> <?php
      }
      /*
      // Настраиваем фоны графическими файлами
      $bgnoise_lg=$this->imgdir.'/bgnoise_lg.jpg';
      $icons=$this->imgdir.'/icons.png';
      echo '
      <style>
      .accordion li > a span,
      .accordion li > i span 
      {
         background:#e0e3ec url('.$bgnoise_lg.') repeat top left;
      }
      .accordion > li > a:before 
      {
         background-image:url('.$icons.');
      }
      </style>
      ';
      */
   }
   // *************************************************************************
   // *                     Открыть соединение с базой данных                 *
   // *************************************************************************
   public function BaseConnect()
   {
      return _BaseConnect($this->basename,$this->username,$this->password);
   }
   // *************************************************************************
   // *    Создать резервную копию базы данных, построить новую базу данных   *
   // * ($aCharters='-',подключить массив со структурой основной базы данных) *
   // *************************************************************************
   public function BaseFirstCreate($aCharters='-') 
   {
      _BaseFirstCreate($this->basename,$this->username,$this->password,$aCharters);
   }

   // ----------------------------------------------------- ЗАПРОСЫ ПО БАЗЕ ---
   
   // *************************************************************************
   // *  Выбрать $pid,$uid,$NameGru,$NameArt,$DateArt,$contents по транслиту  *
   // *************************************************************************
   public function SelUidPid($pdo,$getArti,&$pid,&$uid,&$NameGru,&$NameArt,&$DateArt,&$contents)
   {
      // Так как функция запускается на фазе построения сайта ZERO, то по
      // ошибке возвращается сообщение об этом, иначе возвращается "Все хорошо у меня"
      $ErrMessage=imok;
      // Инициируем возвращаемые данные
      $pid=0; $uid=0; 
      $NameGru='Материал для редактирования не выбран!'; 
      $contents='Новый материал'; 
      $NameArt=''; $DateArt='';
      // Возвращаем ошибку, если транслит не определен
      if ($getArti==NULL) $ErrMessage='Транслит материала не определен';
      // Транслит есть, будем делать запрос
      else
      {
         try
         {
            $pdo->beginTransaction();
            // Выбираем по транслиту $pid,$uid,$NameArt
            $cSQL='SELECT * FROM stockpw WHERE Translit="'.$getArti.'"';
            $stmt=$pdo->query($cSQL);
            $table=$stmt->fetchAll();
            // Фиксируем успешную транзакцию
            $pdo->commit();
            
            $count=count($table); 
            // Если не найдено записей, то диагностируем ошибку.
            if ($count<1) $ErrMessage='Не найдено записей по транслиту: '.$getArti;
            // Если больше одной записи, то диагностируем ошибку
            else if ($count>1) 
               $ErrMessage="По транслиту ".$getArti." найдено более одной записи, всего ".$count;
            // Найдена одна запись, выбираем данные из записи
            else
            {
               $pid=$table[0]['pid']; $uid=$table[0]['uid']; 
               $NameArt=$table[0]['NameArt']; $DateArt=$table[0]['DateArt'];
               $contents=$table[0]['Art'];
               // Добираем $NameGru
               $table=$this->SelRecord($pdo,$pid);
               // Если ошибка, то возвращаем сообщение
               if ($table[0]['Translit']==nstErr) $ErrMessage=$table[0]['NameArt'];
               else
               {
                  if (count($table)>0) $NameGru=$table[0]['NameArt'];
                  else $ErrMessage='Для статьи с Uid='.$uid.' неверный идентификатор группы: Pid='.$pid; 
               }
            }
         } 
         catch (\Exception $e) 
         {
            $ErrMessage=$e->getMessage();
            if ($pdo->inTransaction()) $pdo->rollback();
         }
      }
      return $ErrMessage;
   }
   // *************************************************************************
   // * Выбрать запись по идентификатору                                      *
   // *              (например, узнать наименование группы по идентификатору: *
   // *          $table=SelRecord($pdo,$pid); $NameGru=$table[0]['NameArt'];) *
   // *************************************************************************
   public function SelRecord($pdo,$UnID)
   {
     try
     {
       $pdo->beginTransaction();
       $cSQL='SELECT * FROM stockpw WHERE uid='.$UnID;
       $stmt = $pdo->query($cSQL);
       $table = $stmt->fetchAll();
       $pdo->commit();
     } 
     catch (\Exception $e) 
     {
       $messa=$e->getMessage();
       $table=array(array("NameArt"=>$messa,"Translit"=>nstErr,));
       if ($pdo->inTransaction()) $pdo->rollback();
     }
     return $table; 
   }
   // *************************************************************************
   // *        Найти следующую запись с материалом (статьёй) относительно     *
   // *            текущего идентификатора и выбрать в ней Translit           *
   // *************************************************************************
   public function SelNextTranslit($pdo,$UnID)
   {
     try
     {
       $pdo->beginTransaction();
       $cSQL='SELECT NameArt,Translit FROM stockpw WHERE uid >'.$UnID.' AND IdCue=0 LIMIT 1';
       $stmt = $pdo->query($cSQL);
       $table = $stmt->fetchAll();
       $pdo->commit();
     } 
     catch (\Exception $e) 
     {
       $messa=$e->getMessage();
       $table=array(array("NameArt"=>$messa,"Translit"=>nstErr,));
       if ($pdo->inTransaction()) $pdo->rollback();
     }
     return $table; 
   }
   // *************************************************************************
   // *       Найти предыдущую запись с материалом (статьёй) относительно     *
   // *            текущего идентификатора и выбрать в ней Translit           *
   // *************************************************************************
   public function SelPrevTranslit($pdo,$UnID)
   {
     try
     {
       $pdo->beginTransaction();
       // Первым запросом выбираем максимальный uid меньше данного
       $cSQL='SELECT max(uid) FROM stockpw WHERE uid <'.$UnID.' AND IdCue=0';
       $stmt = $pdo->query($cSQL);
       $table = $stmt->fetchAll();
       // Если по запросу uid не найден, то считаем что был первый и
       // возвращаем сообщение об этом
       if ($table[0]["max(uid)"]==0) 
       {
          $table=array(array("NameArt"=>"NoRecords","Translit"=>nstErr,));       
          $pdo->commit();
          return $table;
       }
       // Если максимальный uid меньше данного найден, 
       // то по нему выбираем транслит
       else
       { 
          $maxUid=$table[0]["max(uid)"];
          $cSQL='SELECT NameArt,Translit FROM stockpw WHERE uid = '.$maxUid;
          $stmt = $pdo->query($cSQL);
          $table = $stmt->fetchAll();
       }  
       $pdo->commit();
     } 
     catch (\Exception $e) 
     {
       $messa=$e->getMessage();
       $table=array(array("NameArt"=>$messa,"Translit"=>nstErr,));
       if ($pdo->inTransaction()) $pdo->rollback();
     }
     return $table; 
   }
   // *************************************************************************
   // *               Выбрать ключи всех изображений к записи и               *
   // *                   другую информацию по идентификатору                 *
   // *************************************************************************
   public function SelImgKeys($pdo,$UnID)
   {
      $cSQL='
         SELECT uid,TranslitPic,
         NamePic,Ext,mime_type,DatePic,SizePic,CommPic
         FROM picturepw WHERE uid='.$UnID;
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      return $table; 
   }
   // *************************************************************************
   // *              Выбрать сведения об изображении по ключам                *
   // *************************************************************************
   public function SelImgPic($pdo,$uid,$TranslitPic)
   {
     try
     {
       $pdo->beginTransaction();
       $cSQL=
          'SELECT [Pic],[mime_type],[Width],[Height],[Descript],[CommPic] '.
          'FROM [picturepw] WHERE uid=:uid AND TranslitPic=:TranslitPic';
       $stmt=$pdo->prepare($cSQL);
       if ($stmt->execute([":uid"=>$uid, ":TranslitPic"=>$TranslitPic]))
       {
         $stmt->bindColumn(1, $Pic, \PDO::PARAM_LOB);
         $stmt->bindColumn(2, $mime_type);
         $stmt->bindColumn(3, $Width);
         $stmt->bindColumn(4, $Height);
         $stmt->bindColumn(5, $Descript);
         $stmt->bindColumn(6, $CommPic);
         
         $table=$stmt->fetch(\PDO::FETCH_BOUND)?
         [
            "uid"         => $uid,
            "TranslitPic" => $TranslitPic,
            "Pic"         => $Pic,
            "Width"       => $Width,
            "Height"      => $Height,
            "Descript"    => $Descript,
            "CommPic"     => $CommPic,
            "mime_type"   => $mime_type
         ]:null;
       } 
       $pdo->commit();
     } 
     catch (\Exception $e) 
     {
       $messa=$e->getMessage();
       $table=[
          "uid"          => $uid,
          "TranslitPic"  => Err,
          "Pic"          => $messa,
          "mime_type"    => 'mime_type'
       ];
       if ($pdo->inTransaction()) $pdo->rollback();
     }
     return $table;
   }
   // *************************************************************************
   // *      Удалить запись об изображении по идентификатору и транслиту:     *
   // *                    в случае успешного удаления функция                *
   // *     возвращает сообщение, что все хорошо, иначе сообщение об ошибке   *
   // *************************************************************************
   public function DelImgRecord($pdo,$uid,$TranslitPic)
   {
     try
     {
       $pdo->beginTransaction();
       $cSQL='DELETE FROM picturepw WHERE uid='.$uid.' AND TranslitPic="'.$TranslitPic.'"';
       $stmt = $pdo->query($cSQL);
       $pdo->commit();
       $messa=imok;
     } 
     catch (\Exception $e) 
     {
       $messa=$e->getMessage();
       if ($pdo->inTransaction()) $pdo->rollback();
     }
     return $messa;
   }
   // *************************************************************************
   // * Удалить запись по идентификатору: в случае успешного удаления функция *
   // *     возвращает сообщение, что все хорошо, иначе сообщение об ошибке   *
   // *************************************************************************
   public function DelRecord($pdo,$UnID)
   {
     try
     {
       $pdo->beginTransaction();
       $cSQL='DELETE FROM stockpw WHERE uid='.$UnID;
       $stmt = $pdo->query($cSQL);
       $pdo->commit();
       $messa=imok;
     } 
     catch (\Exception $e) 
     {
       $messa=$e->getMessage();
       if ($pdo->inTransaction()) $pdo->rollback();
     }
     return $messa;
   }
   // *************************************************************************
   // *                      Вставить материал по транслиту                   *
   // *************************************************************************
   public function InsertByTranslit($pdo,$Translit,$pid,$NameArt,$DateArt,$contents)
   {
     try 
     {
        $pdo->beginTransaction();
        $icontents = htmlspecialchars($contents);	
        $statement = $pdo->prepare("INSERT INTO [stockpw] ".
           "([pid], [IdCue], [NameArt], [Translit], [access], [DateArt], [Art]) VALUES ".
           "(:pid,  :IdCue,  :NameArt,  :Translit,  :access,  :DateArt,  :Art);");
        $statement->execute([
           "pid"      => $pid, 
           "IdCue"    => 0, 
           "NameArt"  => $NameArt, 
           "Translit" => $Translit, 
           "access"   => acsAll, 
           "DateArt"  => $DateArt, 
           "Art"      => $icontents
        ]);
        $pdo->commit();
        $messa=imok;
     } 
     catch (Exception $e) 
     {
        $messa=$e->getMessage();
        // Если в транзакции, то делаем откат изменений
        if ($pdo->inTransaction()) $pdo->rollback();
     }
     return $messa;
   }
   // *************************************************************************
   // *                      Вставить вызов игры по транслиту                 *
   // *************************************************************************
   public function InsGameByTranslit($pdo,$Translit,$NameArt,$DateArt,$contents)
   {
     try 
     {
        $pdo->beginTransaction();
        $icontents = htmlspecialchars($contents);	
        $statement = $pdo->prepare("INSERT INTO [stockpw] ".
           "([pid], [IdCue], [NameArt], [Translit], [access], [DateArt], [Art]) VALUES ".
           "(:pid,  :IdCue,  :NameArt,  :Translit,  :access,  :DateArt,  :Art);");
        $statement->execute([
           "pid"      => 22, 
           "IdCue"    => 2, 
           "NameArt"  => $NameArt, 
           "Translit" => $Translit, 
           "access"   => acsAll, 
           "DateArt"  => $DateArt, 
           "Art"      => $icontents
        ]);
        $pdo->commit();
        $messa=imok;
     } 
     catch (Exception $e) 
     {
        $messa=$e->getMessage();
        // Если в транзакции, то делаем откат изменений
        if ($pdo->inTransaction()) $pdo->rollback();
     }
     return $messa;
   }
   // *************************************************************************
   // *             Проверить, есть ли фотография по транслиту                *
   // *************************************************************************
   public function IsImgByTranslit($pdo,$TranslitPic)
   {
     try
     {
       $pdo->beginTransaction();
       $cSQL='SELECT uid,NamePic FROM picturepw WHERE TranslitPic="'.$TranslitPic.'"';
       $stmt = $pdo->query($cSQL);
       $table = $stmt->fetchAll();
       if (count($table)>0) $table=["uid"=>$table[0]['uid'],"NamePic"=>$table[0]['NamePic'],"TranslitPic"=>$TranslitPic];
       else $table=["uid"=>"-12","NamePic"=>['Не найдено'],"TranslitPic"=>$TranslitPic];
       $pdo->commit();
     } 
     catch (\Exception $e) 
     {
       $messa=$e->getMessage();
       $table=["uid"=>"-99","NamePic"=>$messa,"TranslitPic"=>$TranslitPic];
       if ($pdo->inTransaction()) $pdo->rollback();
     }
     return $table;
   }
   // *************************************************************************
   // *               Вставить реквизиты фотографии по транслиту              *
   // *************************************************************************
   public function InsertImgByTranslit($pdo,$uid,$NamePic,$TranslitPic,$Ext,$mime_type,$DatePic,$SizePic,$Comment,$Width,$Height)
   {
    try 
    {
      $pdo->beginTransaction();
      $statement = $pdo->prepare("INSERT INTO [picturepw] ".              
         "([uid], [NamePic], [TranslitPic], [Ext], [mime_type], [DatePic], [SizePic], [CommPic], [Width], [Height]) VALUES ".
         "(:uid,  :NamePic,  :TranslitPic,  :Ext,  :mime_type,  :DatePic,  :SizePic,  :CommPic,  :Width,  :Height);");
      $statement->execute([
         "uid"         => $uid, 
         "NamePic"     => $NamePic, 
         "TranslitPic" => $TranslitPic, 
         "Ext"         => $Ext, 
         "mime_type"   => $mime_type, 
         "DatePic"     => $DatePic, 
         "SizePic"     => $SizePic, 
         "CommPic"     => $Comment, 
         "Width"       => $Width, 
         "Height"      => $Height
      ]);
      $pdo->commit();
      $messa=imok;
    } 
    catch (\Exception $e) 
    {
       $messa=$e->getMessage();
       if ($pdo->inTransaction()) $pdo->rollback();
    }
    return $messa;
   }
   // *************************************************************************
   // *                Заменить(вставить) фотографию по транслиту             *
   // *************************************************************************
   public function UpdatePicByTranslit($pdo,$pathToFile,$TranslitPic)
   {
    try 
    {
      $pdo->beginTransaction();
      $fh = fopen($pathToFile,'rb');
      $sql = "UPDATE picturepw
             SET Pic = :Pic
             WHERE TranslitPic = :TranslitPic";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':Pic', $fh, \PDO::PARAM_LOB);
      $stmt->bindParam(':TranslitPic', $TranslitPic);
      $stmt->execute();
      unset($fh); 
      $pdo->commit();
      $messa=imok;
    } 
    catch (\Exception $e) 
    {
       $messa=$e->getMessage();
       if ($pdo->inTransaction()) $pdo->rollback();
    }
    return $messa;
   }
   // *************************************************************************
   // *                       Обновить материал по транслиту                  *
   // *************************************************************************
   public function UpdateByTranslit($pdo,$Translit,$contents)
   {
    try 
    {
      $pdo->beginTransaction();
      $statement = $pdo->prepare("UPDATE [stockpw] SET [Art] = :Art WHERE [Translit] = :Translit;");
      $statement->execute(["Art"=>$contents,"Translit"=>$Translit]);
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
   // *************************************************************************
   // *    Записать в базу данных описание (description) текущего материала   *
   // *************************************************************************
   public function PutDescript($pdo,$Uid,$Descript,$modedesc,&$NameGru,&$iif) 
   {
      try 
      {
         $pdo->beginTransaction();
         if ($modedesc=='update') 
         {
            $statement=$pdo->prepare
            ("UPDATE [stockpw] SET [description]=:description WHERE [uid]=:uid;");
         }
         else
         {
            $statement = $pdo->prepare
            ("INSERT INTO [stockpw] ([description]) VALUES (:description) WHERE [uid]=:uid;");
         }
         $statement->execute(["description"=>$Descript,"uid"=>$Uid]);
         $pdo->commit();

         $NameGru='Описание материала записано в базу';
         $iif='все хорошо';
      } 
       catch (\Exception $e) 
       {
          $NameGru=$e->getMessage();
          $iif=nstErr;
          if ($pdo->inTransaction()) $pdo->rollback();
       }
   }
}
// ************************************************* ArticlesMakerClass.php ***
