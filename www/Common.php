<?php                                           
// PHP7/HTML5, EDGE/CHROME                                   *** Common.php ***

// ****************************************************************************
// * KwinFlat.ru                                    Блок общесайтовых функций *
// ****************************************************************************

// v2.0.1, 19.01.2025                                  Автор:       Труфанов В.Е. 
// Copyright © 2019 tve                              Дата создания:  05.03.2019 


// UnlinkFile($filename)                                                        - Проверить существование и удалить файл из файловой системы
// -----CreateTables($pdo,$aCharters)                                           - Создать таблицы базы данных и выполнить начальное заполнение  

// ****************************************************************************
// *          Проверить существование и удалить файл из файловой системы      *
// *         (используется в случаях, когда необходимо перезаполнить файл)    *
// ****************************************************************************
function UnlinkFile($filename)
{
   if (file_exists($filename)) 
   {
      if (!unlink($filename))
      {
         // Для файла базы данных выводится сообщение о неудачном удалении 
         // в случаях:
         //    а) база данных подключена к стороннему приложению;
         //    б) база данных еще привязана к другому объекту класса;
         //    в) прочее
         throw new Exception("Не удалось удалить файл $filename!");
      } 
   } 
}

/*
// ****************************************************************************
// *       Проверить соответствие запроса разрешенной команде управления      *
// ****************************************************************************
// -------------------------------------------- Запросы для меню управления ---
define ('mmlVernutsyaNaGlavnuyu',        'vernutsya-na-glavnuyu-stranicu');      // 4
define ('mmlOtpravitAvtoruSoobshchenie', 'otpravit-avtoru-soobshchenie');        // 5 из главной
define ('mmlVojti',                      'vojti');                               // 6 из главной
define ('mmlIzmenitNastrojkiSajta',      'prochitat-o-sajte-izmenit-nastrojki'); // 7 из 3    

// -- Значения параметра enMode URL-запросов для этапов ввода и регистрации ---
//                                        NULL                               //  Выполнить ввод email и пароля (зарегистрироваться)
define ('entPropustit',                  'propustit');                       //  Пропустить на сайт, как гостя
define ('entProverit',                   'proverit');                        //  Проверить пароль и email
define ('entZamenit',                    'zamenit');                         //  Заменить пароль
define ('entZaregistrirovatsya',         'zaregistrirovatsya');              //  Ввести регистрационные данные перед проверкой почты
define ('entPodtverdit',                 'podtverdit');                      //  Подтвердить регистрацию, пропустить на сайт c email и паролем
define ('entOtpravitPismo',              'otpravit-pismo');                  //  Отправить письмо для подтверждения регистрации
define ('entPoSsylkeIzPisma',            'po-ssylke-iz-pisma');              //  По ссылке из письма пропустить на сайт c email и паролем

define('tstEmailNeNajden',      'Адрес электронной почты не зарегистрирован'); 
define('tstParolNevernyj',      'Пароль неверный');                   
define('tstEmailParolVerny',    'Пароль и email верны');  
define('tstErr',                'Произошла ошибка');  
define('tst396',                '396: Ошибка начального состояния');  

function DefEmailPass()
{
   $actEmailPass=
   '<script>'.
      'entPropustit="'          .entPropustit.'";'.
      'entProverit="'           .entProverit.'";'.
      'entZamenit="'            .entZamenit.'";'.
      'entZaregistrirovatsya="' .entZaregistrirovatsya.'";'.
      'entPodtverdit="'         .entPodtverdit.'";'.
      'entOtpravitPismo="'      .entOtpravitPismo.'";'.
   '</script>';
   echo $actEmailPass;

   $tstEmailPass=
   '<script>'.
      'tstEmailNeNajden="'      .tstEmailNeNajden.'";'.
      'tstParolNevernyj="'      .tstParolNevernyj.'";'.
      'tstEmailParolVerny="'    .tstEmailParolVerny.'";'.
      'tstErr="'                .tstErr.'";'.
      'tst396="'                .tst396.'";'.
   '</script>';
   echo $tstEmailPass;
}
/*
// ---------------------------------------- Результат проверки URI страницы ---
define ('xUriOk',      1);   // URI соответствует запросу для тестирования
define ('xUriNoslash', 2);   // в URI нет первого слэша
define ('xUriMain',    3);   // в URI только 1 слэш - выход на главную страницу
define ('xUriNo',      4);   // URI неправильный
define ('xUriReal',    5);   // URI является разрешенной командой

function testComRequest($mml) 
{
   $Result=xUriNo;
   // Определяем массив запросов для меню управления
   $aLeadRequest=[
      mmlVybratSledMaterial,mmlVernutsyaPredState,mmlZhiznIputeshestviya,mmlVernutsyaNaGlavnuyu,
      mmlOtpravitAvtoruSoobshchenie,mmlVojti,
      mmlIzmenitNastrojkiSajta,mmlSozdatRedaktirovat,mmlIzmenitNazvanieIkonku,
      mmlDobavitNovyjRazdel,mmlUdalitRazdelMaterialov,mmlVybratStatyuRedakti,
      mmlNaznachitStatyu,mmlUdalitMaterial]; 
   // Выбираем URI, который был предоставлен для доступа к этой странице; 
   // например, '/index.html' или '/zhizn-i-puteshestviya'.
   $inUri=$_SERVER["REQUEST_URI"];
   $slash=substr($inUri,0,1);
   if ($slash<>'/')
      $Result=xUriNoslash;
   else
   {
      // Выбираем все, что после слэша, может это соответствует запросу
      $xUri=substr($inUri,1);
      // Проверяем Uri на соответствие разрешенной команде
      foreach ($aLeadRequest as $val) 
      {
         if ($val==$xUri)
         {
            $Result=xUriReal;
            break;
         }
      }
      // Проверяем Uri на соответствие тесту
      if ($Result==xUriReal)
      {
         if ($xUri==$mml) $Result=xUriOk;
      }
   }
   return $Result;
}
// ****************************************************************************
// *                       Определить работаем ли на сайте                    *
// ****************************************************************************
function isIttveme()
{
   $Result=false;
   if ($_SERVER['HTTP_HOST']=='kwinflat.ru') $Result=true;
   return $Result;
}
// ****************************************************************************
// *                      Определить работаем ли на хостинге                  *
// ****************************************************************************
function isNichost()
{ 
   $Result=false;
   if (
     ($_SERVER['HTTP_HOST']=='kwinflat.ru')||
     ($_SERVER['HTTP_HOST']=='www.kwinflat.ru')||
     ($_SERVER['HTTP_HOST']=='kwinflatht.nichost.ru'))
   {
      $Result=true;
   }
   return $Result;
}
// ****************************************************************************
// *                      Изменить и восстановить пароль                      *
// ****************************************************************************
define ('fimPassi','tve_openssl_random_pseudo_bytesx');
function setModiPass($original,&$passiv,&$iv)
{
   $iv = openssl_random_pseudo_bytes(16);                                               
   $passiv = openssl_encrypt($original,"aes-256-cbc",fimPassi,OPENSSL_RAW_DATA,$iv); 
}
function getModiPass(&$original,$passiv,$iv)
{
   $original = openssl_decrypt($passiv,"aes-256-cbc",fimPassi,OPENSSL_RAW_DATA,$iv);
}

// ****************************************************************************
// *                 Послать заголовок с настройкой на HTTPS                  *
// ****************************************************************************
function Headeri($page)
{
    if ($_SERVER['HTTP_HOST']=='kwinflat.ru')
    {
        //echo "Location: https://".$_SERVER['HTTP_HOST'].$page;
        Header("Location: https://".$_SERVER['HTTP_HOST'].$page);
    }
    else 
    {
        //echo "Location: http://".$_SERVER['HTTP_HOST'].$page;
        Header("Location: http://".$_SERVER['HTTP_HOST'].$page);
    }
}
*/

// ************************************************************* Common.php *** 
