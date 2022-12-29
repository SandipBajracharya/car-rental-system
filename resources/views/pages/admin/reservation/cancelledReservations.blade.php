@extends('layouts.adminLayout')

@section('page-specific-styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('pages.admin.reservation.show')

    <div class="app-absolute-layout scrollable p-24">
        <h5 class="mb-16">Cancelled Reservation</h5>
        <ul class="nav nav-pills" id="myTab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab"
                    id="refund-pending-tab" data-bs-target="#refund-pending" type="button" role="tab"
                    aria-controls="refund-pending" aria-selected="true">refund-pending</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab"
                    id="refund-completed-tab" data-bs-target="#refund-completed" type="button" role="tab"
                    aria-controls="refund-completed" aria-selected="false">refund-completed</button></li>
        </ul>
        <div class="tab-content mt-16" id="myTabContent">
            <div class="tab-pane fade show active" id="refund-pending" role="tabpanel"
                aria-labelledby="pending-tab">
                <div class="table-responsive">
                    <table class="table-striped" id="refund-pending-DT">
                        <thead>
                            <tr>
                                <th class="pl-24">SN</th>
                                <th>Reservation ID</th>
                                <th>Client</th>
                                <th>Phone No.</th>
                                <th>Vehicle</th>
                                <th>Refund Type</th>
                                <th>Amount</th>
                                <th class="text-end pr-24">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="refund-completed" role="tabpanel"
                aria-labelledby="completed-tab">
                <div class="table-responsive">
                    <table class="table-striped" id="refund-complete-DT">
                        <thead>
                            <tr>
                                <th class="pl-24">SN</th>
                                <th>Reservation ID</th>
                                <th>Client</th>
                                <th>Phone No.</th>
                                <th>Vehicle</th>
                                <th>Refund Type</th>
                                <th>Amount</th>
                                <th class="text-end pr-24">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-specific-scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>

    <script>
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
            
            // datatable
            let table = $('#refund-pending-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "/admin/cancelled-reservations?pending=1",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'reservation_code', name: 'reservation_code'},
                    {data: 'client', name: 'client'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'vehicle', name: 'vehicle'},
                    {data: 'refund_type', name: 'refund_type'},
                    {data: 'amount', name: 'amount'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, class: 'flex-end'},
                ]
            });

            // show
            table.on('click', '.show_btn', function(event) {
                let id = $(this).data('reservation_id');
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/reservations/show/'+id,
                    success: function(resp) {
                        console.log(resp);
                        $('#show-reservation-initials').html(resp.initials || 'C');
                        $('#show-reservation-client').html(resp.client || 'NA');
                        $('#show-reservation-phone').html(resp.phone_number || 'NA');
                        $('#show-reservation-period').html(resp.reservation_period || 'NA');
                        $('#show-reservation-vehicle').html(resp.vehicle || 'NA');
                        $('#show-reservation-document_number').html(resp.document_number || 'NA');
                        $('#show-reservation-payment').html(resp.payment_mode || 'NA');
                        $('#show-reservation-amount').html('$'+resp.amount || '$0.00');
                        $('#show-reservation-email').html(resp.email || 'NA');
                        $('#show-reservation-pickup').html(resp.pickup_location || 'NA');
                        $('#show-reservation-mar').css('display', 'flex');
                        $('#mark-as-refunded').attr('href', `/admin/reservation/mark-as-refunded/${id}`);     // action value as per the id
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            let table2 = $('#refund-complete-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "/admin/cancelled-reservations",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'reservation_code', name: 'reservation_code'},
                    {data: 'client', name: 'client'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'vehicle', name: 'vehicle'},
                    {data: 'refund_type', name: 'refund_type'},
                    {data: 'amount', name: 'amount'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, class: 'flex-end'},
                ]
            });

            // show
            table2.on('click', '.show_btn', function(event) {
                let id = $(this).data('reservation_id');
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/reservations/show/'+id,
                    success: function(resp) {
                        console.log(resp);
                        $('#show-reservation-initials').html(resp.initials || 'C');
                        $('#show-reservation-client').html(resp.client || 'NA');
                        $('#show-reservation-phone').html(resp.phone_number || 'NA');
                        $('#show-reservation-period').html(resp.reservation_period || 'NA');
                        $('#show-reservation-vehicle').html(resp.vehicle || 'NA');
                        $('#show-reservation-document_number').html(resp.document_number || 'NA');
                        $('#show-reservation-payment').html(resp.payment_mode || 'NA');
                        $('#show-reservation-amount').html('$'+resp.amount || '$0.00');
                        $('#show-reservation-email').html(resp.email || 'NA');
                        $('#show-reservation-pickup').html(resp.pickup_location || 'NA');
                        $('#show-reservation-mar').css('display', 'none');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
