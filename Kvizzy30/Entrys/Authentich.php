<?php

// PHP7/HTML5, EDGE/CHROME                               *** Authentich.php ***

// ****************************************************************************
// * KwinFlat.ru                     Выполнить проверку пользователя и пароля *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.02.2018
// Copyright © 2018 tve                              Посл.изменение: 22.03.2018

function Authentical(&$error,$userlist,$username,$password)
{
    //echo '$userlist='.$userlist;
    if (!file_exists($userlist) || !is_readable($userlist)) 
    {
        $error = 'Вход недоступен! Пожалуйста, попробуйте позднее.';
    } 
    else 
    {
        // Считываем из файла массив зарегистрированных пользователей
        $users = file($userlist);
        // Ищем в массиве зарегистрированного пользователя и пароль
        $isFind=false;
        for ($i = 0; $i < count($users); $i++) 
        {
	        // separate each element and store in a temporary array
            $tmp = explode(', ', $users[$i]);
            // check for a matching record
            if ($tmp[0] == $username && rtrim($tmp[1]) == $password)
            {
                $isFind=true;
 	            break;
            }
        }
        if (!$isFind) 
        {
            $error = 'Неверное имя пользователя или пароль!';
        }
    }
}

// ********************************************************* Authentich.php ***
