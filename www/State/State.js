/**
 * State.js v1.0.0, 2025.01.07
 * Copyright © 2025 tve; Licensed MIT 
**/

$(document).ready(function() 
{
   onProba();
});
 
function onProba()
{
   console.log("onProba");
   const params = new URLSearchParams(window.location.search);
   params.forEach((value, key) => 
   {
      console.log(key, value);  // Выводит ключи и соответствующие им значения каждого параметра
   });
} 


