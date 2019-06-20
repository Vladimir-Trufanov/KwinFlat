<?php
require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/regx.php";

/*
echo '<br>'.'--- 1 -----------------------------------------------------------';
$text = 'abcdefghijklmnopqrstuvwxyz0mno123456789';
$pattern = "|mno|";
echo '<br>'.preg_match($pattern,$text,$matches);
for ($i=0; $i<count($matches); $i++)
{
    echo '<br>$matches: '.$matches[$i];    
}   

echo '<br>'.preg_match_all($pattern,$text,$matches,PREG_PATTERN_ORDER);
for ($i=0; $i<count($matches); $i++)
{
    $findes=$matches[$i]; 
    for ($j=0; $j<count($findes); $j++)
    {
        echo '<br>$findes['.$j.'] = '.$findes[$j];  
    }  
}   

echo '<br>'.preg_match_all($pattern,$text,$matches, PREG_OFFSET_CAPTURE);
for ($i=0; $i<count($matches); $i++)
{
    $findes=$matches[$i]; 
    for ($j=0; $j<count($findes); $j++)
    {
        echo '<br>$findes['.$j.'] = '.$findes[$j][0].' Point = '.$findes[$j][1];  
    }  
}   

echo '<br>'.'--- 2 -----------------------------------------------------------';
echo '<br>'.\prown\regx($pattern,$text,$matches,true);    

echo '<br>'.'--- 3 --- "должны быть и большие, и маленькие латинские буквы"';
$text = 'ab12cdefghijklmnopqrstuvwxyz0mno12A3456789';
$pattern = regAaLatin; // '/(?=.*[a-z])(?=.*[A-Z])/'
//$pattern = '/\d(?=[a-z])/';
echo '<br>'.\prown\regx($pattern,$text,$matches,true);    

echo '<br>'.'--- 4 --- "две цифры"';
$text = 'ab12cdefghijklmnopqrstuvwxyz0mno12A3456789';
$pattern = '/\d\d/';
echo '<br>'.\prown\regx($pattern,$text,$matches,true);    
*/
echo '<br>'.'--- 5 --- "буквенно-цифровые символы"';
$text = 'ab12';
$pattern = "/[-!$%^&*(){}<>[\]'" . '"|#@:;.,?+=_\/\~]/';
echo '<br>'.\prown\regx($pattern,$text,$matches,true);    

echo '<br>'.'--- 6 --- "весь текст не более 17 символов фамилии-инициалов на русском языке (utf8)"';
$text = 'Труф-анов В.Е.';
$pattern = "/^[А-Яа-яЁё\s\.-]{1,17}$/u";
echo '<br>'.\prown\regx($pattern,$text,$matches,true);    
