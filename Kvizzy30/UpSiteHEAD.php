<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                        *** UpSiteHEAD.php ***

// ****************************************************************************
// * KwinFlat                     Указать индивидуальные данные страниц сайта *
// *            для поисковых систем и пользователей, подключить персональные *
// *                    стили для настольных и мобильных версий страниц сайта *
// ****************************************************************************

// v2.0.1, 19.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 08.10.2024

// ---------------------------------------------------------- HEAD and LAST ---
// Выводим данные о favicon
echo '
<link rel="manifest" href="manifest.json">
<link rel="apple-touch-icon" sizes="180x180" href="/favicon260x260/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon260x260/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon260x260/favicon-16x16.png">
<link rel="mask-icon" href="/favicon260x260/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="/favicon260x260/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="/favicon260x260/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
';
// Подключаем jQuery
echo '<script src="/jQuery/jquery-1.11.1.min.js"></script>';
echo '
    <link rel="stylesheet" type="text/css" href="/jQuery/jquery-ui.min.css">
    <script src="/jQuery/jquery-ui.min.js"></script>
';
// Подключаем переменные и константы JavaScript, соответствующие определениям в PHP
DefineJS($SiteHost,$urlHome);
// Подключаем js и CSS
echo '<script src="CommonTools.js"></script>';
echo '<script src="/Update/Update.js"></script>';
// echo '<script src="socket.js"></script>';
echo '<script src="/Rusakov/RusakovJs.js"></script>';
echo '<script src="/Controller/Controller.js"></script>';
echo '<link href="/Styles/Home.css" rel="stylesheet">';
echo '<link href="/Styles/Update.css" rel="stylesheet">';
// Обобщаем мобильную версию сайта
if ($SiteDevice==Mobile)
{
   echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
}

// end ------------------------------------------------------ HEAD and LAST ---

// <!-- --> ************************************************ UpSiteHEAD.php ***
