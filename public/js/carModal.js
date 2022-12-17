function showCarDetail(id) {
    let loading = document.querySelector('#loading-screen');
    loading.style.display = 'flex';
    console.log(loading);
    $("#offcanvasQuickVehicleDetail").html(loading);
    $.ajax({
        type: "GET",
        url: "/modal-car-detail",
        data: { id: id },
        // dataType: 'JSON',
        success: function (resp) {
            loading.style.display = 'none';
            $("#offcanvasQuickVehicleDetail").append(resp.carDetail);
        },
        error: function (resp) {
            console.log("error");
            console.log(resp);
        },
    });
}