<?php                                           
// PHP7/HTML5, EDGE/CHROME                               *** IniSeoTags.php ***

// ****************************************************************************
// * KwinFlat.ru        Проинициализировать SEO-теги соответствующей страницы *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  05.03.2018
// Copyright © 2018 tve                              Посл.изменение: 16.04.2018

function isComRequest($subs)
{
    $Result=false;
    if (IsSet($_REQUEST['Com'])) 
    { 
        if ($_REQUEST['Com']==$subs) $Result=true;
    }
    return $Result;
}

function IniSeoTags()
{
    $Result=true;

    echo "<!DOCTYPE html>";
    echo "<html lang=\"ru\">";
    echo "<head>";
    // Добавляем SEO-привязки для Google и Yandex
    if ($_SERVER['HTTP_HOST']=='kwinflat.ru')
    {
        // Добавляем права доступа к сайту kwinflat.ru в Яндекс.Вебмастере 
        echo "<meta name=\"yandex-verification\" content=\"6c84a6d35d387988\" />";
        // Добавляем идентификатор отслеживания в Google для https://kwinflat.ru
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-36748654-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-36748654-1');
        </script>
        <?php  
    }                                         

    echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\"/>";

    seot();

    echo "<link href='https://fonts.googleapis.com/css?family=Kurale' rel='stylesheet'>";
    echo "<link href=\"https://fonts.googleapis.com/css?family=Pattaya&subset=cyrillic\" rel=\"stylesheet\">";        
    echo "<link href=\"https://fonts.googleapis.com/css?family=Podkova&subset=cyrillic\" rel=\"stylesheet\">";  
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"Allcss/Main.css\"/>";
    echo "</head>";
    echo "<body>";
    return $Result;
}


function IniEndHtml()
{
    echo "</body>";
    echo "</html>";
}

// ********************************************************* IniSeoTags.php *** 
