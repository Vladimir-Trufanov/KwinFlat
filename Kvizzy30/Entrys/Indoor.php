<?php

// PHP7/HTML5, EDGE/CHROME                                   *** Indoor.php ***

// ****************************************************************************
// * KwinFlat.ru             Обеспечить вход зарегистрированного пользователя *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.02.2018
// Copyright © 2018 tve                              Посл.изменение: 20.03.2018

// Определяем начальное сообщение об ошибке
define ("Inerr","Вход не выполнен!");   

require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/GetAbove.php";
$SiteRoot = $_SERVER['DOCUMENT_ROOT'];      // Корневой каталог сайта
$SiteAbove = \prown\GetAbove($SiteRoot);    // Надсайтовый каталог

require_once $SiteRoot."/TPHPPROWN/ViewArray.php";
require_once $SiteRoot."/Common.php";
require_once $SiteRoot.'/Entrys/Authentich.php';

$error = Inerr;
//\prown\ViewArray($_POST,'$_POST');
if (isset($_POST['login'])) 
{
    //echo 'username='.$_POST['username'];
    $username = trim($_POST['username']);
    $password = sha1($username.$_POST['pwd']);
    // Выбираем список пользователей и пароли
    $userlist = $SiteAbove.'/Private/Еncrypted.fil';
    // Проверяем имя пользователя и пароль
    Authentical($error,$userlist,$username,$password);
    // Если все в порядке, перезагружаем страницу с логином
    if ($error==Inerr)
    {
        \common\Headeri("/Main.php?Login=".$username);
    }
}

?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex"/>
    <title>Вход</title>
	<link rel="stylesheet" media="screen" href="/Allcss/ContactUs.css">
</head>

<body>
    <div id="Ers">
    <?php
    if (!($error==Inerr))
    {
        echo '<ul>';
        echo "<li>$error</li>";
        echo '</ul>';
    } 
    ?>
    </div>
    <div id=\"formi\">
    <form class="contact_form" action="" method="post" name="contact_form">
        <ul>
        <li>
            <h2>Войти под зарегистрированным именем</h2>
            <span class="required_notification">* Обязательные для заполнения поля</span>
        </li>
        <li>
            <label for="username">Имя/псевдоним:</label>
            <input type="text" name="username" id="username" placeholder="tve58" required/>
            <span class="form_hint">не менее 5 символов</span>
        </li>
	    <li>
            <label for="pwd">Пароль:</label>
            <input type="password" name="pwd" id="pwd" placeholder="A@315tsd" required/>
            <span class="form_hint">не менее 8 символов</span>
         </li>
        <li>
            <button class="submit" type="submit" name="login" id="login">Войти</button>
            <a class="home" href="/Main.php"><img src="/Images/Home.png" 
                width="40" height="40" alt="На главную страницу"></a>
        </li>
        </ul>
    </form> 
    </div> 
</body>
</html>

<?php
// ************************************************************* Indoor.php ***

