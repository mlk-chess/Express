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
                date = date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();

                $("#container-ticket").html('<p>Passager : ' + data[0][0] + '</p>' +
                    '<p>Date : ' + date + '</p>' +
                    '<p>Train : ' + data[2] + '</p>');
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
}

const scanner = new QrScanner(video, result => setResult(result), {
    onDecodeError: error => {

    },
    highlightScanRegion: true,
    highlightCodeOutline: true,
});


document.getElementById('start-button').addEventListener('click', () => {
    document.getElementById('start-button').style.display = 'none';
    $("#container-ticket").html('');
    scanner.start();
});