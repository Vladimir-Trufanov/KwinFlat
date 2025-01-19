<?php

// PHP7/HTML5, EDGE/CHROME                                   *** AddUsl.php ***

// ****************************************************************************
// * KwinFlat.ru                              Добавить новую услугу к расчету *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.04.2018
// Copyright © 2018 tve                              Посл.изменение: 06.04.2018
?>
<!--  -->
<div id=\"AddUsl\">
<?php
    // Определяем существующую размерность массива включенных услуг,
    // для того чтобы задать номер нового элемента
    $zhUsl=$Nch->UslCount;
    //echo '<br>$zhUsl='.$zhUsl;
?>
<h2>Добавить новую услугу к расчету</h2>
<form class="contact_form" action="" method="get" name="contact_form">
    <ul>
    <li>
        <span class="required_notification">* Обязательные для заполнения поля</span>
    </li>
	<li>
        <label for="usluga">Услуга</label>
        <?php
        echo "<select name=\"Inusl".
            "$zhUsl".
            "\" id=\"usluga\" placeholder=\"1, Содержание общего имущества\" required>";
        // Указываем массив льготных категорий
        global $aUslugi;
        $aInusl=$Nch->aInusl;
        foreach ($aUslugi as $row) 
        {
            if (!\common\isUsl($row['Inusl'],$aInusl))
            {
                echo "<option>".$row['Inusl'].', '.$row['Nmusl']."</option>";
            }
        }
        echo "</select>";
        ?>
        <span class="form_hint">выбрать из справочника</span>
    </li>
    <li>
        <label for="tarifusl">Тариф</label>
        <?php
        echo "<input id=\"tarifusl\" type=\"number\" name=\"Tarif".
            "$zhUsl".
            "\" placeholder=\"10.0\" step=\"0.01\" min=\"0.00\" ".
            "max=\"9999.99\" required>"; 
        ?>
    </li>
    <li>
        <label for="kolusl">Количество</label>
        <?php
        echo "<input id=\"kolusl\" type=\"number\" name=\"Kolich".
            "$zhUsl".
            "\" placeholder=\"1.0\" step=\"0.0001\" min=\"-999.9999\" ".
            "max=\"999.9999\">"; 
        ?>
    </li>
    <li>
        <label for="korrusl">Корректировка</label>
        <?php
        echo "<input id=\"korrusl\" type=\"number\" name=\"Korr".
            "$zhUsl".
            "\" placeholder=\"10.0\" step=\"0.01\" min=\"-999.99\" ".
            "max=\"999.99\" value=\"0\">";
        ?>
    </li>
    <li>
        <button class="submit" type="submit">Добавить</button>
    </li>
    </ul>
</form>
</div> 
<?php
// ************************************************************* AddUsl.php ***
