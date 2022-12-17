<ul class="breadcrumb-main slash">
    {{-- <li class="breadcrumb-main-item"><a class="text-white" href="/">Home</a></li>
    <li class="breadcrumb-main-item"><a class="text-white" href="/car-listing">Our Cars</a></li> --}}
    @foreach ($breadcrumb as $key => $item)
        <li class="breadcrumb-main-item">
            <a class="text-white" href="{{$item}}">{{$key}}</a>
        </li>
    @endforeach
</ul>