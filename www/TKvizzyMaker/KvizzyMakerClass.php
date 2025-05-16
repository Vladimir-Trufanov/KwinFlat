<?php namespace ttools; 
                                         
// PHP7/HTML5, EDGE/CHROME                         *** KvizzyMakerClass.php ***

// ****************************************************************************
// * KwinFlat/TTools                  Построитель базы данных моего хозяйства *
// *                                                                          *
// * v2.0.4, 16.05.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2024 tve                          Дата создания:  03.11.2024 *
// ****************************************************************************

// Подгружаем модули функций класса
require_once("CommonKvizzyMaker.php"); 
require_once("CommonStateMaker.php"); 
require_once("CommonLeadMaker.php"); 
require_once("CommonStreamMaker.php"); 

// ---------------------------------------------------------- МЕТОДЫ КЛАССА ---
// SelChange($pdo)                     - Выбрать изменения состояний управляющих команд  
// setMessForLead($pdo,$num,$sjson)    - Записать в базу данных изменения состояния управляющих json-команд 
// TestSetLed4($pdo,$INsjson)          - Подтвердить изменение и отметить текущий режим работы вспышки
// TestSet($pdo,$INsjson,$action)      - Подтвердить изменения: $action=-1, текущего режима работы вспышки; $action=-2, интервалов подачи сообщений от контроллера 

// --SelectLed4($pdo);                                - Выбрать запись из таблицы базы данных State по Led4
// --UpdateLed4($pdo,$myTime,$myDate,$cycle,$sjson);  - Обновить запись в таблице базы данных State по Led4 
// --BaseConnect();                                    - Открыть соединение с базой данных
// --BaseFirstCreate();                                - Создать резервную копию и заново построить новую базу данных
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
   // Выбрать запись из таблицы базы данных State по Led4  
   public function SelectLed4($pdo)
   {
      $table=_SelectLed4($pdo);
      return $table;
   }
   // Обновить запись в таблице базы данных State по Led4 
   public function UpdateLed4($pdo,$myTime,$myDate,$cycle,$sjson)
   {
      _UpdateLed4($pdo,$myTime,$myDate,$cycle,$sjson);
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
