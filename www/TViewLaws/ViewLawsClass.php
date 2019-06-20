<?php namespace laws;

// PHP7/HTML5, EDGE/CHROME                            *** ViewLawsClass.php ***

// ****************************************************************************
// * KwinFlat.ru                              Представить выдержки из законов *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  14.02.2018
// Copyright © 2018 tve                              Посл.изменение: 19.03.2018

class ViewLaws
{
    var $source;             // Материал о законе из файла
    
    /*
    $aLaws =                                    // Список законов и заголоаков
    [
    'Laws'    =>'Last',
    'LawF5'   =>'ФЗ5,12.01.1995',
    'LawRK827'=>'ЗРК827,09.12.2004',
    'LawF181' =>'ФЗ181,24.11.1995',
    'LawF1244'=>'ФЗ1244,15.05.1991',
    'LawF2'   =>'ФЗ2,10.01.2002'
    ];      
    */

    // ************************************************************************
    // *   Проверить указывает ли назначение вывода для области комментария   *
    // *                           на текст закона                            *
    // ************************************************************************
    function isLaws($Comm)
    {
        global $aLaws;    
        $Result=false;
        foreach($aLaws as $key => $value) 
        {
            if ($key==$Comm) $Result=true;
            /*echo "<br>".$key.'=='.$Comm."<br>";*/
        }
        return $Result;
    }
    // ************************************************************************
    // *                          Подготовить вывод закона                    *
    // ************************************************************************
    function _init($value)
    {
        global $SiteRoot;    // Корень сайта
        if ($value=='LawRK827')
        {
            $this->source=file_get_contents($SiteRoot.'/TViewLaws/ZRK827-20041209_Po_kategoriyam_grazhdan.html');
        }
        elseif ($value=='LawF181')
        {
            $this->source=file_get_contents($SiteRoot.'/TViewLaws/F181-19951124_O_soczaschite_invalidov.html');
        }
        elseif ($value=='LawF1244')
        {
            $this->source=file_get_contents($SiteRoot.'/TViewLaws/F1244-19910515_O_soczaschite_chernobylcev.html');
        }
        else 
        {
            $this->source=file_get_contents($SiteRoot.'/TViewLaws/F5-19950112_O_veteranah.html');
        }
    }
    
    function init($fill,$Comm)
    {
        //echo "<br>".'ViewLaws.Init'."<br>";
        //\prown\ViewArray($fill,'$fill');
        // Если через get параметр не передавался (например, при запуске сайта),
        // то просто готовим вывод последнего выводившегося закона
        if (count($fill)==0) $this->_init($Comm);
        // Готовим вывод документа по заказу
        foreach($fill as $key => $value)
        {
            $this->_init($value);
        }
    }
        
    // ************************************************************************
    // *                  Вывести общее изображение комментариев              *
    // ************************************************************************
    function show($fill)
	{
        echo $this->source;
    }
}
//echo "<br>".'out.ViewLaws'."<br>";
// ****************************************************** ViewLawsClass.php ***

