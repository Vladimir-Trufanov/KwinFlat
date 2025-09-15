<?php
// PHP7/HTML5, EDGE/CHROME                                  *** iniMenu.php ***

// ****************************************************************************
// * KwinFlat                                          Отработать пункты меню *
// ****************************************************************************

// v1.0.3, 15.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2024 tve                               Дата создания: 13.01.2019

// ****************************************************************************
// *                      Отработать пункты верхнего меню                     *
// ****************************************************************************
function TopMenu($urlHome)
{
   $Result = true;
   // Формируем кнопку гамбургера (в компьютерном варианте она скрыта)
   echo '<input id="main-menu-state" type="checkbox"/>';
   echo '<label class="main-menu-btn" for="main-menu-state">';
      echo '<span class="main-menu-btn-icon"></span>'; // Кнопка меню-гамбургера
   echo '</label>';
   // Формируем смарт-меню
   echo '<ul id="main-menu" class="sm sm-doortry">';
   // Переключаем пункты меню главных материалов сайта

   echo '<li>';
   echo '<a href="'.$urlHome.'/Leaflet/">'."Путешествия и достопримечательности".'</a>';
   echo '</ili>';

   echo '<li>';
   echo '<a href="'.$urlHome.'/Leafgpx/">'."Отследить координаты".'</a>';
   echo '</li>';

   echo '<li>';
   echo '<a href="'.$urlHome.'/Ex1Osm/">'."Ex1Osm".'</a>';
   echo '</li>';

   echo '<li>';
   echo '<a href="'.$urlHome.'/Ex1Yandex/">'."Ex1Yandex".'</a>';
   echo '</li>';

   echo '<li>';
   echo '<a href="'.$urlHome.'/Ex4/">'."Пример тайловой карты OpenStreetMap на Leaflet".'</a>';
   echo '</li>';

   echo '<li>';
   echo '<a href="'.$urlHome.'/Ex6/">'."Показывать трек по загружаемым координатам".'</a>';
   echo '</li>';

   echo '<li>';
   echo '<a href="'.$urlHome.'/Ex7/">'."7. Показать карту с вашим местоположением".'</a>';
   echo '</li>';

   echo '<li>';
   echo '<a href="'.$urlHome.'/Ex8/">'."8. Показать карту с вашим местоположением".'</a>';
   echo '</li>';

   echo '<li>';
   echo '<a href="'.$urlHome.'/Ex9/">'."Изучить работу с тайловыми картами яндекса".'</a>';
   echo '</li>';
   
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
   echo '<ul id="main-menu" class="sm sm-doortry">';
   // Переключаем пункты меню главных материалов сайта

   echo '<li>';
   echo '<a href="'.$urlHome.'/Leaflet/">'."--Путешествия и достопримечательности".'</a>';
   echo '</ili>';

   echo '<li>';
   echo '<a href="'.$urlHome.'/Leafgpx/">'."--Отследить координаты".'</a>';
   echo '</li>';
   
   echo '</ul>';
   return $Result;
}
// ************************************************************ iniMenu.php ***
