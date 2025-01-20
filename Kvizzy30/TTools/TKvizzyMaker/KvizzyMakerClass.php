<?php namespace ttools; 
                                         
// PHP7/HTML5, EDGE/CHROME                         *** KvizzyMakerClass.php ***

// ****************************************************************************
// * KwinFlat/TTools                  Построитель базы данных моего хозяйства *
// *                                                                          *
// * v2.0.2, 20.01.2025                            Автор:       Труфанов В.Е. *
// * Copyright © 2024 tve                          Дата создания:  03.11.2024 *
// ****************************************************************************

// Подгружаем модули функций класса
require_once("CommonKvizzyMaker.php"); 
require_once("CommonStateMaker.php"); 
require_once("CommonLeadMaker.php"); 

class KvizzyMaker
{
   // ----------------------------------------------------- СВОЙСТВА КЛАССА ---
   protected $basename;    // база данных моего хозяйства 
   protected $username;    // логин для доступа к базе данных
   protected $password;    // пароль
   protected $email;       // email посетителя
   // ------------------------------------------------------- МЕТОДЫ КЛАССА ---
   // BaseConnect()                                    Открыть соединение с базой данных
   // BaseFirstCreate()                                Создать резервную копию и заново построить новую базу данных
   // SelectLed33($pdo)                                Выбрать запись из таблицы базы данных State по Led33 
   // SelectLMP33($pdo)                                Выбрать запись режима работы контрольного светодиода Led33   
   // UpdateLed33($pdo,$myTime,$myDate,$cycle,$sjson)  Обновить запись в таблице базы данных State по Led33 
   // -------------------------------------------------------------------------

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
   // Выбрать запись из таблицы базы данных State по Led33  
   public function SelectLed33($pdo)
   {
      $table=_SelectLed33($pdo);
      return $table;
   }
   // Выбрать запись режима работы контрольного светодиода Led33   
   public function SelectLMP33($pdo)
   {
      $table=_SelectLMP33($pdo);
      return $table;
   }
   // Обновить запись в таблице базы данных State по Led33 
   public function UpdateLed33($pdo,$myTime,$myDate,$cycle,$sjson)
   {
      _UpdateLed33($pdo,$myTime,$myDate,$cycle,$sjson);
   }
}

// *************************************************** KvizzyMakerClass.php ***
