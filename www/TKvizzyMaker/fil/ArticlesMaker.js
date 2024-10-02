// PHP7/HTML5, EDGE/CHROME                             *** ArticlesMaker.js ***

// ****************************************************************************
// * ArticlesMakerClass       Блок функций сопровождения класса на JavaScript *
// *                                                                          *
// * v1.0, 18.02.2023                               Автор:      Труфанов В.Е. *
// * Copyright © 2023 tve                           Дата создания: 09.01.2023 *
// ****************************************************************************

      /*
      pathPhpTools="<?php echo pathPhpTools;?>";
      pathPhpPrown="<?php echo pathPhpPrown;?>";
      gncNoCue="<?php echo gncNoCue;?>"; 
      */

      // **********************************************************************
      // *       Проверить целостность базы данных по 16 очередным записям    *
      // **********************************************************************
      function GetPunktTestBase()
      {
         // Выбираем последний проверенный uid
         TestPoint=Number(localStorage.getItem('TestPoint'));
         if (Number.isNaN(TestPoint)) TestPoint=0;
         //console.log('в наче '+TestPoint);
         // Делаем запрос на определение наименования раздела материалов
         pathphp="TestBase.php";
         $.ajax({
            url: pathphp,
            type: 'POST',
            data: {TestPoint:TestPoint, pathTools:pathPhpTools, pathPrown:pathPhpPrown},
            // Выводим ошибки при выполнении запроса в PHP-сценарии
            error: function (jqXHR,exception) {SmarttodoError(jqXHR,exception)},
            // Обрабатываем ответное сообщение
            success: function(message)
            {
               // Вырезаем из запроса чистое сообщение
               messa=FreshLabel(message);
               // Получаем параметры ответа
               parm=JSON.parse(messa);
               // Если ошибка, то выводим сообщение
               if (parm.error==true) Error_Info(parm.messa);
               // Иначе меняем значение проверенного uid-а
               else 
               {
                  //console.log('в коне '+parm.TestPoint);
                  // Отмечаем последний проверенный uid
                  localStorage.setItem('TestPoint',parm.TestPoint);
                  // Выводим сообщение, что все хорошо
                  // Info_Info(parm.messa); 
               }
            }
         });
      }
// ******************************************************* ArticlesMaker.js *** 
