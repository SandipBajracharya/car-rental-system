@includeWhen(!auth()->check(), 'include.main.bookingAliasModal', ['vehicle_id' => $vehicle->id])

<div class="offcanvas-header">
    <h5 class="text-dark" id="offcanvasQuickVehicleDetailLabel">{{$vehicle->model}}</h5>
    <button class="btn btn-red btn-sm" type="button" data-bs-dismiss="offcanvas" aria-label="Close">
        <i class="ic-close"></i>
    </button>
</div>
<div class="offcanvas-body">
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
    <div class="flex-center mb-32">
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
    <p class="mb-24">{{$vehicle->description}}</p>
    <h5 class="text-primary mb-24">Features</h5>
    <div class="row gap-24-row">
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
    <div class="border-top border-gray200 mt-24 pt-24 flex-center-between">
        <div>
            <h2 class="text-primary align-center mb-4">${{$vehicle->pricing}} <span class="p text-cGray600 ml-8">Total</span></h2>
            <p>Starting at <span class="fw-semibold text-danger">${{$vehicle->pricing}}</span> / <small
                    class="d-inline">day</small></p>
        </div>
    </div>
    @if ($show_filter)
        <div class="row gap-24-row mb-24" id="availability-section">
            <div class="col-md-6">
                <label for="">Pickup Location:</label> <span class="text-danger">*</span>
                <input class="form-control form-control-lg" placeholder="Pick-up Location" name="pickup_location" id="ca_pl" value="{{ old('pickup_location') }}" />
                <span class="text-danger" id="pl_valn" style="display: none;"><small>Pickup location is required</small></span>
            </div>
            <div class="col-md-6">
                <label for="">Start date:</label> <span class="text-danger">*</span>
                <div class="form-icon trail">
                    <input class="form-control form-control-lg" placeholder="Pickup-up Date &amp; Time" type="datetime-local" name="start_dt" id="ca_sd" value="{{ old('start_dt') }}" />
                    <i class="lg ic-calendar"></i>
                </div>
                <span class="text-danger" id="sd_valn" style="display: none;"><small>Start date is required</small></span>
            </div>
            <div class="col-md-6">
                <label for="">End date:</label> <span class="text-danger">*</span>
                <div class="form-icon trail">
                    <input class="form-control form-control-lg" placeholder="Drop-off Date &amp; Time" type="datetime-local" name="end_dt" id="ca_ed" value="{{ old('end_dt') }}" />
                    <i class="lg ic-calendar"></i>
                </div>
                <span class="text-danger" id="ed_valn" style="display: none;"><small>End date is required</small></span>
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
</div>
<div class="offcanvas-footer p-16 gap-16 border-top border-gray200">
    <a class="flex-grow-1 btn btn-outline-primary btn-lg" href="/car-detail/{{$vehicle->slug}}">VIEW MORE</a>
    @if ($show_filter)
        <button class="flex-grow-1 btn btn-primary btn-lg" onclick="checkVehicleAvailability({{$vehicle->id}})" id="ca_btn">Check Availability</button>
        @if (auth()->check())
            <a class="btn btn-primary btn-lg" type="button" href="/checkout?vehicle_id={{$vehicle->id}}">
                <i class="ic-car mr-8"></i>BOOK NOW
            </a>
        @else
            <a class="btn btn-primary btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#bookingAliasModal">
                <i class="ic-car mr-8"></i>BOOK NOW
            </a>
        @endif
    @else
        @if (auth()->check())
            <a class="btn btn-primary btn-lg" type="button" href="/checkout?vehicle_id={{$vehicle->id}}">
                <i class="ic-car mr-8"></i>BOOK NOW
            </a>
        @else
            <a class="btn btn-primary btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#bookingAliasModal">
                <i class="ic-car mr-8"></i>BOOK NOW
            </a>
        @endif
    @endif
</div>