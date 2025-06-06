<?php

// index.php    RusakovClient.php

  header('Content-Type: text/plain;');  // Мы будем выводить простой текст
  set_time_limit(0);                    // Скрипт должен работать постоянно
  ob_implicit_flush();                  // Все echo должны сразу же выводиться

  // $address = '127.0.0.1';            // Адрес работы сервера
  // $address = '87.242.70.183';        // Адрес работы сервера
  
  $address = '127.0.0.1';               // Адрес работы сервера
  $port = 7774;   // 1985;              // Порт работы сервера (лучше какой-нибудь редкоиспользуемый)
  
  if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) 
  {
    // AF_INET - семейство протоколов
    // SOCK_STREAM - тип сокета
    // SOL_TCP - протокол
    echo "Ошибка создания сокета ".$address.':'.$port;
  }
  else 
  {
    echo "Сокет создан ".$address.':'.$port."\n";
  }
  $result = socket_connect($socket, $address, $port);
  if ($result === false) 
  {
    echo "Ошибка при подключении к сокету";
  } 
  else 
  {
    echo "Подключение к сокету прошло успешно\n";
  }
  $out = socket_read($socket, 1024);          // Читаем сообщение от сервера
  echo "Сообщение от сервера: $out.\n";
  $msg = "15";
  echo "Сообщение серверу: $msg\n";
  socket_write($socket, $msg, strlen($msg));  // Отправляем серверу сообщение
  $out = socket_read($socket, 1024);          // Читаем сообщение от сервера
  echo "Сообщение от сервера: $out.\n";       // Выводим сообщение от сервера
  $msg = 'exit';                              // Команда отключения
  echo "Сообщение серверу: $msg\n";
  socket_write($socket, $msg, strlen($msg));
  echo "Соединение завершено\n";
  // Останавливаем работу с сокетом
  if (isset($socket)) 
  {
    socket_close($socket);
    echo "Сокет успешно закрыт";
  }
?>
