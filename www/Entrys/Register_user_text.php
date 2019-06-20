<?php

// PHP7/HTML5, EDGE/CHROME                       *** Register_user_text.php ***

// ****************************************************************************
// * KwinFlat.ru                  Выполнить контроль регистрации пользователя *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.02.2018
// Copyright © 2018 tve                              Посл.изменение: 21.03.2018

function Register_user_text(&$errors,$username,$password,$retyped,$userfile)
{
	$result = "Регистрация пользователя не выполнена!";
    // Определяем длину минимального имени
    $usernameMinChars = 5;
    // Готовим массив сообщений об ошибках
    $errors = array();
    if (strlen($username) < $usernameMinChars) 
    {
        $errors[] = "Имя пользователя должно содержать не менее $usernameMinChars символов!";
    }
    if (\prown\regx('/\s/',$username)) 
    {
        $errors[] = 'Имя пользователя не должно содержать пробелов!';
    }
    // Задаем ограничения на пароль
    $checkPwd = new Ps2_CheckPassword($password,8); // минимум 8 знаков
    $checkPwd->requireMixedCase();
    $checkPwd->requireNumbers(2);                   // минимум 2 цифры
    $checkPwd->requireSymbols();                    // минимум 1 буква
    // 
    $passwordOK = $checkPwd->check();
    if (!$passwordOK) 
    {
        $errors = array_merge($errors, $checkPwd->getErrors());
    }
    if ($password != $retyped) 
    {
        $errors[] = "Повторный пароль не соответствует первоначальному!";
    }
    if (!$errors) 
    {
        // Шифруем пароль, используя имя пользователя, как соль
        $password = sha1($username.$password);
        // Открываем файл в режиме добавления в конце
        $file = fopen($userfile,'a+');
        // Если размер файла нулевой, то сразу записываем имя пользователя и 
        // зашифрованный пароль
        if (filesize($userfile) === 0) 
        {
            fwrite($file,"$username, $password");
	        $result = "Пользователь $username зарегистрирован!";
        } 
        else 
        // Если размер файла больше нуля, то вначале будем проверять имя 
        // пользователя, переместив указатель в начало файла
        {
            $isFind=false;
            rewind($file);
            // Построчно просматриваем файл, пытаемся определить,
            // что пользователь уже зарегистрирован
            while (!feof($file)) 
            {
                $line = fgets($file);
	            // split line at comma, and check first element against username
	            $tmp = explode(', ', $line);
                // echo '<br>$line='.$line.' $username='.$username.' $tmp[0]='.$tmp[0];
	            if ($tmp[0] == $username) 
                {
                    $errors[] = "Пользователь $username уже зарегистрирован, выберите другое имя!";
                    $isFind=true;
	                break;
	            }
	        }
            // Если пользователь не найден, регистрируем нового пользователя
            if (!$isFind) 
            {
	            fwrite($file, PHP_EOL."$username, $password");
	            $result = "Пользователь $username зарегистрирован!";
            }
            fclose($file);
        }
    }
    return $result;
}

// ************************************************* Register_user_text.php ***
