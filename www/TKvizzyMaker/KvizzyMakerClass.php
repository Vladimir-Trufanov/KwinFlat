<?php namespace ttools; 
                                         
// PHP7/HTML5, EDGE/CHROME                         *** KvizzyMakerClass.php ***

// ****************************************************************************
// * KwinFlat/TTools                  Построитель базы данных моего хозяйства *
// *                                                                          *
// * v4.4.2, 05.06.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2024 tve                          Дата создания:  03.11.2024 *
// ****************************************************************************

// ---------------------------------------------------------- МЕТОДЫ КЛАССА ---
require_once("CommonKvizzyMaker.php"); 
// BaseConnect();                                      - Открыть соединение с базой данных
// BaseFirstCreate();                                  - Создать резервную копию и заново построить новую базу данных
require_once("CommonLeadMaker.php"); 
// setMessLead($pdo,$num,$sjson)                       - Записать в базу данных изменения состояния управляющих json-команд 
// TestSet($pdo,$INsjson,$action)                      - Подтвердить изменения: $action=-1, текущего режима работы вспышки; $action=-2, интервалов подачи сообщений от контроллера 
// SelChange($pdo)                                     - Выбрать изменения состояний управляющих команд  
// --- SelLead($pdo,$action);                          - Выбрать управляющее выражение: $action=-1, текущего режима работы вспышки; $action=-2, интервалов подачи сообщений от контроллера 
require_once("CommonStateMaker.php"); 
// SelectLastMess($pdo);                               - Выбрать запись из таблицы последнего полученного json-сообщения  
// UpdateLastMess($pdo,$myTime,$myDate,$cycle,$sjson); - Обновить запись в таблице последнего полученного json-сообщения
// SelState($pdo);                                     - Выбрать управляющие значения экрана и показания датчиков
// setStateElem($pdo,$Name,$Value);                    - Записать в базу данных изменение управляющего элемента изображения 
require_once("CommonStreamMaker.php"); 
// InsertImgStream($pdo,$src,$time,$frame);            - Вставить текущее изображение  
// SelImgStream($pdo,$intime,$inframe);                - Выбрать данные последнего записанного изображения из базы данных
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
   public function setMessLead($pdo,$num,$sjson) 
   {
      return _setMessLead($pdo,$num,$sjson);
   }
   // Подтвердить изменения: $action=-1, текущего режима работы вспышки; $action=-2, интервалов подачи сообщений от контроллера 
   public function TestSet($pdo,$INsjson,$action)
   {
      return _TestSet($pdo,$INsjson,$action);
   }
   // Выбрать изменения состояний управляющих json-команд  
   public function SelChange($pdo)
   {
      $table=_SelChange($pdo);
      return $table;
   }
   /*
   // Выбрать управляющее выражение: $action=-1, текущего режима работы вспышки; $action=-2, интервалов подачи сообщений от контроллера 
   public function SelLead($pdo,$action)
   {
      $table=_SelLead($pdo,$action);
      return $table;
   }
   */

   // ------------------------------------------------ CommonStateMaker.php ---
   // Выбрать управляющие значения экрана и показания датчиков
   public function SelState($pdo)
   {
      $table=_SelState($pdo);
      return $table;
   }
   // Выбрать запись из таблицы последнего полученного json-сообщения  
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
   // Записать в базу данных изменение управляющего элемента изображения   
   public function setStateElem($pdo,$Name,$Value)
   {
      return _setStateElem($pdo,$Name,$Value);
   }
   
   // ----------------------------------------------- CommonStreamMaker.php ---
   // Вставить текущее изображение 
   public function InsertImgStream($pdo,$src,$time,$frame)
   {
      $messa=_InsertImgStream($pdo,$src,$time,$frame);
      return $messa;
   }
   // Выбрать данные последнего записанного изображения из базы данных
   public function SelImgStream($pdo,$time,$frame)
   {
      $messa=_SelImgStream($pdo,$time,$frame);
      return $messa;
   }
}

// *************************************************** KvizzyMakerClass.php ***
