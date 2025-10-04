// JS/HTML5, EDGE/CHROME/YANDEX                        *** MakeSmartMenu.js ***

// ****************************************************************************
// * KwinFlat                           Вспомогательные функции для smartmenu *
// ****************************************************************************

// v1.0.3, 30.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve                               Дата создания: 17.09.2025

// ****************************************************************************
// *                Показать обработку кликов на пунктах меню                 *
// *          (здесь просто запомнить количество сделанных кликов)            *
// ****************************************************************************
function IncPosi() 
{
  var varValue=1;
  if (window.localStorage)
  {
    varValue=localStorage.getItem('smclicks');
    if (typeof varValue == "object") varValue=1;
    if (typeof varValue == "undefined") varValue=1;
    varValue=Number(varValue);
  }
  varValue=Number(varValue)+1;
  if (window.localStorage)
  {
    localStorage.setItem('smclicks',varValue);
  }
	return varValue;
}
// ****************************************************************************
// *                     Обслужить работу меню-гамбургера                     *
// ****************************************************************************
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
    // Определяем обработку по клику на пункте меню (просто демонстрация взаимодействия
    // с событиями smartmenu - здесь используется пространство имен для того,
    // чтобы отличить событие smartmenu, запускаемого внутри дерева меню, от 
    // обычного события DOM)
    $('#main-menu').on('click.smapi',function(e,item)
    {
      if (e.namespace == 'smapi')
      {
        if (this.id=="main-menu") $('#kwf').css('display','none');
        //console.log('smclicks',IncPosi());
      }
    });
    // Определяем обработку меню-гамбургера
    $(function()
    {
      var $mainMenuState = $('#main-menu-state');
      if ($mainMenuState.length)
      {
        // Анимируем меню
        $mainMenuState.change(function(e)
        {
          var $menu=$('#main-menu');
          if (this.checked)
          {
            if (this.name=="topmenu") 
            {
              $('#kwf').css('display','none');
              $('#vcotr').css('display','none');
            }     
            $menu.hide().slideDown(0,function(){$menu.css('display','');});
          } 
          else
          {
            $menu.show().slideUp(0,function(){$menu.css('display','');});
            if (this.name=="topmenu") 
            {
              $('#kwf').css('display','block');
              $('#vcotr').css('display','block');
            }
         }
        });
        // Сворачиваем меню перед уходом со страницы
        $(window).on('beforeunload',
        function()
        {
          if ($mainMenuState[0].checked) $mainMenuState[0].click();
        });
      }
    });
  }); // end ready
  return Result;
}

// ******************************************************* MakeSmartMenu.js ***

