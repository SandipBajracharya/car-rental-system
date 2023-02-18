<div class="offcanvas offcanvas-end offcanvas-01" data-bs-backdrop="static" id="offcanvasPromoEdit" tabindex="-1" aria-labelledby="offcanvasPromoEditLabel">
    <div class="offcanvas-header">
        <h5 class="text-dark" id="offcanvasPromoEditLabel">Edit Promo Code</h5>
        <button class="btn btn-red btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="Close" onclick="formModalClose()">
            <i class="ic-close"></i>
        </button>
    </div>
    <form action="" method="POST" enctype="multipart/form-data" id="promo-edit-form">
        @csrf
        @method('PUT')
        @include('pages.admin.promoCode.form', ['operation' => 'e'])
        <div class="offcanvas-footer p-16 flex-end gap-16">
            <button class="btn btn-outline-red" type="reset">Reset</button>
            <button class="btn btn-green" onclick="onSubmit('edit')">Submit</button>
        </div>
    </form>
</div>
