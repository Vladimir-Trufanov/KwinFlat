<?php

// PHP7/HTML5, EDGE/CHROME                                 *** Register.php ***

// ****************************************************************************
// * KwinFlat.ru                                Зарегистрировать пользователя *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.02.2018
// Copyright © 2018 tve                              Посл.изменение: 21.03.2018

require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/GetAbove.php";
$SiteRoot = $_SERVER['DOCUMENT_ROOT'];      // Корневой каталог сайта
$SiteAbove = \prown\GetAbove($SiteRoot);    // Надсайтовый каталог

require_once $SiteRoot."/Common.php";
require_once $SiteRoot."/TPHPPROWN/ViewArray.php";
require_once $SiteRoot."/TPHPPROWN/regx.php";
require_once $SiteRoot.'/Entrys/Register_user_text.php';
require_once $SiteRoot.'/Entrys/CheckPassword.php';

//\prown\ViewArray($_POST,'$_POST');
if (isset($_POST['register'])) 
{
    //echo 'username='.$_POST['username'];
    $username = trim($_POST['username']);
    $password = trim($_POST['pwd']);
    $retyped = trim($_POST['conf_pwd']);
    $userfile  = $SiteAbove.'/Private/Еncrypted.fil';
  
    // Инициируем массив ошибок и выполняем регистрацию
    $errors = array();
    Register_user_text($errors,$username,$password,$retyped,$userfile);
    // Если ошибок нет, то переходим в главную страницу с именем пользователя
    if (!$errors) 
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
    <title>Регистрация пользователя</title>
	<link rel="stylesheet" media="screen" href="/Allcss/ContactUs.css">
</head>

<body>
    <div id="Ers">
    <?php
    // Выводим сообщение об ошибке 
    if (!empty($errors)) 
    {
        echo '<ul>';
        foreach ($errors as $item) 
        {
            echo "<li>$item</li>";
	    }
        echo '</ul>';
    }
    ?>
    </div>
    <div id=\"formi\">
    <form class="contact_form" action="" method="post" name="contact_form">
        <ul>
        <li>
            <h2>Зарегистрировать пользовательское имя</h2>
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
            <label for="conf_pwd">Повторите пароль:</label>
            <input type="password" name="conf_pwd" id="conf_pwd" required/>
        </li>
        <li>
            <button class="submit" type="submit" name="register" id="login">Зарегистрировать</button>
            <a class="home" href="/Main.php"><img src="/Images/Home.png" 
                width="40" height="40" alt="На главную страницу"></a>
        </li>
        </ul>
    </form>
    </div> 
</body>
</html>
