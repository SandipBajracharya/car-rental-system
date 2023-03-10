<div class="modal fade modal-confirmation" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-24">
                <div class="d-flex">
                    <div class="circle bg-red100 mr-24 flex-shrink-0"><i class="ic-error text-danger h3"></i></div>
                    <div>
                        <h5 class="mb-8 text-primary">Confirmation</h5>
                        <p class="text-cGray600">Are you sure you want to cancel reservation?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-cGray100 border-0">
                <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">No</button>
                <form action="{{route('cancel.reservation')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="show-reservation-id" value="" name="id">
                    <button class="btn btn-primary" type="submit" data-bs-dismiss="modal">Yes</button></div>
                </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-01" id="offcanvasReservationDetail" tabindex="-1" aria-labelledby="offcanvasReservationDetailLabel">
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
        </div>
    </div>
    <div class="offcanvas-footer p-16 flex-end gap-16">
        <button class="btn btn-outline-red" id="cancel-btn" data-bs-target="#confirmationModal" data-bs-toggle="modal" style="display: none;">Cancel Reservation</button>
    </div>
</div>