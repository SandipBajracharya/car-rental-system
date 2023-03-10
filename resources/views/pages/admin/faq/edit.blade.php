<form  action="" method="POST" id="faq-edit-form">
    <div class="offcanvas offcanvas-end offcanvas-01" data-bs-backdrop="static" id="offcanvasFaqEdit" tabindex="-1" aria-labelledby="offcanvasFaqEditLabel">
        <div class="offcanvas-header">
            <h5 class="text-dark" id="offcanvasFaqEditLabel">Edit FAQ</h5>
            <button class="btn btn-red btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="Close" onclick="formModalClose()">
                <i class="ic-close"></i>
            </button>
        </div>
        @csrf
        @method('PUT')
        @include('pages.admin.faq.form', ['operation' => 'e'])
        <div class="offcanvas-footer p-16 flex-end gap-16">
            <button class="btn btn-outline-red" type="reset">Reset</button>
            <button class="btn btn-green" onclick="onSubmit('edit')">Submit</button>
        </div>
    </div>
</form>
