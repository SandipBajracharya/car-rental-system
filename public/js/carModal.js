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

function checkVehicleAvailability(vehicleId) {
    let pick_location = $("#ca_pl").val();
    let start_dt = $("#ca_sd").val();
    let end_dt = $("#ca_ed").val();
    let proceed = true;

    if (!pick_location) {
        $("#pl_valn").css("display", "block");
        proceed = false;
    }
    if (!start_dt) {
        $("#sd_valn").css("display", "block");
        proceed = false;
    }
    if (!end_dt) {
        $("#ed_valn").css("display", "block");
        proceed = false;
    }

    console.log(proceed);
    if (proceed) {
        let ca_btn = $("#ca_btn");
        ca_btn.html("Checking...");
        ca_btn.attr("disabled", "disabled");
        ca_btn.css("cursor", "not-allowed");

        setTimeout(() => {
            $.ajax({
                type: "GET",
                url: `/check-vehicle-availability/${vehicleId}`,
                data: {
                    pickup_location: pick_location,
                    start_dt: start_dt,
                    end_dt: end_dt
                },
                // dataType: 'JSON',
                success: function (resp) {
                    $("#availability-section").css("display", "none");
                    console.log("resp" + resp);
                    if (resp) {
                        $(".ca_vf").css("display", "flex");
                    } else {
                        $(".ca_vnf").css("display", "flex");
                    }
                },
                error: function (resp) {
                    console.log("error");
                    console.log(resp);
                },
            });
        }, 2000);
    }
}
