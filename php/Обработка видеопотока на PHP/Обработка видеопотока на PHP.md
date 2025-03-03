## [Обработка видеопотока на PHP](#)

### Заголовки

---

#### [dom-examples/streams/README.md](https://github.com/mdn/dom-examples/blob/main/streams/README.md)

#### [Fetch](https://learn.javascript.ru/fetch)

#### [Multipart XMLHTTPRequest](https://javascript.ru/ajax/comet/multipart-xmlhttprequest)

#### [Тема: трансляция потока mJPEG](https://forum.php-myadmin.ru/viewtopic.php?id=2041)

#### [multipart-x-mixed-replace-example](https://github.com/yscoder/multipart-x-mixed-replace-example)

#### [Код Эрика. Тип содержимого multipart/x-mixed-replace](https://blog.dubbelboer.com/2012/01/08/x-mixed-replace.html)

Дата: 8 января 2012 г. Автор: Эрик Даббелбоер

Глядя на новый вид Google Analytics в реальном времени, я заметил, что они используют тип контента multipart/x-mixed-replace для отправки обновлений в реальном времени в веб-браузер.

Используя этот специальный тип контента, вы можете заменить содержимое страницы. Этот пример вы можете найти здесь:

```
<?

// Make sure PHP isn't buffereing anything.
ob_end_clean();

// Sending this header will prevent nginx from buffering the output.
header('X-Accel-Buffering: no');

header('Content-type: multipart/x-mixed-replace; boundary=endofsection');

// Keep in mind that the empty line is important to separate the headers
// from the content.
echo 'Content-type: text/plain

After 5 seconds this will go away and a cat will appear...
--endofsection
';
flush(); // Don't forget to flush the content to the browser.


sleep(5);


echo 'Content-type: image/jpg

';

$stream = fopen('cat.jpg', 'rb');
fpassthru($stream);
fclose($stream);

echo '
--endofsection
';
```






---


#### [Что такое HTTP, или как браузеры общаются с веб-серверами](https://maxkuznetsov.ru/all/http-basics/)

#### [cURL в PHP: примеры POST, GET запросов с headers, cookie, JSON и многопоточностью](https://phpstack.ru/php/curl-v-php-primery-post-get-zaprosov-s-headers-cookie-json-i-mnogopotocnostu.html)

#### [Как работать с Curl: синтаксис и основные команды](https://skillbox.ru/media/code/kak-rabotat-s-curl-sintaksis-i-osnovnye-komandy/#stk-12)

#### [HTTP-запросы от А до Я](https://otus.ru/journal/http-zaprosy-ot-a-do-ya/)

#### [Как работают браузеры. Часть 1: навигация и получение данных](https://habr.com/ru/companies/kts/articles/669784/)














---

***"что такое Content-Type: multipart/x-mixed-replace; boundary=frame"***

***"Обработка видеопотока на PHP"***

***"Обработка видеопотока на js"***

***"как делается обмен между сервером и браузером"***

***"формат запросов и ответов http протокола"***

---

Обмен между сервером и браузером происходит с помощью протокола HTTP. Он работает на основе клиент-серверной модели, где браузер выступает в роли клиента, а веб-сервер — в роли сервера. 13

Процесс взаимодействия:

Ввод URL. Пользователь вводит URL в адресную строку браузера. URL указывает на конкретный ресурс, к которому пользователь хочет получить доступ. 1
DNS-запрос. Браузер отправляет запрос на DNS-сервер для получения IP-адреса веб-сервера. 1
Установка соединения. Браузер устанавливает TCP-соединение с веб-сервером. TCP (Transmission Control Protocol) — это протокол транспортного уровня, который обеспечивает надёжную передачу данных между клиентом и сервером. 1
Отправка HTTP-запроса. Браузер формирует и отправляет HTTP-запрос на сервер. Запрос включает в себя стартовую строку, заголовки и, возможно, тело запроса. 1
Обработка запроса. Веб-сервер принимает запрос, обрабатывает его и формирует HTTP-ответ. Сервер анализирует запрос, выполняет необходимые действия (например, извлечение данных из базы данных или выполнение скрипта) и формирует ответ, который будет отправлен клиенту. 1
Получение HTTP-ответа. Браузер получает ответ от сервера. Ответ включает в себя стартовую строку, заголовки и тело ответа. Браузер анализирует ответ, чтобы определить, как обработать полученные данные. 1
Отображение контента. Браузер интерпретирует полученные данные и отображает их пользователю. Браузер использует HTML, CSS и JavaScript для рендеринга веб-страницы и отображения её пользователю. Этот процесс может включать в себя выполнение дополнительных запросов для загрузки ресурсов, таких как изображения, стили и скрипты. 1

---

### Библиография

#### [php-ffmpeg](https://github.com/PHP-FFMpeg/PHP-FFMpeg/tree/0.x)

#### [PHP-FFMPEG-Extras](https://github.com/PHP-FFMpeg/PHP-FFMpeg-Extras?tab=readme-ov-file)

#### [Media API. Управление видео из JavaScript](https://metanit.com/web/html5/7.3.php)

#### [Захват видео с сетевых камер, часть 1](https://habr.com/ru/articles/115808/)

#### [Спецификация MJPEG поверх HTTP](https://stackoverflow.com/questions/47729941/mjpeg-over-http-specification)

#### [Programming VIP - Very Interesting Programming](https://programming.vip/docs/video-streaming-with-flash.html)
