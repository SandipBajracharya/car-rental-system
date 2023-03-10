<form action="{{route('contact.store')}}" method="POST" class="offcanvas offcanvas-end offcanvas-01" data-bs-backdrop="static" id="offcanvasContactAdd" tabindex="-1" aria-labelledby="offcanvasContactAddLabel">
    <div class="offcanvas-header">
        <h5 class="text-dark" id="offcanvasContactAddLabel">Add New Contact</h5>
        <button class="btn btn-red btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="Close" onclick="formModalClose()">
            <i class="ic-close"></i>
        </button>
    </div>
        @csrf
        @include('pages.admin.contact.form', ['operation' => 'c'])
        <div class="offcanvas-footer p-16 flex-end gap-16">
            <button class="btn btn-outline-red" type="reset">Reset</button>
            <button class="btn btn-green" onclick="onSubmit('create')">Submit</button>
        </div>
</form>