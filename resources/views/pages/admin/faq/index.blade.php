@extends('layouts.adminLayout')

@section('page-specific-styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('pages.admin.faq.create')
    @include('pages.admin.faq.edit')

    <!-- delete modal -->
    @include('include.admin.components.deleteDialog', ['id' => 'faq-delete-form'])

    <div class="app-absolute-layout scrollable p-24">
        <div class="flex-center-between mb-16">
            <h5>FAQ Config</h5>
            <button class="btn btn-green" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFaqAdd" aria-controls="offcanvasFaqAdd">Add FAQ
                <i class="ml-8 ic-add"></i>
            </button>
        </div>
        <div class="table-responsive mb-24">
            <table class="table-striped table-td-desc" id="faq-DT">
                <thead>
                    <tr>
                        <th class="pl-24">SN</th>
                        <th>Question</th>
                        <th>Answer</th>
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
                $('#offcanvasFaqAdd').addClass('show');
            } else {
                let id = sessionStorage.getItem('id');
                $('#offcanvasFaqEdit').addClass('show');
                $('#faq-edit-form').attr('action', `/admin/faq/${id}`);
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
            let table = $('#faq-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "{{ route('faq.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'question', name: 'question'},
                    {data: 'answer', name: 'answer'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // edit
            table.on('click', '.edit_btn', function(event) {
                let id = $(this).data('faq_id');
                sessionStorage.setItem('id', id);
                $('#faq-edit-form').attr('action', `/admin/faq/${id}`);     // action value as per the id
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/faq/'+id+'/edit',
                    success: function(resp) {
                        $('#e-faq_question').val(resp.question || '');
                        $('#e-faq_answer').val(resp.answer || '');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // delete
            table.on('click', '.delete-btn', function(event) {
                let id = $(this).data('faq_id');
                $('#faq-delete-form').attr('action', `/admin/faq/${id}`);
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
