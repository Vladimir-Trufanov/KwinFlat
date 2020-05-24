<?php                                           
// PHP7/HTML5, EDGE/CHROME                               *** ShowCommon.php ***

// ****************************************************************************
// * KwinFlat.ru                              Обеспечить вывод в общей секции *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.11.2017
// Copyright © 2017 TVE                              Посл.изменение: 01.04.2018

function ShowCommon($Comm,$Domik,$Ref,$Law,$Norm,$db,$Nch)
{
    $Result=0;
    //$w2e = new Exceptionizer(E_ALL);
    // Отрабатываем основной код
    //try 
    //{
        // Трассируем параметры
        // prown\ViewArray($_GET,'$_GET');
        // echo '$Comm='.$Comm; 

        // Трассируем варианты ошибок
        // fopen("spoon","r");
        // trigger_error("Сгенерирована ошибка!", E_USER_ERROR);
        
        echo "<section id=\"mright\">";
        if ($Comm=='About')
        {
            if ((IsSet($_GET['Com']))&&(IsSet($_GET['mess'])))
            {
                echo "<div id=\"error\">"; 
                //echo $_GET["mess"];
                require_once $_SERVER['DOCUMENT_ROOT']."/About.php";
            }
            else
            {
                echo "<div id=\"comm\">";            
                $Domik->show($_REQUEST);
            }
        }
        elseif ($Comm=='Common')            
        {
            echo "<div id=\"comm\">";            
            $Domik->show($_REQUEST);
        }
        elseif ($Comm=='addZhKvar')            
        {
            echo "<div id=\"comm\">";            
            require_once $_SERVER['DOCUMENT_ROOT'].'/Entrys/AddZhkvar.php';
          
        }
        elseif ($Comm=='addUsl')            
        {
            echo "<div id=\"comm\">";            
            require_once $_SERVER['DOCUMENT_ROOT'].'/Entrys/AddUsl.php';
          
        }
        elseif  ($Ref->isReffs($Comm))       
        {
           echo "<div id=\"reff\">";
           $Ref->show($_GET,$db,$Comm);
        }
        elseif ($Law->isLaws($Comm))    
        {
            echo "<div id=\"laws\">";        
            $Law->show($_GET);
        }
        elseif ($Norm->isNorms($Comm))    
        {
            echo "<div id=\"laws\">";        
            //prown\ViewArray($_GET,'$_GET');
            $Norm->show($_GET);
        }
        else 
        {
            echo "<div id=\"comm\">";            
            /*prown\ViewArray($_GET);*/ 
            echo "<pre><b>Неопознанное заполнение COMMON! ".'$Comm='.$Comm."</b>\n"."</pre>";
            $Domik->show($_REQUEST);
        }
        echo "</div>";
        echo "</section>";
    //} 
    // Перехватываем пользовательскую ошибку/сообщение
    //catch (E_USER_ERROR $e) 
    //{
    //    echo "<pre><b>E_USER_ERROR!</b>\n",$e,"</pre>";
    //}
    // Перехватываем ошибку сайта
    //catch (E_EXCEPTION $e) 
    //{
     //   echo "<pre><b>COMMON!</b>\n",$e,"</pre>";
    //}
    return $Result;
}
//echo "<br>".'out_ShowCommon';
//
// ********************************************************* ShowCommon.php *** 

