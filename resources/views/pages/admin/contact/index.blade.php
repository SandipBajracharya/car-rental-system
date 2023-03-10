@extends('layouts.adminLayout')

@section('page-specific-styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('pages.admin.contact.create')
    @include('pages.admin.contact.edit')

    <!-- delete modal -->
    @include('include.admin.components.deleteDialog', ['id' => 'contact-delete-form'])

    <div class="app-absolute-layout scrollable p-24">
        <div class="flex-center-between mb-16">
            <h5>Contact Config</h5>
            @if (isset($contactCount) && $contactCount < 1)
                <button class="btn btn-green" data-bs-toggle="offcanvas" data-bs-target="#offcanvasContactAdd" aria-controls="offcanvasContactAdd">Add Contact
                    <i class="ml-8 ic-add"></i>
                </button>
            @endif
        </div>
        <div class="table-responsive mb-24">
            <table class="table-striped table-td-desc" id="contact-DT">
                <thead>
                    <tr>
                        <th class="pl-24">SN</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Facebook link</th>
                        <th>Twitter link</th>
                        <th>Instagram link</th>
                        <th>Map link</th>
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
                $('#offcanvasContactAdd').addClass('show');
            } else {
                let id = sessionStorage.getItem('id');
                $('#offcanvasContactEdit').addClass('show');
                $('#contact-edit-form').attr('action', `/admin/contact/${id}`);
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
            let table = $('#contact-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "{{ route('contact.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'address', name: 'address'},
                    {data: 'phone', name: 'phone'},
                    {data: 'email', name: 'email'},
                    {data: 'facebook_link', name: 'facebook_link'},
                    {data: 'twitter_link', name: 'twitter_link'},
                    {data: 'insta_link', name: 'insta_link'},
                    {data: 'map', name: 'map'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // edit
            table.on('click', '.edit_btn', function(event) {
                let id = $(this).data('contact_id');
                sessionStorage.setItem('id', id);
                $('#contact-edit-form').attr('action', `/admin/contact/${id}`);     // action value as per the id
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/contact/'+id+'/edit',
                    success: function(resp) {
                        $('#e-contact_address').val(resp.address || '');
                        $('#e-contact_phone').val(resp.phone || '');
                        $('#e-contact_email').val(resp.email || '');
                        $('#e-contact_facebook_link').val(resp.facebook_link || '');
                        $('#e-contact_twitter_link').val(resp.twitter_link || '');
                        $('#e-contact_insta_link').val(resp.insta_link || '');
                        $('#e-contact_map').val(resp.map || '');
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
