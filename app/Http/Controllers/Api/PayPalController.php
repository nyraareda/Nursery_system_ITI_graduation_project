<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function paypal(Request $request){
        $provider = new PayPalClient;
        $provider = setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
    }
    public function success(){

    }
    public function cancel(){

    }

}
