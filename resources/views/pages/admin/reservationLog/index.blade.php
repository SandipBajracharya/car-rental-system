@extends('layouts.adminLayout')

@section('page-specific-styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('pages.admin.reservationLog.show')

    <div class="app-absolute-layout scrollable p-24">
        <div class="flex-center-between mb-16">
            <h5>Your Notifications</h5>
        </div>
        <div class="table-responsive">
            <table class="table-striped" id="reservation-log-DT">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date & Time</th>
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
            let table = $('#reservation-log-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "{{ route('reservation-log.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'date_time', name: 'date_time'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, class: 'flex-end'},
                ]
            });

            // show
            table.on('click', '.show-btn', function(event) {
                let id = $(this).data('res_log_id');
                
                console.log('show clicked');
                $.ajax({
                    type: 'GET',
                    url: '/admin/reservation-notification/show/'+id,
                    success: function(resp) {
                        console.log(resp);
                        $('#notification-title').html(resp.title || '-');
                        $('#show-notification-description').html(resp.description || '-');
                        $('#show-notification-type').html(resp.type || '-');
                        $('#show-notification-performer').html(resp.performer || '-');
                        $('#show-notification-status').html(resp.status || '-');
                        $('#show-notification-code').html(resp.code || '-');
                        $('#show-notification-model').html(resp.model || '-');
                        $('#show-notification-period').html(resp.period || '-');
                        $('#show-notification-amount').html(resp.amount || '-');
                        $('#show-notification-user').html(resp.user || '-');
                        $('#show-notification-phone').html(resp.phone || '-');
                        $('#show-notification-email').html(resp.email || '-');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // availability update
            table.on('change', '.mark-read-btn', function(event) {
                let id = $(this).data('res_log_id');
                
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
    </script>
@endsection
