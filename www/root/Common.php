<?php namespace common;

// PHP7/HTML5, EDGE/CHROME                                   *** Common.php ***

// ****************************************************************************
// * KwinFlat.ru                                    Блок общесайтовых функций *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.02.2018
// Copyright © 2018 tve                              Посл.изменение: 09.04.2018

// Определить группу услуги
function ctrlLgokat($Codlg)
{
    // Здесь категория может прийти из справочника, 
    // поэтому обрабатываем параметр через регулярное выражение
    // (выделяем первое целое число)
    $reg="/[0-9]{0,}/u"; 
    if (preg_match($reg,$Codlg,$matches)) 
    {
        $Codlg=$matches[0];
    }
    else $Codlg=1;
    return $Codlg;
}

// Определить группу услуги
function getKind($Inusl,$db)
{
    $Kind=0;
    $sql="select Kind from Vusl where Inusl=".$Inusl;
    $st = $db->query($sql);
    $results = $st->fetch();
    $Kind = $results["Kind"];
    return $Kind;
}

// Выбрать массив льготных категорий
function getLgokat($db)
{
    // Делаем выборку данных 
    $sql="
    select k.Inkat, k.Namekat,
      pzhu.Codprv as Zhucod, pzhu.Tezis as Zhuprv, 
       pku.Codprv as Kucod,   pku.Tezis as Kuprv, 
      podn.Codprv as Odncod, podn.Tezis as Odnprv,
      pvkr.Codprv as Vkrcod, pvkr.Tezis as Vkrprv
    from Lgokat k
    inner join Lgoprv pzhu on (k.Zhuprv=pzhu.Codprv)
    inner join Lgoprv pku on (k.Kuprv=pku.Codprv)
    inner join Lgoprv podn on (k.Odnprv=podn.Codprv)
    inner join Lgoprv pvkr on (k.Vkrprv=pvkr.Codprv)
    order by k.Inkat
    ";
    $st = $db->query($sql);
    $results = $st->fetchAll();
    
    // (Inkat,Namekat,Zhucod,Zhuprv,Kucod,Kuprv,Odncod,Odnprv,Vkrcod,Vkrprv)
    
    return $results;
}

// Выбрать массив услуг
function getUslugi($db)
{
    $sql="
        select Inusl,Nmusl
        from Vusl 
        order by Inusl
    ";
    $st = $db->query($sql);
    $results = $st->fetchAll();
    return $results;
}

// Определить правило и количество членов семьи льготника,
// если в тезисе правила присутствует признак "на семью"
function _getSemja($Tezis)
{
    // Инициируем количество членов семьи
    $IsSemja=False;   // "в тезис правила признак "на семью" не входит"
    // Находим позицию, если есть, признака "на семью"
    $pos = strpos($Tezis,"на семью");
    // Обрабатываем найденный признак
    if (!($pos === false)) $IsSemja=True;  
    return $IsSemja;
}
function _getSxel($row,$Kind,&$IsSemja)
{
    // Определяем правило по номеру группы услуги
    if ($Kind==1)
	{
        $Sxel=$row['Zhucod'];
        $IsSemja=_getSemja($row['Zhuprv']);
    }
    elseif ($Kind==2) 
    {
        $Sxel=$row['Kucod'];
        $IsSemja=_getSemja($row['Kuprv']);
    }  
    elseif ($Kind==3) 
    {
        $Sxel=$row['Odncod'];
        $IsSemja=_getSemja($row['Odnprv']);
    }  
    elseif ($Kind==4) 
    {
        $Sxel=$row['Vkrcod'];
        $IsSemja=_getSemja($row['Vkrprv']);
    } 
    else $Sxel=1;
    return $Sxel;
}
function getSxel($Katlgo,$Kind,&$IsSemja)
{
    // Указываем массив льготных категорий
    global $aLgokat;
    
    // Инициируем правило
    $Sxel=1;   // "льготы нет"
    
    // Перебираем массив и находим категорию
    foreach ($aLgokat as $row)
    {
        //echo "<br>".'getSxel: $row[Inkat]='.$row['Inkat']."  ".'$Katlgo='.$Katlgo;
        if ($row['Inkat']==$Katlgo) 
        {
            $Sxel=_getSxel($row,$Kind,$IsSemja);
            break;
        }
    }

    // $row['Inkat'],  $row['Namekat'],
    // $row['Zhucod'], $row['Zhuprv'],
    // $row['Kucod'],  $row['Kuprv'],
    // $row['Odncod'], $row['Odnprv'],
    // $row['Vkrcod'], $row['Vkrprv']
    
    return $Sxel;
}

function isUsl($InUsl,$aInusl)
{
    $Result=false;
    foreach ($aInusl as $key => $value) 
    {
        if ($value==$InUsl)
        {
            $Result=true;
            break;
        }
    }
    return $Result;
}

// ****************************************************************************
// *                 Послать заголовок с настройкой на HTTPS                  *
// ****************************************************************************
function Headeri($page)
{
    if ($_SERVER['HTTP_HOST']=='kwinflat.ru')
    {
        //echo "Location: https://".$_SERVER['HTTP_HOST'].$page;
        Header("Location: https://".$_SERVER['HTTP_HOST'].$page);
    }
    else 
    {
        //echo "Location: http://".$_SERVER['HTTP_HOST'].$page;
        Header("Location: http://".$_SERVER['HTTP_HOST'].$page);
    }
}


// ************************************************************* Common.php ***

