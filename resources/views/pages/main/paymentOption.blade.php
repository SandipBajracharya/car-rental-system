@extends('layouts.mainLayout')

@section('main-content')
    @php
        $breadcrumb_arr = ['Home' => '/', 'Payment' => '#'];
    @endphp
    @include('include.main.innerHeader', ['breadcrumb_arr' => $breadcrumb_arr])

    <section class="car-detail py-md-88 py-64 bg-gray50">
        <div class="container">
            <div class="row flex-center">
                <div class="col-xl-10">
                    <div class="row gap-24-row">
                        <div class="col-lg-8">
                            {{-- // message  --}}
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {!! $message !!}
                                </div>
                                <?php Session::forget('success');?>
                            @endif

                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger">
                                    {!! $message !!}
                                </div>
                                <?php Session::forget('error');?>
                            @endif

                            <div class="bg-white p-32 mb-24">
                                <h3 class="text-primary mb-8">Payment Method</h3>
                                <p class="mb-24">Select your choice of payment</p>
                                @php
                                    $is_guest = session()->get('is_guest');
                                    if ($is_guest) {
                                        $route = 'process_reservation.store';
                                    } else {
                                        $route = 'reserve.car';
                                    }
                                @endphp
                                <form action="{{route($route)}}" method="POST"  class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ config('stripe.PUBLISH_KEY') }}">
                                    @csrf
                                    <div class="custom-radio-image mb-16">
                                        <div class="align-center flex-column">
                                            <input class="input-hidden" id="map1" type="radio" name="payment" value="stripe" checked="" onclick="changePaymentType('stripe')">
                                            <label class="border border-cool-gray-400" for="map1">
                                                <img src="/images/master.png" alt="">
                                            </label>
                                        </div>
                                        <div class="align-center flex-column">
                                            <input class="input-hidden" id="map2" type="radio" name="payment" value="paypal" onclick="changePaymentType('paypal')">
                                            <label class="border border-cool-gray-400" for="map2">
                                                <img src="/images/paypal.png" alt="">
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{$vehicle_id}}" name="vehicle_id">
                                    <input type="hidden" value="{{$total}}" name="amount">

                                    {{-- Stripe form open  --}}
                                    <div id="stripe-form" class="mb-24">
                                        <div class='form-row row mb-16'>
                                            <div class='col-xs-12 col-md-6 form-group required'>
                                               <label class='control-label'>Name on Card</label> <span class="text-danger">*</span>
                                               <input class='form-control' type='text' name="name">
                                            </div>
                                            <div class='col-xs-12 col-md-6 form-group required'>
                                               <label class='control-label'>Card Number</label> <span class="text-danger">*</span>
                                               <input autocomplete='off' class='form-control card-number' name="card_number" size='20' type='text'>
                                            </div>                           
                                        </div>                        
                                        <div class='form-row row'>
                                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                               <label class='control-label'>CVC</label> <span class="text-danger">*</span>
                                               <input autocomplete='off' class='form-control card-cvc' name="cvc" placeholder='ex. 311' type='text'>
                                            </div>
                                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                               <label class='control-label'>Expiration Month</label> <span class="text-danger">*</span>
                                               <input class='form-control card-expiry-month' name="month" placeholder='MM' size='2' type='text'>
                                            </div>
                                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                               <label class='control-label'>Expiration Year</label> <span class="text-danger">*</span>
                                               <input class='form-control card-expiry-year' name="year" placeholder='YYYY' size='4' type='text'>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Stripe form close --}}

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" name="terms" onclick="termsCheck()">
                                        <label class="form-check-label" for="terms">I agree to the 
                                            <a class="fw-semibold text-primary" href="Privacy.html">Terms & Conditions</a>
                                        </label>
                                    </div>
                                    <div class="flex-end">
                                        <button type="submit" class="btn btn-primary btn-lg mt-24" id="mk-pmt" disabled>Make Payment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="bg-white p-32 mb-24">
                                <h3 class="text-primary mb-24">Booking Summary</h3>
                                <div class="row border-bottom pb-24 mb-24 gap-24-row gx-32">
                                    <div class="col-5">
                                        <p>Pick-up Location</p>
                                    </div>
                                    <div class="col-7">
                                        <p class="fw-semibold">{{$reserve_info['pickup_location'] ?? '-'}}</p>
                                    </div>
                                    <div class="col-5">
                                        <p>Pick-up Date</p>
                                    </div>
                                    <div class="col-7">
                                        <p class="fw-semibold">{{$reserve_info['start_dt']? date('Y/m/d', strtotime($reserve_info['start_dt'])) : '-'}}</p>
                                    </div>
                                    <div class="col-5">
                                        <p>Pick-up Time</p>
                                    </div>
                                    <div class="col-7">
                                        <p class="fw-semibold">{{$reserve_info['start_dt']? date('H:i A', strtotime($reserve_info['start_dt'])) : '-'}}</p>
                                    </div>
                                    <div class="col-5">
                                        <p>Drop-off Date</p>
                                    </div>
                                    <div class="col-7">
                                        <p class="fw-semibold">{{$reserve_info['end_dt']? date('Y/m/d', strtotime($reserve_info['end_dt'])) : '-'}}</p>
                                    </div>
                                    <div class="col-5">
                                        <p>Drop-off Time</p>
                                    </div>
                                    <div class="col-7">
                                        <p class="fw-semibold">{{$reserve_info['end_dt']? date('H:i A', strtotime($reserve_info['end_dt'])) : '-'}}</p>
                                    </div>
                                </div>
                                <div class="flex-center-between">
                                    <div>
                                        <h6 class="mb-4">Total Payable</h6><small>[Inc. VAT]</small>
                                    </div>
                                    <h3>${{$total ?? 0.00}}</h3>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="gateway" value="stripe">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-specific-script')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            var $form = $(".require-validation");
            $('form.require-validation').bind('submit', function(e) {
                let gateway = document.getElementById('gateway').value;
                if (gateway === 'stripe') {
                    var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                    $errorMessage.addClass('hide');
                    $('.has-error').removeClass('has-error');
                    $inputs.each(function(i, el) {
                        var $input = $(el);
                        if ($input.val() === '') {
                            $input.parent().addClass('has-error');
                            $errorMessage.removeClass('hide');
                            e.preventDefault();
                        }
                    });
                    if (!$form.data('cc-on-file')) {
                        e.preventDefault();
                        Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                        Stripe.createToken({
                            number: $('.card-number').val(),
                            cvc: $('.card-cvc').val(),
                            exp_month: $('.card-expiry-month').val(),
                            exp_year: $('.card-expiry-year').val()
                        }, stripeResponseHandler);
                    }
                }
            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    Toast.fire({
                        icon: 'error',
                        title: response.error.message
                    });
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });
    </script>

    <script>
       function termsCheck()
       {
            let terms = document.getElementById('terms');

            if (terms.checked) {
                document.getElementById('mk-pmt').removeAttribute('disabled');
            } else {
                document.getElementById('mk-pmt').setAttribute('disabled', 'disabled');
            }
       }

       function changePaymentType(type)
       {
            let element = document.getElementById('stripe-form');
            let gateway = document.getElementById('gateway');
            gateway.value = type;
            console.log(gateway);
            if (type === 'stripe') {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
       }
    </script>
@endsection
