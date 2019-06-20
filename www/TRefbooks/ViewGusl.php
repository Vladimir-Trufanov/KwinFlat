<?php namespace reff;

// PHP7/HTML5, EDGE/CHROME                                 *** ViewGusl.php ***

// ****************************************************************************
// * KwinFlat.ru                           Представить справочник групп услуг *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  19.02.2018
// Copyright © 2018 tve                              Посл.изменение: 19.02.2018

function show_Gusl($fill,$db)
{
    // Делаем выборку данных 
    $sql="
        select g.Kind, g.Krgru, g.Nmgru 
        from Gusl g
        order by g.Kind
    ";
    $st = $db->query($sql);
    $results = $st->fetchAll();
    // Загружаем выборку в таблицу
    echo "<h2>Справочник групп услуг</h2>";
    echo "
        <table class=\"refGrusl\">
        <tr>
            <td class=\"refCapgrusl\">Код группы</td>
            <td class=\"refCapgrusl\">Краткое наименование</td>
            <td class=\"refCapgrusl\">Полное</td>
        </tr>";
    foreach ($results as $row) 
    {
        echo
        "<tr>".
        "<td class=\"refGrusl\">".$row['Kind']."</td>".
        "<td class=\"refGrusl\">".$row['Krgru']."</td>".
        "<td class=\"refGrusl\">".$row['Nmgru']."</td>".
        "</tr>";
    }
    echo "</table>";
}
// *********************************************************** ViewGusl.php ***

