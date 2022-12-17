@extends('layouts.adminLayout')

@section('page-specific-styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('pages.admin.promoCode.create')
    @include('pages.admin.promoCode.edit')

    <!-- delete modal -->
    @include('include.admin.components.deleteDialog', ['id' => 'promo-delete-form'])

    <div class="app-absolute-layout scrollable p-24">
        <div class="flex-center-between mb-16">
            <h5>Promo Codes</h5><button class="btn btn-green" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasPromoAdd" aria-controls="offcanvasPromoAdd">Add Promo<i
                    class="ml-8 ic-add"></i></button>
        </div>
        <div class="table-responsive">
            <table class="table-striped" id="promo-list-DT">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th class="pl-24">Promo Name</th>
                        <th>Promo Code</th>
                        <th>Dicount Percentage</th>
                        <th>Max Discount</th>
                        <th>Status</th>
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

    @if (count($errors) > 0)
        <script>
            if (sessionStorage.getItem("action") == 'create') {
                $('#offcanvasPromoAdd').addClass('show');
            } else {
                let id = sessionStorage.getItem('id');
                $('#offcanvasPromoEdit').addClass('show');
                $('#promo-edit-form').attr('action', `/admin/promo-code/${id}`);
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
            let table = $('#promo-list-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "{{ route('promo-code.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'promo_name', name: 'promo_name'},
                    {data: 'promo_code', name: 'promo_code'},
                    {data: 'discount_percentage', name: 'discount_percentage'},
                    {data: 'max_discount', name: 'max_discount'},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false, class: 'flex-end'},
                ]
            });

            // edit
            table.on('click', '.edit_btn', function(event) {
                let id = $(this).data('promo_id');
                sessionStorage.setItem('id', id);
                $('#promo-edit-form').attr('action', `/admin/promo-code/${id}`);     // action value as per the id
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/promo-code/'+id+'/edit',
                    success: function(resp) {
                        $('#e-promo_promo_name').val(resp.promo_name || '');
                        $('#e-promo_promo_code').val(resp.promo_code || '');
                        $('#e-promo_discount_percentage').val(resp.discount_percentage || '');
                        $('#e-promo_max_discount').val(resp.max_discount || '');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // delete
            table.on('click', '.delete-btn', function(event) {
                let id = $(this).data('promo_id');
                $('#promo-delete-form').attr('action', `/admin/promo-code/${id}`);
            });

            // availability update
            table.on('change', '.promo-status-switch', function(event) {
                let id = $(this).data('promo_id');
                let val = 0;
                let attr = event.target.checked;
                if (attr) {
                    val = 1;
                }
                $.ajax({
                    type: 'GET',
                    url: `/admin/update-promo-code-status/${id}`,
                    data: {
                        'status': val
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
