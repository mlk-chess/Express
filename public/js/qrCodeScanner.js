const video = document.getElementById('qr-video');

function setResult(result) {
    $.ajax({
        type: 'POST',
        url: '/qrcode/search',
        data: {
            token: result.data
        },
        success: function(data) {
            if (data === false){
                $("#container-ticket").html('<div class="alert alert-danger"><p>Le Qr Code n\'est pas valable</p></div>');
            }else {
                data = JSON.parse(data);
                let date = new Date(data[1].date);
                let timeDeparture = new Date(data[5].date);
                let timeArrival = new Date(data[6].date);
                date = (date.getDate()<10?'0':'') + date.getDate() + '/' + (date.getMonth()<10?'0':'') + date.getMonth() + '/' + date.getFullYear();
                timeDeparture = (timeDeparture.getHours()<10?'0':'') + timeDeparture.getHours() + ':' + (timeDeparture.getMinutes()<10?'0':'') + timeDeparture.getMinutes();
                timeArrival = (timeArrival.getHours()<10?'0':'') + timeArrival.getHours() + ':' + (timeArrival.getMinutes()<10?'0':'') + timeArrival.getMinutes();

                let html = '<h4>Voyage à '+ data[3] +'</h4>' +
                    '<p class="mt-2">Le ' + date + '</p>' +
                    '<div class="mt-4 d-flex justify-content-between align-items-end">' +
                        '<p class="mb-0"><b>'+ timeDeparture +'</b> '+ data[3] +'</p>' +
                        '<p class="mb-0">TGV N° <b>' + data[2] + '</b></p>' +
                    '</div>' +
                    '<p><b>'+ timeArrival +'</b> '+ data[4] +'</p>' +
                    '<div class="d-flex flex-column">';

                data[0].forEach(function (traveler){
                    html += '<p class="mb-2"><i class="fa-solid fa-user"></i> x '+ traveler[0] +' '+ traveler[1] +'</p>';
                });

                html += '</div>';

                $("#container-ticket").html(html);
            }
        },
        error: function (xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            alert(ajaxOptions);
            alert(thrownError);
            alert(xhr.status);
        }
    });
    scanner.stop();
    document.getElementById('start-button').style.display = 'block';
    document.getElementById('container-scanner').style.display = 'none';
    document.getElementById('container-result').style.display = 'block';
}

const scanner = new QrScanner(video, result => setResult(result), {
    onDecodeError: error => {

    },
    highlightScanRegion: true,
    highlightCodeOutline: true,
});


document.getElementById('start-button').addEventListener('click', () => {
    document.getElementById('start-button').style.display = 'none';
    document.getElementById('container-result').style.display = 'none';
    document.getElementById('container-scanner').style.display = 'block';
    $("#container-ticket").html('');
    scanner.start();
});