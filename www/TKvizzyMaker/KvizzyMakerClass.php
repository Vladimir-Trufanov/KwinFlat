<?php namespace ttools; 
                                         
// PHP7/HTML5, EDGE/CHROME                         *** KvizzyMakerClass.php ***

// ****************************************************************************
// * KwinFlat/TTools                  Построитель базы данных моего хозяйства *
// *                                                                          *
// * v4.4.1, 30.05.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2024 tve                          Дата создания:  03.11.2024 *
// ****************************************************************************

// ---------------------------------------------------------- МЕТОДЫ КЛАССА ---
require_once("CommonKvizzyMaker.php"); 
// BaseConnect();                                    - Открыть соединение с базой данных
// BaseFirstCreate();                                - Создать резервную копию и заново построить новую базу данных
require_once("CommonLeadMaker.php"); 



require_once("CommonStateMaker.php"); 
require_once("CommonStreamMaker.php"); 

// SelChange($pdo)                                     - Выбрать изменения состояний управляющих команд  
// SelLead($pdo,$action);                              - Выбрать управляющее выражение: $action=-1, текущего режима работы вспышки; $action=-2, интервалов подачи сообщений от контроллера 
// setMessForLead($pdo,$num,$sjson)                    - Записать в базу данных изменения состояния управляющих json-команд 
// TestSetLed4($pdo,$INsjson)                          - Подтвердить изменение и отметить текущий режим работы вспышки
// TestSet($pdo,$INsjson,$action)                      - Подтвердить изменения: $action=-1, текущего режима работы вспышки; $action=-2, интервалов подачи сообщений от контроллера 
// SelectLastMess($pdo);                               - Выбрать запись из таблицы последнего полученного json-сообщения  
// UpdateLastMess($pdo,$myTime,$myDate,$cycle,$sjson); - Обновить запись в таблице последнего полученного json-сообщения

// --SelChange($pdo);                                  - Выбрать изменения состояний     
// --SelectLMP33($pdo);                                - Выбрать запись режима работы контрольного светодиода Led4   
// --UpdateModeLMP33($pdo,$action);                    - Обновить установку по режиму работы контрольного светодиода  
// --InsertImgStream($pdo,$src);                         - Вставить текущее изображение
// ----------------------------------------------------------------------------

class KvizzyMaker
{
   // ----------------------------------------------------- СВОЙСТВА КЛАССА ---
   protected $basename;        // база данных моего хозяйства 
   protected $username;        // логин для доступа к базе данных
   protected $password;        // пароль
   protected $email;           // email посетителя

   public function __construct($SiteHost) 
   {
      // Инициализируем свойства класса
      $this->basename=$SiteHost.'/Base'.'/kvizzy';  // имя базы без расширения 'db3'
      $this->username='tve';                        // логин посетителя для авторизации
      $this->password='A358-ty19';                  // пароль
      $this->email='tve58@inbox.ru';                // email посетителя
      // При необходимости создаем базу данных моего хозяйства
      if (!file_exists($this->basename.'.db3')) 
         _BaseFirstCreate($this->basename,$this->username,$this->password);
   }
   // ----------------------------------------------- CommonKvizzyMaker.php ---
   // Открыть соединение с базой данных                 
   public function BaseConnect()
   {
      return _BaseConnect($this->basename,$this->username,$this->password);
   }
   // Создать резервную копию и заново построить новую базу данных 
   public function BaseFirstCreate() 
   {
      _BaseFirstCreate($this->basename,$this->username,$this->password);
   }
   // ------------------------------------------------- CommonLeadMaker.php ---
   
   
   
   
   // Записать в базу данных изменения состояния управляющих json-команд 
   public function setMessForLead($pdo,$num,$sjson) 
   {
      return _setMessForLead($pdo,$num,$sjson);
   }
   // Выбрать изменения состояний управляющих json-команд  
   public function SelChange($pdo)
   {
      $table=_SelChange($pdo);
      return $table;
   }
   // Выбрать управляющее выражение: $action=-1, текущего режима работы вспышки; $action=-2, интервалов подачи сообщений от контроллера 
   public function SelLead($pdo,$action)
   {
      $table=_SelLead($pdo,$action);
      return $table;
   }
   // Выбрать запись из таблицы последнего полученного json-сообщения  
   // SelectLastMess($pdo);               - 
   public function SelectLastMess($pdo)
   {
      $table=_SelectLastMess($pdo);
      return $table;
   }
   // Обновить запись в таблице последнего полученного json-сообщения
   public function UpdateLastMess($pdo,$myTime,$myDate,$cycle,$sjson)
   {
      _UpdateLastMess($pdo,$myTime,$myDate,$cycle,$sjson);
   }
   // Выбрать запись режима работы контрольного светодиода Led4   
   public function SelectLMP33($pdo)
   {
      $table=_SelectLMP33($pdo);
      return $table;
   }
   // Подтвердить изменения: $action=-1, текущего режима работы вспышки; $action=-2, интервалов подачи сообщений от контроллера 
   public function TestSet($pdo,$INsjson,$action)
   {
      return _TestSet($pdo,$INsjson,$action);
   }
   // Обновить установку по режиму работы контрольного светодиода  
   public function UpdateModeLMP33($pdo,$action)
   {
      $messa=_UpdateModeLMP33($pdo,$action);
      return $messa;
   }
   // Вставить текущее изображение 
   public function InsertImgStream($pdo,$src,$time,$frame)
   {
      $messa=_InsertImgStream($pdo,$src,$time,$frame);
      return $messa;
   }
   // Выбрать запись из таблицы базы данных State по Led4
   public function SelImgStream($pdo,$time,$frame)
   {
      $messa=_SelImgStream($pdo,$time,$frame);
      return $messa;
   }

}

// *************************************************** KvizzyMakerClass.php ***
