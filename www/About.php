<?php
?>
<!doctype html>
<html>         
<head>                 
    <meta charset="UTF-8">                 
    <title> Заблудились? </title>
    <link href='http://fonts.googleapis.com/css?family=Kurale' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Pattaya&subset=cyrillic" rel="stylesheet">        
    <link href="https://fonts.googleapis.com/css?family=Podkova&subset=cyrillic" rel="stylesheet">  
    <link rel="stylesheet" type="text/css" href="Allcss/Main.css"/>
<!-- -->
</head>         
<body> 
    <div id="error">
        <figure id="errorimg">
            <img src="../Images/ecskursii.jpg" alt="Экскурсии" width="100%">
        </figure>

        <div id="errorcontent">
        <div id="errorcounter">
        <!--noindex-->
        <!--/noindex-->
        </div>
        
        <!--    
        <div id="errorhref">
        <a href="mailto:tve@karelia.ru"> Напишите письмо администратору </a>
        </div>
        -->
 
        <div id="about">
        <p>Программа проверки расчета льгот по жилищным, коммунальным услугам</p>
        <p>Версия 3.0</p>
        <p>Copyright © 2018 Труфанов Владимир Евгеньевич</p>
        </div>
        
        <div id="errorhref">
        <a href="/Main.php"> Возвращайтесь на главную страницу! </a>
        </div>

        </div>
    </div>
    
    <footer id="errormessage">
    <?php 
        echo $_GET["mess"];
    ?>
    </footer>

</body>
</html>
