<?php namespace prown;

// PHP7/HTML5, EDGE/CHROME                                     *** regx.php ***

// ****************************************************************************
// * TPHPPROWN         Выполнить функцию preg_match_all и, при необходимости, *
// *                                                        оттрассировать ее *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  02.04.2018
// Copyright © 2018 tve                              Посл.изменение: 27.04.2018

// ****************************************************************************
// *             Определить популярные регулярные выражения PHP               *
// ****************************************************************************

// "должны быть и большие, и маленькие латинские буквы"
define ("regAaLatin",     '/(?=.*[a-z])(?=.*[A-Z])/');
// "должны быть не буквенно-цифровые символы"  
define ("regSigns",       "/[-!$%^&*(){}<>[\]'".'"|#@:;.,?+=_\/\~]/');
// "весь текст не более 17 символов фамилии-инициалов на русском языке (utf8)"
define ("regFamioUtf8",   "/^[А-Яа-яЁё\s\.-]{1,17}$/u");
define ("regFamio35Utf8", "/^[А-Яа-яЁё\s\.-]{1,35}$/u");
// "адрес электронной почты"
define ("regEmail",       "/^[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}$/i");
// "десятичное число с управляемым числом знаков после запятой"
//                        "/-*[0-9]{0,}\.*[0-9]{0,".$Dec."}/"
// "целое число в тексте"
define ("regInteger",     "/[0-9]{0,}/");

// ****************************************************************************
// *  Выполнить функцию preg_match_all, при необходимости, отттрассировать ее *
// ****************************************************************************
function regx($pattern,$text,&$matches=null,$isTrass=false)
{
    global $e_sign; global $a_err; global $a_mess;
    
    // Ошибки:
    // Warning: preg_match_all(): No ending delimiter '/' found in C:\Webservers\kwinflat-ru\www\TPHPPROWN\regx.php on line 17
    // Warning: preg_match_all(): Delimiter must not be alphanumeric or backslash in C:\Webservers\kwinflat-ru\www\TPHPPROWN\regx.php on line 20
    
    $Result=preg_match_all($pattern,$text,$imatches,PREG_OFFSET_CAPTURE);
    if (!($matches=null)) $matches=$imatches;
    if ($isTrass)
    {
        echo '<br>'.'$text: '.$text;
        echo '<br>'.'$pattern: '.$pattern;
        if ($Result==0)
        {
            echo '<br>'.'$Result=0';
        }
        else 
        {
            for ($i=0; $i<count($imatches); $i++)
		    {
                $findes=$imatches[$i];    
                for ($j=0; $j<count($findes); $j++)
                {
                    echo '<br>$findes['.$j.'] = '.
                    $findes[$j][0].' Point = '.
                    $findes[$j][1];  
                }
            }

        }
    }
    return $Result;
}
// *************************************************************** regx.php ***

