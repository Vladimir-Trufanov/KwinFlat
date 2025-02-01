<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                        *** Controller.php ***

// ****************************************************************************
// * KwinFlat                     Иммитировать некоторые действия контроллера *
// *                                                           из окна jquiry *
// ****************************************************************************

// v1.0.0, 01.02.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 01.02.2025

?>
<div id="dial" title="Controller ESP32-CAM" style="display:none;font-size:1rem;font-family:Courier;">
   <p><button onclick="Proba2()">Получить ответ от контроллера по кнопке ВКЛЮЧИТЬ РЕЖИМ</button></p>
   
   <div id="tabContainer">
	<h2>Комментарии к действиям</h2>
	<ul>
	   <li><a href="#panel1">Получить ответ от контроллера по кнопке ВКЛЮЧИТЬ РЕЖИМ</a></li>
	   <li><a href="#panel2">Вкладка 2</a></li>
	   <li><a href="#panel3">Вкладка 3</a></li>
	</ul>
	<!-- Панель 1 -->
	<div id="panel1" class="panel">
      <p>1. Обновление элементов страницы <b>ViewLed33()</b> производится по данным хранилища при событиях: </p>
      <p>при разворачивании экрана, .</p>
   
   
   
      <p>------------------------------------------------------------</p>
      <p>1. При разворачивании экрана инициируются параметры хранилища:</p>
      <p>ram.set("LmpEvent",0);       1 - прошла команда смены режима, 0 - пришло подтверждение от контроллера</p>
      <p>ram.set("LmpMode",1);        1 - включен режим, 0 - выключен режим (состояние в момент запроса)</p>
      <p>ram.set("LmpRegim",1);       указание по режиму в последней команде (1 - включить режим, 0 - выключить),</p>
      <p>далее сразу делается запрос SelectLMP33 и устанавливаются эти параметры по базе</p>
      <br>
	   <p>2. В момент клика по кнопке ВКЛЮЧИТЬ РЕЖИМ она становится красной.</p>
	</div>
	<!-- Панель 2 -->
	<div id="panel2">
	   <h2>Содержимое панели 2</h2>
		<p>Вы можете поместить в панель любой HTML-код</p>
		<ul>
		   <li>Избранное...</li>
			<li>Заголовки...</li>
			<li>Изображения...</li>
			<li>Другое...</li>
	   </ul>
	</div>
	<!-- Панель 3 -->
	<div id="panel3">
	   <h2><img src="Images/Home.png" style="float:right" height="150" alt="robot">Содержимое панели 1</h2>
	   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	</div>
	</div>
</div>
<?php

// <!-- --> ************************************************ Controller.php ***
