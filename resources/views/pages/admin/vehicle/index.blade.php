@extends('layouts.adminLayout')

@section('page-specific-styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('pages.admin.vehicle.show')
    @include('pages.admin.vehicle.create')
    @include('pages.admin.vehicle.edit')

    <!-- delete modal -->
    @include('include.admin.components.deleteDialog', ['id' => 'vehicle-delete-form'])

    <div class="app-absolute-layout scrollable p-24">
        <div class="flex-center-between mb-16">
            <h5>Vehicle List</h5><button class="btn btn-green" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasVehicleAdd" aria-controls="offcanvasVehicleAdd">Add Vehicle<i
                    class="ml-8 ic-add"></i></button>
        </div>
        <div class="table-responsive">
            <table class="table-striped" id="vehicle-list-DT">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Vehicle Model</th>
                        <th>Plate No.</th>
                        <th>Ocupancy</th>
                        <th>Mileage</th>
                        <th>Fuel Vol.</th>
                        <th>Pricing</th>
                        <th>Availability Status</th>
                        <th class="text-end pr-24">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('page-specific-scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>

    {{-- <script>
        ClassicEditor
            .create( document.querySelector( '#c-vehicle_features' ) )
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );

        ClassicEditor
            .create( document.querySelector( '#e-vehicle_features' ) )
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
    </script> --}}

    @if (count($errors) > 0)
        <script>
            if (sessionStorage.getItem("action") == 'create') {
                $('#offcanvasVehicleAdd').addClass('show');
            } else {
                let id = sessionStorage.getItem('id');
                $('#offcanvasVehicleEdit').addClass('show');
                $('#vehicle-edit-form').attr('action', `/admin/vehicle/${id}`);

                // image list if error
                $.ajax({
                    type: 'GET',
                    url: '/admin/vehicle/'+id+'/edit',
                    success: function(resp) {
                        let images = $.parseJSON(resp.images);
                        let imgHtml = '';
                        images.forEach(item => {
                            imgHtml += '<li> <div class="align-center mr-2"> <i class="ic-file"></i> <span class="p">'+item+' </span> </div> </li>';
                        });
                        $('#e-vehicle_image_list').css('display', 'block');
                        $('#e-vehicle_image_item').append(imgHtml);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        </script>
    @else
        <script>
            sessionStorage.removeItem('id');
        </script>
    @endif

    <script>
        let errors;
        $( document ).ready(function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            errors = {!! json_encode($errors->toArray() ?? [], JSON_HEX_TAG) !!}
            
            // datatable
            let table = $('#vehicle-list-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "{{ route('vehicle.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'model', name: 'model'},
                    {data: 'plate_number', name: 'plate_number'},
                    {data: 'occupancy', name: 'occupancy'},
                    {data: 'mileage', name: 'mileage'},
                    {data: 'fuel_volume', name: 'fuel_volume'},
                    {data: 'pricing', name: 'pricing'},
                    {data: 'availability', name: 'availability', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false, class: 'flex-end'},
                ]
            });

            // show
            table.on('click', '.show_btn', function(event) {
                let id = $(this).data('vehicle_id');
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/vehicle/'+id,
                    success: function(resp) {
                        $('#show-vehicle-description').html(resp.description || 'NA');
                        $('#show-vehicle-model').html(resp.model || 'NA');
                        $('#show-vehicle-plate_number').html(resp.plate_number || 'NA');
                        $('#show-vehicle-mileage').html(resp.mileage || 'NA');
                        $('#show-vehicle-fuel_volume').html(resp.fuel_volume || 'NA');
                        $('#show-vehicle-occupancy').html(resp.occupancy || 'NA');
                        $('#show-vehicle-pricing').html(resp.pricing || '$0.00');
                        let img = $.parseJSON(resp.images);
                        $('#show-vehicle-img').attr('src', `/images/vehicles/${img[0]}`);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // edit
            table.on('click', '.edit_btn', function(event) {
                let id = $(this).data('vehicle_id');
                sessionStorage.setItem('id', id);
                $('#vehicle-edit-form').attr('action', `/admin/vehicle/${id}`);     // action value as per the id
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/vehicle/'+id+'/edit',
                    success: function(resp) {
                        $('#e-vehicle_description').val(resp.description || '');
                        $('#e-vehicle_features').val(resp.features || '');
                        $('#e-vehicle_model').val(resp.model || '');
                        $('#e-vehicle_plate_number').val(resp.plate_number || '');
                        $('#e-vehicle_mileage').val(resp.mileage || '');
                        $('#e-vehicle_fuel_volume').val(resp.fuel_volume || '');
                        $('#e-vehicle_occupancy').val(resp.occupancy || '');
                        $('#e-vehicle_pricing').val(resp.pricing || '');
                        if (resp.is_reserved_now) {
                            $('#e-vehicle_reserved').attr('selected', 'selected');
                        } else {
                            $('#e-vehicle_not_reserved').attr('selected', 'selected');
                        }
                        let images = $.parseJSON(resp.images);
                        let imgHtml = '';
                        images.forEach(item => {
                            imgHtml += '<li> <div class="align-center mr-2"> <i class="ic-file"></i> <span class="p">'+item+' </span> </div> </li>';
                        });
                        $('#e-vehicle_image_list').css('display', 'block');
                        $('#e-vehicle_image_item').append(imgHtml);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // delete
            table.on('click', '.delete-btn', function(event) {
                let id = $(this).data('vehicle_id');
                $('#vehicle-delete-form').attr('action', `/admin/vehicle/${id}`);
            });

            // availability update
            table.on('change', '.vehicle-available-switch', function(event) {
                let id = $(this).data('vehicle_id');
                let val = 0;
                let attr = event.target.checked;
                if (attr) {
                    val = 1;
                }
                $.ajax({
                    type: 'GET',
                    url: `/admin/update-vehicle-availability/${id}`,
                    data: {
                        'available': val
                    },
                    success: function(resp) {
                        if (resp['status'] == 'error') {
                            if (attr) {
                                event.target.checked = false;
                            } else {
                                event.target.checked = true;
                            }
                        }
                        Toast.fire({
                            icon: resp.status,
                            title: resp.message
                        });
                    },
                    error: function(error) {

                    }
                });
            });
        });

        function onFieldInput(e, files = false) {
            var id = e.target.id;
            let field = id.substring(id.indexOf('_') + 1);
            if (!files) {
                if (errors[field]) {
                    $('#'+id).removeClass("is-invalid");
                    delete errors[field];
                    console.log(errors);
                }
            } else {
                $('#'+id).removeClass("is-invalid");
            }
        }

        function onSubmit(action)
        {
            sessionStorage.setItem("action", action);
        }
    </script>
@endsection