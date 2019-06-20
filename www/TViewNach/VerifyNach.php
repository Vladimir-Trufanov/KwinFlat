<?php namespace vnch;

// PHP7/HTML5, EDGE/CHROME                               *** VerifyNach.php ***

// ****************************************************************************
// * KwinFlat.ru           Проверить(преобразовать) данные, которые размещены * 
// *                            в оперативных массивах для расчета начислений * 
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.04.2018
// Copyright © 2018 tve                              Посл.изменение: 05.04.2018

function VerifyKorr(&$aKorr)
{
    $Result=1; // "все в порядке, отработано успешно"
    foreach($aKorr as $key => $value) 
    {
        $aKorr[$key]=\prown\TestNumerical($value,0,2);    
        if (!($aKorr[$key]==$value))
        {
            $Result=0; // "есть замена значения"
        }
    }
    //echo '<br> $aKorr.$Result='.$Result;
    return $Result;
}

function VerifyKolich(&$aKolich)
{
    $Result=1; // "все в порядке, отработано успешно"
    foreach($aKolich as $key => $value) 
    {
        $aKolich[$key]=\prown\TestNumerical($value,0,5);    
        if (!($aKolich[$key]==$value))
        {
            $Result=0; // "есть замена значения"
        }
    }
    //echo '<br> $aKolich.$Result='.$Result;
    return $Result;
}
    
function VerifyTarif($aTarif)
{
    $Result=1; // "все в порядке, отработано успешно"
    foreach($aTarif as $key => $value) 
    {
        $aTarif[$key]=\prown\TestNumerical($value,0,2);    
        if (!($aTarif[$key]==$value))
        {
            $Result=0; // "есть замена значения"
        }
    }
    //echo '<br> $aTarif.$Result='.$Result;
    return $Result;
}

function VerifyInusl(&$aInusl)
{
    global $aUslugi;
    $Result=1; // "все в порядке, изменения услуг не было"
    foreach($aInusl as $key => $value) 
    {
        $OneResult=0; // Пока считаем, что ИН текущей услуги отсутствует
        foreach ($aUslugi as $row) 
        {
            if ($row['Inusl']==$value)
            {
                $OneResult=1; // ИН текущей услуги есть
                break;
            }
        }
        // Если услуга не была найдена, присваиваем ИН="1"
        // и отмечаем, что было изменение услуг
        if ($OneResult==0)
        {
            $aInusl[$key]=1;
            $Result=0; // "было изменение услуг"
        }
    }
    //echo '<br> $aInusl.$Result='.$Result;
    return $Result;
}

function VerifyNach(&$aInusl,&$aTarif,&$aKolich,&$aKorr)
{
    $Result=0; // "замены в массивах были"
    if (VerifyInusl($aInusl) && VerifyTarif($aTarif) &&
       VerifyKolich($aKolich)&&VerifyKorr($aKorr))
    {
       $Result=1; // "все в порядке, отработано успешно"
    }
    return $Result;
}

// ********************************************************* VerifyNach.php *** 

