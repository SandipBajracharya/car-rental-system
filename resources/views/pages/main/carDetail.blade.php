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
                        @if (isset($vehicle->features))
                            <div class="col-sm-6 align-center">
                                <h6 class="text-cGray600">{!! $vehicle->features !!}</h6>
                            </div>    
                        @else
                            <div class="col-sm-6 align-center">
                                <h6 class="text-cGray600">NA</h6>
                            </div>
                        @endif
                    </div>
                    @if ($show_filter)                        
                        <div class="row gap-24-row mb-24">
                            <div class="col-md-6"><input class="form-control form-control-lg"
                                    placeholder="Pick-up Location" /><small></small></div>
                            <div class="col-md-6">
                                <div class="form-icon trail"><input class="form-control form-control-lg"
                                        placeholder="Pickup Date" /><i class="lg ic-calendar"></i></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-icon trail"><input class="form-control form-control-lg"
                                        placeholder="Pickup Time" /><i class="lg ic-clock-outline"></i></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-icon trail"><input class="form-control form-control-lg"
                                        placeholder="Drop-off Date" /><i class="lg ic-calendar"></i></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-icon trail"><input class="form-control form-control-lg"
                                        placeholder="Drop-off Time" /><i class="lg ic-clock-outline"></i></div>
                            </div>
                            <div class="col-md-6"><button class="btn btn-primary btn-lg w-100">Check Availability</button>
                            </div>
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
    <script>
        function checkoutAsGuest() {
            sessionStorage.setItem('is_guest', true);
            window.location.href = '/checkout';
        }
    </script>
@endsection
