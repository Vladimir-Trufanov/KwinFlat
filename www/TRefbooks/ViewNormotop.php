<?php namespace reff;

// PHP7/HTML5, EDGE/CHROME                             *** ViewNormotop.php ***

// ****************************************************************************
// * KwinFlat.ru               Представить справочник нормативов по отоплению *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  19.02.2018
// Copyright © 2018 tve                              Посл.изменение: 19.02.2018

function show_Normotop($db)
{
    // Делаем выборку данных 
    $sql="
        select n.EtDom, n.Factor, n.GruDom, n.KatDom1, n.KatDom2, n.KatDom3, n.KatDom4, n.KatDom5 
        from NormOto n
        order by n.GruDom, n.Factor, n.EtDom
    ";
    $st = $db->query($sql);
    $results = $st->fetchAll();
    // Загружаем выборку в таблицу
    echo "<h2>Нормы потребления по отоплению</h2>";
    echo    
        "<h3>
        <a href=\"https://gov.karelia.ru/Karelia/2722/11.html\">
        Приказ Министерства строительства, жилищно-коммунального хозяйства и  энергетики Республики Карелия от \"29\" июля 2016 года №196
        \"Об утверждении нормативов потребления коммунальной услуги по отоплению в жилых и нежилых помещениях в многоквартирных домах и жилых домов на территории Республики Карелия\"
        </a>                      
        </h3>";
    echo "
        <table class=\"refNormotop\">
        <tr>
            <th>Этажность</td>
            <th>Дома со стенами из дерева</td>
            <th>Дома со стенами из камня, кирпича</td>
            <th>Дома со стенами из панелей, блоков</td>
            <th>Дома с каркасно-засыпными стенами</td>
            <th>Дома со стенами из арбалита и крупно- панельных блоков</td>
        </tr>";
    global $aGrudom,$aFactor;
    $cDopinf='.<br>Норматив потребления (Гкал на 1 кв.метр общей площади жилого помещения в месяц)';
    $GruDom=0; $Factor=0;
    $CtrlRow=0;  // Контрольная строка для формирования постфикса "и более"
    foreach ($results as $row) 
    {
        $CtrlRow++;
        // Отделяем вывод по группам домов
        if (!($GruDom==$row['GruDom']))
        {
            echo "<tr>";
            $GruDom=$row['GruDom'];
            echo
                "<td class=\"refNormoto1\" colspan=\"6\">".
                $aGrudom[$GruDom].$cDopinf.
                "</td>";
            echo "</tr>";
        }
        // Отделяем вывод по отопительным периодам
        if (!($Factor==$row['Factor']))
        {
            echo "<tr>";
            $Factor=$row['Factor'];
            echo
                "<td class=\"refNormoto2\" colspan=\"6\">".
                $aFactor[$Factor].
                "</td>";
            echo "</tr>";
        }
    
        echo "<tr>";
        // Выводим этажность, отлавливая последние этажи для 
        // добавления постфикса "и более" 
        if (($CtrlRow>=count($results))||($results[$CtrlRow]['EtDom']<$row['EtDom']))
        {
            echo "<td>".$row['EtDom']." и более</td>";
        }
        else echo "<td>".$row['EtDom']."</td>";
        // Выводим колонки нормативов
        echo
        "<td>".\prown\NoZero($row['KatDom1'])."</td>".
        "<td>".\prown\NoZero($row['KatDom2'])."</td>".
        "<td>".\prown\NoZero($row['KatDom3'])."</td>".
        "<td>".\prown\NoZero($row['KatDom4'])."</td>";
        echo "<td>".\prown\NoZero($row['KatDom5'])."</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo 
        "<p class=\"izm\">
            Список изменяющих документов (в ред. Приказа Министерства строительства, ЖКХ и энергетики Республики Карелия от 29.08.2016 №215)
        </p>";
}
// ******************************************************* ViewNormotop.php ***

