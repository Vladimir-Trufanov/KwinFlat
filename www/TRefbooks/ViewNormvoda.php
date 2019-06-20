<?php namespace reff;

// PHP7/HTML5, EDGE/CHROME                             *** ViewNormvoda.php ***

// ****************************************************************************
// * KwinFlat.ru                 Представить справочник нормативов по ХВС/ГВС *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  19.02.2018
// Copyright © 2018 tve                              Посл.изменение: 19.02.2018

function show_Normvoda($db)
{
    // Делаем выборку данных 
    $sql="
        select n.Vid, n.Name, n.NormHVS, n.NormGVS 
        from NormVoda n
        order by n.Vid
    ";
    $st = $db->query($sql);
    $results = $st->fetchAll();
    // Загружаем выборку в таблицу
    echo "<h2>Нормы потребления ХВС, ГВС</h2>";
    echo    
        "<h3>
        <a href=\"http://publication.pravo.gov.ru/Document/View/1001201710040002?index=1&rangeSize=1\">
        Приказ Министерства строительства, жилищно-коммунального хозяйства и  энергетики Республики Карелия от \"31\" мая 2017 года №156
        \"Об утверждении нормативов потребления коммунальных ресурсов в целях содержания общего имущества в многоквартирных домах на территории Республики Карелия\"
        </a>                      
        </h3>";
    echo "
        <table class=\"refNormvoda\">
        <tr>
            <td class=\"refCapgrusl\">Вид благоустройства</td>
            <td class=\"refCapgrusl\">Наименование</td>
            <td class=\"refCapgrusl\">ХВС</td>
            <td class=\"refCapgrusl\">ГВС</td>
        </tr>";
    foreach ($results as $row) 
    {
        echo
        "<tr>".
        "<td class=\"refNormvoda\">".$row['Vid']."</td>".
        "<td class=\"refNormvoda\">".$row['Name']."</td>".
        "<td class=\"refNormvoda\">".$row['NormHVS']."</td>".
        "<td class=\"refNormvoda\">".$row['NormGVS']."</td>".
        "</tr>";
    }
    echo "</table>";
    echo 
        "<p class=\"izm\">
            Список изменяющих документов (в ред. Приказа Министерства строительства, ЖКХ и энергетики Республики Карелия от 02.10.2017 №280)
        </p>";
}
// ******************************************************* ViewNormvoda.php ***

