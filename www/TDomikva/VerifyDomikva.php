<?php namespace domik;

// PHP7/HTML5, EDGE/CHROME                            *** VerifyDomikva.php ***

// ****************************************************************************
// * KwinFlat.ru           Проверить(преобразовать) данные, которые размещены * 
// *     в оперативных записях и могли быть введены в работе "Дом и квартира" * 
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.11.2017
// Copyright © 2017 tve                              Посл.изменение: 13.03.2018

// Проверить присутствие категории в справочнике    
function yesLgoKat($Codlg,$db)
{
    $Result=False;
    // Здесь категория может прийти из справочника, 
    // поэтому обрабатываем параметр через регулярное выражение
    // (выделяем первое целое число)
    $Codlg=\common\ctrlLgokat($Codlg); 
    // Делаем выборку данных 
    $sql='select Inkat from Lgokat where Inkat='.$Codlg;
    // echo "<br>".'$sql='.$sql;
    $st = $db->query($sql);
    $a = $st->fetch();
    //echo "<br>".'$st='.$a['Inkat'];
    if ($a['Inkat']==$Codlg) $Result=True;
    return $Result;
}

// Проверить категории льгот в массиве $aZhLgokat  
function VerifyZhLgokat(&$aZhLgokat,$db)
{
    foreach($aZhLgokat as $key => $value) 
    {
        if ($value==null) {$aZhLgokat[$key]=1; $value=1;}
        if ($value=='') {$aZhLgokat[$key]=1; $value=1;}
        // Трассируем выбираемые значения
        // echo '<br>'.'$aZhLgokat: '.$key.'=>'.$value;
        // Проверяем и перезаписываем параметр
        if (!yesLgoKat($value,$db)) 
        {
            $aZhLgokat[$key]=1;
            TriggerUserMessage(NevernaLgoKat,PressWriteKey);
        }
    }
}
    
// Проверить $aZhFio и вырезать символы, которые не могут входить 
// в фамилию, инициалы 
function VerifyZhFio(&$aZhFio)
{
    global $aNonFamys;
    foreach($aZhFio as $key => $value) 
    {
        $name=\prown\number1string($key+1);
        if ($value==null) {$aZhFio[$key]=$name; $value=$name;}
        if ($value=='') {$aZhFio[$key]=$name; $value=$name;}
        // Трассируем выбираемые значения
        // echo '<br>'.'in_$aZhFio: '.$key.'=>'.$value;
        // Вырезаем недопустимые символы и перезаписываем параметр
        $News=strtr($value,$aNonFamys);
        // echo "<br> New: ".$key.'=>'.$News;
        $aZhFio[$key]=$News;
        // Трассируем преобразованные значения
        // echo '<br>'.'ou_$aZhFio: '.$key.'=>'.$aZhFio[$key];
    }
}

// Проверить правильность записей распространения льготы 
// на совместно проживающих
function VerifyZhSovpr(&$aZhSovpr,$zhCount,$aZhLgokat)
{
    // Так как по логике функции контроль выполняется на каждой строке и
    // сообщение об ошибке может возникать несколько раз, то будем отлавливать 
    // только первое сообщение
    $FirstMess=false;
    // Контроллируем пустые значения и
    // подсчитываем число проживающих без льгот
    $bez=0;
    foreach($aZhSovpr as $key => $value) 
    {
        // Обрабатываем пустые значения
        if ($value==null) {$aZhSovpr[$key]=1; $value=1;}
        if ($value=='') {$aZhSovpr[$key]=1; $value=1;}
        if ($value<=1) {$aZhSovpr[$key]=1; $value=1;}
        // Конроллируем первую категорию
        if ($aZhLgokat[$key]<=1) {$aZhSovpr[$key]=1; $value=1; $bez++;}
    }
    // Инициализируем "сколько из 1 категории выбрано в члены семьи"
    $Sovme=0;  
    // Проверяем и считаем количества совместно проживающих для льгот
    // у проживающих льготников на каждой записи
    foreach($aZhSovpr as $key => $value) 
    {
        // Трассируем найденные значения
        // echo "<br>".$key.'=>'.$value.' ['.$zhCount.'] '.$aZhLgokat[$key];
        // Выполняем проверку по оперативным записям льготников
        if ($aZhLgokat[$key]>1)
        {
            // Определяем сколько членов семей указано
            $chsem=$value-1;
            // Определяем, "сколько членов семьи можно указать"
            $vybrati=$bez-$Sovme;
            // Пересчитываем, сколько можно выбрать
            if ($chsem>$vybrati) 
            {
                $chsem=$vybrati;
                if (!$FirstMess)
                {
                    TriggerUserMessage(LgotyBolsheProzhiv);
                    $FirstMess=true;
                }
            }
            // Выбираем расчитанное количество
            $aZhSovpr[$key]=$chsem+1;
            // Пересчитываем, сколько выбрали
            $Sovme=$Sovme+$chsem;
            // Трассируем текущее состояние
            // echo '<br>'.'$bez-$Sovme: '.$bez.'-'.$Sovme;
        }
    }
}

// ****************************************************** VerifyDomikva.php *** 

