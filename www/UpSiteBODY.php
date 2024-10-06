<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                        *** UpSiteBODY.php ***

// ****************************************************************************
// * KwinFlat                                    Разобрать параметры запроса, *
// *                                         запустить оболочки страниц сайта *
// ****************************************************************************

// v2.0, 05.10.2024                                   Автор:      Труфанов В.Е.
// Copyright © 2023 tve                               Дата создания: 08.10.2023

// ------------------------------------------------------------------- BODY ---

echo '<div id="Header">';
echo 'id="Header"'; 
echo '</div>';

echo '<div id="Article">';
echo 'id="Article"'; 
// Подгружаем обновление значений датчиков, состояний устройств и контроллеров
require_once("Update/Update.php"); 
echo '</div>';

echo '<div id="Footer">';
?>
<div id="footer-img">
<img src="../Images/Kwinflat.jpg" alt="Kwinflat-близкий всем!" />
</div>
<?php
echo '<pre>';
echo '$UserAgent='.$UserAgent.'<br>';
echo '$platform='.$platform.'<BR>';
echo '$browser='.$browser.'<BR>';
echo '$version='.$version.'<BR>';
echo '$device_type='.$device_type.'<BR>';
echo '</pre>';
echo '</div>';

// <!-- --> ************************************************ UpSiteBODY.php ***
