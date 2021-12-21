$.ajax({
    type: 'GET',
    url: '/home/stations',
    data: '',
    success: function(data) {
        loadMarkers(JSON.parse(data));
    },
    error: function (xhr, ajaxOptions, thrownError){
        alert(xhr.responseText);
        alert(ajaxOptions);
        alert(thrownError);
        alert(xhr.status);
    }
});



function loadMarkers(stations){
    let map = L.map('map').setView([48.856614, 2.3522219], 6);

    L.tileLayer('https://api.maptiler.com/maps/basic/{z}/{x}/{y}.png?key=Wh74TSnYGDH5Hqr4lM9e', {
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20
    }).addTo(map);


    for (let key in stations) {

        L.popup({
            autoClose: false,
            closeOnEscapeKey: false,
            closeOnClick: false,
            closeButton: false,
            className: 'marker',
            maxWidth: 400
        })
            .setLatLng([stations[key].Latitude, stations[key].Longitude])
            .setContent('<i class="fas fa-train"></i><br/><p>'+stations[key].Nom_Gare+'</p><br/><button onclick="selectStation()">Choisir</button>')
            .openOn(map);
    }
}

function selectStation(){
    console.log('test');
}