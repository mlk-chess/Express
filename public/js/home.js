let counterTraveler = 1;

////////////////////////////
//      MAP     //
////////////////////////////

let stations;

$.ajax({
    type: 'GET',
    url: '/stations',
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
        }).setContent('<h5>'+stations[key].Nom_Gare+'</h5><br/><button class="btn btn-primary mb-3" onclick=\'selectDepartureStation("'+stations[key].Nom_Gare+'")\'>Gare de départ</button><br/><button class="btn btn-primary" onclick=\'selectArrivalStation("'+stations[key].Nom_Gare+'")\'>Gare d\'arrivée</button>');

        marker.bindPopup(popup);

        markersCluster.addLayer(marker);
    }
    map.addLayer(markersCluster);

}



////////////////////////////
//      INPUT     //
////////////////////////////


const departureStationSearch = document.getElementById('departureStationSearch');
const arrivalStationSearch = document.getElementById('arrivalStationSearch');

const departureStationInput = document.getElementById('home_departureStationInput');
const arrivalStationInput = document.getElementById('home_arrivalStationInput');

const listStationsDeparture = document.getElementById('listStationsDeparture');
const listStationsArrival = document.getElementById('listStationsArrival');

const departureStation = document.getElementById('departureStation');
const arrivalStation = document.getElementById('arrivalStation');

const updateDepartureStation = document.getElementById('updateDepartureStation');
const updateArrivalStation = document.getElementById('updateArrivalStation');


$(window).click(function() {
    listStationsDeparture.innerHTML = '';
    listStationsArrival.innerHTML = '';
});

$("#listStationsDeparture").click(function(event){
    event.stopPropagation();
});

$("#listStationsArrival").click(function(event){
    event.stopPropagation();
});



departureStationSearch.addEventListener('keyup', function(){
    handleKeyPress(departureStationSearch, listStationsDeparture, true)
});

arrivalStationSearch.addEventListener('keyup', function(){
    handleKeyPress(arrivalStationSearch, listStationsArrival, false)
});


departureStationSearch.addEventListener('focus', function(){
    listStationsArrival.innerHTML = '';
});

arrivalStationSearch.addEventListener('focus', function(){
    listStationsDeparture.innerHTML = '';
});


updateDepartureStation.addEventListener('click', function(){
    clickUpdate(updateDepartureStation, departureStation, departureStationSearch, departureStationInput);
});

updateArrivalStation.addEventListener('click', function(){
    clickUpdate(updateArrivalStation, arrivalStation, arrivalStationSearch, arrivalStationInput);
});





function handleKeyPress(input, list, type) {
    let html = '';

    if (input.value.length !== 0) {
        if (input.value.length % 2 === 0) {

            let regexSearch = "\^(.)*" + input.value.toLowerCase() + "(.)*\$";

            for (let key in stations) {
                if (stations[key].Nom_Gare.toLowerCase().search(regexSearch) === 0) {
                    html += "<li class='list-group-item' onclick='addStation(\""+stations[key].Nom_Gare+"\", "+type+")'>" + stations[key].Nom_Gare + "</li>";
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
        $("#departureStation").append('<p class="form-control">'+station+' </p>');
        departureStationInput.value = station
        listStationsDeparture.innerHTML = '';
        departureStationSearch.style.display = "none";
        updateDepartureStation.style.display = "block";
    }else {
        $("#arrivalStation").append('<p class="form-control">'+station+' </p>');
        arrivalStationInput.value = station
        listStationsArrival.innerHTML = '';
        arrivalStationSearch.style.display = "none";
        updateArrivalStation.style.display = "block";
    }

}


function selectDepartureStation(name){
    $("#departureStation").append('<p class="form-control">'+name+' </p>');
    departureStationInput.value = name;
    listStationsDeparture.innerHTML = '';
    departureStationSearch.style.display = "none";
    updateDepartureStation.style.display = "block";
}

function selectArrivalStation(name){
    $("#arrivalStation").append('<p class="form-control">'+name+' </p>');
    arrivalStationInput.value = name;
    listStationsArrival.innerHTML = '';
    arrivalStationSearch.style.display = "none";
    updateArrivalStation.style.display = "block";
}


function clickUpdate(update, station, search, input) {
    update.style.display = "none";
    station.innerHTML = '';
    search.style.display = "block";
    search.value = '';
    input.value = '';
}


////////////////////////////
//      OPTIONS     //
////////////////////////////

function selectOption(id, classWagon, price, dateDeparture, dateArrival, departure, arrival) {
    counterTraveler = 1;

    $("#buttonSaveModal").attr('onclick', 'addOption('+id+','+classWagon+')')
    $("#errorModal").hide();
    $("#footerModal").show();

    $("#bodyModal").html('<div class="d-flex">' +
        '                        <div class="d-flex flex-column">' +
        '                            <p>'+dateDeparture+'</p>' +
        '                            <p>'+dateArrival+'</p>' +
        '                        </div>' +
        '                        <div class="d-flex flex-column ms-4">' +
        '                            <p>'+departure+'</p>' +
        '                            <p>'+arrival+'</p>' +
        '                        </div>' +
        '                    </div>' +
        '                    <p class="my-4 text-center fw-bold">'+price+'€ par voyageur</p>' +
        '                    <div class="d-flex flex-column" id="containerModal"></div>' +
        '                    <div class="mt-3 d-flex justify-content-between">' +
        '                        <button class="btn btn-outline-secondary" onclick="addTraveler()">Ajouter un voyageur</button>' +
        '                        <button class="btn btn-outline-danger" id="deleteTraveler" onclick="deleteTraveler()">Supprimer' +
        '                            un voyageur' +
        '                        </button>' +
        '                    </div>')


    const html = '<p class="mt-5">Voyageur '+counterTraveler+'</p>' +

        '<label for="firstname'+counterTraveler+'">Prénom</label>' +
        '<input type="text" class="form-control" name="firstname'+counterTraveler+'" id="firstname'+counterTraveler+'">' +

        '<label for="lastname'+counterTraveler+'" class="mt-2">Nom</label>' +
        '<input type="text" class="form-control" name="lastName'+counterTraveler+'" id="lastname'+counterTraveler+'">';

    $("#containerModal").html(html);
    counterTraveler++;
}

function addTraveler() {
    const html = '<div id="traveler'+counterTraveler+'">' +
            '<p class="mt-5">Voyageur '+counterTraveler+'</p>' +

            '<label for="firstname'+counterTraveler+'">Prénom</label>' +
            '<input type="text" class="form-control" name="firstname'+counterTraveler+'" id="firstname'+counterTraveler+'">' +

            '<label for="lastname'+counterTraveler+'" class="mt-2">Nom</label>' +
            '<input type="text" class="form-control" name="lastName'+counterTraveler+'" id="lastname'+counterTraveler+'">' +
        '</div>';

    $("#containerModal").append(html);
    $("#deleteTraveler").show();
    counterTraveler++;
}

function deleteTraveler() {
    $("#traveler"+(counterTraveler - 1)).remove();
    counterTraveler--;
    if (counterTraveler === 2) {
        $("#deleteTraveler").hide();
    }
}

function addOption(id, classWagon) {
    let travelers = [];
    for (let i = 1; i < counterTraveler; i++){
        if ($("#firstname"+i).val() === '' || $("#lastname"+i).val() === ''){
            travelers = [];
            break;
        }else {
            travelers.push([$("#firstname" + i).val(), $("#lastname" + i).val()]);
        }
    }

    if (travelers.length === 0) {
        $("#errorModal").show();
        return;
    }
    console.log(id);
    console.log(classWagon);
    console.log(travelers);
    $.ajax({
        type: 'POST',
        url: '/add-option',
        data: {
            id: id,
            classWagon: classWagon,
            travelers: travelers
        },
        success: function(data) {
            console.log(data);
            if (data === false) {

            }else {
                $("#footerModal").hide();

                $("#bodyModal").html('<p class="text-center">Le voyage a été ajouté à votre panier</p>' +
                    '<div class="my-4 d-flex justify-content-between">' +
                    '<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Choisir un autre voyage</button>\n' +
                    '<a href="/shopping"><button type="button" class="btn btn-outline-dark">Voir mon panier</button></a>' +
                    '</div>');
            }
        },
        error: function (xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            alert(ajaxOptions);
            alert(thrownError);
            alert(xhr.status);
        }
    });
}