<?php
// PHP7/HTML5, EDGE/CHROME                                *** multipart.php ***

// ****************************************************************************
// *  ----KwinFlat30                               --- KwinFlat-близкий всем! *
// ****************************************************************************

// v4.0.1, 19.01.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2016 tve                               Дата создания: 14.08.2016

/*
// уникальный разделитель, можете использовать конкат нескльких uniqid() и т.п.
$delimiter = "boundary";
header('Content-type: multipart/x-mixed-replace;boundary="'.$delimiter.'"');
// полностью отрубаем буферизацию
while (@ob_end_flush()) {}
$header = "Content-type: text/html\r\n\r\n"; // перед каждой частью
$boundary = "--{$delimiter}\n"; // между частями
$footer = "--{$delimiter}--\n"; // в конце
$max = 10;
for ($i = 1; $i <= $max; $i++)
{	
	echo $header; # Заголовок перед каждой частью ответа	
	echo "$i\n"; # пишем сообщение	
	echo $boundary; # и выводим границу между сообщениями
	sleep(1);    
}
// завершающее сообщение
echo $header;
echo "-1";
echo $footer;
*/
echo "Multipart отработал!";

// ********************************************************** multipart.php ***

