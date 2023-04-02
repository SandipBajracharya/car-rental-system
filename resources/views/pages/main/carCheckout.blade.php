@extends('layouts.mainLayout')

@section('main-content')
    @php
        $breadcrumb_arr = ['Home' => '/', 'Checkout' => '#'];
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
                        <form action="{{route('guest.store')}}" method="POST" enctype="multipart/form-data">
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
                                            <input class="form-control @error('mobile_number') is-invalid @enderror" id="floatingInput" name="mobile_number" type="text" value="{{old('mobile_number')}}" placeholder="Contact number">
                                            <label for="floatingInput">Contact number</label>

                                            @error('mobile_number')
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
                                        <label class="form-label" for="formFile">Driver License Image</label>
                                        <input class="form-control @error('document_image') is-invalid @enderror" id="formFile" type="file" name="document_image" accept="image/*">

                                        @error('document_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <h5 class="mb-16">Additional Information</h5>
                                <div class="form-floating h-100">
                                    <textarea class="form-control" id="floatingTextarea" placeholder="Leave a comment here" name="notes" value="{{old('notes')}}"></textarea>
                                    <label for="floatingTextarea">Message</label>
                                </div>
                                <div class="flex-end">
                                    <button type="submit" class="btn btn-primary btn-lg mt-24" >
                                        Proceed to Payment
                                    </button>
                                </div>
                            </div>
                            <input name="document_type" value="Driving license" type="hidden">
                        </form>
                    @else
                        <div class="bg-white p-32 mb-24">
                            <h3 class="text-primary mb-24">Document Details</h3>
                            <div class="row mb-40 gap-24-row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="floatingInput" placeholder="Expiry Date" value="{{auth()->user()->first_name .' '.auth()->user()->last_name}}" disabled>
                                        <label for="floatingInput">Document owner</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="floatingInput" type="date" value="{{auth()->user()->profile->dob}}" disabled>
                                        <label for="floatingInput">Birth Date</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="floatingInput" placeholder="Expiry Date" value="{{auth()->user()->profile->document_type}}" disabled>
                                        <label for="floatingInput">Document type</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="floatingInput" value="{{auth()->user()->profile->document_number}}" disabled>
                                        <label for="floatingInput">Document No.</label>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-end">
                                <a href="/payment-option" class="btn btn-primary btn-lg mt-24" >
                                    Proceed to Payment
                                </a>
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
                    </div>
                    <a class="align-center text-primary fw-semibold" href="{{getCarListUrl()}}">
                        <i class="ic-chevron-left mr-8"></i>Select Different Car
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
