<?php namespace vnch;

// PHP7/HTML5, EDGE/CHROME                                 *** InitNach.php ***

// ****************************************************************************
// * KwinFlat.ru          Проинициализировать массивы и переменные начислений *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.02.2018
// Copyright © 2018 tve                              Посл.изменение: 15.03.2018

/*
 Проинициализировать массивы и переменные начислений         
*/
function InitNach(&$UslCount,&$aInusl,&$aNameUsl,&$aEdIzm,&$aNorma,&$aKind,
    &$aTarif,&$aKolich,&$aKorr,&$aNach,&$aSumUsl,&$ItSumUsl,$db,$Domik,$Atfirst)
{
    // Инициализируем по умолчанию массивы и переменные 
    DefoNach($UslCount,$aInusl,$aNameUsl,$aEdIzm,$aNorma,$aTarif,$aKolich,$aKorr,$Atfirst);
    // Заполняем массив наименований услуг
    getNameUsl($aInusl,$aNameUsl,$db);
    // Заполняем массив единиц измерения
    getEdizm($aInusl,$aEdIzm,$db);
    // Заполняем массив нормативов
    \norms\getNorms($aInusl,$aNorma,
        $Domik->zhCount,$Domik->Vidblag,$Domik->EtDom,$Domik->GodStr,
        $Domik->KatDom,$Domik->PerOto,$db);
    // Если тарифы были в кукисах, то выбираем их оттуда 
    // c контролем правильности кукиса
    //$aTarif=ControlArray("aTarif",$aTarif);
    // Инициируем количества
    //$aKolich=ControlArray("aKolich",$aKolich);
    // Переопределяем количества по ЖУ и ВКР
    for ($i=0; $i<count($aKolich); $i++)
	{
        // Определяем группу услуги и запоминаем для передачи в расчет льгот
        $Kind=\common\getKind($aInusl[$i],$db);
        $aKind[$i]=$Kind;
        // Если группы услуг 1 и 4, то количество=общей площади квартиры
        // и поля не подлежат редактированию (просто выводим площадь)
        if (($Kind==1)||($Kind==4)) $aKolich[$i]=$Domik->PlKvar; 
    }
    // Инициируем корректировки
    //$aKorr=ControlArray("aKorr",$aKorr);
    // Определяем начисления и итоговые суммы
    
    //\prown\ViewArray($aKorr,'2 $aKorr');
    RecalcNach($UslCount,$aTarif,$aKolich,$aKorr,$aNach,$aSumUsl,$ItSumUsl);
}

/*
 Заполнить массив наименований услуг          
*/
function getNameUsl(&$aInusl,&$aNameUsl,$db)
{
    // Делаем выборку данных 
    $sql="
        select Inusl,Nmusl
        from Vusl 
        order by Inusl
    ";
    $st = $db->query($sql);
    $results = $st->fetchAll();
    
    // Перебираем коды услуг и подбираем наименования
    foreach($aInusl as $key => $value) 
    {
        $isFind=false; // Услуга не найдена! 
        // Просматриваем справочник и подбираем услугу
        foreach ($results as $row) 
        {
            if ($row['Inusl']==$value) 
            {
                $aNameUsl[$key]=$row['Nmusl'];
                $isFind=true; // Услуга найдена! 
                break;
            }
        }
        // Услуга не была найдена, включаем 1 услугу
        if (!$isFind) 
        {
            $aNameUsl[$key]='Неверный код услуги ['.$value.']';
            $aInusl[$key]=1;
        }
       
    }
}

/*
 Заполнить массив единиц измерения          
*/
function getEdizm($aInusl,&$aEdIzm,$db)
{
    // Делаем выборку данных 
    $sql="
        select a.Inusl, e.Name
        from Vusl a
        inner join Edizm e on (a.Edsch=e.Edizm)
        order by Inusl    
    ";
    $st = $db->query($sql);
    $results = $st->fetchAll();
    
    // Перебираем коды услуг и подбираем наименования
    foreach($aInusl as $key => $value) 
    {
        $aEdIzm[$key]=' ';
        foreach ($results as $row) 
        {
            if ($row['Inusl']==$value) 
            {
                $aEdIzm[$key]=$row['Name'];
                break;
            }
        }
    }
}

// *********************************************************** InitNach.php ***

