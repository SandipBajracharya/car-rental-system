<form action="{{route('home-slider.store')}}" method="POST" enctype="multipart/form-data" class="offcanvas offcanvas-end offcanvas-01" data-bs-backdrop="static" id="offcanvasHomeSliderAdd" tabindex="-1" aria-labelledby="offcanvasHomeSliderAddLabel">
    <div class="offcanvas-header">
        <h5 class="text-dark" id="offcanvasHomeSliderAddLabel">Add New Hero Slide</h5>
        <button class="btn btn-red btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="Close" onclick="formModalClose()">
            <i class="ic-close"></i>
        </button>
    </div>
        @csrf
        @include('pages.admin.landingCms.form', ['operation' => 'c'])
        <div class="offcanvas-footer p-16 flex-end gap-16">
            <button class="btn btn-outline-red" type="reset">Reset</button>
            <button class="btn btn-green" onclick="onSubmit('create')">Submit</button>
        </div>
</form>