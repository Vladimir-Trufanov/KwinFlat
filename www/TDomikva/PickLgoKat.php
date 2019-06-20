<?php /* namespace domik; */

// PHP7/HTML5, EDGE/CHROME                               *** PickLgoKat.php ***

// ****************************************************************************
// * KwinFlat.ru                                     Выбрать категорию льготы *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.02.2018
// Copyright © 2018 tve                              Посл.изменение: 29.03.2018

function PickLgoKat($zhLgokat)
{
    global $aLgokat;
    $Result='';
    foreach ($aLgokat as $row) 
    {
        $Prefix='';
        if ($row['Inkat']==$zhLgokat) $Prefix='selected ';
        //$Result=$Result.
        //    "<option ".$Prefix."value=".$row['Inkat'].">".
        //    $row['Inkat'].', '.$row['Namekat']."</option>";
        $Result=$Result.
            "<option ".$Prefix."value=".$row['Inkat'].">".$row['Namekat']."</option>";
    }
    return $Result;
}

// ********************************************************* PickLgoKat.php ***
