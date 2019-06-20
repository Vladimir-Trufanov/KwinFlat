<?php namespace vlgo;

// PHP7/HTML5, EDGE/CHROME                                   *** SxelXX.php ***

// ****************************************************************************
// * KwinFlat.ru                  Рассчитать льготу по правилу, тарифу и доле *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.02.2018
// Copyright © 2018 tve                              Посл.изменение: 25.02.2018


// Рассчитать льготу по 1 правилу
// "льготы нет"
function Sxel01($Nachlg)
{
    $Result=0;
    return $Result;
}

// Рассчитать льготу по 11 правилу
// "по доле площади не более норматива компенсация 50%"
function Sxel11($Tlg,$vNorm,$vDolya)
{
    if (abs($Tlg)<0.0001) $Result=0;
    else
    {
        if ($vDolya>$vNorm) $vDolya=$vNorm; 
        $Result=round($Tlg*$vDolya/100*50,2);
        // echo '<br>$Result=$Tlg*$vDolya/2 '.$Result.'='.$Tlg.'*'.$vDolya.'/100*50';
    }
    return $Result;
}

// 12: "по доле площади компенсация 50%"
function Sxel12($Nachlg,$Vu,$Tlg,$vDolya)
{
    $Result=0;
    $Result=$vDolya;
    return $Result;
}

// 13: "по доле площади не более норматива компенсация 100%"
function Sxel13($Nachlgo,$Tlg,$vDolya,$vNorm)
{
    if (abs($Tlg)<0.0001) $Result=0;
    else
    {
        if ($vDolya>$vNorm) $vDolya=$vNorm; 
        $Result=round($vDolya*$Tlg,2);
        //echo "<br>".$Result.'>'.$Nachlgo;
        if ($Result>$Nachlgo) $Result=$Nachlgo;
    }
    return $Result;
}

// 14: "по доле площади компенсация 100%"
function Sxel14($Nachlgo,$Tlg,$vDolya)
{
    if (abs($Tlg)<0.0001) $Result=0;
    else
    {
        $Result=round($vDolya*$Tlg,2);
        if ($Result>$Nachlgo) $Result=$Nachlgo;
    }
    return $Result;
}

// 41: "по доле площади от минимального размера не более норматива компенсация 50%"
function Sxel41($Tlg,$vDolya,$vNorm)
{
    if (abs($Tlg)<0.0001) $Result=0;
    else
    {
        if ($vDolya>$vNorm) $vDolya=$vNorm; 
        if ($Tlg>MinVKR) $Tlg=MinVKR; 
        $Result=round($vDolya*$Tlg/2,2);
    }
    return $Result;
}

// 57: "по доле объема не более норматива компенсация 50%"
function Sxel57($Tlg,$vNorm,$vDolya)
{
    if (abs($Tlg)<0.0001) $Result=0;
    else
    {
        if ($vDolya>$vNorm) $vDolya=$vNorm; 
        $Result=round($vDolya*$Tlg/2,2);
    }
    return $Result;
}

// 58: "по доле объема компенсация 100% (ОТО,освещение)"
function Sxel58($Nachlg)
{
    $Result=0;
    return $Result;
}

// 59: "по доле объема не более норматива компенсация 100%"
function Sxel59($Nachlgo,$Tlg,$vDolya,$vNorm)
{
    if (abs($Tlg)<0.0001) $Result=0;
    else
    {
        if ($vDolya>$vNorm) $vDolya=$vNorm; 
        $Result=round($vDolya*$Tlg,2);
        //echo "<br>".$Result.'>'.$Nachlgo;
        if ($Result>$Nachlgo) $Result=$Nachlgo;
    }
    return $Result;
}

// 70: "на семью по доле площади от мин.размера не более фед.нормы компенсация 50%"
function Sxel70($Tlg,$vDolya,$zhSovpr)
{
    if (abs($Tlg)<0.0001) $Result=0;
    else
    {
        $vNorm=18;
        if ($vDolya>$vNorm) $vDolya=$vNorm; 
        if ($Tlg>MinVKR) $Tlg=MinVKR; 
        $Result=round($vDolya*$Tlg*$zhSovpr/2,2);
    }
    return $Result;
}

// 71: "на семью по доле площади от минимального размера не более норматива компенсация 50%"
function Sxel71($Tlg,$vDolya,$vNorm,$zhSovpr)
{
    if (abs($Tlg)<0.0001) $Result=0;
    else
    {
        if ($vDolya>$vNorm) $vDolya=$vNorm; 
        if ($Tlg>MinVKR) $Tlg=MinVKR; 
        $Result=round($vDolya*$Tlg*$zhSovpr/2,2);
    }
    return $Result;
}

// 72: "на семью по доле площади от минимального размера компенсация 50%"
function Sxel72($Nachlg)
{
    $Result=0;
    return $Result;
}

// 77: "на семью по доле объема не более норматива компенсация 50%"
function Sxel77($Tlg,$vDolya,$vNorm,$zhSovpr)
{
    if (abs($Tlg)<0.0001) $Result=0;
    else
    {
        if ($vDolya>$vNorm) $vDolya=$vNorm; 
        $Result=round($vDolya*$Tlg*$zhSovpr/2,2);
    }
    return $Result;
}

// 80: "на семью по доле площади не более фед.нормы компенсация 50%"
function Sxel80($Tlg,$vDolya,$zhSovpr)
{
    if (abs($Tlg)<0.0001) $Result=0;
    else
    {
        $vNorm=18;
        if ($vDolya>$vNorm) $vDolya=$vNorm; 
        $Result=round($vDolya*$Tlg*$zhSovpr/2,2);
    }
    return $Result;
}

// 81: "на семью по доле площади не более норматива компенсация 50%"
function Sxel81($Nachlg)
{
    $Result=0;
    return $Result;
}

// 82: "на семью по доле площади компенсация 50%"
function Sxel82($Tlg,$vDolya,$zhSovpr)
{
    $Result=round($vDolya*$Tlg*$zhSovpr/2,2);
    return $Result;
}

// Рассчитать льготу по правилу, тарифу и доле
function SxelXX($Sxel,$ItNach,$Vu,$Tlg,$vNorm,$vDolya,$zhCount,$zhSovpr)
{
    // Заменяем отрицательные значения
    $Nachlgo=$ItNach; 
    if ($ItNach<0) $Nachlgo=-$ItNach; 
    if ($Vu<0) $Vu=-$Vu; 
    if ($Tlg<0) $Tlg=-$Tlg; 
    if ($vNorm<0) $vNorm=-$vNorm; 
    if ($vDolya<0) $vDolya=-$vDolya; 
    if ($zhSovpr<0) $zhSovpr=1; 
    
    // Трассируем параметры расчета
    // echo "<br>".'SxelXX: $Sxel='.$Sxel;
    /*
    if ($Sxel==77)
	{
        echo "<br>".'$ItNach='.$ItNach.'  $Vu='.$Vu.'  $Tlg='.$Tlg.
            '  $vNorm='.$vNorm.'  $vDolya='.$vDolya.'  $zhSovpr='.$zhSovpr;
    }
    */
    
    // 1: "без льготы"
    $Result=0;

    // 11: "по доле площади не более норматива компенсация 50%"
    if ($Sxel==11)
	{
       $Result=Sxel11($Tlg,$vNorm,$vDolya);
    }
    // 12: "по доле площади компенсация 50%"
    elseif ($Sxel==12) 
    {
        $Result=Sxel12($Nachlgo,$Vu,$Tlg,$vDolya);
    } 
    // 13: "по доле площади не более норматива компенсация 100%"
    elseif ($Sxel==13) 
    {
        $Result=Sxel13($Nachlgo,$Tlg,$vDolya,$vNorm);
    } 
    // 14: "по доле площади компенсация 100%"
    elseif ($Sxel==14) 
    {
        $Result=Sxel14($Nachlgo,$Tlg,$vDolya);
    } 
    // 41: "по доле площади от минимального размера не более норматива компенсация 50%"
    elseif ($Sxel==41) 
    {
        $Result=Sxel41($Tlg,$vDolya,$vNorm);
    } 
    // 57: "по доле объема не более норматива компенсация 50%"
    elseif ($Sxel==57) 
    {
        $Result=Sxel57($Tlg,$vNorm,$vDolya);
    } 
    // 59: "по доле объема не более норматива компенсация 100%"
    elseif ($Sxel==59) 
    {
        $Result=Sxel59($Nachlgo,$Tlg,$vDolya,$vNorm);
    } 
    // 70: "на семью по доле площади от мин.размера не более фед.нормы компенсация 50%"
    elseif ($Sxel==70) 
    {
        $Result=Sxel70($Tlg,$vDolya,$zhSovpr);
    } 
    // 71: "на семью по доле площади от минимального размера не более норматива компенсация 50%"
    elseif ($Sxel==71) 
    {
        $Result=Sxel71($Tlg,$vDolya,$vNorm,$zhSovpr);
    } 
    // 77: "на семью по доле объема не более норматива компенсация 50%"
    elseif ($Sxel==77) 
    {
        $Result=Sxel77($Tlg,$vDolya,$vNorm,$zhSovpr);
    } 
    // 80: "на семью по доле площади не более фед.нормы компенсация 50%"
    elseif ($Sxel==80) 
    {
        $Result=Sxel80($Tlg,$vDolya,$zhSovpr);
    } 
    // 82: "на семью по доле площади компенсация 50%"
    elseif ($Sxel==82) 
    {
        $Result=Sxel82($Tlg,$vDolya,$zhSovpr);
    } 

    // Если итоговое начисление было отрицательным, то и льготу с минусом
    if ($ItNach<0) $Result=-$Result; 

    return $Result;
}
// echo "<br>".'out SxelXX'."<br>";

// ************************************************************* SxelXX.php ***

