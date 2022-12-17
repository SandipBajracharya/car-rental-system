<div class="modal fade" id="bookingAliasModal" tabindex="-1" aria-labelledby="bookingAliasModalLabel" aria-hidden="true">
    <div class="modal-dialog sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-24">
                <div class="flex-center-center flex-column mb-24">
                    <div class="circle bg-blue100 mb-24 flex-shrink-0"><i class="ic-info text-blue h3"></i></div>
                    <div>
                        <h3 class="mb-8 text-primary text-center">Pick Booking Method</h3>
                        <p class="text-cGray600 text-center">Seems like you have not logged in. Before moving
                            forward you either require to log in or checkout as a guest</p>
                    </div>
                </div>
                <div class="gap-24">
                    <a class="btn btn-outline-primary w-50 btn-lg" href="/checkout-as-guest?vehicle_id={{$vehicle_id}}" type="button">Checkout as Guest</a>
                    <a class="btn btn-primary w-50 btn-lg" href="/login" type="button">Log in</a>
                </div>
            </div>
        </div>
    </div>
</div>