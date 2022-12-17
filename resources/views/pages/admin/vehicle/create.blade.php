<div class="offcanvas offcanvas-end offcanvas-01" id="offcanvasVehicleAdd" tabindex="-1" aria-labelledby="offcanvasVehicleAddLabel">
    <div class="offcanvas-header">
        <h5 class="text-dark" id="offcanvasVehicleAddLabel">Add New Vehicle</h5>
        <button class="btn btn-red btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="Close" onclick="formModalClose()">
            <i class="ic-close"></i>
        </button>
    </div>
    <form action="{{route('vehicle.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('pages.admin.vehicle.form', ['operation' => 'c'])
        <div class="offcanvas-footer p-16 flex-end gap-16">
            <button class="btn btn-outline-red" type="reset">Reset</button>
            <button class="btn btn-green" onclick="onSubmit('create')">Submit</button>
        </div>
    </form>
</div>

