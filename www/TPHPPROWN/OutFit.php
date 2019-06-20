<?php namespace prown;

// PHP7/HTML5, EDGE/CHROME                                   *** OutFit.php ***

// ****************************************************************************
// * TPHPPROWN    Произвести установки общих констант и переменных библиотеки *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  26.02.2018
// Copyright © 2018 tve                              Посл.изменение: 06.04.2018

// Константы-определения типов переменных 
define ("tarr",        "array");    
define ("tobj",        "object");    
define ("tint",        "integer");    
define ("tfloat",      "double");    
define ("tstr",        "string");    
define ("tbool",       "boolean");    
define ("tnull",       "null");    


function MakeType($Value,$Type)
{
    if ($Type==tint) 
    {
        $Result=intval($Value);
    }
    elseif ($Type==tfloat) 
    {
        $Result=floatval($Value);
    }
    elseif ($Type==tstr) 
    {
        $Result=strval($Value);
    }
    else $Result=null;
    return $Result;
}


// ************************************************************* OutFit.php *** 

