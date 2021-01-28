<?php

namespace App\Http\Controllers\Api;

use App\Models\MobileApp;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function purchase(Request $request, Purchase $purchase)
    {
        $validator = Validator::make($request->all(), [
            'receipt' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $token = $request->bearerToken();

        $client = MobileApp::where('client_token', $token)->first();
        if (!$client) {
            $response = ["message" => 'please register application'];
            return response($response, 422);
        }

        if ($client->subscription_expire > date('Y-m-d H:i:s')) {
            $response = ["message" => 'you are already subscribed'];
            return response($response, 405);
        }
        switch (strtolower($client->device_OS)) {

            case 'android':
                if ($this->Google_mocker($request['receipt']) !== true) {
                    $response = ["message" => 'Not verified by google'];
                    return response($response, 422);
                }

                $request['app_id'] = $client->id;
                $request['purchase_time'] = date('Y-m-d H:i:s');
                $purchase = Purchase::create($request->toArray());
                $client->subscription_start = date('Y-m-d H:i:s');
                $client->subscription_expire = date('Y-m-d H:i:s', strtotime('+1 year'));
                $client->subscription_renewal +=1;
                $client->save();
                return response($purchase, 200);

            case 'ios':

                if ($this->ios_mocker($request['receipt']) !== true) {
                    $response = ["message" => 'Not verified by Apple'];
                    return response($response, 422);
                }

                $request['app_id'] = $client->id;
                $request['purchase_time'] = date('Y-m-d H:i:s');
                $purchase = Purchase::create($request->toArray());
                $client->subscription_start = date('Y-m-d H:i:s');
                $client->subscription_expire = date('Y-m-d H:i:s', strtotime('+1 year'));
                $client->subscription_renewal +=1;
                $client->save();
                return response($purchase, 200);


            default:
                $response = ["message" => 'OS not supported'];
                return response($response, 422);
        }
    }


    public function subscription_Check(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            $response = ["message" => 'please insert token'];
            return response($response, 406);
        }

        $client = MobileApp::where('client_token', $token)->first();
        if (!$client) {
            $response = ["message" => 'UNAUTHORIZED'];
            return response($response, 401);
        }

        if ($client->subscription_expire > date('Y-m-d H:i:s')) {
            return 'You Are Subscribed';
        } else {
            return 'You are Not Subscribed';
        }

    }

    public function cancel_subscription(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            $response = ["message" => 'please insert token'];
            return response($response, 406);
        }

        $client = MobileApp::where('client_token', $token)->first();
        if (!$client){
            $response = ["message" => 'UNAUTHORIZED'];
            return response($response, 401);
        }
        $client->subscription_expire=date('Y-m-d H:i:s');
        $client->save();
        $response = ["message" => 'subscription canceled'];
        return response($response, 200);

    }

    public function Google_mocker($hash)
    {
        $receipt = str_split(strrev($hash));
        foreach ($receipt as $val) {
            if (is_numeric($val)) {
                if ($val % 2 !== 0) {
                    return true;
                } else {
                    return false;
                }
            }

        }
        return false;
    }

    public function ios_mocker($hash)
    {
        $receipt = str_split(strrev($hash));
        foreach ($receipt as $val) {
            if (is_numeric($val)) {
                if ($val % 2 !== 0) {
                    return true;
                } else {
                    return false;
                }
            }

        }
        return false;
    }

}
