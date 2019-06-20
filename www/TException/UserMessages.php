<?php 
                                          
// PHP7/HTML5, EDGE/CHROME                             *** UserMessages.php ***

// ****************************************************************************
// * KwinFlat.ru              Определение констант пользовательских сообщений *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  03.02.2018
// Copyright © 2018 tve                              Посл.изменение: 02.05.2018

define ("Simple",             "001: Просто сообщение!");
define ("PressWriteKey",      "Нажмите кнопку \"Записать\" с верным значением");
define ("NevernaLgoKat",      "101: Неверно выбрана категория льготы!");
define ("LgotyBolsheProzhiv", "102: Количество льготополучателей и членов их семей ".
    "превышает количество проживающих!");
define ("Pldom10_999999",     "103: Площадь дома не в диапазоне 10-99999.99 м2!");
define ("Plkvar10_999",       "104: Площадь квартиры не в диапазоне 10-999.99 м2!");
define ("MassivBolshoy",      "105: В параметре превышена размерность массива!");
define ("MasCookBolshoy",     "106: Максимумом ограничен размер кукиса массива!");
define ("Etdom1_35",          "107: Этажность дома не в диапазоне 1-35 этажей!");
define ("Godstr17_58",        "108: Год постройки не в диапазоне 1917-2058!");
define ("KatDom1_5",          "109: Категория дома не в диапазоне 1-5!");
define ("PerOto89_12",        "110: Отопительный период не в диапазоне 8-12!");

function TriggerUserMessage($Message,$Postfix=null)
{
    //trigger_error($Message,E_USER_ERROR);
    echo "<div id=\"Ers\"> ";
    if ($Postfix==null) echo $Message;
    else echo $Message.' ['.$Postfix.']';
    echo "</div>";
}

function MakeUserMessage($E_message)
{
    preg_match("/\d+: [а-яА-ЯЁёa-zA-Z0-9 _]+!/u",$E_message,$matches);
    \common\Headeri("/Main.php?Com=Mess&mess=".$matches[0]);
}

// ******************************************************* UserMessages.php ***
