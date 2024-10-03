<?php namespace ttools; 
                                         
// PHP7/HTML5, EDGE/CHROME                      *** CommonArticlesMaker.php ***

// ****************************************************************************
// * TPhpTools               Блок общих функций класса TArticleMaker для базы *
// *                                                 данных материалов сайта. *
// *                                                                          *
// * v1.0, 14.11.2022                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  13.11.2022 *
// ****************************************************************************

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
// ************************************************ CommonArticlesMaker.php ***
