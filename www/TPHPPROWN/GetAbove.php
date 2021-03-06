<?php namespace prown; 
                                         
// PHP7/HTML5, EDGE/CHROME                                 *** GetAbove.php ***

// ****************************************************************************
// * Определить корневой каталог сайта, надсайтовый каталог, каталог хостинга *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  30.01.2018
// Copyright © 2018 TVE                              Посл.изменение: 10.12.2018

// Из абсолютного пути корневого каталога сайта 
// выбрать путь надсайтового каталога 
function GetAbove($SiteRoot)
{
    $Result=$SiteRoot;
    // Считаем, что отладка идет в Windows IIS,
    // поэтому вначале ищем последний обратный слэш
    $Point=strrpos($Result,'\\');
    // Обратный слэш не найден, считаем что на хостинге (Apache,Linux)
    if ($Point==0) 
	{
	    // echo "Обратного слэша не найдено!"."<br>";
	    // Ищем последний слэш
        $Point=strrpos($Result,'/');
	    // Если слэш найден, выделяем надсайтовый каталог
        if ($Point>0) {$Result=substr($SiteRoot,0,$Point);}
    }
    // Обратный слэш найден, выделяем надсайтовый каталог в Windows
    else 
	{
        // echo "Обратный слэш "; echo "***".$Point."***"."<br>";
	    $Result=substr($SiteRoot,0,$Point);
    }
    return $Result;
}

// *********************************************************** GetAbove.php ***
 
