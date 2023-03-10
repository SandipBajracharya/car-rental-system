<form  action="" method="POST" enctype="multipart/form-data" id="about-edit-form">
    <div class="offcanvas offcanvas-end offcanvas-01" data-bs-backdrop="static" id="offcanvasAboutEdit" tabindex="-1" aria-labelledby="offcanvasAboutEditLabel">
        <div class="offcanvas-header">
            <h5 class="text-dark" id="offcanvasAboutEditLabel">Edit Hero Slide</h5>
            <button class="btn btn-red btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="Close" onclick="formModalClose()">
                <i class="ic-close"></i>
            </button>
        </div>
        @csrf
        @method('PUT')
        @include('pages.admin.aboutUs.form', ['operation' => 'e'])
        <div class="offcanvas-footer p-16 flex-end gap-16">
            <button class="btn btn-outline-red" type="reset">Reset</button>
            <button class="btn btn-green" onclick="onSubmit('edit')">Submit</button>
        </div>
    </div>
</form>
