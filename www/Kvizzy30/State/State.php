<?php
// PHP7/HTML5, EDGE/CHROME                                    *** State.php ***

// ****************************************************************************
// * Kvizzy30                         ---Зарегистрировать изменения состояний *
// *                                     ---контроллеров и показаний датчиков *
// ****************************************************************************

// --v1.1, 06.10.2024                                 Автор:      Труфанов В.Е.
// --Copyright © 2024 tve                             Дата создания: 06.09.2024


?>
<!-- 
   <article>
-->
<?php

   echo '***';
   echo $parm; 
   echo '***<br>'; 
   //$backmessage='State';
   //echo $backmessage.'<br>';

   // http://localhost:100/State/?Com={%22nicctrl%22:%22myjoy%22,%22led33%22:[{%22typedev%22:%22inLed%22,%22status%22:%22inHIGH%22}]}
   // http://localhost:100/State/?Com={"nicctrl":"myjoy","led33":[{%22typedev%22:%22inLed%22,%22status%22:%22inHIGH%22}]}

   // $json = '{"name": "John Doe", "age": 30}';
   // Конвертация JSON-строки в PHP-объект
   // $user = json_decode($json);
   // Использование
   // echo $user->name;  // Выведет «John Doe»
   // echo $user->age;  // Выведет 30
 
   /*
   $nicctrl = json_decode($parm);
   //echo '$nicctrl->nicctrl = '.$nicctrl->nicctrl.'<br>'; 
   $led33=$nicctrl->led33[0];
   //echo '$led33->typedev = '.$led33->typedev.'<br>'; 
   //echo '$led33->status = '.$led33->status.'<br>'; 
         
   $oStarter->Message('$nicctrl->nicctrl = '.$nicctrl->nicctrl);
   $oStarter->Message('$led33->typedev = '.$led33->typedev);
   $oStarter->Message('$led33->status = '.$led33->status);
   */
    //$oStarter->Message('Привет!');
         
         
?>
<!-- 
</article>
<footer>
   Copyright &copy; Владимир Труфанов
</footer>
-->
<?php

?> <!-- --> <?php // ******************************************** State.php ***

