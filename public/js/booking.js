function getBooking(id) {
    $.ajax({
        type: 'POST',
        url: '/admin/booking/info',
        data: {
            id: id
        },
        success: function (data) {
            const dateArrival = (new Date(data[2].date)).toLocaleDateString("fr");
            const timeDeparture = (new Date(data[3].date)).toLocaleTimeString("fr");
            const timeArrival = (new Date(data[4].date)).toLocaleTimeString("fr");

            let content ='<div>' +
                '<div class="mt-3 mb-5">' +
                    '<div class="d-flex align-items-center">' +
                        '<p class="m-0">'+timeDeparture+'</p>' +
                        '<i class="fa-solid fa-arrow-right mx-3"></i>' +
                        '<p class="m-0">'+data[5]+'</p>' +
                    '</div>' +
                    '<div class="d-flex align-items-center mt-3">' +
                        '<p class="m-0">'+timeArrival+'</p>' +
                        '<i class="fa-solid fa-arrow-right mx-3"></i>' +
                        '<p class="m-0">'+data[6]+'</p>' +
                    '</div>' +
                '</div>' +
                '<p class="mt-4 text-center">Prix : '+data[0]*data[1].length+'</p>' +
            '</div>';

            for (let i = 0; i < data[1].length; i++) {
                content += '<div>' +
                    '<p>- '+data[1][i][0]+' '+data[1][i][1]+'</p>' +
                    '</div>' ;
            }

            $("#infoModalLabel").html('<p class="text-center">'+dateArrival+'</p>');
            $("#containerModalInfo").html(content);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            alert(ajaxOptions);
            alert(thrownError);
            alert(xhr.status);
        }
    });
}

function deleteBooking(id) {
    $("#inputDeleteBooking").attr('value', id)
}

function addContentRefund(id){
    $('#infoModalFooter').empty()
    let html =  '<div class="mt-3">' +
                    '<p>Etes vous sûr de vouloir annuler le voyage ? </p>'
                '</div>'
    $("#infoModalLabel").html('<p class="text-center">Annulation/Remboursement du voyage</p>');
    $("#containerModalInfo").html(html);
    $('#infoModalFooter').append('<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Valider</button>')
}