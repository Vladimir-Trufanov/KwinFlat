// JS/HTML5, EDGE/CHROME/YANDEX                               *** gpoint.js ***

// ****************************************************************************
// * KwinFlat/Leaflet  Сгенерировать точки трека для демонстрации трассировки *
// ****************************************************************************

// v1.0.3, 21.09.2025                                 Автор:      Труфанов В.Е.
// Copyright © 2025 tve       sla6en9edged            Дата создания: 17.09.2025

function GenTrkpt(itrk)
{
  let delta=0.03000;
  let latdelta=0.01;
  let londelta=0.02;
  ccolor='red';

  // Генерируем начальную точку
  // 'Эссойла, ул.Школьная, 3'
  if (itrk==-4) 
  {
    latcur=61.846308;
    loncur=33.206584;
  }
  // Генерируем вторую точку первой линии треугольника
  // 'СНТ Геолог, 98'
  else if (itrk==-3) 
  {
    latcur=61.934839;
    loncur=33.655948;
  }
  // Для второй линии треугольника
  // 'Новые пески, ул.Центральная, 13'
  else if (itrk==-2) 
  {
    latcur=61.833141;
    loncur=32.929247;
  }
  // Для третьей линии треугольника
  else if (itrk==-1) 
  {
    latcur=61.846308;
    loncur=33.206584;
  }
  // Для начального отрезка
  else if (itrk==0) 
  {
    latcur=61.856308;
    loncur=33.216584;
    ccolor='white';
  }
  else if (itrk<25)
  {
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
    lonVitoc=(Math.floor(inew/4)+1)*londelta;
    latVitoc=(Math.floor(inew/4)+1)*latdelta;
    // Определяем шаг в витке спирали
    nStep=(inew % 4);
    // Выводим шаги витков спирали
    console.log('itrk='+itrk,'latVitoc='+latVitoc,'lonVitoc='+lonVitoc,'nStep='+nStep); 
    if (nStep==0)
    {
      loncur=loncur-lonVitoc;
      latcur=latcur-latVitoc;
    }
    else if (nStep==1)
    {
      loncur=loncur-lonVitoc;
      latcur=latcur+latVitoc;
    }
    else if (nStep==2)
    {
      loncur=loncur+lonVitoc+londelta;
      latcur=latcur+latVitoc;
    }
    else if (nStep==3)
    {
      loncur=loncur+lonVitoc;
      latcur=latcur-latVitoc;
    }
  }
}

// ************************************************************** gpoint.js ***
