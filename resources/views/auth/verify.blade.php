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
                                <h2 class="mb-24">{{ __('Verify Your Email Address') }}</h2>
                                
                                @if (session('resent'))
                                    <div class="alert alert-success mb-40" role="alert">
                                        {{ __('A fresh verification link has been sent to your email address.') }}
                                    </div>
                                @endif

                                <p class="mb-24"> {{ __('Before proceeding, please check your email for a verification link.') }}</p>

                                <p class="mb-24"> {{ __('If you did not receive the email') }}, </p>

                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-24">{{ __('click here to request another') }}</button>.
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
