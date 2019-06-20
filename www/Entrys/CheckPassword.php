<?php

// PHP7/HTML5, EDGE/CHROME                            *** CheckPassword.php ***

// ****************************************************************************
// * KwinFlat.ru                                Проверить пароль пользователя *
// ****************************************************************************

//                                           Авторы: David Powers,Труфанов В.Е.
//                                           Дата создания:          24.02.2012
// Copyright © 2018 tve                      Посл.изменение:         21.03.2018


class Ps2_CheckPassword
{
    protected $_password;
    protected $_minimumChars;
    protected $_mixedCase = false;
    protected $_minimumNumbers = 0;
    protected $_minimumSymbols = 0;
    protected $_errors = array();      // массив сообщений об ошибках

    public function __construct($password, $minimumChars = 8) 
    {
        $this->_password = $password;
	    $this->_minimumChars = $minimumChars;
    }

    public function requireMixedCase() 
    {
	    $this->_mixedCase = true;
    }
  
    public function requireNumbers($num=1) 
    {
	    if (is_numeric($num) && $num > 0) 
        {
	       $this->_minimumNumbers = (int) $num; 
	    }
    }
  
    public function requireSymbols($num = 1) 
    {
        if (is_numeric($num) && $num > 0) 
        {
            $this->_minimumSymbols = (int) $num; 
	    }
    }

    public function check() 
    {
        if (\prown\regx('/\s/', $this->_password)) 
        {
            $this->_errors[] = 'Пароль не может содержать пробелов!';	
        }
        if (strlen($this->_password) < $this->_minimumChars) 
        {
	        $this->_errors[] = "Пароль не должен содержать менее $this->_minimumChars символов!";
        } 
	    if ($this->_mixedCase) 
        {
	        $pattern = regAaLatin; // '/(?=.*[a-z])(?=.*[A-Z])/';
	        if (!\prown\regx($pattern, $this->_password)) 
            {
		        $this->_errors[] = 'Пароль должен включать большие и маленькие латинские буквы!';
	        }
	    }
        if ($this->_minimumNumbers) 
        {
            $pattern = '/\d/';
            $found = \prown\regx($pattern, $this->_password, $matches);
            if ($found < $this->_minimumNumbers) 
            {
                $this->_errors[] = "Пароль не должен содержать менее $this->_minimumNumbers цифр!";
            }
        }
        if ($this->_minimumSymbols) 
        {
            $pattern = regSigns; // "/[-!$%^&*(){}<>[\]'".'"|#@:;.,?+=_\/\~]/'
            $found = \prown\regx($pattern, $this->_password, $matches);
            if ($found < $this->_minimumSymbols) 
            {
                $this->_errors[] = "Пароль должен включать не буквенно-цифровые ".
                "символы, не менее $this->_minimumSymbols!"; 
	        }
        }
	    return $this->_errors ? false : true;
    }

    public function getErrors() 
    {
	    return $this->_errors; 
    }
}

// ****************************************************** CheckPassword.php ***
