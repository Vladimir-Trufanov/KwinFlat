<?php namespace vnch;

// PHP7/HTML5, EDGE/CHROME                                 *** DefoNach.php ***

// ****************************************************************************
// * KwinFlat.ru                             Проинициализировать по умолчанию * 
// *                                          массивы и переменные начислений *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.02.2018
// Copyright © 2018 tve                              Посл.изменение: 03.04.2018

function IniNachStep(&$UslCount,&$aInusl,&$aTarif,&$aKolich,&$aKorr,$Mode)
{
    $MaxCount=14;    // максимальное количество проживающих
    \prown\PullArray($aInusl,'Inusl',$Mode,tInt,$MaxCount);
    \prown\PullArray($aTarif,'Tarif',$Mode,tFloat,$MaxCount);
    \prown\PullArray($aKolich,'Kolich',$Mode,tFloat,$MaxCount);
    \prown\PullArray($aKorr,'Korr',$Mode,tFloat,$MaxCount);
    $UslCount=count($aInusl);
    \prown\MakeCookie('UslCount',$UslCount);

}

function DefoNach(&$UslCount,&$aInusl,&$aNameUsl,&$aEdIzm,&$aNorma,
    &$aTarif,&$aKolich,&$aKorr,$Atfirst)
{
    // Инициируем наименования услуг
    $aNameUsl=array();
    // Инициируем единицы измерения
    $aEdIzm=array();
    // Инициируем нормативы
    $aNorma=array();
    
    // Step1: Инициируем массивы по умолчанию
    // \prown\ViewArray($_COOKIE,'1 $_COOKIE');
    $UslCount=4;
    // Инициируем услуги
    $aInusl[0]=1;
    $aInusl[1]=7;
    $aInusl[2]=151;
    $aInusl[3]=206;
    // Инициируем тарифы
    $aTarif[0]=22.92;
    $aTarif[1]=38.24;
    $aTarif[2]=2.13;
    $aTarif[3]=7.60;
    // Инициируем количества
    $aKolich[0]=52.3;
    $aKolich[1]=3.214;
    $aKolich[2]=0.736;
    $aKolich[3]=52.3;
    // Инициируем корректировки
    $aKorr[0]=214.17;
    $aKorr[1]=0;
    $aKorr[2]=-14.24;
    $aKorr[3]=0;
    
    // Очищаем параметры с ИН услуг от наименований
    foreach($_REQUEST as $key => $value) 
    {
        // Трассируем выбираемые значения
        //echo '<br>'.'Dfn: '.$key.'=>'.$value;
        // Отлавливаем параметы массива
        $reg="/^Inusl\d+$/u"; 
        //echo '<br>'.'$reg='.$reg.' ';
        if (preg_match($reg,$key,$matches)) 
        {
            $elem=$matches[0];
            //echo '$elem='.$elem.' ';
            // Выбираем номер элемента массива
            $reg="/".'\d+'."/u"; 
            if (preg_match($reg,$value,$matches)) 
            {
                $num=$matches[0];
                $_REQUEST[$key]=intval($num);
                //echo '$_REQUEST['.$key.']='.$_REQUEST[$key].'  $num='.$num;
            }
        }
    }
        
    // Step2: Изменяем значения через кукисы и параметры
    if ($Atfirst==Atfirst)
    {
        $Mode=arcoCookie;  // Перенести опер.массив в кукис не изменяя его параметрами 
        IniNachStep($UslCount,$aInusl,$aTarif,$aKolich,$aKorr,$Mode);
        \common\Headeri("/Main.php");
    }
    $Mode=arcoUpdateOrInsert;  // Обновить опер.массивы по кукисам и параметрам 
    IniNachStep($UslCount,$aInusl,$aTarif,$aKolich,$aKorr,$Mode);

    // Step2.1: Удаляем указанную услугу
    //\prown\ViewArray($_COOKIE,'2 $_COOKIE');
    DelUslugu($UslCount,$aInusl,$aTarif,$aKolich,$aKorr);
    //\prown\ViewArray($_COOKIE,'3 $_COOKIE');
        
    // Step3: Проверяем соответствие размеров массивов. Если размеры не 
    // совпадают, поджимаем массивы, вырезая несоответствия
    $Arrays=array();
    $Arrays[]=$aInusl;
    $Arrays[]=$aTarif;
    $Arrays[]=$aKolich;
    $Arrays[]=$aKorr;
    $Dim=0;
    if (!(\prown\isCountArrays($Arrays,$Dim)))
    {
        $Arrays=\prown\SqueezeArrays($Arrays,$Dim);
        // Реинициализируем массивы по оперативным данным
        if (!($UslCount==$Dim))
        {
            $UslCount=$Dim;
            $aInusl=$Arrays[0];
            $aTarif=$Arrays[1];
            $aKolich=$Arrays[2];
            $aKorr=$Arrays[3];
            // Переписываем кукисы по оперативным массивам
            $Mode=arcoCookie; // Перенести опер.массив в кукис не изменяя его параметрами
            IniNachStep($UslCount,$aInusl,$aTarif,$aKolich,$aKorr,$Mode);
        }
    }
    //\prown\ViewArray($_COOKIE,'4 $_COOKIE');

    // Step4: Делаем контрольные преобразования элементов массивов
    if (!VerifyNach($aInusl,$aTarif,$aKolich,$aKorr))
    {
        $Mode=arcoCookie; // Перенести опер.массив в кукис не изменяя его параметрами
        IniNachStep($UslCount,$aInusl,$aTarif,$aKolich,$aKorr,$Mode);
    };
    //\prown\ViewArray($aKorr,'2 $aKorr');
    //\prown\ViewArray($_COOKIE,'5 $_COOKIE');
    //$aInusl[3]=206;
    //\prown\PullArray($aInusl,'Inusl',arcoUpdateOrInsert,14);
    //\prown\ViewArray($aInusl,'3 aInusl');
    //\prown\ViewArray($_COOKIE,'5 $_COOKIE');
    
}
// *********************************************************** DefoNach.php ***

