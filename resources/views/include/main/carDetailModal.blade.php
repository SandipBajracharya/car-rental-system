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
    <div class="border-top border-gray200 mt-24 pt-24 flex-center-between">
        <div>
            <h2 class="text-primary align-center mb-4">${{$vehicle->pricing}} <span class="p text-cGray600 ml-8">Total</span></h2>
            <p>Starting at <span class="fw-semibold text-danger">${{$vehicle->pricing}}</span> / <small
                    class="d-inline">day</small></p>
        </div>
    </div>
</div>
<div class="offcanvas-footer p-16 gap-16 border-top border-gray200">
    <a class="flex-grow-1 btn btn-outline-primary btn-lg" href="/car-detail/{{$vehicle->slug}}">VIEW MORE</a>
    @if (!$show_filter)
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