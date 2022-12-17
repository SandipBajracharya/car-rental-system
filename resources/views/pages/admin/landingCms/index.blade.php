@extends('layouts.adminLayout')

@section('page-specific-styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('pages.admin.landingCms.create')
    @include('pages.admin.landingCms.edit')

    <!-- delete modal -->
    @include('include.admin.components.deleteDialog', ['id' => 'home-slider-delete-form'])

    <div class="app-absolute-layout scrollable p-24">
        <div class="flex-center-between mb-16">
            <h5>Slider Content Config</h5>
            <button class="btn btn-green" data-bs-toggle="offcanvas" data-bs-target="#offcanvasHomeSliderAdd" aria-controls="offcanvasHomeSliderAdd">Add Slide
                <i class="ml-8 ic-add"></i>
            </button>
        </div>
        <div class="table-responsive mb-24">
            <table class="table-striped table-td-desc" id="home-slider-DT">
                <thead>
                    <tr>
                        <th class="pl-24">SN</th>
                        <th>Image</th>
                        <th>Heading</th>
                        <th class="flex-end pr-24">Action</th>
                    </tr>
                </thead>
            </table>
        </div>

        <h5 class="mb-16">Top Vehicle Config</h5>
        <div class="bg-white p-24">
            <form action="{{route('homepage.topVehicle')}}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ isset($topVehicle)? $topVehicle->id : ''}}">
                <div class="row align-end gap-16-row mb-16">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">First Vehicle</label>
                        <select class="form-select" name="vehicle1">
                            @if (isset($vehicles))
                                @foreach ($vehicles as $vehicle)
                                    <option {{isset($topVehicle) && $topVehicle->vehicle1 === $vehicle->id? 'selected' : ''}} value="{{$vehicle->id}}">{{$vehicle->model}}</option>
                                @endforeach
                            @else
                                <option selected value="">No options available</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Second Vehicle</label>
                        <select class="form-select" name="vehicle2">
                            @if (isset($vehicles))
                                @foreach ($vehicles as $vehicle)
                                    <option {{isset($topVehicle) && $topVehicle->vehicle2 === $vehicle->id? 'selected' : ''}} value="{{$vehicle->id}}">{{$vehicle->model}}</option>
                                @endforeach
                            @else
                                <option selected value="">No options available</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="flex-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-specific-scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    @if (count($errors) > 0)
        <script>
            if (sessionStorage.getItem("action") == 'create') {
                $('#offcanvasHomeSliderAdd').addClass('show');
            } else {
                let id = sessionStorage.getItem('id');
                $('#offcanvasHomeSliderEdit').addClass('show');
                $('#home-slider-edit-form').attr('action', `/admin/home-slider/${id}`);
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
            let table = $('#home-slider-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "{{ route('home-slider.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'images', name: 'images', orderable: false, searchable: false},
                    {data: 'heading', name: 'heading'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // edit
            table.on('click', '.edit_btn', function(event) {
                let id = $(this).data('home_slider_id');
                sessionStorage.setItem('id', id);
                $('#home-slider-edit-form').attr('action', `/admin/home-slider/${id}`);     // action value as per the id
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/home-slider/'+id+'/edit',
                    success: function(resp) {
                        $('#e-home_slider_image').val(resp.image || '');
                        $('#e-home_slider_heading').val(resp.heading || '');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // delete
            table.on('click', '.delete-btn', function(event) {
                let id = $(this).data('home_slider_id');
                $('#home-slider-delete-form').attr('action', `/admin/home-slider/${id}`);
            });

            // availability update
            // table.on('change', '.promo-status-switch', function(event) {
            //     let id = $(this).data('home_slider_id');
            //     let val = 0;
            //     let attr = event.target.checked;
            //     if (attr) {
            //         val = 1;
            //     }
            //     $.ajax({
            //         type: 'GET',
            //         url: `/admin/update-home-slider-status/${id}`,
            //         data: {
            //             'status': val
            //         },
            //         success: function(resp) {
            //             if (resp['status'] == 'error') {
            //                 if (attr) {
            //                     event.target.checked = false;
            //                 } else {
            //                     event.target.checked = true;
            //                 }
            //             }
            //             Toast.fire({
            //                 icon: resp.status,
            //                 title: resp.message
            //             });
            //         },
            //         error: function(error) {
            //             console.log(error);
            //         }
            //     });
            // });
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
