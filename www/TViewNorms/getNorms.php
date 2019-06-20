<?php namespace norms;

// PHP7/HTML5, EDGE/CHROME                                 *** getNorms.php ***

// ****************************************************************************
// * KwinFlat.ru                         Выбрать нормы по услугам для расчета *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.03.2018
// Copyright © 2018 tve                              Посл.изменение: 20.04.2018

function getNorms($aInusl,&$aNorma,$zhCount,$Vidblag,$EtDom,$GodStr,
    $KatDom,$PerOto,$db)
{
    foreach($aInusl as $key => $value) 
    {
        // Выбираем категорию норматива
        $Normu=getNormu($aInusl[$key]);
        // echo '<br>$Normu='.$Normu;
        // Определяем норматив по услуге
        if ($Normu=='Normu') $aNorma[$key]=0;
        elseif ($Normu=='NormPPRK129') $aNorma[$key]=NormPPRK129($zhCount);
        elseif ($Normu==HVS) $aNorma[$key]=NormHVS($Vidblag,$db);
        elseif ($Normu==GVS) $aNorma[$key]=NormGVS($Vidblag,$db);
        elseif ($Normu==OTOPL) $aNorma[$key]=NormOTOPL($EtDom,$GodStr,$KatDom,$PerOto,$db);
        else $aNorma[$key]=0; 
    }
}

/*
 Выбрать категорию норматива по услуге          
*/
function getNormu($Inusl)
{
    global $aNormu; // Связь услуг с нормативами
    $Result='Normu';
    foreach($aNormu as $key => $value) 
    {
        if ($key==$Inusl) $Result=$value;
    }
    return $Result;
}

/*
 Выбрать норматив по жилищной услуге
 Постановление Правительства РК от 27.08.2007 №129-П "О социальных нормах площади жилья"           
*/
function NormPPRK129($zhCount)
{
    $Result=18;
    if ($zhCount<=0) $Result=0;
    if ($zhCount==1) $Result=38;
    if ($zhCount==2) $Result=22.5;
    if ($zhCount==3) $Result=21;
    return $Result;
}
/*
 Выбрать норматив по ХВС,ГВС
 */
function NormHVS($Vidblag,$db)
{
    $Result=0;
    $sql="select NormHVS from NormVoda where Vid=".$Vidblag;
    $st = $db->query($sql);
    $results = $st->fetchAll();
    foreach ($results as $row) 
    {
        $Result=$row["NormHVS"];
    }
    return $Result;
}
function NormGVS($Vidblag,$db)
{
    $Result=0;
    $sql="select NormGVS from NormVoda where Vid=".$Vidblag;
    $st = $db->query($sql);
    $results = $st->fetchAll();
    foreach ($results as $row) 
    {
        $Result=$row["NormGVS"];
    }
    return $Result;
}
function NormOTOPL($EtDom,$GodStr,$KatDom,$PerOto,$db)
{
    $Result=0;
    // По году постройки определяем группу домов (для Карелии)
    if ($GodStr<1999) $GruDom=1;
    else $GruDom=2;
    // Выполняем запрос на выборку нормативов по категориям домов 
    $sql=
        "select KatDom1, KatDom2, KatDom3, KatDom4, KatDom5 ".
        "from NormOto ".
        "where Oktmo=86701000 and EtDom=".$EtDom." and Factor=".$PerOto." and GruDom=".$GruDom;
    //echo '<br>$EtDom='.$EtDom.' $PerOto='.$PerOto.' $GruDom='.$GruDom.' $KatDom='.$KatDom;
    $st = $db->query($sql);
    $results = $st->fetch();
    // Выбираем норматив по категории дома 
    $Result=$results["KatDom".$KatDom];
    return $Result;
}
// *********************************************************** getNorms.php ***

