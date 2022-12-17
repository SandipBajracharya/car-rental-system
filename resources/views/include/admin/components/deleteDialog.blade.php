<div class="modal fade modal-confirmation" id="confirmationModal" tabindex="-1"
    aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-24">
                <div class="d-flex">
                    <div class="circle bg-red100 mr-24 flex-shrink-0"><i
                            class="ic-error text-danger h3"></i></div>
                    <div>
                        <h5 class="mb-8 text-primary">Confirmation</h5>
                        <p class="text-cGray600">Are you sure you want to delete this item?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-cGray100 border-0">
                <form action="" method="POST" id="{{$id}}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">No</button>
                    <button class="btn btn-primary" type="submit" data-bs-dismiss="modal">Yes</a>
                </form>
            </div>
        </div>
    </div>
</div>