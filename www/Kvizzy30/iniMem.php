<?php 
// PHP7/HTML5, YANDEX|EDGE/CHROME                            *** iniMem.php ***

// ****************************************************************************
// * kwinflat.ru                                        Определить константы, *
// *                              проинициализировать общесайтовые переменные *
// ****************************************************************************

// v4.0, 04.10.2024                                  Автор:       Труфанов В.Е. 
// Copyright © 2019 tve                              Дата создания:  13.01.2019 

require_once "Common.php";  

// ---------------------------------- Межязыковые (PHP-JScript) определения ---
define ("RootDir",      $_SERVER['DOCUMENT_ROOT']); 
define ("RootUrl",      $_SERVER['SCRIPT_NAME']); 

define ("nstNoVyb",     "не выбрано");     
define ("nstNoNaz",     "не назначено");
define ("nstErr",       'произошла ошибка');  
define ("nstOk",        'все в порядке'); 
define ('nobase',       'Нет базы');   // Аякс-запрос базы завершился ошибкой

define ("oriLandscape", 'landscape');  // Ландшафтное расположение устройства
define ("oriPortrait",  'portrait');   // Портретное расположение устройства


// -------------- Дополнительные контроли адреса электронной почты и пароля ---
/*
define ("mEmneformat",   'Адрес email не соответствует разрешённому формату \r\n (правильно, например: tve@karelia.ru, tve58@inbox.ru)'); //   
define ("mBolee8",       "Должно быть быть более 8 символов");     
define ("mMenee21",      "Не должно быть менее 21 символа");  
define ("mNoSpace",      "Не должны содержаться пробелы"); 
define ("mNeruss",       "Не должно быть русских букв (Мы их все равно любим!)");   
define ("mNelatPropisi", "Не должно быть прописных (больших) латинских букв"); 
define ("mDalatPropisi", "Должна быть хотя бы одна прописная (большая) латинская буква");  
define ("mNumbers",      "Должны присутствовать цифры (одна или более)"); 
define ("mSpecsim",      'Должен присутствовать хотя бы один специальный символ, \r\n например из набора +-*_#@!?%&$~%^'); 
define ("mPassNoDbl",    'Пароль и его подтверждение не совпадают'); 
*/
// Объявляем переменные и константы JavaScript, соответствующие определениям в PHP
function DefineJS($SiteHost,$urlHome)
{
   // Добавляем к штатным, дополнительные контроли правильности заполнения адреса электронной почты и пароля
   // (по опыту будем их вставлять в обработчик addEventListener нежели в blur)
   /*
   $defCtrlInput=
   '<script>'.
   'const mEmneformat="'   .mEmneformat.'";'."\n".
   'const mBolee8="'       .mBolee8.'";'.
   'const mMenee21="'      .mMenee21.'";'.
   'const mNoSpace="'      .mNoSpace.'";'.
   'const mNeruss="'       .mNeruss.'";'.
   'const mNelatPropisi="' .mNelatPropisi.'";'.
   'const mDalatPropisi="' .mDalatPropisi.'";'.
   'const mNumbers="'      .mNumbers.'";'.
   'const mSpecsim="'      .mSpecsim.'";'.
   'const mPassNoDbl="'    .mPassNoDbl.'";'.
   '</script>';
   echo $defCtrlInput;
   */

   $cycle=1;   // счетчик циклов контроллера
   $sjson=' '; // последнее json-сообщение {"led33":[{"status":"inLOW"}]}

   $define=//"\n".
   '<script>'."\n".
   'nstNoVyb="'            .nstNoVyb.'";'.
   'nstNoNaz="'            .nstNoNaz.'";'.
   'nstErr="'              .nstErr.'";'.
   'nstOk="'               .nstOk.'";'.
   'nobase="'              .nobase.'";'."\n".
   'pathPhpPrown="'        .pathPhpPrown.'";'."\n".
   'pathPhpTools="'        .pathPhpTools.'";'."\n".
   'SiteHost="'            .$SiteHost.'";'."\n".
   'urlHome="'             .$urlHome.'";'."\n".
   'cycle="'               .$cycle.'";'."\n".
   'sjson="'               .$sjson.'";'."\n".
   'RootDir="'             .RootDir.'";'."\n".
   'RootUrl="'             .RootUrl.'";'."\n".
   '</script>'."\n";
   echo $define;
} 

// Инициализируем общесайтовые константы (здесь стараемся не назначать константу = 0, так как 
// проверка значению "==" может не отличить 0 от NULL)
define("articleSite",  'IttveMe');                        // тип базы данных для управления классом ArticlesMaker 
define("editdir",      'ittveEdit');                      // каталог файлов, связанных c материалом
define("stylesdir",    'Styles');                         // каталог стилей элементов разметки и фонтов
define("imgdir",       'Images');                         // каталог служебных изображений
define("jsxdir",       'Jsx');                            // каталог файлов на javascript
define("ChangeSize",   "chs");                            // "Изменить размер базового шрифта"  
define('nym',          'ittve');                          // префикс имен файлов для фотографий галереи и материалов
define('moditap',      'Изменить настройки');             // активатор тапок

/*
// ---------------------- Регулятор кукисов (порядок использования кукисов) ---
define ("rciCookiNo", 1);        // кукисов нет, выдать сообщение
define ("rciCookiNoMes", 2);     // кукисов нет, выдано сообщение
define ("rciCookiUserNo", 3);    // есть, пользователем запрещено использование
define ("rciCookiUserYes", 4);   // пользователем разрешено использование кукисов
// ---------------------------------------- Сообщения по регулятору кукисов ---
define ("mesCookiNo", 1);        // Сообщение не выводить
define ("mesCookiNoMes", 2);     // "Кукисы в Вашем браузере отключены, выполняется упрощенная версия сайта!"
define ("mesCookiUserNo", 3);    // "Разрешить использование кукисов для Вашего удобства?" 
define ("mesCookiUserYes", 4);   // Сообщение не выводить
*/

// Считаем, что iniMem отработает хорошо
$iniMem=nstOk;

// Подключаем прикладные функции TPhpPrown
/*
require_once pathPhpPrown."/getTranslit.php";
require_once pathPhpPrown."/iniConstMem.php";
*/
require_once pathPhpPrown."/MakeCookie.php";
/*
require_once pathPhpPrown."/MakeSession.php";
require_once pathPhpPrown."/ViewGlobal.php";
*/

// Выполняем запуск сессии и работу с лог-файлом
require_once pathPhpTools."/TPageStarter/PageStarterClass.php";
$oMainStarter = new PageStarter('kwinflatru','kwinflat-log');

// Подключаем внутренние классы
require_once "TTools/TKvizzyMaker/KvizzyMakerClass.php";
// Выбираем данные из браузера - UserAgent
$browseri = get_browser(null, true);
$platform = $browseri['platform'];
$browser = $browseri['browser'];
$version = $browseri['version'];
$device_type = $browseri['device_type'];

// При запросе через $UserAgent=ESP32HTTPClient
if ($UserAgent=='ESP32HTTPClient') $platform=$UserAgent;

// Пропускаем пользователя на сайт
//SiteEntry($c_UserName,$c_PersName,$c_PersMail,$c_PersPass,$c_BrowEntry,$c_PersEntry,$s_Counter);

// Определяем данные для работы с базой данных моего хозяйства 
$basename=$SiteHost.'/Base'.'/kvizzy';          // имя базы без расширения 'db3'
$email='tve58@inbox.ru';                        // email посетителя
$username='tve';                                // логин посетителя для авторизации
$password='23ety17'; 
// Подключаем объект для работы с базой данных моего хозяйства
$Kvizzy=new ttools\KvizzyMaker($basename,$username,$password);
// При необходимости создаем базу данных моего хозяйства
if (!file_exists($basename.'.db3')) 
{
   $Kvizzy->BaseFirstCreate();
}

//$Entry=new ttools\Entrying($urlHome,$basename,$username,$password,$note); 
// Меняем кукис ориентации устройства 
$c_Orient=prown\MakeCookie('Orient',oriLandscape,tStr,true);             // ориентация устройства
if (IsSet($_GET["orient"]))
{
   if ($_GET["orient"]==oriLandscape) $c_Orient=prown\MakeCookie('Orient',oriLandscape,tStr); 
   if ($_GET["orient"]==oriPortrait)  $c_Orient=prown\MakeCookie('Orient',oriPortrait,tStr); 
   if ($SiteDevice==Computer) $c_Orient=prown\MakeCookie('Orient',oriLandscape,tStr); 
}
//Moditap(moditap,$c_UserName,$c_PersName);
// Инициализируем настройки, далее они могут быть изменены
//$c_PresMode=prown\MakeCookie('PresMode',rpmOneRight,tStr,true);         // режим представления материалов

/*
//$c_isJScript=prown\MakeCookie('isJScript',7,tInt,false);               // JavaScript не включен
//$s_isJScript=prown\MakeSession('isJScript','no',tInt,false);           // JavaScript не включен
*/

/*
if ($SiteDevice==Mobile) 
{   
   $p_NewsForm=prown\MakeParm('NewsForm',frnWithImg);            // форма представления новостей
}
else
{
   $p_NewsForm=prown\MakeParm('NewsForm',frnSimple);             // форма представления новостей
}
$p_NewsAmt=prown\MakeParm('NewsAmt',8);                          // количество новостей в форме
$p_NewsView=prown\MakeParm('NewsView',true,tBool,true);          // true - разворачивать новости при загрузке
*/

// ****************************************************************************
// *                               Проверить тапы                             *
// ****************************************************************************
function Moditap($moditap,&$c_UserName,&$c_PersName)
{
   //\prown\ConsoleLog('$moditap='.$moditap);
   $tap=\prown\getComRequest('buttons');
   //\prown\ConsoleLog('$tap='.$tap);
   if ($tap<>NULL)
   {
      $domen=$_SERVER['HTTP_HOST'];
      //\prown\ConsoleLog('$domen='.$domen);
      if (($domen=='ittve.me')||($domen=='www.ittve.me')||($domen=='localhost:83'))
      {
         if ($tap==$moditap) $UserName='Гость'; else $UserName="tve"; 
         $c_UserName=prown\MakeCookie('UserName',$UserName,tStr); 
         $c_PersName=prown\MakeCookie('PersName',$UserName,tStr); 
         //\prown\ConsoleLog('$c_UserName='.$c_UserName);
      }
   }
}
// ****************************************************************************
// *                                    Пройти на сайт                        *
// ****************************************************************************
function SiteEntry(&$c_UserName,&$c_PersName,&$c_PersMail,&$c_PersPass,&$c_BrowEntry,&$c_PersEntry,&$s_Counter)
{
   // Инициируем в браузере авторизованное имя пользователя (сейчас после 2023-11-08,
   // в первой версии механизма авторизации это либо "Гость", либо email после регистрации)
   $c_UserName=prown\MakeCookie('UserName',"Гость",tStr,true); 
   // Инициируем в браузере текущего пользователя, пароль, email
   $c_PersName=prown\MakeCookie('PersName',"Гость",tStr,true); 
   $c_PersMail=prown\MakeCookie('PersMail',"username@example.com",tStr,true); 
   $c_PersPass=prown\MakeCookie('PersPass',"Гость",tStr,true);   
   // Изменяем счетчик запросов сайта из браузера и, таким образом,       
   // регистрируем новую загрузку страницы
   $c_BrowEntry=prown\MakeCookie('BrowEntry',0,tInt,true); 
   $c_BrowEntry=prown\MakeCookie('BrowEntry',$c_BrowEntry+1,tInt);  
   // Изменяем счетчик посещений текущим посетителем      
   $c_PersEntry=prown\MakeCookie('PersEntry',0,tInt,true);           
   $c_PersEntry=prown\MakeCookie('PersEntry',$c_PersEntry+1,tInt);
   // Изменяем счетчик посещений за сессию                 
   $s_Counter=prown\MakeSession('Counter',0,tInt,true);              
   $s_Counter=prown\MakeSession('Counter',$s_Counter+1,tInt);   
   // echo "Вы обновили эту страницу ".$_SESSION['Counter']." раз. ";
   // echo "<br><a href=".$_SERVER['PHP_SELF'].">обновить"; 
   // По умолчанию, выбираем параметры из кукисов
   $c_UserName=prown\MakeCookie('UserName'); 
   $c_PersName=prown\MakeCookie('PersName'); 
   $c_PersMail=prown\MakeCookie('PersMail'); 
   $c_PersPass=prown\MakeCookie('PersPass');   
   // Если после авторизации изменилось имя пользователя,
   // то перенастраиваем счетчики и посетителя
   if ($c_PersName<>$c_UserName)
   {
      $c_PersName=prown\MakeCookie('PersName',$c_UserName,tStr); 
      $c_PersEntry=prown\MakeCookie('PersEntry',1,tInt);
      $s_Counter=prown\MakeSession('Counter',1,tInt); 
   }
}

// ************************************************************* iniMem.php *** 
