<?php namespace domik;

// PHP7/HTML5, EDGE/CHROME                               *** AddProzhiv.php ***

// ****************************************************************************
// * KwinFlat.ru       Добавить нового проживающего, приняв его из параметров *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  30.03.2018
// Copyright © 2018 tve                              Посл.изменение: 30.03.2018

function AddProzhiv(&$zhCount,&$aZhFio,&$aZhLgokat,&$aZhSovpr)
{
    $Result=0;
    // Проверяем, есть ли полный комплект из трех параметров:
    // фамилия ио, категория льготы и количество членов семьи
    $famio=''; $lgokat=1; $kolvo=1; 
    if (IsSet($_REQUEST['famio'])) 
    {
        $famio=$_REQUEST['famio']; 
        if (IsSet($_REQUEST['lgokat'])) 
        {
            // Здесь категория пришла через параметр с комментарием, 
            // поэтому отрезаем комментарий через регулярное выражение
            // (выделяем первое целое число)
            $lgokat=\common\ctrlLgokat($_REQUEST['lgokat']); 
            //
            if (IsSet($_REQUEST['kolvo'])) 
            {
                $kolvo=$_REQUEST['kolvo']; 
            }
            // Обеспечиваем количество, как минимум=1
            if ($kolvo<=1) 
            {
                $kolvo=1; 
            }
            // Все три параметра для нового проживающего есть,
            // добавляем их в оперативные массивы, и в кукисы
            $aZhFio[$zhCount]=$famio;
            $aZhLgokat[$zhCount]=$lgokat;
            $aZhSovpr[$zhCount]=$kolvo;
            $zhCount=$zhCount+1;
            // Реинициализируем массивы по оперативным данным
            $IsCookie=False; 
            IniDomikStep($zhCount,$aZhFio,$aZhLgokat,$aZhSovpr,$IsCookie);
            /*
            \prown\ViewArray($_REQUEST,'$_REQUEST');
            \prown\ViewArray($aZhFio,'aZhFio');
            \prown\ViewArray($aZhLgokat,'aZhLgokat');
            \prown\ViewArray($aZhSovpr,'aZhSovpr');
            \prown\ViewArray($_COOKIE,'$_COOKIE');
            */
            // Для предотвращения повторной перезагрузки сайта с параметрами
            // явно перезапускаем его без параметров 
            \common\Headeri("/Main.php");
         }
    }
    
    return $Result;
}

// ********************************************************* AddProzhiv.php ***
