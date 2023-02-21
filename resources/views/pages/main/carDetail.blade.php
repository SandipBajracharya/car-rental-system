@extends('layouts.mainLayout')

@section('main-content')
    @php
        $car = '2020 Ford Raptor (Auto) Dual Cab';
        $breadcrumb_arr = ['Home' => '/', 'Our Cars' => '/car-listing', $car => '#'];
    @endphp
    @include('include.main.innerHeader', ['breadcrumb_arr' => $breadcrumb_arr])
    @includeWhen(!auth()->check(), 'include.main.bookingAliasModal', ['vehicle_id' => $vehicle->id])

    <section class="car-detail py-md-88 py-64 bg-gray50">
        <div class="container">
            <div class="row mb-88 gap-32-row">
                <div class="col-lg-6">
                    <div class="tab-content mb-32" id="myTabContent">
                        @php
                            $images = [];
                            if (isset($vehicle->images)) {
                                $images = json_decode($vehicle->images, true);
                            }
                        @endphp
                        @foreach ($images as $key => $image)
                            <div class="tab-pane fade {{ $key == 0? 'show active' : ''}}" id="car-{{$key}}" role="tabpanel" aria-labelledby="car-{{$key}}-tab">
                                <div class="img-landscape"><img src="/images/vehicles/{{$image}}" alt=""></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex-center">
                        <ul class="nav nav-tabs nav-image" id="myTab" role="tablist">
                            @foreach ($images as $key => $image)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $key == 0? 'active' : ''}}" data-bs-toggle="tab" id="car-tab" data-bs-target="#car-{{$key}}" type="button" role="tab" aria-controls="car-{{$key}}" aria-selected="true">
                                        <div class="img"><img src="/images/vehicles/{{$image}}" alt=""></div>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="text-primary mb-24">{{$vehicle->model}}</h3>
                    <p class="mb-16">{{$vehicle->description}}</p>
                    <h3 class="border-top border-gray200 pt-24 text-primary mb-24">Features</h3>
                    <div class="row gap-24-row mb-24">
                        @if (count($features) > 0)
                            @foreach ($features as $feature)
                                <div class="col-sm-6 align-center">
                                    <i class="ic-double-check h4 mr-8 text-success"></i>
                                    <h6 class="text-cGray600">{{trim($feature)}}</h6>
                                </div>
                            @endforeach    
                        @else
                            <div class="col-sm-6 align-center">
                                <h6 class="text-cGray600">NA</h6>
                            </div>
                        @endif
                    </div>
                    @if ($show_filter)                        
                        <div class="row gap-24-row mb-24" id="availability-section">
                            <div class="col-md-6">
                                <label for="">Pickup Location:</label> <span class="text-danger">*</span>
                                <input class="form-control form-control-lg" placeholder="Pick-up Location" name="pickup_location" id="ca_pl" value="{{ old('pickup_location') }}" />
                                <small><span class="text-danger" id="pl_valn" style="display: none;">Pickup location is required</span></small>
                            </div>
                            <div class="col-md-6">
                                <label for="">Start date:</label> <span class="text-danger">*</span>
                                <div class="form-icon trail">
                                    <input class="form-control form-control-lg" placeholder="Pickup-up Date &amp; Time" type="datetime-local" name="start_dt" id="ca_sd" value="{{ old('start_dt') }}" />
                                    <i class="lg ic-calendar"></i>
                                </div>
                                <small><span class="text-danger" id="sd_valn" style="display: none;">Pick-up date is required</span></small>
                            </div>
                            <div class="col-md-6">
                                <label for="">End date:</label> <span class="text-danger">*</span>
                                <div class="form-icon trail">
                                    <input class="form-control form-control-lg" placeholder="Drop-off Date &amp; Time" type="datetime-local" name="end_dt" id="ca_ed" value="{{ old('end_dt') }}" />
                                    <i class="lg ic-calendar"></i>
                                </div>
                                <small><span class="text-danger" id="ed_valn" style="display: none;">Drop-off date is required</span></small>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button class="btn btn-primary btn-lg w-100" onclick="checkVehicleAvailability({{$vehicle->id}})" id="ca_btn">Check Availability</button>
                            </div>
                        </div>
                        <div class="row gap-24-row mb-24 text-success flex-center ca_vf" id="car-available" style="display: none">
                            This vehicle is available for booking.!
                        </div>
                        <div class="row gap-24-row mb-24 text-danger flex-center ca_vnf" id="car-unavailable" style="display: none">
                            Sorry! This vehicle is not available for time being. <br>
                            Please try booking other vehicles.
                        </div>
                    @endif
                    <div class="border-top border-gray200 mt-24 pt-24 flex-end">
                        <div>
                            <h2 class="mb-4 text-primary align-center">${{$vehicle->pricing}} <span
                                    class="p text-cGray600 ml-8">Total</span></h2>
                            <p>Starting at <span class="fw-semibold text-danger">${{$vehicle->pricing}}</span> / <small
                                    class="d-inline">day</small></p>
                        </div>
                    </div>
                </div>
                @if ($show_filter)
                    <div class="flex-end border-top border-gray200 pt-24 mt-24 ca_vf" style="display: none;">
                        @if (auth()->check())
                            <a class="btn btn-primary btn-lg" type="button" href="/checkout?vehicle_id={{$vehicle->id}}">
                                <i class="ic-car mr-8"></i>BOOK NOW
                            </a>
                        @else
                            <a class="btn btn-primary btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#bookingAliasModal">
                                <i class="ic-car mr-8"></i>BOOK NOW
                            </a>
                        @endif
                    </div>
                @else
                    <div class="flex-end border-top border-gray200 pt-24 mt-24">
                        @if (auth()->check())
                            <a class="btn btn-primary btn-lg" type="button" href="/checkout?vehicle_id={{$vehicle->id}}">
                                <i class="ic-car mr-8"></i>BOOK NOW
                            </a>
                        @else
                            <a class="btn btn-primary btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#bookingAliasModal">
                                <i class="ic-car mr-8"></i>BOOK NOW
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            <div class="row gx-md-48 gap-48-row">
                <div class="col-xl-6">
                    @include('include.main.relatedCars', ['id' => $vehicle->id])            {{-- to not show the same car in related car --}}
                </div>
                <div class="col-xl-6">
                    @include('include.main.faq')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-specific-script')
    <script src="/js/carModal.js" type="text/javascript"></script>
    <script>
        function checkoutAsGuest() {
            sessionStorage.setItem('is_guest', true);
            window.location.href = '/checkout';
        }
    </script>
@endsection
