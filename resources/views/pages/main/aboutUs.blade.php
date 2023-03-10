@extends('layouts.mainLayout')

@section('main-content')
    @php
        $breadcrumb_arr = ['Home' => '/', 'About Us' => '#']; 
    @endphp
    @include('include.main.innerHeader', ['breadcrumb_arr' => $breadcrumb_arr])

    @if (!empty($about->heading1) && !empty($about->description1))
        <section class="py-md-88 py-64 bg-gray50">
            <div class="container">
                <div class="row flex-center">
                    <div class="col-lg-6 col-md-8">
                        <h5 class="mb-16">{{$about->heading1}}</h5>
                        <div class="textbox mb-24">
                            <p>{{$about->description1}}</p>
                        </div>
                        @if (!empty($about->image))
                            <div class="img-wide"><img src="/images/aboutUs/{{$about->image}}" alt="About Us"></div>
                        @endif
                        @if (!empty($about->heading2) && !empty($about->description2))
                            <div class="bg-primary p-md-40 p-24">
                                <h5 class="heading--underline text-white white mb-32">{{$about->heading2}}</h5>
                                <p class="text-white">{{$about->description2}}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection