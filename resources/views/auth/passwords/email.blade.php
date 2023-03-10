@extends('layouts.appLayout')

@section('app-content')
    <div id="wrapper">
        <div class="container-fluid h-100">
            <div class="py-48 h-100">
                <div class="row h-100">
                    <div class="col-xl-4 col-md-6">
                        <div class="position-relative h-100">
                            <div class="app-absolute-layout scrollable p-24">
                                <div class="auth__logo mb-48"><img src="/images/logo.svg" alt=""></div>
                                <h2 class="mb-24">Forgot Password?</h2>
                                
                                <p class="mb-40">Please enter your email address to receive a verification code.</p>
                                @if (session('status'))
                                    <div class="alert alert-success mb-24" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-floating mb-24">
                                        <input class="form-control @error('email') is-invalid @enderror" id="floatingName" type="email" placeholder="email" name="email" value="{{ old('email') }}" required>
                                        <label for="floatingName">Email Address</label>
                                        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <p class="mb-40"> 
                                        Did not receive a verification link ? 
                                        <button class="btn btn-sm text-primary" type="submit">Resend Link</button>
                                    </p>
                                    <button class="btn btn-primary btn-lg w-100 mb-24" type="submit">Submit</button>
                                    
                                    <h6 class="fw-regular text-center">Back to 
                                        <a class="fw-semibold text-decoration-underline" href="/login">Login</a>
                                    </h6>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-md-6 d-none d-md-block">
                        <div class="img rounded-8 h-100"><img src="/images/img1.jpg" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
