<?php
// PHP7/HTML5, EDGE/CHROME                               *** multipart3.php ***

// ****************************************************************************
// *                     По XMLHttpRequest заменить одно изображение (сервер) *
// ****************************************************************************

// v1.0.0, 03.03.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2016 tve                               Дата создания: 03.03.2025

//$file = __DIR__ . '/test.jpg';
$file = 'test.jpg';
$img=ImgToBase64($file);
echo $img;

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

// ********************************************************* multipart3.php ***

