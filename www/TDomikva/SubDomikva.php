<?php namespace domik;

// PHP7/HTML5, EDGE/CHROME                               *** SubDomikva.php ***

// ****************************************************************************
// * KwinFlat.ru       Обеспечить работу дива по дому, квартире и проживающим *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.02.2018
// Copyright © 2018 tve                              Посл.изменение: 05.05.2018


// ****************************************************************************
// *              Обеспечить работу в поле со списком выбора                  *
// ****************************************************************************
function echoGroupList($Classname,$Name,$Parmname,$aGroupList,$IniKey) 

// $Classname - класс форматирования вывода в форме
// $Name - наименование поля в форме
// $Parmname - список выбора, параметр запроса, класс форматирования списка
// $aGroupList - массив групп списка выбора
// $IniKey - ключ начального выбора в списке

{
    echo "<li class=\"".$Classname."\">";
    echo "<label for=\"".$Parmname."\">".$Name." </label>";
    echo "<select id=\"".$Parmname."\" name=\"".$Parmname."\" class=\"".$Parmname."\">";
    for ($i=0; $i<count($aGroupList); $i++)
    {
        // Определяем наименование группы списка выбора
        $NameGroup=$aGroupList[$i][0];        
        echo "<optgroup label=\"".$NameGroup."\">";
        // Выбираем группу списка выбора
        $aOptGroup=$aGroupList[$i][1]; 
        foreach($aOptGroup as $key => $value) 
        {
            if ($IniKey==$key) echo "<option selected value=\"".$key."\">".$value."</option>";
            else echo "<option value=\"".$key."\">".$value."</option>";
        }
        echo "</optgroup>";
    }
    echo "</select>";
    echo "</li>";
}
    
// ********************************************************* SubDomikva.php ***

