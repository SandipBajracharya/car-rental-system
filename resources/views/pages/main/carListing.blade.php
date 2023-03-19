@extends('layouts.mainLayout')

@section('main-content')
    @php
        // dd($inputs);
        $breadcrumb_arr = ['Home' => '/', 'Our Cars' => '/car-listing'];
    @endphp
    @include('include.main.innerHeader', ['breadcrumb_arr' => $breadcrumb_arr])

    {{-- car detail modal --}}
    <div class="offcanvas offcanvas-end offcanvas-01" id="offcanvasQuickVehicleDetail" tabindex="-1" aria-labelledby="offcanvasQuickVehicleDetailLabel">
    </div>
    <section class="car-listing bg-gray50 py-md-88 py-64">
        <div class="container">
            <h3 class="text-primary mb-40">Renting a Car is Easy!</h3>
            <form action="{{ route('find.car') }}" method="GET">
                <div class="row gap-24-row mb-24">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label" for="pickup_location">Pick-up Location</label>
                        <input class="form-control form-control-lg" placeholder="Pick-up Location" name="pickup_location" value="{{ count($inputs) > 0? ($inputs['pickup_location'] ?? '') : '' }}" />
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label" for="">Pick-up Date & Time</label>
                        <div class="form-icon trail">
                            <input class="form-control form-control-lg" placeholder="Pickup-up Date &amp; Time" type="datetime-local" name="start_dt" value="{{ count($inputs) > 0? ($inputs['start_dt'] ?? '') : '' }}" />
                            <i class="lg ic-calendar"></i>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label" for="">Drop-off Date & Time</label>
                        <div class="form-icon trail">
                            <input class="form-control form-control-lg" placeholder="Drop-off Date &amp; Time" type="datetime-local" name="end_dt" value="{{ count($inputs) > 0? ($inputs['end_dt'] ?? '') : '' }}" />
                            <i class="lg ic-calendar"></i>
                        </div>
                    </div>
                </div>
                <div class="gap-16 flex-end mb-56">
                    <button  class="btn btn-outline-primary btn-lg">Reset Filter</button>
                    <button type="submit" class="btn btn-primary btn-lg ">Find a Car</button>
                </div>
            </form>
            <div class="row gap-24-row">
                @if (isset($vehicles))
                    @foreach ($vehicles as $vehicle)
                        @php
                            $images = json_decode($vehicle->images, true);
                            $cover_img = isset($images['0'])? $images['0'] : '';
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="card-car">
                                <div class="img-landscape"><img src="/images/vehicles/{{$cover_img}}" alt=""></div>
                                <div class="bg-white border px-32 py-24">
                                    <div class="flex-center-between gap-12">
                                        <h6 class="clamp-1">{{$vehicle->model}}</h6>
                                        @if ($vehicle->availability)
                                            <div class="badge badge-primary">Available</div>
                                        @else
                                            <div class="badge badge-gray">Unavailable</div>
                                        @endif
                                    </div>
                                    <div class="flex-center-between border-top border-cGray300 mt-16 pt-16">
                                        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasQuickVehicleDetail" aria-controls="offcanvasQuickVehicleDetail" onclick="showCarDetail({{$vehicle->id}})">Details</a>
                                        <p>
                                            Starting at <span class="fw-semibold text-danger">${{$vehicle->pricing}}</span> / 
                                            <small class="d-inline">day</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div>
                        No vehicles found.
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('page-specific-script')
    <script src="/js/carModal.js" type="text/javascript"></script>
@endsection