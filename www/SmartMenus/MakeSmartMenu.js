// JavaScript Document
function IncPosi() 
{
   var varValue=1;
   //console.log('Ajaks1='+varValue);
   if (window.localStorage)
   {
      varValue=localStorage.getItem('Ajaks');
      if (typeof varValue == "object") varValue=1;
      if (typeof varValue == "undefined") varValue=1;
      varValue=Number(varValue);
   }
   //console.log('Ajaks2='+varValue);
   varValue=Number(varValue)+1;
   //console.log('Ajaks3='+varValue);
   if (window.localStorage)
   {
      localStorage.setItem('Ajaks',varValue);
   }
   //console.log('Ajaks='+varValue);
	return varValue;
}
function MakeSmartMenu()
{
   var Result=0;
   $(document).ready(function() 
   {
      // Определяем время развертывания и сворачивания меню
      $('.sm').smartmenus
      ({
         showFunction: function($ul,complete) 
         {
            $ul.slideDown(250,complete);
         },
         hideFunction: function($ul,complete) 
         {
            $ul.slideUp(250,complete);
         }
      });
      // Определяем аякс-обработку по клику на пункте меню
      $('#main-menu').on('click.smapi',function(e,item)
      {
         // check namespace if you need to differentiate from a regular DOM
         // event fired inside the menu tree
         if (e.namespace == 'smapi')
         { 
            // your handler code
            var $arr=IncPosi();
         console.log('IncPosi',$arr);
            //console.log('$arr='+$arr);
            //alert('AJAX скриптом управляется!');
            /*
            $.ajax({
               url: 'SmartMenus/save.php',
               type: 'POST',
               data: {masiv:$arr},
               error: function()
               {
                  $('#res').text("Ошибка!").fadeOut(1000);
               },
               success: function()
               {
                  $('#res').show().text("Сохранено!").fadeOut(1000);
               }
			   });
            */
         }
      });
      // Определяем обработку меню-гамбургера
      
      $(function()
      {
         var $mainMenuState = $('#main-menu-state');
         //alert('Гамбургер скриптом управляется!');
         if ($mainMenuState.length)
         {
            // animate mobile menu
            $mainMenuState.change(function(e)
            {
               var $menu=$('#main-menu');
               if (this.checked)
               {
                  $menu.hide().slideDown(250,function(){$menu.css('display','');});
               } 
               else
               {
                  $menu.show().slideUp(250,function(){$menu.css('display','');});
               }
            });
            // hide mobile menu beforeunload
            $(window).on('beforeunload unload',
            function()
            {
               if ($mainMenuState[0].checked)
               {
                  $mainMenuState[0].click();
               }
            });
         }
      });
      
   }); // end ready
   return Result;
}
