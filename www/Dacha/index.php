<!DOCTYPE html> 
<!-- 
-->
<html>

<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
   <title>Дачная страница</title>
   <!-- <link rel="stylesheet" type="text/css" href="Allcss/Reset.css" /> -->
    
   <style>
      html{font-family:Helvetica; display:inline-block; margin:0px auto; text-align: center;}
      body{margin-top:50px;} h1{color:#444444; margin:50px auto 30px;} h3{color:#444444; margin-bottom:50px;}
      
      .button
      {
         display:block; width:80px; background-color:#3498db; border:none; color:white; padding:13px 30px; 
         text-decoration:none; font-size:25px; margin:0px auto 35px; cursor:pointer; border-radius: 4px;
      }
      
      .button-on         {background-color:#3498db;}
      .button-on:active  {background-color:#2980b9;}
      .button-off        {background-color:#34495e;}
      .button-off:active {background-color:#2c3e50;}
      
      p {font-size:14px; color:#888; margin-bottom:10px;}
   </style>
</head>

<body>

<header>
   <div class="header-bg">
   <img src="../Images/Kwinflat.jpg" alt="Kwinflat-близкий всем!" />
   </div>
</header>

<article>
   <h1>ESP32 - Дачная страница</h1>
   <?php
      
      //if (led1stat)
         //echo '<p>Состояние LED1: ВКЛ. </p><a class="button button-off" href="/led1off">ВЫКЛ.</a>';
         echo '<p>Состояние LED1: ВКЛ. </p><a class="button button-off" href="?com=led1off">ВЫКЛ.</a>';
      //else
      //   echo '<p>Состояние LED1: ВЫКЛ.</p><a class="button button-on"  href="/led1on"> ВКЛ. </a>';
         
      //if (led2stat)
         echo '<p>Состояние LED2: ВКЛ. </p><a class="button button-off" href="/led2off">ВЫКЛ.</a>';
      //else
      //   echo '<p>Состояние LED2: ВЫКЛ.</p><a class="button button-on"  href="/led2on"> ВКЛ. </a>';

      echo "Всем большой привет с дачной страницы";
    ?>
</article>

<footer>
    Copyright &copy; Владимир Труфанов
</footer>

</body>
</html>

<?php
/*
  ?page=1&perpage=20

  String ptr = "<!DOCTYPE html> <html>\n";
  ptr +="<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\"><head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=no\">\n";
  ptr +="<title>Управление светодиодом</title>\n";

  ptr +="<style>html { font-family: Helvetica; display: inline-block; margin: 0px auto; text-align: center;}\n";
  ptr +="body{margin-top: 50px;} h1 {color: #444444;margin: 50px auto 30px;} h3 {color: #444444;margin-bottom: 50px;}\n";
  ptr +=".button {display: block;width: 80px;background-color: #3498db;border: none;color: white;padding: 13px 30px;text-decoration: none;font-size: 25px;margin: 0px auto 35px;cursor: pointer;border-radius: 4px;}\n";
  ptr +=".button-on {background-color: #3498db;}\n";
  ptr +=".button-on:active {background-color: #2980b9;}\n";
  ptr +=".button-off {background-color: #34495e;}\n";
  ptr +=".button-off:active {background-color: #2c3e50;}\n";
  ptr +="p {font-size: 14px;color: #888;margin-bottom: 10px;}\n";
  ptr +="</style>\n";
  ptr +="</head>\n";
  ptr +="<body>\n";

  ptr +="<h1>ESP32 Веб сервер</h1>\n";
    ptr +="<h3>Режим станции (STA)</h3>\n";
   if(led1stat)
  {ptr +="<p>Состояние LED1: ВКЛ.</p><a class=\"button button-off\" href=\"/led1off\">ВЫКЛ.</a>\n";}
  else
  {ptr +="<p>Состояние LED1: ВЫКЛ.</p><a class=\"button button-on\" href=\"/led1on\">ВКЛ.</a>\n";}
  if(led2stat)
  {ptr +="<p>Состояние LED2: ВКЛ.</p><a class=\"button button-off\" href=\"/led2off\">ВЫКЛ.</a>\n";}
  else
  {ptr +="<p>Состояние LED2: ВЫКЛ.</p><a class=\"button button-on\" href=\"/led2on\">ВКЛ.</a>\n";}
  ptr +="</body>\n";
  ptr +="</html>\n";
  return ptr;
}
*/
?>

