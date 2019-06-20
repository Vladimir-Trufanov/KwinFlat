<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
<title>KwinFlat-проба!</title>
<!-- --> 
</head>
<body>
<header>
</header>
<article>
    <?php
    // Первая проба
    // Запуск команды опер.системы
	// $string=`dir`;
    // echo $string;
    ?>
    
    <?php
    // Вторая проба
    // Отправка письма

    // Создается форма с тремя полями для ввода адреса, темы и содержания письма. 
    // Нажатие на кнопку «Отправить» отправит запрос этому же скрипту.
    // Если данные введены, то будет вызвана функция mail, которая и отправит письмо. 
    // В случае успешной отправки функция возвращает true, в противном случае — false.
    $addr = $_POST['addr'];
    $theme = $_POST['theme'];
    $text = $_POST['text'];
    if (isset($addr) && isset($theme) && isset($text)
    && $addr != "" && $theme != "" && $text != "") 
    {
        if (mail($addr, $theme, $text, "From: vova_33@mail.ru")) 
        {
            echo "<h3>Сообщение отправлено</h3>";
        }
        else 
        {
            echo "<h3>При отправке сообщения возникла ошибка</h3>";
        }
    }
    ?>
    <form action="Proba.php" method="post">
    <p>
        <label for="addr">eMail:</label>
        <input type="text" name="addr" id="addr" size="30" />
    </p>
    <p>
        <label for="theme">Тема письма:</label>
        <input type="text" name="theme" id="theme" size="30" />
    </p>
    <p>
        <label for="text">Текст письма:</label>
     	<textarea rows="10" cols="20" name="text" id="text"></textarea>
    </p>
    <p>
        <input type="submit" value="Отправить" />
    </p>
    </form>
</article>
<footer>
  Copyright &copy; Владимир Труфанов
</footer>
</body>
</html>
