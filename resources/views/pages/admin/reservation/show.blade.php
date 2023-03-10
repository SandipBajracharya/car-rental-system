<div class="offcanvas offcanvas-end offcanvas-01" data-bs-backdrop="static" id="offcanvasReservationDetail" tabindex="-1" aria-labelledby="offcanvasReservationDetailLabel">
    <div class="offcanvas-header">
        <h5 class="text-dark" id="offcanvasReservationDetailLabel">Reservation Details</h5><button
            class="btn btn-red btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="ic-close"></i></button>
    </div>
    <div class="offcanvas-body">
        <div class="flex-center-between mb-24 border-bottom pb-24">
            <div class="align-center">
                <div class="avatar-initial-xxl mr-16" id="show-reservation-initials">SB</div>
                <div>
                    <h6 class="text-blue mb-8" id="show-reservation-client"> - </h6>
                    <p id="show-reservation-phone"> - </p>
                </div>
            </div>
        </div>
        <div class="row gap-24-row">
            <div class="col-12">
                <p class="text-cGray600 mb-4">Reservation Period</p>
                <p class="fw-semibold" id="show-reservation-period"> - </p>
            </div>
            <div class="col-6">
                <p class="text-cGray600 mb-4">Vehicle</p>
                <p class="fw-semibold" id="show-reservation-vehicle"> - </p>
            </div>
            <div class="col-6">
                <p class="text-cGray600 mb-4">Customer's License No.</p>
                <p class="fw-semibold" id="show-reservation-document_number"> - </p>
            </div>
            <div class="col-6">
                <p class="text-cGray600 mb-4">Payment Mode</p>
                <div class="badge badge-red" id="show-reservation-payment"> - </div>
                <p></p>
            </div>
            <div class="col-6">
                <p class="text-cGray600 mb-4">Payment Amt.</p>
                <div class="badge badge-green" id="show-reservation-amount"> - </div>
                <p></p>
            </div>
            <div class="col-6">
                <p class="text-cGray600 mb-4">Email Address</p>
                <p class="fw-semibold" id="show-reservation-email"> - </p>
            </div>
            <div class="col-6">
                <p class="text-cGray600 mb-4">Pickup Location</p><a class="fw-semibold p"
                    href="https://goo.gl/maps/314kSQG9ves4E4z79" id="show-reservation-pickup"> - </a>
            </div>
            {{-- <div class="col-6">
                <p class="text-cGray600 mb-4">Drop-Off Location</p><a class="fw-semibold p"
                    href="https://goo.gl/maps/314kSQG9ves4E4z79">Villawood NSW 2163, Australia</a>
            </div> --}}
            <div class="offcanvas-footer p-16 flex-end gap-16" style="display: none" id="show-reservation-mar">
                <a href="" class="btn btn-green" id="mark-as-refunded"> Mark as Refunded <i class="ml-8 ic-check"></i></a>
            </div>
        </div>
    </div>
</div>