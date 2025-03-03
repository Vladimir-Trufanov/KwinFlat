<?php
// PHP7/HTML5, EDGE/CHROME                                    *** index.php ***

// ****************************************************************************
// *                     По XMLHttpRequest заменить одно изображение (клиент) *
// ****************************************************************************

// v1.0.1, 03.03.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2016 tve                               Дата создания: 03.03.2025

?>

<!DOCTYPE html>
<!-- 
Яндекс запрос "как на js менять изображение через пол секунды"
-->
<html>
   <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Заменить изображение в потоке</title>
      <script type = "text/javascript">
      function displayNextImage() 
      {
         x = (x === images.length - 1) ? 0 : x + 1;
         document.getElementById("img").src = images[x];
      }
      function displayPreviousImage() 
      {
         x = (x <= 0) ? images.length - 1 : x - 1;
         document.getElementById("img").src = images[x];
      }
      function startTimer() 
      {
         setInterval(displayNextImage, 50);
      }
      var images = [], x = -1;
      images[0]  = "imgs/run1.png";
      images[1]  = "imgs/run2.png";
      images[2]  = "imgs/run3.png";
      images[3]  = "imgs/run4.png";
      images[4]  = "imgs/run5.png";
      images[5]  = "imgs/run6.png";
      images[6]  = "imgs/run7.png";
      images[7]  = "imgs/run8.png";
      images[8]  = "imgs/run9.png";
      images[9]  = "imgs/run10.png";
      images[10] = "imgs/run11.png";
      images[11] = "imgs/run12.png";
      images[12] = "imgs/run13.png";
      images[13] = "imgs/run14.png";
      images[14] = "imgs/run15.png";
      images[15] = "imgs/run16.png";
      images[16] = "imgs/run17.png";
      images[17] = "imgs/run18.png";
      images[18] = "imgs/run19.png";
      images[19] = "imgs/run20.png";
          
      function runMultipart() 
      {
           var req = new XMLHttpRequest();
           // асинхронный запрос
           req.open("GET","multipart4.php?r="+Math.random(), true);
           req.onload = function(event) 
           {
              console.log('Запрос загружен!');
              var result = event.target.responseText;
              //console.log("Place: ", elem.innerText); 
              //var elem = document.getElementById("Place");
              //elem.innerText=result;
              
              
              //let json = JSON.stringify(result);
              //alert(json);
              
              user = JSON.parse(result);
              //alert(user.img[0]); 
              //alert(user.img[1]); 
              let num = document.getElementById('Place');
              num.innerText=user.img[0];




              let elem = document.getElementById('img2');
              //elem.setAttribute('src', result);
              elem.setAttribute('src',user.img[1]);
              
              
              /*
              var result = event.target.responseText
              var d = document.createElement("div")
              d.innerHTML = "onload:"+result;
              document.getElementById('xhr_multipart_dump1').appendChild(d)
              */
           }
           req.onreadystatechange = function() 
           {
              //console.log('Состояние изменилось!');
              /*
              if (req.readyState!=4) return
              var d = document.createElement("div")
              d.innerHTML = "State:"+req.readyState+' Status:'+req.status
              document.getElementById('xhr_multipart_dump1').appendChild(d)
              */
           }
           req.send(null);
           console.log('Всем привет!');
      }
      </script>
   </head>
   <body onload = "startTimer()">
      <p><img id="img" src="imgs/run20.png"/></p>
      <!-- 
      <button type="button" onclick="displayPreviousImage()">Previous</button>
      <button type="button" onclick="displayNextImage()">Next</button>
      -->
      <p>
      <img id="img2" src="data:image/jpeg;base64,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">
      </p>
      <p id="Place">Место ответа</p>
      <p><input onclick="runMultipart()" value="Запустить miltipart-запрос" type="button" /></p>
      <p><img src="test.jpg"></p>

<?php

/*
$json = json_encode(
    array(
        1 => array(
            'English' => array(
                'One',
                'January'
            ),
            'French' => array(
                'Une',
                'Janvier'
            )
        )
    )
);
*/

/*
$num=8; $src="data:image/jpeg;base64,Janvier";
$json = json_encode(array(
   'img' => array
   (
     8,
     'data:image/jpeg;base64,Janvier'
   )
));
echo  $json;
*/

?>
      
   </body>
</html>
<?php

// <!-- --> ***************************************************** index.php ***

