<?php
// PHP7/HTML5, EDGE/CHROME                          *** multipartDigits.php ***

// ****************************************************************************
// *        По XMLHttpRequest выбрать одно Base64-изображение (это сервер)    *
// ****************************************************************************

// v2.1.0, 19.04.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 03.03.2025

define("imgDigits",   1);      // тестовые изображения = цифры
define("imgMulti",    2);      // бегущая девочка - самые большие файлы
define("imgESP32CAM", 3);      // тестовые изображения = кадры от esp32-cam

// Определяем номер и выбираем очередной файл
$imgDir=$_GET['mode'];
$num=GetNum($imgDir);
if ($imgDir==imgDigits)   $file = 'imgDigits/png'.$num.'.png';
if ($imgDir==imgESP32CAM) $file = 'imgESP32CAM/picture'.$num.'.jpg';
if ($imgDir==imgMulti)    $file = 'imgMulti/run'.$num.'.png';

// Преобразовываем изображение в Base64
$src=ImgToBase64($file);

// Контрольные изображения
// "kwinflat"
// $src="data:image/jpeg;base64,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";
// "star"
// $src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAEnQAABJ0Ad5mH3gAAADhSURBVChTVZA9TwJBEIb350pCL1BYoIUFITbE2tAYCxPobGwvEgpsIIaDgkJjtBLI5di7e8w7e0ugmMzXu8/MjivzAgqgOrHyPJfGWVHmgUPO3yrFf35bbIC67yyRZXvY7hi32rwO7kMexVUtFIV0Cb8/JNddvkZji7PZu9HDaI8RRFrfdJm3Lo9eNXvkRTzkYafkje1dn49mg0XjAoYPVhM5ELWDdkmXRpE4UiWyXQtwUlel57F3y8tVBzYrmCY2dvL8FCD6jE5l98r24VMixLgWqe00OQpFVjP6eHhflfwDul9tENLGFW4AAAAASUVORK5CYII=";

// Сворачиваем ответ в JSON
$json = json_encode(array(
   'img' => array
   (
     $num,
     $src
   )
));
// Возвращаем JSON
echo  $json;

// ****************************************************************************
// *                     Преобразовать изображение в Base64                   *
// ****************************************************************************
function ImgToBase64($file)
{
   $path = pathinfo($file);
   $ext = mb_strtolower($path['extension']);
 
   if (in_array($ext, array('jpeg', 'jpg', 'gif', 'png', 'webp', 'svg'))) 
   {       
      if ($ext == 'svg') 
      {
	       $img = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($file));
	    } 
      else 
      {
         $size = getimagesize($file);
         $img = 'data:' . $size['mime'] . ';base64,' . base64_encode(file_get_contents($file));
	    }
   }
   return $img;
} 
// ****************************************************************************
// *  Получить номер очередного изображения, записанный во вспомогательный файл    
// ****************************************************************************
function GetNum($imgDir)
{
   $count_file = "counts.txt";
   if (file_exists($count_file)) 
   {
      $counts = file($count_file);
      $counts[0] ++;
      // Инициируем номер текущей цифры
      if ($imgDir==imgDigits) if ($counts[0] > 9) $counts[0]=0;
      // Инициируем номер фотографии контроллера
      if ($imgDir==imgESP32CAM) 
      {
         if ($counts[0] > 55) $counts[0]=40;
         if ($counts[0] < 40) $counts[0]=40;
      }
      // Инициируем номер кадра бегощей девочки
      if ($imgDir==imgMulti) if ($counts[0] > 20) $counts[0]=1;
   } 
   else 
   {
      if ($imgDir==imgDigits)   $counts[0]=0;
      if ($imgDir==imgESP32CAM) $counts[0]=40;
      if ($imgDir==imgMulti)    $counts[0]=1;
   }
   $fp = fopen($count_file , "w");
   fputs($fp, "$counts[0]");
   fclose($fp);
   return $counts[0];
}

// **************************************************** multipartDigits.php ***

