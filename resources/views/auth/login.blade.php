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
                                <h2 class="mb-24">Welcome Back</h2>
                                <h6 class="fw-regular mb-40">Don't have an accout? 
                                    <a class="fw-semibold text-decoration-underline" href="/register">Create One</a>
                                </h6>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-floating mb-24">
                                        <input class="form-control @error('email') is-invalid @enderror" id="floatingInput" name="email" type="email" value="{{ old('email') }}" placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-24">
                                        <input class="form-control @error('password') is-invalid @enderror" id="floatingPassword" name="password" type="password" placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="flex-center-between mb-40">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                            <label class="form-check-label" for="checkRemember">Remember me</label>
                                        </div>
                                        <a class="p" href="/password/reset">Forgot Password?</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-24">Login</button>
                                </form>
                                <h6 class="fw-regular mb-16" href="Forgot.html">Or continue with social media</h6>
                                <div class="gap-16">
                                    <a href="{{ url('auth/facebook') }}"><img src="/images/fb.svg" alt=""></a>
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
