<?php                                           
// PHP7/HTML5, EDGE/CHROME                                  *** ShowNch.php ***

// ****************************************************************************
// * KwinFlat.ru                    Обеспечить деятельность в диве начислений *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.11.2017
// Copyright © 2017 TVE                              Посл.изменение: 05.03.2018

function ShowNch($Nch,$db,$Domik)
{
    $Result=0;
    $w2e = new Exceptionizer(E_ALL);
    try 
    {
        // Трассируем варианты ошибок
        // fopen("spoon","r");
        // trigger_error("Сгенерирована ошибка!",E_USER_ERROR);
        
        $Nch->show($_REQUEST,$db,$Domik);
    } 
    catch (E_EXCEPTION $e) 
    {
        echo "<pre><b>NCH!</b>\n",$e,"</pre>";
    }
    return $Result;
}
//echo "<br>".'out_ShowNch';
//
// ************************************************************ ShowNch.php *** 

