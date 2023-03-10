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
                                <h2 class="mb-24">Reset Password</h2>
                                
                                <p class="mb-40">Please enter your email address and set new password.</p>
                                @if (session('status'))
                                    <div class="alert alert-info mb-24" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-floating mb-24">
                                        <input class="form-control @error('email') is-invalid @enderror" id="floatingName" type="email" placeholder="email" name="email" value="{{ $email ?? old('email') }}" required>
                                        <label for="floatingName">Email Address</label>
                                        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-floating mb-24">
                                        <input class="form-control @error('password') is-invalid @enderror" id="floatingPassword" type="password" placeholder="password" name="password" value="{{ old('password') }}" required>
                                        <label for="floatingPassword">Password</label>
                                        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-floating mb-40">
                                        <input class="form-control" id="floatingInput" type="password" placeholder="password-confirm" name="password_confirmation" required autocomplete="new-password">
                                        <label for="floatingInput">Confirm Password</label>
                                    </div>

                                    <button class="btn btn-primary btn-lg w-100 mb-24" type="submit">Reset Password</button>
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
