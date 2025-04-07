<?php
// PHP7/HTML5, EDGE/CHROME/YANDEX                        *** Controller.php ***

// ****************************************************************************
// * KwinFlat                     Иммитировать некоторые действия контроллера *
// *                                                           из окна jquiry *
// ****************************************************************************

// v1.0.1, 10.03.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 01.02.2025

?>
<div id="dial" title="Controller ESP32-CAM" style="display:none;font-size:1rem;font-family:Courier;">
   <div id="tabContainer">
   <h2>Действия контроллера</h2>
   <ul>
      <li><a href="#panel1">Передавать сообщения о смене состояния led33 через 1 сек.</a></li>
	    <li><a href="#panel2">Получить ответ от контроллера по кнопке ВКЛЮЧИТЬ РЕЖИМ</a></li>
	    <li><a href="#panel3">Отправлять изображения в базу данных с заданной частотой</a></li>
   </ul>
   <!-- Панель 1 -->
   <div id="panel1" class="panel">
      <p>1. Обновление элементов страницы <b>ViewLed33()</b> производится по данным хранилища при событиях: </p>
      <p>при разворачивании экрана, затем по событию для обновления экрана через четверть секунды.</p>
      <p>------------------------------------------------------------</p>
      <p>1. При разворачивании экрана инициируются параметры хранилища:</p>
      <p>ram.set("LmpEvent",0);       1 - прошла команда смены режима, 0 - пришло подтверждение от контроллера</p>
      <p>ram.set("LmpMode",1);        1 - включен режим, 0 - выключен режим (состояние в момент запроса)</p>
      <p>ram.set("LmpRegim",1);       указание по режиму в последней команде (1 - включить режим, 0 - выключить),</p>
      <p>далее сразу делается запрос SelectLMP33 и устанавливаются эти параметры по базе</p>
      <br>
      <p>2. В момент клика по кнопке ВКЛЮЧИТЬ РЕЖИМ она становится красной.</p>
      <br>
      <button onclick="Test1()"><h2>Передавать сообщения о смене состояния led33 через 1 сек</h2></button>
   </div>
   <!-- Панель 2 -->
   <div id="panel2">
      <h2>Получить ответ от контроллера по кнопке ВКЛЮЧИТЬ РЕЖИМ</h2>
      <p>Вы можете поместить в панель любой HTML-код</p>
      <ul>
         <li>Избранное...</li>
         <li>Заголовки...</li>
         <li>Изображения...</li>
         <li>Другое...</li>
      </ul>
      <!-- 
	    <img src="Images/Home.png" style="float:right" height="150" alt="robot">
      -->
      <br>
      <button onclick="Test2()"><h2>Получить ответ от контроллера по кнопке ВКЛЮЧИТЬ РЕЖИМ</h2></button>
   </div>
   <!-- Панель 3 -->
   <div id="panel3">
      <h2>Контрольные изображения отправляются в базу данных</h2>
      <br>
      В виртуальном контроллере заготовлено три набора изображений: цифры, бегущая девочка и 
      набор фотографий, поступивших от контроллера. Все изображения отправляются в базу данных,
      а затем прокручиваются из базы данных.
      <br><br>
      <button onclick="Test3(1)"><h2>Отправлять в базу данных цифры с частотой 3 изображения в секунду</h2></button>
      <button onclick="Test3(2)"><h2>Отправлять в базу данных кадры бегущей девочки с частотой 10 изображений в секунду</h2></button>
      <button onclick="Test3(3)"><h2>Отправлять в базу данных фото с контроллера с частотой 2 изображения в секунду</h2></button>
   </div>
   </div>
</div>
<?php

// <!-- --> ************************************************ Controller.php ***
