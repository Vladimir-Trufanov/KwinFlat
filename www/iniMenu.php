<?php
// PHP7/HTML5, EDGE/CHROME                                  *** iniMenu.php ***

// ****************************************************************************
// * KwinFlat                                          Отработать пункты меню *
// ****************************************************************************

// v1.0.7, 02.10.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 13.01.2019

define ("pageMapStart", "Карта отслеживания треков и загрузки GPX"); 
define ("pageMapGpx",   "Загрузка файлов .gpx"); 
define ("pageMapCtrl",  "Отслеживание координат"); 

// ****************************************************************************
// *                      Отработать пункты верхнего меню                     *
// ****************************************************************************
function TopMenu($urlHome)
{
   $Result = true;

   // Формируем кнопку гамбургера 
   echo '<input id="main-menu-state" name="topmenu" type="checkbox"/>';
   echo '<label class="main-menu-btn" for="main-menu-state">';
      echo '<span class="main-menu-btn-icon"></span>'; // Кнопка меню-гамбургера
   echo '</label>';
   // Формируем смарт-меню
   echo '<ul id="main-menu" class="sm sm-kwinflat">';
   // Переключаем пункты меню главных материалов сайта
   /*
   echo '<li>';
   echo '<a href="'.$urlHome.'/Leaflet/">'."Путешествия и достопримечательности".'</a>';
   echo '</li>';
   */
   echo '<li>';
   echo '<a href="'.$urlHome.'/Leafgpx/">'.pageMapStart.'</a>';
   echo '</li>';
   /*
   echo '<li>';
   echo '<a href="'.$urlHome.'/Ex4/">'."Ex4. Пример тайловой карты OpenStreetMap на Leaflet".'</a>';
   echo '</li>';
   */
   echo '</ul>';
   return $Result;
}

// ****************************************************************************
// *                      Отработать пункты верхнего меню                     *
// ****************************************************************************
function GpxMenu($urlHome)
{
   $Result = true;
   // Формируем кнопку гамбургера (в компьютерном варианте она скрыта)
   echo '<input id="main-menu-state" type="checkbox"/>';
   echo '<label class="main-menu-btn" for="main-menu-state">';
      echo '<span class="main-menu-btn-icon"></span>'; // Кнопка меню-гамбургера
   echo '</label>';
   // Формируем смарт-меню
   echo '<ul id="main-menu" class="sm sm-kwinflat">';
   
   // Переключаем пункты меню главных материалов сайта
   echo '<li><a href="#">'.pageMapGpx.'</a>';
   echo '<ul>';
   echo '<li><a href="'.$urlHome.'/Leafgpx/?gpx=203">Sim900 в автомобиле    [203] </a></li>';
   echo '<li><a href="'.$urlHome.'/Leafgpx/?gpx=204">Виртуальный контроллер [204] </a></li>';
   echo '</ul>';
   echo '</li>';

   echo '<li>';
   //echo '<a href="'.$urlHome.'/Leafgpx/">'."Отследить координаты".'</a>';
   echo '<li><a href="#">'.pageMapCtrl.'</a>';
   echo '<ul>';
   echo '<li><a href="'.$urlHome.'/Leafgpx/?ctrl=203">Sim900 в автомобиле    [203] </a></li>';
   echo '<li><a href="'.$urlHome.'/Leafgpx/?ctrl=204">Виртуальный контроллер [204] </a></li>';
   echo '</ul>';
   echo '</li>';

   ?>
   <!-- 
   <li><a href="#">TPhpPrown</a>
   <ul>
   <li><a href="/TPhpPrown/o-biblioteke">О библиотеке</a></li>
   <li><a href="/TPhpPrown/blok-obshchih-funkcij">CommonPrown</a></li>
   <li><a href="/TPhpPrown/sozdat-katalog-i-zadat-ego-prava">CreateRightsDir</a></li>
   </ul>
   </li>
   -->
   <?php
   
   echo '</ul>';
   return $Result;
}
// ************************************************************ iniMenu.php ***
