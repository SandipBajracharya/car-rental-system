@extends('layouts.mainLayout')

@section('page-specific-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
@endsection

@section('main-content')
    @php
        $breadcrumb_arr = ['Home' => '/', 'History' => '#'];
    @endphp
    @include('include.main.innerHeader', ['breadcrumb_arr' => $breadcrumb_arr])

    @include('pages.customer.history.show')

    <section class="history py-md-88 py-64 bg-gray50">
        <div class="container">
            <div class="table-responsive mb-24">
                <table id="customerHistory">
                    <thead>
                        <tr>
                            <th class="pl-24">Reservation ID</th>
                            <th>Vehicle</th>
                            <th>Vehicle Name</th>
                            <th>Reservation Period</th>
                            <th>Status</th>
                            <th class="text-end pr-24">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $item)
                            @php
                                $image = '';
                                if (!empty($item->vehicles->images)) {
                                    $image = json_decode($item->vehicles->images, true);
                                }
                            @endphp
                            <tr>
                                <td class="pl-24">{{$item->reservation_code}}</td>
                                <td><img src="/images/vehicles/{{$image[0]}}" alt="" /></td>
                                <td>{{$item->vehicles->model}}</td>
                                <td>{{date('H:i A jS M Y', strtotime($item->start_dt))}} - {{date('H:i A jS M Y', strtotime($item->start_dt))}}</td>
                                <td>
                                    <div class="badge {{strtolower($item->status) == 'active'? 'badge-primary' : (strtolower($item->status) == 'completed'? 'badge-green': 'badge-red')}}">{{$item->status}}</div>
                                </td>
                                <td class="pr-24">
                                    <div class="flex-end">
                                        <button class="btn btn-ghost-gray btn-sm show_btn" data-reservation_id="{{$item->id}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasReservationDetail" aria-controls="offcanvasReservationDetail"><i class="ic-show"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('page-specific-script')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            let table = $('#customerHistory').DataTable();
            
            // show
            table.on('click', '.show_btn', function(event) {
                let id = $(this).data('reservation_id');
                
                $.ajax({
                    type: 'GET',
                    url: '/admin/reservations/show/'+id,
                    success: function(resp) {
                        $('#show-reservation-id').val(resp.reservation_id || '');
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

                        if (resp.status == 'Active') {
                            $('#cancel-btn').css('display', 'block');
                        } else {
                            $('#cancel-btn').css('display', 'none');
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            table.on('click', '.cancel-btn', function(event) {
                
            });
        });
    </script>
@endsection