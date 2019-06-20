<?php                                           
// PHP7/HTML5, EDGE/CHROME                                *** ContactUs.php ***

// ****************************************************************************
// * KwinFlat.ru                                       Написать письмо автору *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  05.03.2018
// Copyright © 2016 TVE                              Посл.изменение: 27.04.2018

// Существует 2 вида заходов на страницу: без параметров для подготовки сообщения 
// и с параметрами для их проверки и отправки письма

require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/ViewArray.php";
require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/regx.php";

function send_mail($to, $thm, $html, $path) 
{
    // Показываем спецификацию загружаемого файла
    //echo '$path='.$path;
    $Result="Cообщение с вложением от ".$thm." отправлено!";
    $fp = fopen($path,"r"); 
    if (!$fp) 
    { 
        $Result="Файл $path не может быть прочитан!"; 
        exit(); 
    } 
    $file = fread($fp,filesize($path)); 
    fclose($fp); 
    $boundary = "--".md5(uniqid(time())); // генерируем разделитель 
    $headers .= "MIME-Version: 1.0\n"; 
    $headers .="Content-Type: multipart/mixed; boundary=\"$boundary\"\n"; 
    $multipart .= "--$boundary\n"; 
    $kod = 'utf-8'; // $kod = 'koi8-r'; // или $kod = 'windows-1251'; 
    $multipart .= "Content-Type: text/html; charset=$kod\n"; 
    $multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n"; 
    $multipart .= "$html\n\n"; 
    $message_part = "--$boundary\n"; 
    $message_part .= "Content-Type: application/octet-stream\n"; 
    $message_part .= "Content-Transfer-Encoding: base64\n"; 
    $message_part .= "Content-Disposition: attachment; filename = \"".$path."\"\n\n"; 
    $message_part .= chunk_split(base64_encode($file))."\n"; 
    $multipart .= $message_part."--$boundary--\n"; 
    if(!mail($to, $thm, $multipart, $headers)) 
    { 
        $Result="К сожалению, письмо не отправлено!"; 
        exit(); 
    }
    return $Result;
}

// Определяем начальное сообщение об ошибке
define ("Inerr","Ошибок нет!");   
$error = Inerr;
//\prown\ViewArray($_REQUEST,'$_REQUEST');

// Готовим набор условий посылки письма
$toSendMessage=0;
// Проверяем правильности заполнения фамилии, имени, отчества (инициалов)
$name=''; 
if (isset($_REQUEST['name'])) 
{
    $name=$_REQUEST['name'];
    if (!preg_match(regFamio35Utf8,$_REQUEST['name'])) 
    {
        $error = 'Неверно заполнено "Фамилия-имя (отчество или инициалы)"!'; 
    }
    else $toSendMessage=$toSendMessage+2;
}
// Проверяем правильности адреса email
$email=''; 
if (isset($_REQUEST['email'])) 
{
    $email=$_REQUEST['email'];
    if (!preg_match(regEmail,$_REQUEST['email'])) 
    {
        $error = 'Не в формате указан e-mail "tve58@inbox.ru"!'; 
    }
    else $toSendMessage=$toSendMessage+4;
}
// Принимаем текст сообщения
$mess='';
if (isset($_REQUEST['message'])) 
{
    $mess=$_REQUEST['message'];
}
// Отправляем почту, когда можно
if ($toSendMessage==6)
{
    $_REQUEST['name']=htmlspecialchars(stripslashes($_REQUEST['name']));
    $_REQUEST['email']=htmlspecialchars(stripslashes($_REQUEST['email']));
    $_REQUEST['message']=htmlspecialchars(stripslashes($_REQUEST['message']));
    // Если поле выбора вложения не пустое - закачиваем его на сервер 
    $picture = "";  // инициализировали вложение
    if (!empty($_FILES['mailfile']['tmp_name'])) 
    { 
        // Закачиваем файл 
        $path = $_FILES['mailfile']['name']; 
        if (copy($_FILES['mailfile']['tmp_name'], 'floads/'.$path)) $picture = 'floads/'.$path; 
    }
    $thm = $_REQUEST['email'];
    $msg = $_REQUEST['message'];
    $mail_to = "tve58@inbox.ru";
    // Отправляем почтовое сообщение 
    $error="Cообщение от ".$thm." отправлено!";
    if(empty($picture)) 
    {
        if(!mail($mail_to,$thm,$msg)) 
        { 
            $error="К сожалению, письмо не отправлено!"; 
        }
    }
    else 
    {
        $error = send_mail($mail_to,$thm,$msg,$picture); 
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Контакты</title>
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

<div id=\"formc\">
<form class="contact_form" action="ContactUs.php" enctype='multipart/form-data' method="post" name="contact_form">

    <ul>
    <li>
        <h2>Отправить сообщение автору</h2>
        <span class="required_notification">* Обязательные для заполнения поля</span>
    </li>
    <li>
        <label for="name">Ваше имя:</label>
        <?php
        if ($name=='') 
        {
            echo "<input type=\"text\" name=\"name\" placeholder=\"Труфанов Владимир\" required/>";
        }
        else
        {
            echo "<input type=\"text\" name=\"name\" value=\"".$name."\" required/>";
        }
        ?>
    </li>
	<li>
        <label for="email">Ваш е-mail:</label>
        <?php
        if ($email=='') 
        {
            echo "<input type=\"text\" name=\"email\" maxlength=32 placeholder=\"tve58@inbox.ru\" required/>";
        }
        else
        {
            echo "<input type=\"text\" name=\"email\" maxlength=32 value=\"".$email."\" required/>";
        }
        ?>
        <span class="form_hint">в правильном формате email</span>
    </li>
    <!--  
    <li>
      <label for="website">Ваш сайт:</label>
      <input type="url" name="website" placeholder="https://kwinflat.ru" pattern="(http|https)://.+" />
      <span class="form_hint">с указанием домена сайта "https://kwinflat.ru"</span>
    </li>
    -->
    <li>
        <label for="message">Сообщение:</label>
        <?php
        if ($mess=='') 
        {
            echo "<textarea name=\"message\" cols=\"40\" rows=\"6\" placeholder=\"Текст сообщения\" required></textarea>"; 
        }
        else
        {
            echo "<textarea name=\"message\" cols=\"40\" rows=\"6\" required>".$mess."</textarea>";
        }
        ?>
    </li>
    <li>
        <label for="mailfile">Вложение:</label>
        <input class="infile" type="file" name="mailfile" maxlength="128">
    </li>
    <li>
        <button class="submit" type="submit"> Отправить сообщение </button>
        <a class="home" href="/Main.php"><img src="/Images/Home.png" 
            width="40" height="40" alt="На главную страницу"></a>
    </li>
    </ul>
</form> 
</div> 
</body>
</html>

<?php                                           
// ********************************************************** ContactUs.php ***
