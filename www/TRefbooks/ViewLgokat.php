<?php namespace reff;

// PHP7/HTML5, EDGE/CHROME                               *** ViewLgokat.php ***

// ****************************************************************************
// * KwinFlat.ru                       Представить справочник категорий льгот *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  19.02.2018
// Copyright © 2018 tve                              Посл.изменение: 06.03.2018
    
function show_LgoKat($fill,$db)
{
    // Указываем массив льготных категорий
    global $aLgokat;
    // Загружаем выборку в таблицу
    echo "<h2>Справочник категорий льгот</h2>";
    echo "
        <table class=\"refUslugi\">
        <tr>
        <td class=\"refCaption\"></td>
        <td class=\"refCaption\">Наименование</td>
        <td class=\"refCaption\">Льгота по ЖУ</td>
        <td class=\"refCaption\">Комм.услуги</td>
        <td class=\"refCaption\">ОДН КУ</td>
        <td class=\"refCaption\">Взнос кап.ремонта</td>
        </tr>";
    foreach ($aLgokat as $row) 
    {
        echo 
        "<tr>".
        "<td class=\"refGreat\">".$row['Inkat']."</td>".
        "<td>".$row['Namekat']."</td>".
        "<td>".$row['Zhucod'].', '.$row['Zhuprv']."</td>".
        "<td>".$row['Kucod'].', '.$row['Kuprv']."</td>".
        "<td>".$row['Odncod'].', '.$row['Odnprv']."</td>".
        "<td>".$row['Vkrcod'].', '.$row['Vkrprv']."</td>".
        "</tr>";
    }
    echo "</table>";
}

// ********************************************************* ViewLgokat.php ***

