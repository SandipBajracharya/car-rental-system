@extends('layouts.mainLayout')

@section('main-content')
    @php
        $breadcrumb_arr = ['Home' => '/', 'FAQ' => '#']; 
    @endphp
    @include('include.main.innerHeader', ['breadcrumb_arr' => $breadcrumb_arr])

    <section class="faq py-md-88 py-64 bg-gray50">
        <div class="container">
            <div class="row gap-24-row">
                <div class="col-xl-3 col-lg-4">
                    <div class="sticker">
                        <h4>FAQ</h4>
                        <div class="sidebar-sticky gap-16-vertical d-none d-lg-flex mt-24">
                            @foreach ($faqs as $item)
                                <a class="side-nav-link p" href="#link-{{$item->id}}" aria-selected="true">
                                    {{$item->question}}<i class="ic-chevron-right"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <ul class="gap-24-vertical">
                        @foreach ($faqs as $faq)
                            <li class="pb-24 border-bottom border-gray200" id="link-{{$faq->id}}">
                                <h6 class="mb-12">{{$faq->question}}</h6>
                                <p>{{$faq->answer}}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection