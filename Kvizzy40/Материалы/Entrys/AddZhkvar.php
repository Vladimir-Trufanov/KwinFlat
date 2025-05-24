<?php

// PHP7/HTML5, EDGE/CHROME                                *** AddZhkvar.php ***

// ****************************************************************************
// * KwinFlat.ru                            Ввести новую запись о проживающих *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.02.2018
// Copyright © 2018 tve                              Посл.изменение: 29.03.2018
?>
<!--  -->
<div id=\"AddZhkvar\">
<h2>Внести новую запись о проживающих</h2>
<form class="contact_form" action="" method="post" name="contact_form">
    <ul>
    <li>
        <span class="required_notification">* Обязательные для заполнения поля</span>
    </li>
    <li>
       <label for="famio">Фамилия И.О.</label>
       <input type="text" name="famio" id="famio" 
            pattern="^[А-Яа-яЁё\s\.-]{1,17}" 
            placeholder="Иванов И.И." required 
        />
        <span class="form_hint">не более 17 символов</span>
    </li>
	<li>
        <label for="lgokat">Категория льготы</label>
        <select name="lgokat" id="lgokat" placeholder="1, Без льготы" required>
        <?php
        // Указываем массив льготных категорий
        global $aLgokat;
        foreach ($aLgokat as $row) 
        {
            echo "<option>".$row['Inkat'].', '.$row['Namekat']."</option>";
        }
        ?>
        </select>
        <span class="form_hint">выбрать из справочника</span>
    </li>
	<li class="notific" data-title="По категориям льгот, действующим на семью">
        <label for="kolvo">Членов семьи</label>
        <input type="text" name="kolvo" id="kolvo" placeholder="1"/>
            <span class="form_hint">по умолчанию 1</span>
    </li>
    <li>
        <button class="submit" type="submit">Внести</button>
    </li>
    </ul>
</form>
</div> 
<?php
// ********************************************************** AddZhkvar.php ***
