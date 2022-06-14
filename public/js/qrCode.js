const video = document.getElementById('qr-video');

function setResult(result) {
    // $.ajax({
    //     type: 'GET',
    //     url: '/qrCode/search',
    //     data: {
    //         token: result.data
    //     },
    //     success: function(data) {
    //         console.log(JSON.parse(data));
    //     },
    //     error: function (xhr, ajaxOptions, thrownError){
    //         alert(xhr.responseText);
    //         alert(ajaxOptions);
    //         alert(thrownError);
    //         alert(xhr.status);
    //     }
    // });
    console.log(result.data);
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
    scanner.start();
});