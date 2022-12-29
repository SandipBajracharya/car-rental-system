@extends('layouts.adminLayout')

@section('page-specific-styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('pages.admin.reservation.show')
    @include('pages.admin.reservation.edit')

    <!-- delete modal -->
    {{-- @include('include.admin.components.deleteDialog', ['id' => 'reservation-delete-form']) --}}

    <div class="app-absolute-layout scrollable p-24">
        <div class="flex-center-between mb-16">
            <h5>Active Reservations</h5>
        </div>
        <div class="table-responsive">
            <table class="table-striped" id="a_resn-list-DT">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Reservation ID</th>
                        <th>Client</th>
                        <th>Phone No.</th>
                        <th>Vehicle</th>
                        <th>Reservation Period</th>
                        <th>Amount</th>
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

    @if (count($errors) > 0)
        <script>
            let id = sessionStorage.getItem('id');
            $('#offcanvasVehicleEdit').addClass('show');
            $('#reservation-edit-form').attr('action', `/admin/reservation/${id}`);
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
            let table = $('#a_resn-list-DT').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                searchDelay: 400,
                pageLength: 10,
                ajax: "{{ route('reservation.active') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'pl-24'},
                    {data: 'reservation_code', name: 'reservation_code'},
                    {data: 'client', name: 'client'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'vehicle', name: 'vehicle'},
                    {data: 'reservation_period', name: 'reservation_period'},
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
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // edit
            table.on('click', '.edit_btn', function(event) {
                let id = $(this).data('reservation_id');
                let vehicleOptions = '';
                sessionStorage.setItem('id', id);
                $('#reservation-edit-form').attr('action', `/admin/reservation/${id}`);     // action value as per the id
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/reservation/'+id+'/edit',
                    success: function(resp) {
                        console.log(resp);
                        $('#e-reservation-initials').html(resp.initials || 'C');
                        $('#e-reservation-client').html(resp.client || 'NA');
                        $('#e-reservation-phone').html(resp.phone_number || 'NA');
                        $('#e-reservation-period').html(resp.reservation_period || 'NA');
                        $('#e-reservation-vehicle').html(resp.vehicle || 'NA');
                        $('#e-reservation-document_number').html(resp.document_number || 'NA');
                        $('#e-reservation-payment').html(resp.payment_mode || 'NA');
                        $('#e-reservation-amount').html(resp.amount || '$0.00');
                        $('#e-reservation-email').html(resp.email || 'NA');
                        $('#e-reservation-pickup').html(resp.pickup_location || 'NA');
                        vehicleOptions = `<option selected="" value="${resp.vehicle_id}">${resp.vehicle}</option>`;
                        resp.vehicles.forEach(item => {
                            vehicleOptions += `<option value="${item.id}">${item.model}</option>`;
                        });
                        $('#e-reservation-vehicle').html(vehicleOptions || 'NA');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection