@extends('layouts.mainLayout')

@section('main-content')
    @php
        $car = '2020 Ford Raptor (Auto) Dual Cab';
        $breadcrumb_arr = ['Home' => '/', 'Our Cars' => '/car-listing', $car => '#'];
    @endphp
    @include('include.main.innerHeader', ['breadcrumb_arr' => $breadcrumb_arr])

    <section class="car-checkout-guest py-md-88 py-64 bg-gray50">
        <div class="container">
            @if (isset($is_guest) && $is_guest)
                <p class="fw-semibold mb-24">Since you are checking out as a guest we require you to fill the following form
                </p>
            @endif
            <div class="row gap-24-row">
                <div class="col-xl-8">
                    @if (isset($is_guest) && $is_guest)
                        <form action="{{route('process_reservation.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="bg-white p-32 mb-24">
                                <h3 class="text-primary mb-24">Personal Details</h3>
                                <h5 class="mb-16">Renter Information</h5>
                                <div class="row mb-40 gap-24-row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('full_name') is-invalid @enderror" id="floatingInput" name="full_name" value="{{old('full_name')}}" placeholder="Full Name">
                                            <label for="floatingInput">Full Name</label>

                                            @error('full_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('email') is-invalid @enderror" id="floatingInput" name="email" type="email" value="{{old('email')}}" placeholder="Email">
                                            <label for="floatingInput">Email Address</label>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('country') is-invalid @enderror" id="floatingInput" name="country" value="{{old('country')}}" placeholder="Country">
                                            <label for="floatingInput">Country</label>

                                            @error('country')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('state') is-invalid @enderror" id="floatingInput" name="state" value="{{old('state')}}" placeholder="State">
                                            <label for="floatingInput">State</label>

                                            @error('state')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('city') is-invalid @enderror" id="floatingInput" name="city" value="{{old('city')}}" placeholder="City">
                                            <label for="floatingInput">City</label>

                                            @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('street') is-invalid @enderror" id="floatingInput" name="street" value="{{old('street')}}" placeholder="Street">
                                            <label for="floatingInput">Street</label>

                                            @error('street')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('postal_code') is-invalid @enderror" id="floatingInput" name="postal_code" value="{{old('postal_code')}}" placeholder="Postal">
                                            <label for="floatingInput">Postal Code</label>

                                            @error('postal_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-16">Driver License Information</h5>
                                <div class="row mb-40 gap-24-row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('dob') is-invalid @enderror" id="floatingInput" name="dob" type="date" value="{{old('dob')}}" placeholder="Birth Date">
                                            <label for="floatingInput">Birth Date</label>

                                            @error('dob')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('document_number') is-invalid @enderror" id="floatingInput" name="document_number" value="{{old('document_number')}}" placeholder="License">
                                            <label for="floatingInput">License No.</label>

                                            @error('document_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('document_country') is-invalid @enderror" id="floatingInput" name="document_country" value="{{old('document_country')}}" placeholder="Country">
                                            <label for="floatingInput">Country</label>
                                            
                                            @error('document_country')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('document_expire') is-invalid @enderror" id="floatingInput" name="document_expire" value="{{old('document_expire')}}" type="date" placeholder="Expiry Date">
                                            <label for="floatingInput">License Expiry Date</label>

                                            @error('document_expire')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="formFile">Driver License Image/PDF</label>
                                        <input class="form-control @error('document_image') is-invalid @enderror" id="formFile" type="file" name="document_image"></div>

                                        @error('document_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <h5 class="mb-16">Additional Information</h5>
                                <div class="form-floating h-100">
                                    <textarea class="form-control" id="floatingTextarea" placeholder="Leave a comment here" name="notes" value="{{old('notes')}}"></textarea>
                                    <label for="floatingTextarea">Message</label>
                                </div>
                            </div>
                            <div class="bg-white p-32">
                                <h3 class="text-primary mb-24">Payment Method</h3>
                                <div class="custom-radio-image">
                                    <div class="align-center flex-column">
                                        <input class="input-hidden" id="map1" type="radio" name="map" checked="">
                                        <label class="border border-cool-gray-400" for="map1">
                                            <img src="/images/master.png" alt="">
                                        </label>
                                    </div>
                                    <div class="align-center flex-column">
                                        <input class="input-hidden" id="map2" type="radio" name="map">
                                        <label class="border border-cool-gray-400" for="map2">
                                            <img src="/images/paypal.png" alt="">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-floating mb-24"><input class="form-control" id="floatingInput"
                                        placeholder="Cardholder Name"><label for="floatingInput">Cardholder Name</label></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-24"><input class="form-control" id="floatingInput"
                                                placeholder="Cardholder Name"><label for="floatingInput">Cardholder Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-24"><input class="form-control" id="floatingInput"
                                                placeholder="date"><label for="floatingInput">Date</label></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-24"><input class="form-control" id="floatingInput"
                                                placeholder="ccv"><label for="floatingInput">CCV</label></div>
                                    </div>
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="terms">
                                    <label class="form-check-label" for="terms">I agree to the 
                                        <a class="fw-semibold text-primary" href="Privacy.html">Terms & Conditions</a>
                                    </label>
                                </div>
                                <div class="flex-end">
                                    <button class="btn btn-primary btn-lg mt-24" type="submit" data-bs-target="#bookingSuccessModal" data-bs-toggle="modal">
                                        Confirm your booking
                                    </button>
                                </div>
                            </div>
                            <input name="document_type" value="Driving license" type="hidden">
                        </form>
                    @else
                        <div class="bg-white p-32 mb-24">
                            <h3 class="text-primary mb-24">Payment Method</h3>
                            <div class="row mb-40 gap-24-row">
                                <div class="col-md-6">
                                    <div class="form-floating"><input class="form-control" id="floatingInput"
                                            type="date" placeholder="Birth Date"><label for="floatingInput">Birth
                                            Date</label></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating"><input class="form-control" id="floatingInput"
                                            placeholder="License"><label for="floatingInput">License No.</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating"><input class="form-control" id="floatingInput"
                                            placeholder="Country"><label for="floatingInput">Country</label></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating"><input class="form-control" id="floatingInput"
                                            type="date" placeholder="Expiry Date"><label for="floatingInput">License
                                            Expiry Date</label></div>
                                </div>
                            </div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="terms">
                                <label class="form-check-label" for="terms">I agree to the 
                                    <a class="fw-semibold text-primary" href="Privacy.html">Terms & Conditions</a>
                                </label>
                            </div>
                            <div class="flex-end">
                                <button class="btn btn-primary btn-lg mt-24" data-bs-target="#bookingSuccessModal" data-bs-toggle="modal">
                                    Proceed to Payment
                                </button>
                            </div>
                        </div>
                        <div class="modal fade" id="bookingSuccessModal" tabindex="-1" aria-labelledby="bookingSuccessModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body p-md-72 p-24">
                                        <div class="">
                                            <h3 class="text-primary mb-24">Payment Method</h3>

                                            <form action="{{route('reserve.car')}}" method="POST">
                                                @csrf
                                                <div class="custom-radio-image">
                                                    <div class="align-center flex-column">
                                                        <input class="input-hidden" id="map1" type="radio" name="pmt_gateway" value="master" checked="">
                                                        <label class="border border-cool-gray-400" for="map1">
                                                            <img src="/images/master.png" alt="">
                                                        </label>
                                                    </div>
                                                    <div class="align-center flex-column">
                                                        <input class="input-hidden" id="map2" type="radio" name="pmt_gateway" value="paypal">
                                                        <label class="border border-cool-gray-400" for="map2">
                                                            <img src="/images/paypal.png" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <button type="submit">Submit</button>
                                            </form>

                                            @if ($message = Session::get('success'))
                                                <div class="custom-alerts alert alert-success fade in">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    {!! $message !!}
                                                </div>
                                                <?php Session::forget('success');?>
                                            @endif
                            
                                            @if ($message = Session::get('error'))
                                                <div class="custom-alerts alert alert-danger fade in">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    {!! $message !!}
                                                </div>
                                                <?php Session::forget('error');?>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-xl-4">
                    <div class="bg-white p-32 mb-24">
                        <h3 class="text-primary mb-24">Booking Summary</h3>
                        <div class="row border-bottom pb-24 mb-24 gap-24-row gx-32">
                            <div class="col-5">
                                <p>Pick-up Location</p>
                            </div>
                            <div class="col-7">
                                <p class="fw-semibold">{{$reserve_info['pickup_location'] ?? '-'}}</p>
                            </div>
                            <div class="col-5">
                                <p>Pick-up Date</p>
                            </div>
                            <div class="col-7">
                                <p class="fw-semibold">{{$reserve_info['start_dt']? date('Y/m/d', strtotime($reserve_info['start_dt'])) : '-'}}</p>
                            </div>
                            <div class="col-5">
                                <p>Pick-up Time</p>
                            </div>
                            <div class="col-7">
                                <p class="fw-semibold">{{$reserve_info['start_dt']? date('H:i A', strtotime($reserve_info['start_dt'])) : '-'}}</p>
                            </div>
                            <div class="col-5">
                                <p>Drop-off Date</p>
                            </div>
                            <div class="col-7">
                                <p class="fw-semibold">{{$reserve_info['end_dt']? date('Y/m/d', strtotime($reserve_info['end_dt'])) : '-'}}</p>
                            </div>
                            <div class="col-5">
                                <p>Drop-off Time</p>
                            </div>
                            <div class="col-7">
                                <p class="fw-semibold">{{$reserve_info['end_dt']? date('H:i A', strtotime($reserve_info['end_dt'])) : '-'}}</p>
                            </div>
                        </div>
                        <div class="flex-center-between">
                            <div>
                                <h6 class="mb-4">Total Payable</h6><small>[Inc. VAT]</small>
                            </div>
                            <h3>${{$total ?? 0.00}}</h3>
                        </div>
                    </div><a class="align-center text-primary fw-semibold" href="/car-listing"><i
                            class="ic-chevron-left mr-8"></i>Select Different Car</a>
                </div>
            </div>
        </div>
    </section>
@endsection
