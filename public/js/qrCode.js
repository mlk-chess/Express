const video = document.getElementById('qr-video');

function setResult(result) {
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