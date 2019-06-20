<?php namespace domik;

// PHP7/HTML5, EDGE/CHROME                               *** IniDomikva.php ***

// ****************************************************************************
// * KwinFlat.ru                     Проинициализировать массивы и переменные * 
// *                                          по дому, квартире и проживающим *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.02.2018
// Copyright © 2018 tve                              Посл.изменение: 03.05.2018

function IniDomikStep(&$zhCount,&$aZhFio,&$aZhLgokat,&$aZhSovpr,$IsCookie)
{
    $MaxCount=14;    // максимальное количество проживающих
    \prown\CtrlArray($zhCount,'ZhCount',$aZhFio,"aZhFio","zhFio",$MaxCount,$IsCookie,$Err);
    $Postfix='Размер("Фамилия И.О.")>'.$MaxCount;
    if ($Err==1) TriggerUserMessage(MassivBolshoy,$Postfix);
    if ($Err==2) TriggerUserMessage(MasCookBolshoy,$Postfix);
    //$IsCookie=False;  // "выбирать массив из кукисов"
    \prown\CtrlArray($zhCount,'ZhCount',$aZhLgokat,"aZhLgokat","zhLgokat",$MaxCount,$IsCookie,$Err);
    $Postfix='Размер("Категория льготы")>'.$MaxCount;
    if ($Err==1) TriggerUserMessage(MassivBolshoy,$Postfix);
    if ($Err==2) TriggerUserMessage(MasCookBolshoy,$Postfix);
    // Трассируем данные
    // echo "<br>".'$zhCount='.$zhCount;
    // \prown\ViewArray($aZhLgokat,'$aZhLgokat');
    //$IsCookie=False;  // "выбирать массив из кукисов"
    \prown\CtrlArray($zhCount,'ZhCount',$aZhSovpr,"aZhSovpr","zhSovpr",$MaxCount,$IsCookie,$Err);
    $Postfix='Размер("Совместно")>'.$MaxCount;
    if ($Err==1) TriggerUserMessage(MassivBolshoy,$Postfix);
    if ($Err==2) TriggerUserMessage(MasCookBolshoy,$Postfix);

    // Трассируем данные
    //echo "<br>".'$zhCount='.$zhCount;
    //\prown\ViewArray($aZhFio,'$aZhFio');
    //\prown\ViewGlobal('avgCOOKIE');
}

function IniDomik(&$PlDom,&$PlKvar,&$Vidblag,&$zhCount,&$aZhFio,&$aZhLgokat,&$aZhSovpr,$db,$Atfirst,
    &$EtDom,&$GodStr,&$KatDom,&$PerOto)
{
    $Err=null;
    // Принимаем площадь дома
    $PlDom=\prown\CtrlNumber(2147.10,10,999999.99,'PlDom','pld',2,$Err);
    if (!($Err==0)) TriggerUserMessage(Pldom10_999999);
    // Инициализируем площадь квартиры: 
    $PlKvar=\prown\CtrlNumber(52.30,10,999.99,'PlKvar','plk',2,$Err);
    if (!($Err==0)) TriggerUserMessage(Plkvar10_999);
    // Инициализируем степень благоустройства: 
    $Vidblag=\prown\CtrlNumber(1,1,10,'Vidblag','vidblag',0,$Err);
    // Принимаем этажность дома
    $EtDom=\prown\CtrlNumber(9,1,35,'EtDom','etd',0,$Err);
    if (!($Err==0)) TriggerUserMessage(Etdom1_35);
    // Год постройки
    $GodStr=\prown\CtrlNumber(2016,1917,2058,'GodStr','gst',0,$Err);
    if (!($Err==0)) TriggerUserMessage(Godstr17_58);
    // Категория дома
    $KatDom=\prown\CtrlNumber(2,1,5,'KatDom','ktd',0,$Err);
    if (!($Err==0)) TriggerUserMessage(KatDom1_5);
    // Отопительный период
    //$PerOto=8;
    //echo "<br>".'$PerOto='.$PerOto;
    $PerOto=\prown\CtrlNumber(1,1,3,'PerOto','otp',0,$Err);
    if (!($Err==0)) TriggerUserMessage(PerOto89_12);
    
    // Step1: Инициализируем массивы по умолчанию
    $zhCount=3;
    // Инициируем проживающих 
    $aZhFio[0]='ФОТЕЕВА Н.П.';
    $aZhFio[1]='СИДОРЕНКО И.М.';
    $aZhFio[2]='внучка';
    // Инициируем категории льгот проживающих
    $aZhLgokat[0]=201;
    $aZhLgokat[1]=118;
    $aZhLgokat[2]=1;
    // Инициируем количества совместно проживающих 
    $aZhSovpr[0]=0;
    $aZhSovpr[1]=2;
    $aZhSovpr[2]=0;
    
    if ($Atfirst==Atfirst)
    {
        $PlDom=2147.10; \prown\MakeCookie('PlDom',$PlDom);
        $PlKvar=52.30;  \prown\MakeCookie('PlKvar',$PlKvar);
        $Vidblag=1;     \prown\MakeCookie('Vidblag',$Vidblag);
        $EtDom=9;       \prown\MakeCookie('EtDom',$EtDom);
        $GodStr=2016;   \prown\MakeCookie('GodStr',$GodStr);
        $KatDom=2;      \prown\MakeCookie('KatDom',$KatDom);
        $PerOto=1;      \prown\MakeCookie('PerOto',$PerOto);
        $IsCookie=False;  // "перенести массивы в кукисы"
        IniDomikStep($zhCount,$aZhFio,$aZhLgokat,$aZhSovpr,$IsCookie);
        $zhCount=count($aZhFio);
        \prown\MakeCookie('ZhCount',$zhCount);
    }
    else
    {
        // Step2: Изменяем значения через кукисы и параметры
        $IsCookie=True;  // "выбирать массив из кукисов"
        IniDomikStep($zhCount,$aZhFio,$aZhLgokat,$aZhSovpr,$IsCookie);

        // Step2.1: Удаляем указанных проживающих
        // \prown\ViewArray($_COOKIE,'2 $_COOKIE');
        DelProzhiv($zhCount,$aZhFio,$aZhLgokat,$aZhSovpr);
        //\prown\ViewArray($_COOKIE,'3 $_COOKIE');
        // Step3: Проверяем соответствие размеров массивов. Если размеры не 
        // совпадают, поджимаем массивы, вырезая несоответствия
        $Arrays[]=$aZhFio;
        $Arrays[]=$aZhLgokat;
        $Arrays[]=$aZhSovpr;
        $Dim=0;
        if (!(\prown\isCountArrays($Arrays,$Dim)))
        {
            // echo "<br>".'false False';
            $Arrays=\prown\SqueezeArrays($Arrays,$Dim);
            // Трассируем полученные массивы
            //foreach($Arrays as $key => $value) 
            //{
            //    \prown\ViewArray($value,'$Arrays'.$key);
            //}
            // Реинициализируем массивы по оперативным данным
            $zhCount=$Dim;
            $aZhFio=$Arrays[0];
            $aZhLgokat=$Arrays[1];
            $aZhSovpr=$Arrays[2];
            $IsCookie=False; 
            IniDomikStep($zhCount,$aZhFio,$aZhLgokat,$aZhSovpr,$IsCookie);
        }
        // Размеры совпали, анализируем  далее элементы массивов
        else 
        {
            //echo "<br>".'true True';
        }
        // Step4: Добавляем нового проживающего в массив кукисов и 
        // в оперативный массив , приняв его из параметров
        AddProzhiv($zhCount,$aZhFio,$aZhLgokat,$aZhSovpr);
        // Step5: Делаем контрольные преобразования элементов массивов
        // Проверяем $aZhFio и вырезаем символы, которые не могут входить 
        // в фамилию, инициалы 
        VerifyZhFio($aZhFio);
        // Проверяем категории льгот в массиве $aZhLgokat  
        VerifyZhLgokat($aZhLgokat,$db);
        // Проверяем правильность записей распространения льготы 
        // на совместно проживающих
        VerifyZhSovpr($aZhSovpr,$zhCount,$aZhLgokat);
    }
}
    
// ********************************************************* IniDomikva.php ***

