// JS/HTML5, EDGE/CHROME/YANDEX                               *** gpoint.js ***

// ****************************************************************************
// * KwinFlat/Leaflet  Сгенерировать точки трека для демонстрации трассировки *
// ****************************************************************************

// v1.0.2, 20.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 17.09.2025

// ****************************************************************************
// *                Построить начальный треугольник и отрезок                 *
// ****************************************************************************
function MakeTriangleAndLine()
{
  // Формируем координаты и строим начальный треугольник
  latlngs = [
     [61.846308, 33.206584],
     [61.934839, 33.655948],
     [61.833141, 32.929247],
     [61.846308, 33.206584]
  ];
  var polyline = L.polyline(latlngs, {color: 'red'});
  polyline.addTo(map);
  
  // Строим отрезок
  latold=61.846308;
  lonold=33.206584;
  latcur=61.856308;
  loncur=33.216584;
  latlngs = [[latold,lonold],[latcur,loncur]];
  polyline = L.polyline(latlngs, {color: 'white'});
  polyline.addTo(map);
}
// ****************************************************************************
// *                              Генерировать точки трека                    *
// ****************************************************************************
function genPoint(itrk)
{
  //console.log(itrk); 
  let delta=0.03000;
  let ddelta=0.01;
  if (itrk<25)
  {
    //let delta=0.03000;
    let remainder = itrk % 5;
    if (remainder==1)
    {
      latcur=latcur+delta;
      loncur=loncur+delta;
      ccolor='green';
    }
    else if (remainder==2)
    {
      latcur=latcur+delta;
      ccolor='yellow';
    }
    else if (remainder==3)
    {
      latcur=latcur-delta;
      loncur=loncur-delta;
      ccolor='black';
    }
    else if (remainder==4)
    {
      latcur=latcur-delta;
      ccolor='red';
    }
    else if (remainder==0)
    {
      loncur=loncur+delta*2;
      ccolor='white';
    }
  }
  else if (itrk==25)
  {
    latcur=61.846308;
    loncur=33.206584;
    ccolor='white';
  }
  // Вычерчиваем бесконечную спираль
  else
  {
    ccolor='blue';
    inew=itrk-26;
    // Определяем длину линии по номеру "витка спирали"
    nVitoc=(Math.floor(inew/4)+1)*ddelta;
    // Определяем шаг в витке спирали
    nStep=(inew % 4);
    // Выводим шаги витков спирали
    console.log('nVitoc='+nVitoc); 
    console.log('nStep='+nStep); 
    console.log(' '); 
    if (nStep==0)
    {
      loncur=loncur-nVitoc;
      latcur=latcur-nVitoc;
      //latcur=latcur-nVitoc;
      //loncur=loncur-nVitoc;
    }
    else if (nStep==1)
    {
      loncur=loncur-nVitoc;
      latcur=latcur+nVitoc;
      //latcur=latcur+nVitoc+nVitoc;       
      //loncur=loncur-nVitoc-nVitoc;
    }
    else if (nStep==2)
    {
      loncur=loncur+nVitoc+ddelta;
      latcur=latcur+nVitoc;
      //loncur=loncur+nVitoc+nVitoc;
    }
    else if (nStep==3)
    {
      loncur=loncur+nVitoc;
      latcur=latcur-nVitoc;
      //latcur=latcur-nVitoc;
      //loncur=loncur+nVitoc;
    }
  }
}

// ************************************************************** gpoint.js ***
