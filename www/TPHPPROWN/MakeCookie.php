<?php namespace prown; 
                                         
// PHP7/HTML5, EDGE/CHROME                               *** MakeCookie.php ***

// ****************************************************************************
// *                Установить новое значение COOKIE в браузере               *
// *             и заменить значение во внутреннем массиве $_COOKIE           *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  03.02.2018
// Copyright © 2018 TVE                              Посл.изменение: 10.02.2018

function MakeCookie($Name,$Value,$Duration=0x6FFFFFFF)
{
    setcookie($Name,$Value,$Duration);
    //echo "<br>"."MakeCookie_1: ".$Name."=".$Value." [".$Duration."]<br>";
    if (IsSet($_COOKIE[$Name])) 
    {
        $_COOKIE[$Name]=$Value;
        //echo "<br>"."MakeCookie_2: ".$Name."=".$_COOKIE[$Name]." [".$Duration."]<br>";
    }
}

// ********************************************************* MakeCookie.php ***
 
