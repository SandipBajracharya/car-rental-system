<div class="offcanvas offcanvas-end offcanvas-01" data-bs-backdrop="static" id="offcanvasReservationEdit" tabindex="-1" aria-labelledby="offcanvasReservationEditLabel">
    <form action="" method="POST" id="reservation-edit-form">
        @csrf
        @method('PUT')
        <div class="offcanvas-header">
            <h5 class="text-dark" id="offcanvasReservationEditLabel">Reservation Details</h5><button
                class="btn btn-red btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="Close"><i
                    class="ic-close"></i></button>
        </div>
        <div class="offcanvas-body">
            <div class="flex-center-between mb-24 border-bottom pb-24">
                <div class="align-center">
                    <div class="avatar-initial-xxl mr-16" id="e-reservation-initials">SB</div>
                    <div>
                        <h6 class="text-blue mb-8" id="e-reservation-client"> - </h6>
                        <p id="e-reservation-phone"> - </p>
                    </div>
                </div>
            </div>
            <div class="row gap-24-row">
                <div class="col-12">
                    <p class="text-cGray600 mb-4">Reservation Period</p>
                    <p class="fw-semibold" id="e-reservation-period"> - </p>
                </div>
                <div class="col-6">
                    <p class="text-cGray600 mb-4">Customer's License No.</p>
                    <p class="fw-semibold" id="e-reservation-document_number"> - </p>
                </div>
                <div class="col-6">
                    <p class="text-cGray600 mb-4">Payment Mode</p>
                    <div class="badge badge-red" id="e-reservation-payment"> - </div>
                    <p></p>
                </div>
                <div class="col-6">
                    <p class="text-cGray600 mb-4">Payment Amt.</p>
                    <div class="badge badge-green" id="e-reservation-amount"> - </div>
                    <p></p>
                </div>
                <div class="col-6">
                    <p class="text-cGray600 mb-4">Email Address</p>
                    <p class="fw-semibold" id="e-reservation-email"> - </p>
                </div>
                <div class="col-12">
                    <p class="text-cGray600 mb-4">Pickup Location</p>
                    <a class="fw-semibold p" href="https://goo.gl/maps/314kSQG9ves4E4z79" id="e-reservation-pickup"> - </a>
                </div>
                {{-- <div class="col-6">
                    <p class="text-cGray600 mb-4">Drop-Off Location</p><a class="fw-semibold p"
                        href="https://goo.gl/maps/314kSQG9ves4E4z79">Villawood NSW 2163, Australia</a>
                </div> --}}
                <div class="col-6">
                    <p class="text-cGray600 mb-4">Vehicle</p>
                    <select class="form-select" name="vehicle_id" id="e-reservation-vehicle">
                    </select>
                </div>
                <div class="col-6">
                    <p class="text-cGray600 mb-4">Reservation Status</p>
                    <select class="form-select" name="status">
                        <option selected="" value="Active">Active</option>
                        <option value="Completed">Completed</option>
                        <option value="Canceled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer p-16 flex-end gap-16">
            {{-- <button type="reset" class="btn btn-outline-red">Reset</button> --}}
            <button class="btn btn-red" type="button" data-bs-dismiss="offcanvas" aria-label="Close">
                Cancel
            </button>
            <button type="submit" class="btn btn-green">Submit</button>
        </div>
    </form>
</div>