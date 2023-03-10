<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\ObjectHelper;

class PaypalController extends Controller
{
    private $_api_context;
    
    public function __construct()
    {
            
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    // public function payWithPaypal()
    // {
    //     return view('paywithpaypal');
    // }

    public function postPaymentWithpaypal($data)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

    	$item_1 = new Item();

        $item_1->setName($data['model'])
            ->setCurrency(config('payment.currency'))
            ->setQuantity(1)
            ->setPrice($data['amount']);

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency(config('payment.currency'))
            ->setTotal($data['amount']);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($data['note']);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status'))
            ->setCancelUrl(URL::route('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')             // sale or order
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));       
            
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error','Connection timeout');
                return Redirect::route('payment.option');
            } else {
                \Session::put('error','Some error occur, sorry for inconvenient');
                return Redirect::route('payment.option');
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        
        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {            
            return Redirect::away($redirect_url);
        }

        \Session::put('error','Unknown error occurred');
    	return Redirect::route('payment.option');
    }

    public function getPaymentStatus(Request $request)
    {        
        $is_guest = session()->get('is_guest');
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            \Session::put('error','Payment failed!');
            return Redirect::route('payment.option');
        }

        try {
            $payment = Payment::get($payment_id, $this->_api_context);        
            $execution = new PaymentExecution();
            $execution->setPayerId($request->input('PayerID'));        
            $result = $payment->execute($execution, $this->_api_context);
            
            if ($result->getState() == 'approved') {
                $reservationObj = ObjectHelper::getReservationServiceObject();
                if ($is_guest) {
                    $reservation = $reservationObj->afterPaymentProcessGuest($payment_id);
                } else {
                    $reservation = $reservationObj->afterPaymentProcess($payment_id);
                }
                clearSession();
                Alert::toast($reservation['message'], $reservation['status']);  
                return redirect('/reservation-complete');
            }
        } catch (\Throwable $e) {
            Log::channel('general_error')->error($e->getMessage());
        }
        \Session::put('error','Payment failed !!');
        return Redirect::route('payment.option');
    }
}
