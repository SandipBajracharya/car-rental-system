@extends('layouts.mainLayout')

@section('main-content')
    <div class="modal fade modal-confirmation" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Book A Car</h1><button
                        class="btn btn-red btn-sm" type="button" data-bs-dismiss="modal" aria-label="Close"><i
                            class="ic-close"></i></button>
                </div>
                <div class="modal-body p-24 pt-8">
                    <form action="{{ route('find.car') }}" method="GET">
                        <div class="mb-16">
                            <label class="form-label" for="">Pick-up Location</label>
                            <div class="form-icon trail">
                                <input class="form-control form-control-lg" placeholder="Pick-up Location" name="pickup_location" value="{{old('pickup_location')}}"/>
                            </div>
                        </div>
                        <div class="mb-16">
                            <label class="form-label" for="">Pickup-up Date & Time</label>
                            <div class="form-icon trail">
                                <input class="form-control form-control-lg" placeholder="Pickup-up Date &amp; Time" name="start_dt" type="datetime-local" value="{{old('start_dt')}}" />
                                <i class="lg ic-calendar"></i>
                            </div>
                        </div>
                        <div class="mb-16">
                            <label class="form-label" for="">Drop-Off Date & Time</label>
                            <div class="form-icon trail">
                                <input class="form-control form-control-lg" placeholder="Drop-off Date &amp; Time" name="end_dt"  type="datetime-local" value="{{old('end_dt')}}" />
                                <i class="lg ic-calendar"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-lg w-100" type="submit">Find a Car</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="hero">
        <div class="hero-slider">
            <div class="hero-header">
                <div class="hero-header__logo"><img src="./images/logo-light.svg" alt=""></div>
                <ul class="gap-32 align-center">
                    <li><a class="ic-burger-menu text-white h4" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"></a>
                    </li>
                    @guest
                        <li><a class="text-white h6" href="/login">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a class="align-center small" id="dropdownMenua" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (!empty(auth()->user()->social_id))
                                    <div class="avatar-xl">        
                                        <img src="{{auth()->user()->image}}" alt="profile pic">
                                    </div>
                                    @else
                                    @if (!empty(auth()->user()->image))
                                        <div class="avatar-xl">        
                                            <img src="/images/profilePictures/{{auth()->user()->image}}" alt="profile pic">
                                        </div>
                                    @else
                                        <div class="avatar-initial-xl">{{auth()->user()->initials}}</div>
                                    @endif
                                @endif
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <div class="p-24"><small class="text-cGray600 mb-12">Logged in as</small>
                                    <div class="align-center">
                                        @if (!empty(auth()->user()->social_id))
                                        <div class="avatar-xxl">
                                            <img src="{{auth()->user()->image}}" alt="profile pic">
                                        </div>
                                        @else
                                            @if (!empty(auth()->user()->image))
                                            <div class="avatar-xxl">
                                                <img src="/images/profilePictures/{{auth()->user()->image}}" alt="profile pic">
                                            </div>
                                            @else
                                                <div class="avatar-initial-xxl">{{auth()->user()->initials}}</div>
                                            @endif
                                        @endif
                                        <div class="ml-16">
                                            <h5 class="mb-4">{{ auth()->user()->first_name .' '. auth()->user()->last_name }}</h5><small
                                                class="text-cGray600">{{ auth()->user()->email }}</small>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-cGray600 mb-8 px-24">More options</p>
                                <ul class="px-16 pb-16">
                                    @if (auth()->user()->role->id == 1)
                                        <li><a class="dropdown-item" href="/admin/dashboard">Dashboard</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="/booking-history">History</a></li>
                                    <li><a class="dropdown-item" href="/profile-setting">Profile Settings</a></li>
                                    {{-- <li><a class="dropdown-item" href="BookingHistory.html">Booking History</a></li> --}}
                                    {{-- <li><a class="dropdown-item" href="Faq.html">Faq</a></li> --}}
                                    {{-- <li><a class="dropdown-item" href="Privacy.html">Terms & Conditions</a></li> --}}
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
            <div class="swiper swiper-hero h-100">
                <div class="swiper-wrapper">
                    @if (isset($home_sliders))
                        @foreach ($home_sliders as $key => $item)
                            <div class="swiper-slide">
                                <div class="img h-100"><img src="/images/homeSliders/{{$item->images}}" alt=""></div>
                                <div class="content">
                                    <div class="row align-center flex-wrap-reverse">
                                        <div class="col-lg-6 col-md-4">
                                            <div class="gap-24-vertical align-start mb-32"><a
                                                    class="ic-arrow-left text-white h3 heroPrev-btn" type="button"></a><a
                                                    class="ic-arrow-right text-white h3 heroNext-btn" type="button"></a></div>
                                            <div class="align-end">
                                                <h3 class="text-white mr-2">{{$key + 1}}</h3>
                                                <p class="text-white">/{{count($home_sliders)}}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-8">
                                            <h2 class="text-white text-end mb-16">{{$item->heading}}</h2>
                                            <h5 class="text-white text-end heading--underline right">With Everest Car Rental
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="hero-form">
                <button class="btn btn-primary btn-lg w-100 d-block d-md-none" data-bs-toggle="modal"
                    data-bs-target="#bookingModal">Book Now</button>
                <form action="{{ route('find.car') }}" method="GET">
                    <div class="row gap-24-row d-none d-md-flex">
                        <div class="col-md-6">
                            <label class="text-white form-label" for="">Pick-up Location</label>
                            <div class="form-icon trail">
                                <input class="form-control form-control-lg form-transparent" placeholder="Pick-up Location" name="pickup_location" value="{{old('pickup_location')}}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-white form-label" for="">Pick-up Date & Time</label>
                            <div class="form-icon trail">
                                <input class="form-control form-control-lg form-transparent" placeholder="Pickup-up Date &amp; Time" name="start_dt" type="datetime-local" value="{{old('start_dt')}}" />
                                <i class="lg ic-calendar"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-white form-label" for="">Drop-off Date & Time</label>
                            <div class="form-icon trail">
                                <input class="form-control form-control-lg form-transparent" placeholder="Drop-off Date &amp; Time" name="end_dt"  type="datetime-local" value="{{old('end_dt')}}" />
                                <i class="lg ic-calendar"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-white form-label" for="">&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-lg w-100">Find a Car</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            if (isset($topVehicle)) {
                $vehicle1 = $topVehicle->getVehicle($topVehicle->vehicle1);
                $vehicle1_img = json_decode($vehicle1->images, true);
                $vehicle2 = $topVehicle->getVehicle($topVehicle->vehicle2);
                $vehicle2_img = json_decode($vehicle2->images, true);
            }
        @endphp

        <div class="hero-car hero-car--1">
            <div class="img h-100">
                @if (isset($vehicle1_img))
                    <img src="{{'/images/vehicles/'.$vehicle1_img[0]}}" alt="">
                @else
                    <img src="/images/vehicles/car4.jpg" alt="">
                @endif
            </div>
            <div class="hero-car__content">
                <h6 class="text-white heading--underline white">{{ isset($vehicle1)? $vehicle1->model : 'NA' }}</h6>
                <a class="h6 text-white text-end" href="{{ isset($vehicle1)? '/car-detail/'.$vehicle1->slug.'?rent=1' : '#' }}">+ Rent</a>
            </div>
        </div>
        <div class="hero-car hero-car--2">
            <div class="img h-100">
                @if (isset($vehicle2_img))
                    <img src="{{'/images/vehicles/'.$vehicle2_img[0]}}" alt="">
                @else
                    <img src="/images/vehicles/car4.jpg" alt="">
                @endif
            </div>
            <div class="hero-car__content">
                <h6 class="text-white heading--underline white">{{ isset($vehicle2)? $vehicle2->model : 'NA' }}</h6>
                <a class="h6 text-white text-end" href="{{ isset($vehicle2)? '/car-detail/'.$vehicle2->slug.'?rent=1' : '#' }}">+ Rent</a>
            </div>
        </div>
    </section>
@endsection
