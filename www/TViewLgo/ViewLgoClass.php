<?php namespace vlgo;

// PHP7/HTML5, EDGE/CHROME                             *** ViewLgoClass.php ***

// ****************************************************************************
// * KwinFlat.ru                  Обеспечить расчет льгот по услугам на сайте *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  05.02.2018
// Copyright © 2018 TVE                              Посл.изменение: 30.05.2018

require_once $SiteRoot."/TViewLgo/ParamNachLgo.php";
require_once $SiteRoot."/TViewLgo/SxelXX.php";

class ViewLgo
{
    public  $UslCount;            // Количество услуг по л.счету
    public  $LgoCount;            // Количество льготников по л.счету
    private $VsegoLgo;            // Итоговая сумма льгот по всем льготникам
    private $ItSumLgo = array();  // Общие суммы льгот по льготникам
  
    // Массив начислений льгот
    public $aNachLgo = array(); 
    private $aZhiv = array();     // Предварительный массив льготников

    // ****************************************************************************
    // *  Проинициализировать переменные изображения для расчета льгот по услугам *
    // ****************************************************************************
    function init($Domik,$Nch,$db)
    {
        $this->UslCount=$Nch->UslCount;  // Количество услуг
        $this->LgoCount=0;               // Количество льготников по л.счету
        
        // Формируем предварительный массив льготников 
        // по списку проживающих со льготными категориями
        $j=0;
        foreach($Domik->aZhFio as $i => $value) 
        {
            if ($Domik->aZhLgokat[$i]>1) 
            {
                $this->LgoCount++;               
                $this->aZhiv[$j]['ZhFio']=$Domik->aZhFio[$i]; 
                $this->aZhiv[$j]['ZhLgokat']=$Domik->aZhLgokat[$i]; 
                $this->aZhiv[$j]['ZhSovpr']=$Domik->aZhSovpr[$i]; 
                $j++;
                
                // Трассируем предварительный массив
                //echo "<br>".$this->aZhiv[$i]['ZhFio'].
                //'-'.$this->aZhiv[$i]['ZhLgokat'].
                //'-'.$this->aZhiv[$i]['ZhSovpr'];
            }
        }
        // Инициируем общие суммы по льготникам
        for ($j=0; $j<$this->LgoCount; $j++)
        {
            $this->ItSumLgo[$j]=0;
        }
        $this->VsegoLgo=0;
  
        // Инициируем по услугам, а внутри по льготникам
        for ($i=0;$i<$this->UslCount;$i++){
        for ($j=0;$j<$this->LgoCount;$j++)
        {
            // Определяем категорию льготы
            $this->aNachLgo[$j][$i]["Katlgo"]=$this->aZhiv[$j]['ZhLgokat'];
            // Определяем группу услуги
            $Kind=$Nch->aKind[$i];
            // Определяем правило расчета льготы
            $Sxel=\common\getSxel($this->aNachLgo[$j][$i]["Katlgo"],$Kind,$IsSemja);
            $this->aNachLgo[$j][$i]["Sxel"]=$Sxel;

            // Заполняем другие элементы вывода в диве льгот
            $this->aNachLgo[$j][$i]["NameUsl"]=$Nch->aNameUsl[$i];
            $this->aNachLgo[$j][$i]["Famio"]=$this->aZhiv[$j]['ZhFio'];
            $this->aNachLgo[$j][$i]["EdIzm"]=$Nch->aEdIzm[$i];
            // Регулируем норму по чернобыльцам
            if (($this->aNachLgo[$j][$i]["Katlgo"]>=401)&&
                ($this->aNachLgo[$j][$i]["Katlgo"]<=402)&&
                (($Kind==1)||($Kind==4)))
                $this->aNachLgo[$j][$i]["Norma"]=18;
            // Для остальных случаев по справочникам, как в начислениях
            else $this->aNachLgo[$j][$i]["Norma"]=$Nch->aNorma[$i];
            // Для отопления пересчитываем норму через долю площади
            if ($Nch->aInusl[$i]==OTOPL) 
            {
                $this->aNachLgo[$j][$i]["Norma"]=
                round($this->aNachLgo[$j][$i]["Norma"]*$Domik->PlKvar/$Domik->zhCount,3);
            }
            // Определяем итоговое начисление, объем и тариф для льготы            
            ParamNachLgo($Nch->aTarif[$i],$Nch->aNach[$i],$Nch->aKorr[$i],
                $Domik->PlKvar,$Kind,$ItNach,$Vu,$Tlg,$Nch->aInusl[$i]);
            // Расчитываем долю
            if (abs($Domik->zhCount)<1) 
            {
                $this->aNachLgo[$j][$i]["Dolya"]=0;
            }
            else
            {
                $this->aNachLgo[$j][$i]["Dolya"]=round($Vu/$Domik->zhCount,3);
            } 
            
            // Расчитываем льготу 
            $this->aNachLgo[$j][$i]["Lgota"]=
                SxelXX($Sxel,$ItNach,$Vu,$Tlg,$this->aNachLgo[$j][$i]["Norma"], 
                $this->aNachLgo[$j][$i]["Dolya"],$Domik->zhCount,
                $this->aZhiv[$j]['ZhSovpr']);
        }}

        //
        for ($i=0; $i<$this->UslCount; $i++)
        for ($j=0; $j<$this->LgoCount; $j++)
        {
            $this->ItSumLgo[$j]=$this->ItSumLgo[$j]+$this->aNachLgo[$j][$i]["Lgota"];
            $this->VsegoLgo=$this->VsegoLgo+$this->aNachLgo[$j][$i]["Lgota"];
        }
    }
    
    // $NumUsl - номер услуги; $LgoCount - количество льготников; $Lgota - начисленная льгота
    function EchoRating($NumUsl,$LgoCount,$Lgota)
    {
        // Изначально назначаем максимальный рейтинг = 3
        $Count=3;
        // Перебираем начисления по льготникам и, если есть большая льгота, то снижаем рейтинг,
        // но не меньше 1 звездочки
        for ($i=0;$i<$LgoCount;$i++)
        {
            //if ($this->aRating[$i][$NumUsl]["Lgota"]>$Lgota){
            if (abs($this->aNachLgo[$i][$NumUsl]["Lgota"])>abs($Lgota))
            {
                $Count--;
                if ($Count<1) $Count=1;
            }	  
        };
        // Если начисление нулевое, то 1 "звездочка"
        if (abs($Lgota)<10.01) $Count=1;

        //	Выводим рейтинг 
        echo "<td>";
        for ($i=0;$i<$Count;$i++)
        {
            echo "<span class=\"rating\"><img src=\"Images/star.png\" width=\"16\" height=\"16\" alt=\"звезда\"></span>";
        };
        echo "</td>";
    }

    // ************************************************************************
    // *       Вывести изображение таблицы начисленных льгот по услугам       *
    // ************************************************************************
    function show($Domik)
    { 
        // Выводим во 2 варианте: по услугам, а внутри по льготникам
        for ($i=0;$i<$this->UslCount;$i++){
        for ($j=0;$j<$this->LgoCount;$j++)
        {
            // Выводим только ненулевые льготы (без 1 категории)
            if (abs($this->aNachLgo[$j][$i]["Sxel"])>1)
            {
                // Определяем постфикс категории
                if ($this->aZhiv[$j]['ZhSovpr']<=1) $postfix=" "; 
                else $postfix="*".$this->aZhiv[$j]['ZhSovpr'];
                // Выводим строку
                echo "<tr class=\"TblLgo\">";
                echo 
                "<td class=\"NameUsl\">".$this->aNachLgo[$j][$i]["NameUsl"]."</td>
                <td class=\"Katlgo\">"  .$this->aNachLgo[$j][$i]["Katlgo"].
                    "-".$this->aNachLgo[$j][$i]["Sxel"].$postfix."</td>
                <td class=\"Famio\">"   .$this->aNachLgo[$j][$i]["Famio"]."</td>
                <td class=\"Norma\">".\prown\NoZero($this->aNachLgo[$j][$i]["Norma"])."</td>
                <td class=\"Dolya\">".\prown\NoSpace($this->aNachLgo[$j][$i]["Dolya"],
                    $this->aNachLgo[$j][$i]["EdIzm"])."</td>
                <td class=\"Nach\">"    .number_format($this->aNachLgo[$j][$i]["Lgota"],2,'.','')."₽</td>";
                $this->EchoRating($i,$this->LgoCount,$this->aNachLgo[$j][$i]["Lgota"]); 
                echo "</tr>";
                //number_format($this->aNach[$i],2,'.','')
                //<td class=\"Nach\">"    .$this->aNachLgo[$j][$i]["Lgota"]."₽</td>";

            }
        }}
     
        // Выводим итоговые строчки
        for ($j=0; $j<$this->LgoCount; $j++)
        {
    	echo "
        <tr>
            <th scope=\"col\"> </th>
            <th scope=\"col\">".$this->aZhiv[$j]['ZhLgokat']."</th>
            <th scope=\"col\"> </th>
            <th scope=\"col\"> </th>
            <th scope=\"col\"> </th>
            <th scope=\"col\">".$this->ItSumLgo[$j]."₽</th>
            <th scope=\"col\"> </th>
        </tr>";
        }
    	echo "
        <tr>
            <th scope=\"col\">Всего</th>
            <th scope=\"col\"> </th>
            <th scope=\"col\"> </th>
            <th scope=\"col\"> </th>
            <th scope=\"col\"> </th>
            <th scope=\"col\">".$this->VsegoLgo."₽</th>
            <th scope=\"col\"> </th>
        </tr>";
    }
    
}

// ******************************************************* ViewLgoClass.php ***


