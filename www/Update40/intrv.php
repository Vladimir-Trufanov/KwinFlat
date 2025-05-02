<?php
?>
<div id="intrv" style="text-align:center;">
Интервалы подачи сообщений от контроллера
</div>
<div id="plans" class="clearfix">
   <div class="plan" id="border-left">
      <div class="name" onclick="onIntrv('pmode4',100,100000)" title="От 100 до 100 тысяч мсек">Режим работы Led4</div>
      <p id="pmode4" class="price">7007</p>
   </div>

   <div class="plan">
      <div class="name" onclick="onIntrv('pimg',100,100000)" title="От 100 до 100 тысяч мсек">Подача изображения</div>
      <p id="pimg" class="price">1001</p>
   </div>

   <div class="plan">
      <div class="name" onclick="onIntrv('ptempvl',100,100000)" title="От 100 до 100 тысяч мсек">Температура и влажность</div>
      <p id="ptempvl" class="price">3003</p>
   </div>

   <div class="plan">
      <div class="name" onclick="onIntrv('plight',100,100000)" title="От 100 до 100 тысяч мсек">Освещённость камеры</div>
      <p id="plight" class="price">4004</p>
   </div>

   <div class="plan">
      <div class="name" onclick="onIntrv('pbar',100,100000)" title="От 100 до 100 тысяч мсек"">Атмосферное давление</div>
      <p id="pbar" class="price">4004</p>
   </div>
</div>
<?php

