@extends('layouts.mainLayout')

@section('main-content')
    @php
        $breadcrumb_arr = ['Home' => '/', 'Contact Us' => '#']; 
        $phone = strpos($contact->phone, '/') === false? $contact->phone : substr($contact->phone, 0 , strpos($contact->phone, '/'));
    @endphp
    @include('include.main.innerHeader', ['breadcrumb_arr' => $breadcrumb_arr])

    <section class="faq py-md-88 py-64 bg-gray50">
        <div class="container">
            <h2 class="text-center text-primary heading--underline center">Keep In Touch</h2>
            <div class="flex-center mt-32 mb-40">
                <p class="textbox-w-50 text-center">Contact us for any inquiries.</p>
            </div>
            <div class="row flex-center gap-24-row">
                <div class="col-lg-4 col-md-6">
                    <div class="flex-center-center flex-column">
                        <div class="circle bg-primary mb-24"><i class="ic-location h3 text-white"></i></div>
                        <p class="mb-8">Address</p><a class="h6 text-center"
                            href="javascript:void(0)">{{$contact->address ?? '-'}}</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="flex-center-center flex-column">
                        <div class="circle bg-primary mb-24"><i class="ic-call h3 text-white"></i></div>
                        <p class="mb-8">Phone Number</p><a class="h6 text-center" href="tel:{{$phone}}">{{$contact->phone ?? '-'}}</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="flex-center-center flex-column">
                        <div class="circle bg-primary mb-24"><i class="ic-mail-fill h3 text-white"></i></div>
                        <p class="mb-8">Email</p><a class="h6 text-center" href="mailto:{{$contact->email ?? ''}}">{{$contact->email ?? '-'}}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="img-landscape mt-56"><iframe
                src="{{$contact->map ?? '#'}}"
                width="600" height="450" style="border:0" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe></div>
        <div class="container position-relative mt-n88">
            <div class="bg-white shadow-1 px-md-40 p-24 py-md-80">
                <h2 class="text-center text-primary heading--underline center">Feedback</h2>
                <div class="flex-center mt-32 mb-32">
                    <p class="textbox-w-50 text-center">Feel free to leave your feedback or ask any queries regarding our services.</p>
                </div>
                <form action="{{route('feedback.add')}}" method="POST">
                    @csrf
                    <div class="row mb-40 gap-24-row">
                        <div class="col-md-6">
                            <div class="form-floating mb-24">
                                <input class="form-control @error('fullname') is-invalid @enderror" id="floatingInput" name="fullname" placeholder="Full Name" required>
                                <label for="floatingInput">Full Name <span class="text-danger">*</span></label>

                                @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-24">
                                <input class="form-control @error('email') is-invalid @enderror" id="floatingInput" name="email" placeholder="Email" type="email" required>
                                <label for="floatingInput">Email <span class="text-danger">*</span></label>
                                
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                              
                            </div>
                            <div class="form-floating">
                                <input class="form-control @error('subject') is-invalid @enderror" id="floatingInput" name="subject" placeholder="Subject" required>
                                <label for="floatingInput">Subject <span class="text-danger">*</span></label>

                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating h-100">
                                <textarea class="form-control h-100 @error('message') is-invalid @enderror" id="floatingTextarea" name="message" placeholder="Leave a comment here">{{old('message')}}</textarea>
                                <label for="floatingTextarea">Message</label>

                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                </form>
            </div>
        </div>
    </section>
@endsection