<?php
  require "../../IniSitemem.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>KwinFlat-трассировка!</title>
<!-- --> 
</head>
<body>
<header>
</header>
<article>
  <!-- -->
  <?php
    // Показываем сайтовые переменные
    /* */	
    $cSiteMem='';
    $cSiteMem=$cSiteMem
      .'Корневой каталог сайта='.$SiteRoot.'<br>';
    echo $cSiteMem;
	
	$cTrass = $_REQUEST['cTrass'] ?? "Мимо!";
    echo "cTrass:"."<br>".$cTrass."<br>"."---";

     
  ?>
</article>
<footer>
  Copyright &copy; Владимир Труфанов
</footer>
</body>
</html>
