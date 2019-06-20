<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/GetAbove.php";
$SiteRoot = $_SERVER['DOCUMENT_ROOT'];      // Корневой каталог сайта
$SiteAbove = \prown\GetAbove($SiteRoot);    // Надсайтовый каталог
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset=utf-8">
<title>Read File in a Single Operation</title>
</head>

<body>
<?php 
//echo $SiteAbove.'/private/filetest_01.txt';
//echo file_get_contents('C:/private/filetest_01.txt'); 
echo file_get_contents($SiteAbove.'/Private/filetest_01.txt'); 
?>
</body>
</html>