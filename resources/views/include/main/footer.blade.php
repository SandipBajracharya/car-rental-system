@php
    $contact = getContact();
    $phone = substr($contact->phone, 0 , strpos($contact->phone, '/'));
@endphp

<footer class="position-relative pt-lg-88 bg-gray50">
    <div class="footer-cta">
        <div class="row gx-0 flex-end">
            <div class="col-xl-10 col-lg-11 bg-primary py-md-48 py-32">
                <h1 class="fw-regular">Need help renting car online? Call <a class="fw-bold"
                        href="tel:{{$phone}}">{{$phone}}</a></h1>
            </div>
        </div>
    </div>
    <div class="footer-links">
        <div class="container">
            <div class="row gap-40-row">
                <div class="col-lg-4 col-md-6">
                    <h4 class="mb-32">Quick Link</h4>
                    <ul class="gap-24-vertical">
                        <li><a href="/">Home</a></li>
                        <li><a href="{{getCarListUrl()}}">Our Cars</a></li>
                        <li><a href="/faq">FAQs</a></li>
                        <li><a href="/about-us">About Us</a></li>
                        <li><a href="/contact-us">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="mb-32">Contact Information</h4>
                    <ul class="gap-24-vertical">
                        <li><a href="#">Address : {{$contact->address?? '-'}}</a></li>
                        <li><a href="#">Phone :  {{$contact->phone?? '-'}}</a></li>
                        <li><a href="mailto:{{$contact->email?? ''}}">Email : {{$contact->email?? '-'}}</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h4 class="mb-32">Map Location</h4>
                    <div class="img-landscape">
                        <iframe src="{{$contact->map ?? ''}}" width="600" height="450" style="border:0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white py-16">
        <div class="container flex-center-between gap-16 flex-wrap">
            <ul class="gap-24">
                @if (!empty($contact->facebook_link))
                    <li><a class="circle-sm bg-cGray100" href="{{$contact->facebook_link ?? '#'}}" target="_blank"><i class="ic-facebook h3"></i></a></li>
                @endif
                @if (!empty($contact->twitter_link))
                    <li><a class="circle-sm bg-cGray100" href="{{$contact->twitter_link ?? '#'}}" target="_blank"><i class="ic-twitter h3"></i></a></li>
                @endif
                @if (!empty($contact->insta_link))
                    <li><a class="circle-sm bg-cGray100" href="{{$contact->insta_link ?? '#'}}" target="_blank"><i class="ic-instagram h3"></i></a></li>
                @endif
            </ul>
            <p>©Copyright {{date('Y')}} {{config('app.name')}}</p>
        </div>
    </div>
</footer>