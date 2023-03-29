<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\ObjectHelper;

use Session;
use Stripe;
use Redirect;

class StripeController extends Controller
{
    public function stripe()
    {
        return view('stripe');
    }

    public function saveStripePayment($data)
    {
        $is_guest = session()->get('is_guest');
        
        try {
            Stripe\Stripe::setApiKey(config('stripe.SECRET_KEY'));
            $response = Stripe\Charge::create ([
                "source" => $data['stripeToken'],
                "amount" => $data['amount'] * 100,
                "currency" => config('payment.currency'),
                "description" => $data['description'],
            ]);
            $payment_id = $response->id;

            $reservationObj = ObjectHelper::getReservationServiceObject();
            if ($is_guest) {
                $reservation = $reservationObj->afterPaymentProcessGuest($payment_id);
            } else {
                $reservation = $reservationObj->afterPaymentProcess($payment_id);
            }
            clearSession();
            Alert::toast($reservation['message'], $reservation['status']);  
            return redirect('/reservation-complete');
        } catch (\Throwable $e) {
            Log::channel('general_error')->error($e->getMessage());
            \Session::put('error','Payment failed !!');
            return Redirect::route('payment.option');
        }
    }
}
