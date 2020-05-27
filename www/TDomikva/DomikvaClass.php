<?php namespace domik; 

// PHP7/HTML5, EDGE/CHROME                             *** DomikvaClass.php ***

// ****************************************************************************
// * KwinFlat.ru             Обслужить вывод и редактирование данных по дому, * 
// *                                                   квартире и проживающим *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.02.2018
// Copyright © 2018 tve                              Посл.изменение: 03.05.2018

require_once $SiteRoot."/TDomikva/IniDomikva.php";
require_once $SiteRoot."/TDomikva/SubDomikva.php";
require_once $SiteRoot."/TDomikva/VerifyDomikva.php";
require_once $SiteRoot."/TDomikva/PickLgoKat.php";
require_once $SiteRoot."/TDomikva/AddProzhiv.php";
require_once $SiteRoot."/TDomikva/DelProzhiv.php";

class Domikva
{
    // Сведения о доме для расчета
    public $PlDom;               // Общая площадь дома
    public $PlKvar;              // Общая площадь квартиры
    public $EtDom;               // Этажность дома
    public $GodStr;              // Год постройки
    public $Vidblag;             // Вид благоустройства
    public $KatDom;              // Категория дома
    public $PerOto;              // Отопительный период
     
    // Сведения о проживающих
    public $zhCount;             // Количество проживающих в квартире
    public $aZhFio = array();    // Массив проживающих
    public $aZhLgokat = array(); // Массив категорий льгот проживающих
    public $aZhSovpr = array();  // Массив совместно проживающих (семей)
    
    // ************************************************************************
    // *             Проинициализировать сведения о проживающих               *
    // *                   и сведения о доме для расчета                      *
    // ************************************************************************
    function init($db,$Atfirst)
	{
        IniDomik($this->PlDom,$this->PlKvar,$this->Vidblag,$this->zhCount,
           $this->aZhFio,$this->aZhLgokat,$this->aZhSovpr,$db,$Atfirst,
           $this->EtDom,$this->GodStr,$this->KatDom,$this->PerOto);
    }
        
    // ************************************************************************
    // *       Представить сведения о проживающих и о доме для расчета        *
    // ************************************************************************
    function show($aRequest)
    { 
    echo "<h2>Дом и квартира</h2>";
    echo "<form class=\"frmDomKvar\" method=\"post\" name=\"DomvesFrm\">";
    // Обрабатываем данные по дому
    echo "<div id=\"Domves\">";
    echo "<fieldset>";
    echo "<legend class=\"legDomKvar\">Параметры расчета</legend>";
    echo "<ul>";
    
    echo "<li class=\"liPld\">";
    echo "<label for=\"pld\">Общая площадь дома, м2: </label>";
    echo "<input id=\"pld\" type=\"number\" name=\"pld\" value=".$this->PlDom." ".
         "step=\"0.01\" min=\"10.00\" max=\"999999.99\"".">"; 
    echo "</li>";
    
    echo "<li class=\"liPlk\">";
    echo "<label for=\"plk\">Общая площадь квартиры, м2: </label>";
    echo "<input id=\"plk\" type=\"number\" name=\"plk\" value=".$this->PlKvar." ".
         "step=\"0.01\" min=\"10.00\" max=\"999.99\"".">"; 
    echo "</li>";
    // Определяем степень благоустройства
    global $aOpenSys,$aCloseSys;
    $VidblagList[]=["Открытая система водоразбора",$aOpenSys];
    $VidblagList[]=["Закрытая система водоразбора",$aCloseSys];
    echoGroupList("liVidblag","Благоустройство:","vidblag",$VidblagList,$this->Vidblag); 
    // Определяем этажность дома
    echo "<li class=\"liEtd\">";
    echo "<label for=\"etd\">Этажность дома: </label>";
    echo "<input id=\"etd\" type=\"number\" name=\"etd\" value=".$this->EtDom." ".
         "step=\"1\" min=\"1\" max=\"35\"".">"; 
    echo "</li>";
    // Определяем год постройки
    echo "<li class=\"liGst\">";
    echo "<label for=\"gst\">Год постройки: </label>";
    echo "<input id=\"gst\" type=\"number\" name=\"gst\" value=".$this->GodStr." ".
         "step=\"1\" min=\"1917\" max=\"2058\"".">"; 
    echo "</li>";
    // Определяем категорию дома
    global $aKatdom;
    $KatDomList[]=["Категория дома",$aKatdom];
    echoGroupList("liKtd","Категория дома:","ktd",$KatDomList,$this->KatDom); 
    // Определяем отопительный период
    global $aOtoper;    
    $PerOtoList[]=["Отопительный период",$aOtoper];
    echoGroupList("liOtp","Отопительный период:","otp",$PerOtoList,$this->PerOto); 
    
    echo "</ul>";
    echo "</fieldset>";
    echo "</div>";
    
    // Управляем вводом
    echo '<div id="LineCommon">';
    echo '<button id="btnDomKvar" class="buttons" type="submit">Рассчитать льготы</button>';
    IniPlusMinus(Zhkvar,false);
    echo "</div>";
    
    // Обрабатываем данные по квартире
    echo "<div id=\"Kvartira\"".">";
    echo "<fieldset>";
    echo "<legend class=\"legDomKvar\">Проживающие, количества членов семей для льготы</legend>";
    echo "<table class=\"tblProzh\">";
    
    // Выводим таблицу проживающих
    foreach($this->aZhFio as $i => $value) 
	{
        $oddi=$i%2;    
        if ($oddi==0) $cl=" class=\"inpOdd\" ";
        else $cl=" class=\"inpEven\" ";
        
        echo "<tr>";
        
        // Выводим чекбоксы при запросе на удаление
        if (IsSet($_GET['Com'])) 
        { 
            if ($_GET['Com']=="delZhKvar")
            {
                echo "<td class=\"notific\" data-title=\"Удалить\">";
                echo "<input type=\"checkbox\" name=\"dr".$i."\">";
                echo "</td>";
            } 
        }
        
        echo "<td class=\"notific\" data-title=\"Не более 17 символов\">";
        echo "<input".$cl.
            " pattern=\"^[А-Яа-яЁё\s\.-]{1,17}\"".
            " type=\"text\" name=\"zhFio".$i."\"".
            " value=\"".$this->aZhFio[$i]."\"/>"; 
        echo "</td>";
        
        echo "<td class=\"tdLgokat\">";
        echo "<select".$cl." name=\"zhLgokat".$i."\">".
            "<optgroup label=\"Льготная категория граждан\">";
        echo PickLgoKat($this->aZhLgokat[$i]);
        echo "</optgroup></select>";    
        echo "</td>";
        
        echo "<td class=\"tdSovpr\">";
        echo "<input".$cl."type=\"number\" name=\"zhSovpr".$i."\" ".
            "value=\"".\prown\NoZero($this->aZhSovpr[$i])."\" ".
            "step=\"1\" min=\"0\" max=\"14\"".">"; 
        echo "</td>";
        echo "</tr>"; 
    }
    
    echo "<tr>";
    // Выводим заголовок чекбоксов при запросе на удаление
    if (IsSet($_GET['Com'])) 
    { 
        if ($_GET['Com']=="delZhKvar")
        {
            echo "<th> </th>";
        }
    }
    echo "<th>Фамилия И.О.</th>";
    echo "<th>Категория</th>";
    echo "<th>Количество</th>";
    echo "</tr>";

    
    echo "</table>";
    echo "</fieldset>";
    echo "</div>";
    echo "</form>"; 
    }
}
//echo "<br>".'out.DomikvaClass'."<br>";
// ******************************************************* DomikvaClass.php ***
