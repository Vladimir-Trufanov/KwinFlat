<?php
   $Posi=$_POST['masiv']; 

   $SiteRooti = $_SERVER['DOCUMENT_ROOT'];       // Корневой каталог сайта
   // Подключаем базу данных  
   $pathBase='sqlite:'.$SiteRooti.'/SmartMenus/AjaxBase.db3';                                          
   $db = new PDO($pathBase);
   $sql="UPDATE `Parmi` SET `Posi`=".$Posi;
   $st = $db->query($sql);
?>
<?php
?>
  <script> 
  </script>
<?php
