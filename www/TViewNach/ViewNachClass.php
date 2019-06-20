<?php namespace vnch;
                                          
// PHP7/HTML5, EDGE/CHROME                            *** ViewNachClass.php ***

// ****************************************************************************
// * KwinFlat.ru         Обеспечить выполнение начислений по услугам на сайте *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.11.2016
// Copyright © 2016 TVE                              Посл.изменение: 03.02.2018

require_once $SiteRoot."/TViewNach/RecalcNach.php";
require_once $SiteRoot."/TViewNach/DelUslugu.php";
require_once $SiteRoot."/TViewNach/ControlArray.php";
require_once $SiteRoot."/TViewNach/DefoNach.php";
require_once $SiteRoot."/TViewNach/InitNach.php";
require_once $SiteRoot."/TViewNach/UpdateArray.php";

class ViewNach
{
    // Трассировочная строка
    // <a href="/Info/Trass.php?cTrass=x" target="_blank">Трася!</a> - трассировочная ссылка

    public $UslCount;              // Количество услуг по л.счету
    
    public $aInusl     = array();  // ИН услуг
    public $aTarif     = array();  // Тарифы
    public $aKolich    = array();  // Объемы услуг/количества
    public $aKorr      = array();  // Корректировки
    public $aNameUsl   = array();  // Наименования услуг
    public $aEdIzm     = array();  // Единицы измерения
    public $aNorma     = array();  // Нормативы
    public $aKind      = array();  // Группы услуг
    public $aNach      = array();  // Начисление по услуге
    
    private $ItSumUsl;             // Сумма итоговых начислений по услугам
    // Массивы и переменные класса
    private $aSumUsl   = array();  // Итоговая сумма по услуге
    
    // *************************************************************************
    // *    Проинициализировать переменные изображения начислений по услугам   *
    // *************************************************************************
    function init($fill,$db,$Domik,$Atfirst)
	{
        InitNach(
            $this->UslCount,$this->aInusl,$this->aNameUsl,$this->aEdIzm,
            $this->aNorma,$this->aKind,$this->aTarif,$this->aKolich,
            $this->aKorr,$this->aNach,$this->aSumUsl,$this->ItSumUsl,
            $db,$Domik,$Atfirst
        );
        
        ////// может в initnach
        
        // Обновляем массивы, если есть по ним кукисы
        UpdateArray($this->UslCount,$fill,$this->aTarif,"aTarif");
        UpdateArray($this->UslCount,$fill,$this->aKolich,"aKolich");
        UpdateArray($this->UslCount,$fill,$this->aKorr,"aKorr");
        // Пересчитываем итоги
        RecalcNach($this->UslCount,$this->aTarif,$this->aKolich,
            $this->aKorr,$this->aNach,$this->aSumUsl,$this->ItSumUsl);

    }

    // ************************************************************************
    // *            Вывести изображение таблицы начислений по услугам         *
    // ************************************************************************
    function show($fill,$db,$Domik)
	{
 
        // Пользователь может редактировать на экране поля тарифов, количеств
        // и корректировок для пересчета начислений и льгот. Сайт отлавливает 
        // позиции в полях редактирования и передает их через параметры в
        // в сценарий Main и далее ViewNach->show

        // Поcле редактирования поля сайт перезагружает сценарий Main
        // и, конечно, ViewNach->show, а через один из параметров (ata*,ako*,akr*)
        // передается новое значение элемента массива. Сценарий обновляет
        // соответствующий элемент массива и весь массив отправляет в кукисы браузера
  
        // -------------------------------------------------   
		// Здесь будем проверять:
		// а) допустимые значения передаваемых параметров;
		//
        // б) соответствие размерностей массивов,
        // используемых для построения таблицы.
		//
        // Проверка необходима, так как параметры могут прийти
        // с испорченных кукисов или злонамеренно
        // -------------------------------------------------
	
        // Готовим обработку возможного запроса по редактированию поля,
        // определяем позицию редактируемого поля  
        $ta=-1;      // Позиция в полях ввода тарифов
        if (IsSet($fill['ta'])) $ta=$fill['ta'];
        $ko=-1;      // Позиция в полях ввода количеств
        if (IsSet($fill['ko'])) $ko=$fill['ko'];
        $kr=-1;      // Позиция в полях ввода корректировок
        if (IsSet($fill['kr'])) $kr=$fill['kr'];
            
        // Создаем форму для удаления услуг через чекбокс
        if (IsSet($_GET['Com'])) 
        { 
            if ($_GET['Com']=="delUsl")
            {
                echo "<form id=\"idDelusl\" action=\"\" method=\"get\" name=\"nmDelUsl\">";
            } 
        }
        
        // Построчно выводим элементы таблицы
        for ($i=0;$i<count($this->aTarif);$i++)
		{
	        // Начинаем таблицу
            echo"<tr class=\"TblNach\">";
            
            // Выводим чекбоксы при запросе на удаление
            if (IsSet($_GET['Com'])) 
            { 
                if ($_GET['Com']=="delUsl")
                {
                    echo "<td class=\"notific\" data-title=\"Удалить\">";
                    //echo "<input type=\"checkbox\" form=\"idDelusl\" name=\"du".$i."\">";
                    echo "<input type=\"image\" form=\"idDelusl\" src=\"Images/delusl.png\" name=\"du".$i."\">";
                    echo "</td>";
                } 
            }
            
            // Выводим наименования услуг и нормы
            echo"
	        <td class=\"NameUsl\">".$this->aNameUsl[$i]."</td>
	        <td class=\"Norma\">".\prown\NoZero($this->aNorma[$i])."</td>";
			// Выводим тарифы
		    if ($ta!=$i) 
			{
		    	// Если текущее поле тарифов не указано для редактирования, 
			    // то выводим его, как ссылку
	            echo"
                <td class=\"Tarif\"><a href=\"../Main.php?ta=".$i."\"".
                " rel=\"nofollow\">".$this->aTarif[$i]."₽</a></td>";
			}
	        else 
			{
				// Поле отмечено для редактирования поэтому запускаем форму
	            echo"
		        <td>
	                <form class=\"Frm\"  action=\"Main.php\" method=\"get\" id=\"frmNch\">
	 	            <input class=\"Inp\" type=\"number\" name=\"aTarif".$i."\" ". 
                        "step=\"0.01\" min=\"0.00\" max=\"9999.99\" ".
                        "form=\"frmNch\" value=\"".$this->aTarif[$i]."\"> 
	                <button class=\"Btn\" type=\"submit\">Ok</button>
	                </form>
	            </td>";
			}
	        // Выводим количества
            if ($ko!=$i) 
			{
                // Определяем группу услуги
                $Kind=\common\getKind($this->aInusl[$i],$db);
                // Если группы услуг 1 и 4, то количество=общей площади квартиры
                // и поля не подлежат редактированию (просто выводим площадь)
                if (($Kind==1)||($Kind==4))
                {
	               echo"<td>".$this->aKolich[$i]."".$this->aEdIzm[$i]."</td>";
                }
	            else echo"
				    <td class=\"Kolich\"><a href=\"../Main.php?ko=".$i."\"".
                    " rel=\"nofollow\">".
                    $this->aKolich[$i]."".$this->aEdIzm[$i]."</a></td>";
			}
			else 
			{
	            echo"
		        <td>
                    <form class=\"Frm\"  action=\"Main.php\" method=\"get\" id=\"frmNch\">
	 	            <input class=\"Inp\" type=\"number\" name=\"aKolich".$i."\" ".
                        "step=\"0.0001\" min=\"-999.9999\" max=\"999.9999\" ".
                        "form=\"frmNch\" value=\"".$this->aKolich[$i]."\"> 
	                <button class=\"Btn\" type=\"submit\">Ok</button>
	                </form>
	            </td>";
			}
            // Выводим начисления
	        echo"<td class=\"Nach\">".number_format($this->aNach[$i],2,'.','')."</td>";
	        // Выводим корректировки
	        if ($kr!=$i) 
			{
                echo"
                <td class=\"Korr\"><a href=\"../Main.php?kr=".$i."\"".
                " rel=\"nofollow\">".$this->aKorr[$i]."</a></td>";
            }
            else 
            {
                echo"
                <td >
                <form class=\"Frm\"  action=\"Main.php\" method=\"get\" id=\"frmNch\">
                <input class=\"Inp\" type=\"number\" step=\"0.01\" ".
                    "min=\"-999999.99\" max=\"999999.99\" name=\"aKorr".$i.
                    "\" form=\"frmNch\" value=\"".$this->aKorr[$i]."\"> 
                <button class=\"Btn\" type=\"submit\">Ok</button>
                </form>
                </td>";
            }
			// Выводим итоговые суммы
		    echo"<td class=\"Nach\">".number_format($this->aSumUsl[$i],2,'.','')."₽</td>";
            // Завершаем таблицу
            echo"</tr>";
        }
        
        // Закрываем форму
        if (IsSet($_GET['Com'])) 
        { 
            if ($_GET['Com']=="delUsl")
            {
                echo "</form>";
            } 
        }
        
        // echo "<br>".'ViewNachClass.show'."<br
        
        // Трассируем приходящие параметры по полям редактирования
        /*echo "
        <tr align=\"center\">
        <td>Трассировка параметров</td>
        <td>".'$ta='.$ta."</td>
        <td>".'$ko='.$ko."</td>
        <td>".'$kr='.$kr."</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        </tr>";*/
        
        // Трассируем корректировку данного
        /*echo "
        <tr align=\"center\">
        <td>Трассировка ввода</td>
        <td>1</td>
        <td>
        <form class=\"Frm\"  action=\"Main.php\" method=\"get\" id=\"myform\">
            <input class=\"Inp\" type=\"text\" name=\"kk\" form=\"myform\" placeholder=\"17.14\"> 
            <button class=\"Btn\" type=\"submit\">Ok</button>
        </form>
        </td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        </tr>";*/
        
        // Трассируем JSON
        /*$Str="Привет!";
        $cTrass='f75';
        
        //$Str = json_encode($this->aTarif);
	    //$this->akTarif = json_decode($Str,true);
        //$Str = serialize($this->aTarif);
	    //$this->akTarif = unserialize($Str);
        $Str = serialize($this->aNameUsl);
	    $this->akTarif = unserialize($Str);


        for ($i=0;$i<count($this->aTarif);$i++)
        {
            echo 
            "<tr align=\"center\">
            <td class=\"NameUsl\">".$this->aNameUsl[$i]."</td>
            <td>".$Str." </td>
            <td>".$this->aTarif[$i]."</td>
            <td>".$this->akTarif[$i]."*"."</td> 
            <td>".$SiteRoot."</td>
            <td> <a href=\"/Info/Trass.php\?cTrass=".$cTrass."\" target=\"_blank\">Трася!</a></td>
            </tr>";
        }*/

        // Выводим итоговую сумму
        echo"<tr>";
        // Выводим заголовок чекбоксов при запросе на удаление
        if (IsSet($_GET['Com'])) 
        { 
            if ($_GET['Com']=="delUsl")
            {
                echo "<th> </th>";
            }
        }
        echo"
		<th scope=\"col\">Итого</th>
		<th scope=\"col\"> </th>
		<th scope=\"col\"> </th>
		<th scope=\"col\"> </th>
		<th scope=\"col\"> </th>
		<th scope=\"col\"> </th>
		<th scope=\"col\">".$this->ItSumUsl."₽</th>
        </tr>";
	

    }	
}
//echo "<br>".'out.ViewNachClass'."<br>";

// ****************************************************** ViewNachClass.php ***

