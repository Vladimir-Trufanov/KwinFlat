<?php namespace vnch;

// PHP7/HTML5, EDGE/CHROME                                *** DelUslugu.php ***

// ****************************************************************************
// * KwinFlat.ru                      Удалить, указанную в параметрах, услугу *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  30.03.2018
// Copyright © 2018 tve                              Посл.изменение: 07.04.2018

function isParm($key)
{
    $Result=False;
    //echo '<br>'.'$key='.$key.' ';
    foreach($_REQUEST as $parm => $pvalue) 
    {
        // Готовим поиск параметра с номером удаляемого элемента
        $reg="/du".'\d+'."/u"; 
        //echo '<br>'.'$reg='.$reg.' '.'$parm='.$parm.' ';
        if (preg_match($reg,$parm,$matches)) 
        {
            // Нашли и выбираем параметр с номером удаляемого элемента
            $elem=$matches[0];
            //echo '$elem='.$elem.' ';
            // Готовим выделение номера элемента массива
            $reg="/\d+/u"; 
            if (preg_match($reg,$elem,$matches)) 
            {
                // Выбираем номер удаляемого элемента массива услуг
                $num=$matches[0];
                //echo '$num='.$num;
                if ($num==$key)
                {
                    $Result=True;
                    break; 
                }
                
            }
        }
    }
    return $Result;
}

function _DelUslugu(&$arr,$aName)
{
    $isDel=false;  // "пока ничего не удалялось"
    // Пересобираем массив, удаляя указанную запись
    $arrZh=array();
    foreach($arr as $key => $value) 
    {
        if (isParm($key))    
        {
            // Не выбираем данный элемент (т.е. удаляем его)
            $isDel=true;
        }
        else
        {
            $arrZh[]=$value; 
        }
    }
    //\prown\ViewArray($arrZh,'2 $aInusl');
    // Возвращаем новый массив и регистрируем в кукисе 
    if ($isDel)
    {
        $arr=$arrZh;  
        $aVali=serialize($arr);
        \prown\MakeCookie($aName,$aVali);
    }
    return $isDel;
}

function DelUslugu(&$UslCount,&$aInusl,&$aTarif,&$aKolich,&$aKorr)
{
    //\prown\ViewArray($aInusl,'1 $aInusl');
    
    _DelUslugu($aInusl,'aInusl');   // здесь массивы
    _DelUslugu($aTarif,'aTarif');   // не сериализуем и не сохраняем 
    _DelUslugu($aKolich,'aKolich'); // в кукисах,
    _DelUslugu($aKorr,'aKorr');     // так как в DefoNach будет поджатие
    $UslCount=count($aInusl);
    \prown\MakeCookie('UslCount',$UslCount);
    
    //\prown\ViewArray($aInusl,'3 $aInusl');
}
// ********************************************************* DelProzhiv.php ***
