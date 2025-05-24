<?php
/**
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
xml:lang="<?php echo $this->language; ?>" 
lang="<?php echo $this->language; ?>" 
dir="<?php echo $this->direction; ?>">
<head>
  <title> Заблудились? </title>
  <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/error.css" type="text/css"/>
  <?php if($this->direction == 'rtl') : ?>
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/error_rtl.css" type="text/css"/>
  <?php endif; ?>
  <!-- Указываем кодировку страницы в Юникоде -->
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <!-- Указываем стили страницы -->
  <style type="text/css"> <!--
  .стиль6 {
	color: #135CAE;
	font-weight: bold; } -->
  </style>
</head>
<body>
  <div align="center">
	<div id="outline">
	  <div id="errorboxoutline">
        <p align="left">
        <img src="404.jpg" width="400" height="481" hspace="15" vspace="15" align="left" title="Экскурсией на главную">
        Здравствуйте, еще раз! Заблудились? <BR> <BR>
        Ничего страшного, даже <span class="стиль6">интересно, как Вы сюда попали</span>.<BR>
        Может ссылку набрали неправильно, или на клавишу лишнюю нажали нечаянно? <BR><BR>
        Вы пока еще у нас на сайте <span class="стиль6">KwinFlat.ru</span>. 
        Можете ниже написать нам и рассказать об этом событии, <BR>
        а можете вернуться на главную страницу. <BR><BR> 
        Мы всегда рады Вас видеть и быть полезными! <BR></p>
		<div id="errorboxheader"><?php echo $this->error->code ?> - <?php echo $this->error->message ?></div>
        <!-- Размещаем код счетчика LiveInternet --> <BR>
        <div><!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t53.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,80))+";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров и"+
" посетителей за 24 часа' "+
"border='0' width='88' height='31'><\/a>")
//--></script><!--/LiveInternet--> </div>
        <p><img src="images/stories/Filler2x58.jpg" alt="Заполнитель2x58" align="texttop"/></p>
        <BR> <a href="mailto:tve@karelia.ru" class="стиль6"> Напишите письмо администратору </a> <BR>
        <BR> <a href="home" class="стиль6"> Возвращайтесь на главную страницу! </a> <BR> <BR> <BR> <BR>
	  </div>
	</div>
</div>
</body>
</html>
