let stations = [
    {"name": "Paris", "lat": 48.852969, "lon": 2.349903 },
    {"name": "Brest", "lat": 48.383, "lon": -4.500 },
    {"name": "Quimper", "lat": 48.000, "lon": -4.100 },
    {"name": "Bayonne", "lat": 43.500, "lon": -1.467 }
];


let map = L.map('map').setView([48.856614, 2.3522219], 6);



L.tileLayer('https://api.maptiler.com/maps/basic/{z}/{x}/{y}.png?key=Wh74TSnYGDH5Hqr4lM9e', {
    // Il est toujours bien de laisser le lien vers la source des données
    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
    minZoom: 1,
    maxZoom: 20
}).addTo(map);


for (let station in stations) {
    let test = L.popup({
        autoClose: false,
        closeOnEscapeKey: false,
        closeOnClick: false,
        closeButton: false,
        className: 'marker',
        maxWidth: 400
    })
        .setLatLng([stations[station].lat, stations[station].lon])
        .setContent('<p>'+stations[station].name+'<br />This is a nice popup.</p>')
        .openOn(map);

    console.log(test);



}