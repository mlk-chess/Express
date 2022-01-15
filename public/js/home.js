////////////////////////////
//      MAP     //
////////////////////////////

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
        }).setContent(stations[key].Nom_Gare+'</p><br/><button onclick=\'selectDepartureStation("'+stations[key].Nom_Gare+'")\'>Gare de départ</button><br/><button onclick=\'selectArrivalStation("'+stations[key].Nom_Gare+'")\'>Gare d\'arrivée</button>');

        marker.bindPopup(popup);

        markersCluster.addLayer(marker);
    }
    map.addLayer(markersCluster);

}



////////////////////////////
//      INPUT     //
////////////////////////////


const departureStationInput = document.getElementById('departureStationInput');
const arrivalStationInput = document.getElementById('arrivalStationInput');

const listStationsDeparture = document.getElementById('listStationsDeparture');
const listStationsArrival = document.getElementById('listStationsArrival');

const departureStation = document.getElementById('departureStation');
const arrivalStation = document.getElementById('arrivalStation');

const updateDepartureStation = document.getElementById('updateDepartureStation');
const updateArrivalStation = document.getElementById('updateArrivalStation');






departureStationInput.addEventListener('keyup', function(){
    handleKeyPress(departureStationInput, listStationsDeparture, true)
});

arrivalStationInput.addEventListener('keyup', function(){
    handleKeyPress(arrivalStationInput, listStationsArrival, false)
});


departureStationInput.addEventListener('focus', function(){
    listStationsArrival.innerHTML = '';
});

arrivalStationInput.addEventListener('focus', function(){
    listStationsDeparture.innerHTML = '';
});


updateDepartureStation.addEventListener('click', function(){
    clickUpdate(updateDepartureStation, departureStation, departureStationInput);
});

updateArrivalStation.addEventListener('click', function(){
    clickUpdate(updateArrivalStation, arrivalStation, arrivalStationInput);
});





function handleKeyPress(input, list, type) {
    let html = '';

    if (input.value.length !== 0) {
        if (input.value.length % 2 === 0) {

            let regexSearch = "\^(.)*" + input.value.toLowerCase() + "(.)*\$";

            for (let key in stations) {
                if (stations[key].Nom_Gare.toLowerCase().search(regexSearch) === 0) {
                    html += "<li onclick='addStation(\""+stations[key].Nom_Gare+"\", "+type+")'>" + stations[key].Nom_Gare + "</li>";
                }
            }
            list.innerHTML = html;
        }
    }else {
        list.innerHTML = '';
    }
}

function addStation(station, type) {

    if (type){
        departureStation.innerHTML = "<p>"+station+"</p>";
        listStationsDeparture.innerHTML = '';
        departureStationInput.style.display = "none";
        updateDepartureStation.style.display = "block";
    }else {
        arrivalStation.innerHTML = "<p>"+station+"</p>";
        listStationsArrival.innerHTML = '';
        arrivalStationInput.style.display = "none";
        updateArrivalStation.style.display = "block";
    }

}


function selectDepartureStation(name){
    departureStation.innerHTML = "<p>"+name+"</p>";
    listStationsDeparture.innerHTML = '';
    departureStationInput.style.display = "none";
    updateDepartureStation.style.display = "block";
}

function selectArrivalStation(name){
    arrivalStation.innerHTML = "<p>"+name+"</p>";
    listStationsArrival.innerHTML = '';
    arrivalStationInput.style.display = "none";
    updateArrivalStation.style.display = "block";
}


function clickUpdate(update, station, input) {
    update.style.display = "none";
    station.innerHTML = '';
    input.style.display = "block";
    input.value = '';
}