<?php namespace norms;

// PHP7/HTML5, EDGE/CHROME                           *** ViewNormsClass.php ***

// ****************************************************************************
// * KwinFlat.ru                Представить выдержки из законов по нормативам *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.03.2018
// Copyright © 2018 tve                              Посл.изменение: 01.03.2018

class ViewNorms
{
    var $source;             // Материал о законе из файла
    
    // ************************************************************************
    // *   Проверить указывает ли назначение вывода для области комментария   *
    // *                           на текст закона                            *
    // ************************************************************************
    function isNorms($Comm)
    {
        global $aNorms;    
        $Result=false;
        foreach($aNorms as $key => $value) 
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
        //$this->source='Привет!';
        if ($value=='NormPPRK469')
        {
            $this->source=file_get_contents($SiteRoot.'/TViewNorms/PPRK469-20171226_O_minimalnom_VKR.html');
        }
        elseif ($value=='NormPPRF541')
        {
            $this->source=file_get_contents($SiteRoot.'/TViewNorms/PPRF541-20050829_O_Federalnyh_standartah_zhilya.html');
        }
        else 
        {
            $this->source=file_get_contents($SiteRoot.'/TViewNorms/PPRK129-20070827_O_socnormah_ploschadi.html');
        }
    }
    
    function init($fill,$Comm)
    {
        //echo "<br>".'ViewNorms.Init'."<br>";
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
    // *         Вывести изображение выбранного документа по нормативам       *
    // ************************************************************************
    function show($fill)
	{
        echo $this->source;
    }
}
// echo "<br>".'out.ViewNorms';
// ***************************************************** ViewNormsClass.php ***

