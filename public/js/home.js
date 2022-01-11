let stations;

$.ajax({
    type: 'GET',
    url: '/home/stations',
    data: '',
    success: function(data) {
        stations = JSON.parse(data);
        loadMarkers();
    },
    error: function (xhr, ajaxOptions, thrownError){
        alert(xhr.responseText);
        alert(ajaxOptions);
        alert(thrownError);
        alert(xhr.status);
    }
});



function loadMarkers(){
    let map = L.map('map').setView([46.227638, 2.213749], 6);

    L.tileLayer('https://api.maptiler.com/maps/basic/{z}/{x}/{y}.png?key=Wh74TSnYGDH5Hqr4lM9e', {
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 5,
        maxZoom: 20
    }).addTo(map);

    let markersCluster = new L.MarkerClusterGroup({
        iconCreateFunction: function(cluster) {
            return L.divIcon({
                html: cluster.getChildCount(),
                className: 'mycluster',
                iconSize: null
            });
        }
    });


    let icon = L.icon({
        iconUrl: linkAsset+'train-solid.svg',
        shadowUrl: linkAsset+'train-solid.svg',
        iconSize:     [38, 95], // size of the icon
        shadowSize:   [0, 0], // size of the shadow
        iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
        shadowAnchor: [0, 0],  // the same for the shadow
        popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });

    for (let key in stations) {

        let marker = L.marker([stations[key].Latitude, stations[key].Longitude], {icon: icon});

        let popup = L.popup({
            autoClose: true,
            closeOnEscapeKey: false,
            closeOnClick: true,
            closeButton: false,
            className: 'marker',
            maxWidth: 400
        }).setContent(stations[key].Nom_Gare+'</p><br/><button onclick="selectStation()">Choisir</button>');

        marker.bindPopup(popup);

        markersCluster.addLayer(marker);
    }
    map.addLayer(markersCluster);

}

function selectStation(){
    console.log('test');
}


const departureStation = document.getElementById('departureStation');
const listStations = document.getElementById('listStations');

departureStation.addEventListener('keyup', handleKeyPress);

function handleKeyPress(e) {
    let html = '';

    if (departureStation.value.length !== 0) {
        if (departureStation.value.length % 2 === 0) {

            let regexSearch = "\^(.)*" + departureStation.value.toLowerCase() + "(.)*\$";

            for (let key in stations) {
                if (stations[key].Nom_Gare.toLowerCase().search(regexSearch) === 0) {
                    html += "<li onclick='addStation(\""+stations[key].Nom_Gare+"\")'>" + stations[key].Nom_Gare + "</li>";
                }
            }
            listStations.innerHTML = html;
        }
    }else {
        listStations.innerHTML = '';
        console.log('dzdd');
    }
}

function addStation(station) {
    departureStation.value = station;
}