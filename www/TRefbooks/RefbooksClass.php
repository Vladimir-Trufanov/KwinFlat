<?php namespace reff;

// PHP7/HTML5, EDGE/CHROME                            *** RefbooksClass.php ***

// ****************************************************************************
// * KwinFlat.ru                               Обслужить ведение справочников *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.02.2018
// Copyright © 2018 tve                              Посл.изменение: 14.03.2018

require_once $SiteRoot."/TRefbooks/ViewGusl.php";
require_once $SiteRoot."/TRefbooks/ViewLgokat.php";
require_once $SiteRoot."/TRefbooks/ViewNormvoda.php";
require_once $SiteRoot."/TRefbooks/ViewNormotop.php";

class Refbooks
{
    // ************************************************************************
    // *   Проверить указывает ли назначение вывода для области комментария   *
    // *                       на существующий справочник                     *
    // ************************************************************************
    function isReffs($Comm)
    {
        global $aReffs;      
        $Result=false;
        foreach($aReffs as $key => $value) 
        {
            if ($key==$Comm) $Result=true;
            /*echo "<br>".$key.'=='.$Comm."<br>";*/
        }
        return $Result;
    }

    // ************************************************************************
    // *    Проинициализировать переменные общего изображения комментариев    *
    // ************************************************************************
    function init($fill)
	{
    }
    
    function show_Uslugi($fill,$db)
	{
        // Делаем выборку данных 
        $sql="
            select a.Inusl, a.Nmusl, a.Krusl, e.Name, g.Krgru, a.Tarif
            from Vusl a
            inner join Edizm e on (a.Edizm=e.Edizm)
            inner join Gusl g on (a.Kind=g.Kind)
            order by Inusl
        ";
        $st = $db->query($sql);
        $results = $st->fetchAll();
        // Загружаем выборку в таблицу
        $today = ''; //date("Y-m-d H:i:s");   
        echo "<h2>Справочник услуг</h2>";
        echo "
            <table class=\"refUslugi\">
            <tr>
                <td class=\"refCaption\">".$today."</td>
                <td class=\"refCaption\">Наименование</td>
                <td class=\"refCaption\">Кратко</td>
                <!--<td class=\"refCaption\">Ед.изм</td>-->
                <td class=\"refCaption\">Группа</td>
                <!--<td class=\"refCaption\">Тариф</td>-->
            </tr>";
        
        foreach ($results as $row) 
        {
            // if ($row['Inusl']==12) $row['Tarif']=14.18;
            echo 
            "<tr>".
            "<td class=\"refGreat\">".$row['Inusl']."</td>".
            "<td>".$row['Nmusl']."</td>".
            "<td>".$row['Krusl']."</td>".
            "<!--<td>".$row['Name']."</td>-->".
            "<td>".$row['Krgru']."</td>".
            "<!--<td>".$row['Tarif']."</td>-->".
            "</tr>";
        }
        echo "</table>";
    }
    
    // ************************************************************************
    // *               Вывести справочник по заданному запросу                *
    // ************************************************************************
    function _show($fill,$db,$value)
    {
        if ($value=='refLgokat')
        {
            show_LgoKat($fill,$db);
        }
        elseif ($value=='refGrusl')
        {
            show_Gusl($fill,$db);
        }
        elseif ($value=='refNormvoda')
        {
            show_Normvoda($db);
        }
        elseif ($value=='refNormotop')
        {
            show_Normotop($db);
        }
        elseif (($value=='refUsl')||($value=='Uslugi'))
        {
            $this->show_Uslugi($fill,$db);
        }
    }
    
    function show($fill,$db,$Comm)
	{
        // Трассируем количество элементов массива и переданный кукис
        // echo "<br>"."count=".count($fill).';  $Comm='.$Comm."<br>";
        // Если через get параметр не передавался (например, при запуске сайта),
        // то просто выводим последний выводившийся справочник
        if (count($fill)==0) $this->_show($fill,$db,$Comm);
        
        // Иначе выводим по указанию через параметр
        else
        {
            foreach($fill as $key => $value)
            {
                //echo "<br>"."show".$key."-->".$value."<br>";
                $this->_show($fill,$db,$value);
            }
        }
    }
}
//echo "<br>".'out.RefbooksClass'."<br>";
// ****************************************************** RefbooksClass.php ***

