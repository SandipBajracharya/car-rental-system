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
    let currDate = formatCurrentDate();

    if (!pick_location) {
        $("#pl_valn").css("display", "block");
        proceed = false;
    } else {
        $("#pl_valn").css("display", "none");
        proceed = true;
    }
    if (!start_dt) {
        $("#sd_valn").css("display", "block");
        proceed = false;
    } else {
        if (start_dt < currDate) {
            $("#sd_valn").css("display", "block");
            $("#sd_valn").html("Pick up date should be greater or same as today");
            proceed = false;
        } else {
            $("#sd_valn").css("display", "none");
            proceed = true;
        }
    }
    if (!end_dt) {
        $("#ed_valn").css("display", "block");
        proceed = false;
    } else {
        if (end_dt <= start_dt) {
            $("#ed_valn").css("display", "block");
            $("#ed_valn").html("Drop off date should be greater than pickup date");
            proceed = false;
        } else {
            $("#ed_valn").css("display", "none");
            proceed = true;
        }
    }

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

function formatCurrentDate()
{
    const dateObj = new Date();

    let year = dateObj.getFullYear();
    
    let month = dateObj.getMonth();
    month = ('0' + (month + 1)).slice(-2);
    // To make sure the month always has 2-character-formate. For example, 1 => 01, 2 => 02

    let date = dateObj.getDate();
    date = ('0' + date).slice(-2);
    // To make sure the date always has 2-character-formate

    let hour = dateObj.getHours();
    hour = ('0' + hour).slice(-2);
    // To make sure the hour always has 2-character-formate

    let minute = dateObj.getMinutes();
    minute = ('0' + minute).slice(-2);
    // To make sure the minute always has 2-character-formate

    let second = dateObj.getSeconds();
    second = ('0' + second).slice(-2);
    // To make sure the second always has 2-character-formate

    const time = `${year}-${month}-${date} ${hour}:${minute}:${second}`;
    return time;
}