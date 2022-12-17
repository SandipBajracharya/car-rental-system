@extends('layouts.appLayout')

@section('app-content')
    <div id="wrapper">
        <div class="container-fluid h-100">
            <div class="py-48 h-100">
                <div class="row h-100">
                    <div class="col-xxxl-4 col-xl-5 col-md-6">
                        <div class="position-relative h-100">
                            <div class="app-absolute-layout scrollable p-24">
                                <div class="auth__logo mb-48"><img src="/images/logo.svg" alt=""></div>
                                <h2 class="mb-24">Get started</h2>
                                <h6 class="fw-regular mb-40">Already have an accout? 
                                    <a class="fw-semibold text-decoration-underline" href="/login">Login</a>
                                </h6>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-floating mb-24">
                                        <input class="form-control @error('name') is-invalid @enderror" id="floatingName" name="name" value="{{ old('name') }}" placeholder="name" required>
                                        <label for="floatingName">Full name</label>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-24">
                                        <input class="form-control @error('email') is-invalid @enderror" id="floatingInput" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                                        <label for="floatingInput">Email address</label>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-24">
                                        <input class="form-control @error('mobile_number') is-invalid @enderror" id="floatingMobile" type="number" min="0" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="mobile" required>
                                        <label for="floatingMobile">Mobile No.</label>

                                        @error('mobile_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-24">
                                        <input class="form-control @error('password') is-invalid @enderror" id="floatingPassword" type="password" name="password" placeholder="Password" required>
                                        <label for="floatingPassword">Password</label>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-24">
                                        <input class="form-control" id="floatingPassword" type="password" name="password_confirmation" placeholder="Password">
                                        <label for="floatingPassword">Confirm Password</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-24">Register</button>
                                </form>
                                <h6 class="fw-regular mb-16" href="Forgot.html">Or continue with social media</h6>
                                <div class="gap-16">
                                    <a href="#"><img src="/images/fb.svg" alt=""></a>
                                    <a href="{{ url('auth/google') }}"><img src="/images/google.svg" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxxl-8 col-xl-7 col-md-6 d-none d-md-block">
                        <div class="img rounded-8 h-100"><img src="/images/img1.jpg" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
