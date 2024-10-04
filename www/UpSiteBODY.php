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


echo '</div>';

echo '<div id="Footer">';
//echo '<pre>';
echo '$UserAgent='.$UserAgent.'<BR>';
?>
<div id="footer-img">
<img src="../Images/Kwinflat.jpg" alt="Kwinflat-близкий всем!" />
</div>
<?php
echo '$platform='.$platform.'<BR>';
echo '$browser='.$browser.'<BR>';
echo '$version='.$version.'<BR>';
echo '$device_type='.$device_type.'<BR>';
//echo '</pre>';
echo '</div>';


// <!-- --> ************************************************ UpSiteBODY.php ***
