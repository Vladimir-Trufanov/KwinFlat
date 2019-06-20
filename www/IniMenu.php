<?php                                           
// PHP7/HTML5, EDGE/CHROME                                  *** IniMenu.php ***

// ****************************************************************************
// * KwinFlat.ru              Вывести дополнительные меню, отработать функции *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  14.02.2018
// Copyright © 2018 tve                              Посл.изменение: 21.06.2018

function IniTopMenu($Comm,$isLaws,$isNorms,$isReffs)
{
    echo "<nav>";
    echo "<ul>";
    echo "<li><a class=\"buttons\" href=\"Main.php?Com=Common\">Дом и квартира</a></li>";
    if (!($isReffs)) echo "<li><a class=\"buttons\" href=\"Main.php?Com=Uslugi\">Справочники</a></li>";
    if (!($isLaws)) echo "<li><a class=\"buttons\" href=\"Main.php?Com=Laws\">Законы</a></li>";
    if (!($isNorms)) echo "<li><a class=\"buttons\" href=\"Main.php?Com=Norms\">Нормативы</a></li>";

    if ($isReffs) 
    {
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=refUsl\">Услуги</a></li>";
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=refLgokat\">Категории льгот</a></li>";
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=refGrusl\">Группы услуг</a></li>";
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=refNormvoda\">Нормы ХВС,ГВС</a></li>";
        if (($_SERVER['HTTP_HOST']=='kwinflat.ru')||($_SERVER['HTTP_HOST']=='kwinflatht.nichost.ru'))
        {
            echo "<li><a class=\"buttons\" href=\"Normativy_po_otopleniyu\">Нормы отопления</a></li>";
        }
        else
        {
            echo "<li><a class=\"buttons\" href=\"Main.php?Com=refNormotop\">Нормы отопления</a></li>";
        }
    }

    elseif ($isLaws)  
    {
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=LawF5\">ФЗ5,12.01.1995</a></li>";
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=LawRK827\">ЗРК827,09.12.2004</a></li>";
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=LawF181\">ФЗ181,24.11.1995</a></li>";
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=LawF1244\">ФЗ1244,15.05.1991</a></li>";
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=LawF2\">ФЗ2,10.01.2002</a></li>";
    }

    elseif ($isNorms)  
    {
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=NormPPRK129\">ППРК129,27.08.2007</a></li>";
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=NormPPRF541\">ППРФ541,29.08.2005</a></li>";
        echo "<li><a class=\"buttons\" href=\"Main.php?Com=NormPPRK469\">ППРК469,12.26.2017</a></li>";
    }
    echo "</ul>";
    echo "</nav>";
}
                                                              
function IniBottomMenu()
{
    echo "<nav>";
    echo "<ul>";
    // echo "<li><a class=\"buttons\" href=\"/Info/Proba.php\">Проба</a></li>";
    // echo "<li><a class=\"buttons\" href=\"/Info/regexp.php\">Регулярки</a></li>";
    echo "<li><a class=\"buttons\" href=\"/Entrys/Indoor.php\">Вход</a></li>";
    echo "<li><a class=\"buttons\" href=\"/Entrys/ContactUs.php\">Контакты</a></li>";
    // echo "<li><a href=\"/TRefbooks/MenuRomashka.html\" target=\"_blank\">Регистрация</a></li>";
    echo "<li><a class=\"buttons\" href=\"/Entrys/Register.php\">Регистрация</a></li>";
 
    if (($_SERVER['HTTP_HOST']=='kwinflat.ru')||($_SERVER['HTTP_HOST']=='kwinflatht.nichost.ru'))
    {
        echo "<li><a class=\"buttons\" href=\"Redaktor_tekstov\">Материалы</a></li>";
    }
    else
    {
        echo "<li><a class=\"buttons\" href=\"/TinyMCE\">Материалы</a></li>";
    }
 
    // echo "<li><a href=\"Main.php\">Настройки</a></li>";
    // echo "<li><a href=\"/Filesystem/get_contents.php\">Карелия?</a></li>";
    // echo "<li><a class=\"buttons\" href=\"/Info/Info.php\" target=\"_blank\">Информация</a></li>";
    echo "<li><a class=\"buttons\" href=\"Main.php?Com=About&mess=KwinFlat-близкий_всем!\">О программе</a></li>";
    //echo "<li><a href=\"Main.php?Com=Mess&mess=KwinFlat-близкий всем!\">Mess</a></li>";
    echo "</ul>";
    echo "</nav>";
}
                                                              
function IniPlusMinus($parm,$isMinus=true)
{
    echo "<nav>";
    echo "<ul>";
    if ($parm==Instr)
    {
        echo "<li><a id=\"plusins\" class=\"buttons\" href=\"Main.php?Com=bolIns\">╬</a></li>";
        echo "<li><a id=\"minusins\" class=\"buttons\" href=\"Main.php?Com=menIns\">═</a></li>";
    }
    elseif ($parm==Zhkvar)
    {
        echo "<li><a id=\"pluszh\" class=\"buttons\" href=\"Main.php?Com=addZhKvar\">╬</a></li>";
        // if ($isMinus) 
        echo "<li><a id=\"minuszh\" class=\"buttons\" href=\"Main.php?Com=delZhKvar\">═</a></li>";
    }
    elseif ($parm==ListUsl)
    {
        echo "<li><a id=\"plusus\" class=\"buttons\" href=\"Main.php?Com=addUsl\">╬</a></li>";
        echo "<li><a id=\"minusus\" class=\"buttons\" href=\"Main.php?Com=delUsl\">═</a></li>";
    }
    else
    {
        echo "<li><a id=\"plus\" class=\"buttons\" href=\"Main.php\">╬</a></li>";
        echo "<li><a id=\"minus\" class=\"buttons\" href=\"Main.php\">═</a></li>";
    }
    echo "</ul>";
    echo "</nav>";
}

// ****************************************************************************
// *                    Изменить высоту дива инструкции                       *
// ****************************************************************************
function putwi($wi)
{
    \prown\MakeCookie('wi',$wi); 
    \common\Headeri("/Main.php?wi=".$wi);
}
function IniHeightInstr(&$wi)
{
    // Определяем текущую высоту дива инструкции
    $wi = $_COOKIE['wi'] ?? 10; 
    // Если нужно изменяем высоту дива
    if (IsSet($_GET['Com'])) 
    { 
        if ($_GET['Com']=="bolIns")
        {
            $wi=$wi+10;
            if ($wi>114) $wi=114; 
            putwi($wi);
        } 
        elseif ($_GET['Com']=="menIns")
        {
            $wi=$wi-10;
            if ($wi<4) $wi=4;  
            putwi($wi);
        } 
    }
}

// ************************************************************ IniMenu.php *** 

