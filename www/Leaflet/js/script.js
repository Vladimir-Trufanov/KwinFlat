//let map = L.map('mymap').setView([19.5937, 78.9629], 5);
let map = L.map('mymap').setView([61.8021, 34.3296], 8);

let ourData = [];

// https://tiles.api-maps.yandex.ru/v1/tiles/?x=9902&y=5137&z=14&lang=ru_RU&l=map&apikey=YOUR_API_KEY
// русский


L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 20,
    minZoom: 2,
    tileSize: 512,
    zoomOffset: -1
}).addTo(map);


// https://tiles.api-maps.yandex.ru/v1/tiles/?x=9902&y=5137&z=14&lang=ru_RU&l=map&apikey=YOUR_API_KEY
/*
L.tileLayer(
  'http://vec{s}.maps.yandex.net/tiles?l=map&v=4.55.2&z={z}&x={x}&y={y}&scale=2&lang=ru_RU', {
    subdomains: ['01', '02', '03', '04'],
    attribution: '<a http="yandex.ru" target="_blank">Яндекс</a>',
    reuseTiles: true,
    updateWhenIdle: false
  }
).addTo(map);
*/

let iconOption = {
    iconUrl: './assets/location-marker.svg',
    iconSize: [30, 30]
};
let ourCustomIcon = L.icon(iconOption);

fetch("./assets/location-data.json")
    .then(response => response.json())
    .then(data => {
        ourData = data;
        for(let i=0;i<data.length;i++) {
            let option = document.createElement("option");
            option.value = i+1;
            option.text = data[i].title;
            document.querySelector(".select-dropdown").appendChild(option);

            let marker = L.marker([data[i].latitude, data[i].longitude], {icon: ourCustomIcon}).bindPopup(`<h3> ${data[i].title} </h3> <p> ${data[i].description} </p>`).on('click', () => {
                map.flyTo([data[i].latitude, data[i].longitude], data[i].zoomLevel);
            }).addTo(map);
        }
    })
    .catch(error => alert(error))

document.querySelector(".map-zoom-out-btn").addEventListener('click', () => {
    //map.flyTo([19.5937, 78.9629], 5);
    map.flyTo([61.8021, 34.3296], 8);
});

document.querySelector(".search-btn").addEventListener('click', () => {
    let select = document.querySelector(".select-dropdown");
    let value = select.options[select.selectedIndex].value;
    map.flyTo([ourData[value-1].latitude, ourData[value-1].longitude], ourData[value-1].zoomLevel);
});
