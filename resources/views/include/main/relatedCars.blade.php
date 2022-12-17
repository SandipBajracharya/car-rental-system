@php
    $vehicles = getRelatedCars($id);
@endphp
<div class="flex-center-between border-bottom border-gray200 pb-16 mb-32">
    <h3 class="text-primary">Relates Cars</h3><a href="/car-listing">View All</a>
</div>
@foreach ($vehicles as $vehicle)
    @php
        $image = '';
        if (isset($vehicle->images) && $vehicle->images != "[]") {
            $images = json_decode($vehicle->images, true);
            $image = $images[0];
        }
    @endphp
    <div class="card-car card-car--inline p-24 bg-white">
        <div class="thumb">
            <div class="img-landscape"><img src="/images/vehicles/{{$image}}" alt=""></div>
        </div>
        <div class="flex-grow-1">
            <div class="flex-center-between gap-12">
                <h6 class="clamp-1">{{$vehicle->model}}</h6>
                @if ($vehicle->availability)
                    <div class="badge badge-primary">Available</div>
                @else
                    <div class="badge badge-gray">Unavailable</div>
                @endif
            </div>
            <div class="flex-center-between border-top border-cGray300 mt-16 pt-16"><a
                    href="/car-detail/{{$vehicle->slug}}">Details</a>
                <p>Starting at <span class="fw-semibold text-danger">${{$vehicle->pricing}}</span> / <small
                        class="d-inline">day</small></p>
            </div>
        </div>
    </div>
@endforeach