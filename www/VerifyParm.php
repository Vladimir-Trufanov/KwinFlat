<?php                                           
// PHP7/HTML5, EDGE/CHROME                               *** VerifyParm.php ***

// ****************************************************************************
// * KwinFlat.ru                  Проверить переданный параметр и вернуть его *
//                                                  или параметр по умолчанию *
//                               (если проверка дала отрицательный результат) *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.11.2017
// Copyright © 2017 TVE                              Посл.изменение: 08.05.2018

// Задать умалчиваемое значение параметра
function VDefault($Parm)
{
    //echo "<br>"."VDefault: "."$Parm"."<br>";
    if ($Parm=='Comm') {return 'Common';}
    else {return null;}
}

// Проверить значение параметра и вернуть его
function VerifyParm($Parm,$vParm)
{
    $Result=null;
    //echo "<br>"."VVerify: "."$Parm"."=".$vParm."<br>";

    // *************************************************************************
    // * 'Comm' - Назначение вывода в поле комментария                         *
    // *************************************************************************
    if ($Parm='Comm')
    //  Comm = 'Common' - общий комментарий по сайту
    //  Comm = 'Uslugi' - вывести справочник услуг
    {
        if (
        ($vParm=='Common')||($vParm=='Uslugi')||($vParm=='Laws')||($vParm=='Norms')||
        ($vParm=='About')||($vParm=='addZhKvar')||($vParm=='addUsl')||
        ($vParm=='LawF5')||($vParm=='LawRK827')||($vParm=='LawF181')||($vParm=='LawF1244')||($vParm=='LawF2')||
        ($vParm=='NormPPRK129')||($vParm=='NormPPRF541')||($vParm=='NormPPRK469')||
        ($vParm=='refUsl')||($vParm=='refLgokat')||($vParm=='refGrusl')||
        ($vParm=='refNormvoda')||($vParm=='refNormotop')
        )
        {
            $Result=$vParm; 
            // echo "<br>"."1: VVerifi: "."$Result";
        }
        else 
        {
            $Result=VDefault($Parm); /*echo "<br>"."2: VVerifi: "."$Result"."<br>";*/
        }
    }
    return $Result;
}

//echo "<br>".'outVerifiParm'."<br>";
//
// ********************************************************* VerifiParm.php *** 

