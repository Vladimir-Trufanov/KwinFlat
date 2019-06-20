<?php namespace vnch;

// PHP7/HTML5, EDGE/CHROME                               *** RecalcNach.php ***

// ****************************************************************************
// * KwinFlat.ru                      Пересчитать начисления и итоговые суммы *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.02.2018
// Copyright © 2018 tve                              Посл.изменение: 04.02.2018

function RecalcNach($UslCount,$aTarif,$aKolich,$aKorr,&$aNach,&$aSumUsl,&$ItSumUsl)
{
    // Инициируем итоговую сумму
    $ItSumUsl=0;
    // Определяем начисления и пересчитываем итоговые суммы
    for ($i=0;$i<$UslCount;$i++)
	{
        //echo '<br>Count '.$i.' '.count($aTarif).' '.count($aKolich);
        //echo '<br>Value '.$i.' '.$aTarif[$i].' '.$aKolich[$i];
        $aNach[$i]=round($aTarif[$i]*$aKolich[$i],2);
        $aSumUsl[$i]=round($aNach[$i]+$aKorr[$i],2);
        $ItSumUsl=round($ItSumUsl+$aSumUsl[$i],2);
    }
    // echo "<br>".'RecalcNach'."<br>";
}
// echo "<br>".'out RecalcNach'."<br>";

// ********************************************************* RecalcNach.php ***

