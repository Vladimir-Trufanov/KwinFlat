<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                        *** UpSiteBODY.php ***

// ****************************************************************************
// * SimaMark                                    Разбираем параметры запроса, *
// *                                запускаем общую оболочку и страницы сайта *
// ****************************************************************************

// v1.0, 08.10.2023                                   Автор:      Труфанов В.Е.
// Copyright © 2023 tve                               Дата создания: 08.10.2023

// ------------------------------------------------------------------- BODY ---

echo '<div id="Header">';
echo 'id="Header"'; 
echo '</div>';

echo '<div id="Article">';
echo 'id="Article"'; 


echo '<BR>'; 
echo '$RemoteAddr'.'<BR>'; 
echo $RemoteAddr.'<BR>'; 
echo '$UserAgent'.'<BR>'; 
echo $UserAgent.'<BR>'; 
$browser = get_browser(null, true);
echo '<pre>';
print_r($browser);
echo '</pre>';



echo '</div>';

echo '<div id="Footer">';
echo 'id="Footer"'; 
echo '</div>';


// <!-- --> ************************************************ UpSiteBODY.php ***
