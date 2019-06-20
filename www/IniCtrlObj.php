<?php                                           
// PHP7/HTML5, EDGE/CHROME                               *** IniCtrlObj.php ***

// ****************************************************************************
// * KwinFlat.ru    Проконтроллировать кукисы, инициализировать объекты сайта *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.11.2017
// Copyright © 2017 TVE                              Посл.изменение: 05.03.2018

function IniCtrlObj($db,&$Domik,&$Nch,&$Lgo,&$Ref,&$Law,&$Norm,$Comm,$Atfirst)
{
    global $PersName;    // Логин посетителя
    global $PersEntry;   // Число входов посетителя на сайт 

    $Result=0;
    $w2e = new Exceptionizer(E_ALL);
    // Отрабатываем основной код
    try 
    {
    
        /* Проба по счетчику
        //session_save_path('philipp');
        //session_name('tili');
        //session_start();
        // Если на сайт только-только зашли, обнуляем счетчик.
        if (!isset($_SESSION['count']))
        {
            $_SESSION['count'] = 0;
            // Увеличиваем счетчик в сессии.
            $_SESSION['count'] = $_SESSION['count'] + 1;
        }
        */

        // Трассируем варианты ошибок
        // fopen("spoon","r");
        // trigger_error("Сгенерирована ошибка!",E_USER_ERROR);

        // Переопределяем посещения пользователя
        if (IsSet($_GET['Login'])) 
        {
            //echo 'Login='.$_GET['Login'];
            $PersName = $_COOKIE['PersName'] ?? $PersName; 
            if (!($_GET['Login']==$PersName))
            {
                $PersName=$_GET['Login'];
                \prown\MakeCookie('PersName',$PersName); 
                $PersEntry=0;
            }
        } 
        $PersEntry = $PersEntry+1;
        \prown\MakeCookie('PersEntry',$PersEntry); 
        //\prown\ViewArray($_COOKIE,'1 $_COOKIE');

        // Инициализируем вывод дома,квартиры и проживающих
        $Domik=new domik\Domikva;
        $Domik->init($db,$Atfirst);

        //echo \prown\number2string(123456789,false);
        //echo \prown\number2string(23);
         
        // Инициализируем начисления по услугам
        $Nch=new vnch\ViewNach;
        $Nch->init($_REQUEST,$db,$Domik,$Atfirst);
        //\prown\ViewArray($_COOKIE,'2 $_COOKIE');
        // Инициализируем льготы по услугам/категориям
        $Lgo=new vlgo\ViewLgo;
        $Lgo->init($Domik,$Nch,$db);
        // Инициализируем ведение справочников
        $Ref=new reff\Refbooks;
        $Ref->init($_REQUEST);
        // Инициализируем представление законов
        // Здесь передаем массив $_GET, чтобы идентифицировать ситуацию, когда явно
        // вызывается по кнопке конкретный документ;
        // А передача $Comm указывает (через кукис) каким документом была заполнена
        // область комментариев
        $Law=new laws\ViewLaws;
        $Law->init($_GET,$Comm);
        $Norm=new norms\ViewNorms;
        $Norm->init($_GET,$Comm);
    } 
    // Перехватываем пользовательскую ошибку/сообщение
    catch (E_USER_ERROR $e) {MakeUserMessage($e);}
    // Перехватываем ошибку сайта
    catch (E_EXCEPTION $e) 
    {
        //Трассируем все заголовки
        //$headers = getallheaders();
        //Header("Content-type: text/plain");
        //print_r($headers);
        //print_r($_SERVER);
        echo "<pre><b>INI!</b>\n",$e,"</pre>";
    }
    return $Result;
}
//echo "<br>".'out_IniCtrlObj';
//
// ********************************************************* IniCtrlObj.php *** 

