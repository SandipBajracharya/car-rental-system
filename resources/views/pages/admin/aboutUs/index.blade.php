@extends('layouts.adminLayout')

@section('page-specific-styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('pages.admin.aboutUs.create')
    @include('pages.admin.aboutUs.edit')

    <div class="app-absolute-layout scrollable p-24">
        <div class="flex-center-between mb-16">
            <h5>About us Config</h5>
            @if (isset($aboutCount) && $aboutCount < 1)
                <button class="btn btn-green" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAboutAdd" aria-controls="offcanvasAboutAdd">Add Content
                    <i class="ml-8 ic-add"></i>
                </button>
            @endif
        </div>
        <div class="table-responsive mb-24">
            <table class="table-striped table-td-desc" id="about-DT">
                <thead>
                    <tr>
                        <th class="pl-24">SN</th>
                        <th>Image</th>
                        <th>Heading1</th>
                        <th>Description1</th>
                        <th>Heading2</th>
                        <th>Description2</th>
                        <th class="flex-end pr-24">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('page-specific-scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    @if (count($errors) > 0)
        <script>
            if (sessionStorage.getItem("action") == 'create') {
                $('#offcanvasAboutAdd').addClass('show');
            } else {
                let id = sessionStorage.getItem('id');
                $('#offcanvasAboutEdit').addClass('show');
                $('#about-edit-form').attr('action', `/admin/about/${id}`);

                // image list if error
                $.ajax({
                    type: 'GET',
                    url: '/admin/about/'+id+'/edit',
                    success: function(resp) {
                        $('#e-about_image_item').html(resp.image);
                        $('#e-about_image_list').css('display', 'block');
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
            let table = $('#about-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "{{ route('about.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'image', name: 'images', orderable: false, searchable: false},
                    {data: 'heading1', name: 'heading1'},
                    {data: 'description1', name: 'description1'},
                    {data: 'heading2', name: 'heading2'},
                    {data: 'description2', name: 'description2'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // edit
            table.on('click', '.edit_btn', function(event) {
                let id = $(this).data('about_id');
                sessionStorage.setItem('id', id);
                $('#about-edit-form').attr('action', `/admin/about/${id}`);     // action value as per the id
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/about/'+id+'/edit',
                    success: function(resp) {
                        $('#e-about_image_item').html(resp.image);
                        $('#e-about_image_list').css('display', 'block');
                        $('#e-about_heading1').val(resp.heading1 || '');
                        $('#e-about_description1').val(resp.description1 || '');
                        $('#e-about_heading2').val(resp.heading2 || '');
                        $('#e-about_description2').val(resp.description2 || '');
                    },
                    error: function(error) {
                        console.log(error);
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
