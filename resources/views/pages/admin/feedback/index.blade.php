@extends('layouts.adminLayout')

@section('page-specific-styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')

    <!-- delete modal -->
    @include('include.admin.components.deleteDialog', ['id' => 'feedback-delete-form'])

    <div class="app-absolute-layout scrollable p-24">
        <div class="flex-center-between mb-16">
            <h5>Feedbacks</h5>
        </div>
        <div class="table-responsive mb-24">
            <table class="table-striped table-td-desc" id="feedback-DT">
                <thead>
                    <tr>
                        <th class="pl-24">SN</th>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
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
            let table = $('#feedback-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "{{ route('feedback.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'fullname', name: 'fullname'},
                    {data: 'email', name: 'email'},
                    {data: 'subject', name: 'subject'},
                    {data: 'message', name: 'message'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // delete
            table.on('click', '.delete-btn', function(event) {
                let id = $(this).data('feedback_id');
                $('#feedback-delete-form').attr('action', `/admin/feedback/${id}`);
            });
        });
    </script>
@endsection
