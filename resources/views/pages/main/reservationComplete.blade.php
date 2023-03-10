@extends('layouts.mainLayout')

@section('main-content')
    @php
        $breadcrumb_arr = ['Home' => '/', 'Reservation Complete' => '#']; 
    @endphp
    @include('include.main.innerHeader', ['breadcrumb_arr' => $breadcrumb_arr])

    <section class="py-md-88 py-64 bg-gray50">
        <div class="container">
            <div class="row flex-center">
                <div class="col-lg-6 col-md-8">
                    <div class="flex-center-center flex-column"><img src="/images/booking-success.svg" alt="">
                        <h3 class="text-primary text-center my-24">You have successfully rented a car from us.</h3>
                        @if (auth()->check())
                            <a class="btn btn-primary btn-lg" href="/booking-history" type="button">View Booking Detail</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
