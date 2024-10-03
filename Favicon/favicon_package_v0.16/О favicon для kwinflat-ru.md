## О favicon для kwinflat.ru

Загрузите свой пакет.

Извлеките этот пакет из корневого каталога вашего веб-сайта. Если ваш сайт http://www.example.com, вы сможете получить доступ к файлу с именем http://www.example.com/favicon.ico.

Вставьте следующий код в раздел <head> ваших страниц:

```
Download your package: 

Extract this package in the root of your web site. If your site is http://www.example.com, you should be able to access a file named http://www.example.com/favicon.ico.

Insert the following code in the <head> section of your pages:

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

Optional - Once your website is deployed, check your favicon
```

В первоначальном варианте не срабатывает – манифест не отрабатывается. Следует переименовать файл в manifest.json и поместить его в корневой каталог.

```
<link rel="manifest" href="manifest.json">
<link rel="apple-touch-icon" sizes="180x180" href="/favicon260x260/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon260x260/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon260x260/favicon-16x16.png">
<link rel="mask-icon" href="/favicon260x260/safari-pinned-tab.svg" color="#5bbad5">

<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<link rel="shortcut icon" href="/favicon260x260/favicon.ico">
<meta name="msapplication-config" content="/favicon260x260/browserconfig.xml">




```
