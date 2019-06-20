<?php namespace domik;

// PHP7/HTML5, EDGE/CHROME                               *** DelProzhiv.php ***

// ****************************************************************************
// * KwinFlat.ru                 Удалить, указанных в параметрах, проживающих *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  30.03.2018
// Copyright © 2018 tve                              Посл.изменение: 31.03.2018

function _DelProzhiv(&$arr,$aName)
{
    $isDel=false;  // "пока ничего не удалялось"
    // Пересобираем массивы, удаляя указанных проживающих
    // (так можно и для несколько записей для удаления)
    $arrZh=array();
    foreach($arr as $key => $value) 
    {
        // echo '$key='.$key;
        if (IsSet($_REQUEST['dr'.$key])) 
        {
            // Не выбираем данный элемент
            // (т.е. удаляем его)
            $isDel=true;
        }
        else
        {
            $arrZh[]=$value; 
        }
    }
    // Возвращаем новый массив и регистрируем в кукисах
    if ($isDel)
    {
        //\prown\ViewArray($arrZh,'$arrZh');
        $arr=$arrZh;
        $aVali=serialize($arr);
        \prown\MakeCookie($aName,$aVali);
    }
    return $isDel;
}

function DelProzhiv(&$zhCount,&$aZhFio,&$aZhLgokat,&$aZhSovpr)
{
    $isDel=_DelProzhiv($aZhFio,'aZhFio');
    //\prown\ViewArray($aZhFio,'$aZhFio');

    _DelProzhiv($aZhLgokat,'aZhLgokat');
    _DelProzhiv($aZhSovpr,'aZhSovpr');
    if ($isDel)
    {
        $zhCount=count($aZhFio);
        \prown\MakeCookie('ZhCount',$zhCount);
    }
}
// ********************************************************* DelProzhiv.php ***
