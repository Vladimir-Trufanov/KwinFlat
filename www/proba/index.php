<?php

  // v1
  /*
	header('Content-Type: application/pdf');
  header('Content-Disposition: attachment; filename=hello.pdf');
	header('Pragma: no-cache');
	header('Expires: 0');
  readfile('hello.pdf');
  exit;
  */
  
  /*
	header('Content-Description: File Transfer');
  header('Content-Disposition: inline; filename="' .basename($file).'"');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
  */
  
  // v2
  
  /*
  // Массив соответствий расширений. Примеры только для изображений и pdf.
  // Вы можете поэкспериментировать для любых других документов
  $exts = array(
    'BMP' => 'image/jpeg',
    'JPG' => 'image/jpeg',
    'JPEG' => 'image/jpeg',
    'GIF' => 'image/jpeg',
    'PNG' => 'image/jpeg',
    'PDF' => 'application/pdf'
  );
  $ext = 'PDF';
  // Получаем Content-Type документа
  $contentType = $exts[$ext];
 
  // Получаем файл (читаем его из файла, получаем curl-ом с удаленного сервера, как угодно...)
  $file = file_get_contents('hello.pdf');
  header("Content-Type: $contentType");
  echo $file;
  */
  
  
//$fpdf='Roscha.pdf';
$fpdf='hello.pdf';
viewpdf($fpdf);

function viewpdf($fpdf)
{
  // Массив соответствий расширений. Примеры только для изображений и pdf.
  // Вы можете поэкспериментировать для любых других документов
  $exts = array(
    'BMP' => 'image/jpeg',
    'JPG' => 'image/jpeg',
    'JPEG' => 'image/jpeg',
    'GIF' => 'image/jpeg',
    'PNG' => 'image/jpeg',
    'PDF' => 'application/pdf'
  );
  $ext = 'PDF';
  // Получаем Content-Type документа
  $contentType = $exts[$ext];
 
  // Получаем файл (читаем его из файла, получаем curl-ом с удаленного сервера, как угодно...)
  $file = file_get_contents($fpdf);
  header("Content-Type: $contentType");
  echo $file;
}

  
  ?>
