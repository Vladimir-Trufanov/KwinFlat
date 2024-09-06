

<?php
echo "Привет!";

include 'simple_html_dom.php';
$k = 1;
while($k>0)
{
   //$html = file_get_html('https://kwinflat.ru/Dacha'); // загружаем данные
   $html = file_get_html('http://localhost:100/Dacha/'); // загружаем данные
   // Выводим контекст страницы
   echo $html->plaintext;


   // как-то их обрабатываем
   //$html->clear(); // подчищаем за собой
   // Ищем все заголовки h1
   foreach($html->find('h1') as $title) 
   {
      // Выводим текст заголовка
      echo '***';
      echo $title->plaintext;
      echo '***';
   }

   foreach($html->find('#LED1on') as $title) 
   {
      // Выводим текст заголовка
      echo '===';
      echo $title->plaintext;
      echo '===';
   }

   foreach($html->find('#LED1off') as $title) 
   {
      // Выводим текст заголовка
      echo '===';
      echo $title->plaintext;
      echo '===';
   }

   foreach($html->find('#LED2on') as $title) 
   {
      // Выводим текст заголовка
      echo '===';
      echo $title->plaintext;
      echo '===';
   }

   foreach($html->find('#LED2off') as $title) 
   {
      // Выводим текст заголовка
      echo '===';
      echo $title->plaintext;
      echo '===';
   }
   $html->clear(); // подчищаем за собой
   unset($html);
   $k--;
}

/*
  $dom = new DOMDocument('1.0','UTF-8');
  $dom->formatOutput = true;

  $root = $dom->createElement('student');
  $dom->appendChild($root);

  $result = $dom->createElement('result');
  $root->appendChild($result);

  $result->setAttribute('id', 1);
  $result->appendChild( $dom->createElement('name', 'Opal Kole') );
  $result->appendChild( $dom->createElement('sgpa', '8.1') );
  $result->appendChild( $dom->createElement('cgpa', '8.4') );

  echo '<xmp>'. $dom->saveXML() .'</xmp>';
  $dom->save('result.xml') or die('XML Create Error');
*/

   foreach($html->find('h1') as $title) 
   {
      // Выводим текст заголовка
      echo '***';
      echo $title->plaintext;
      echo '***';
   }


echo "Пока!";

?>
