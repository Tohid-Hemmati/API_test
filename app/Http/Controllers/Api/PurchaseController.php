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

        $client = MobileApp::where('app_token', $token)->first();
        if ($client) {
            if ($client->subscription_status !== 1) {
                if (strtolower($client->device_OS) == 'android') {
                    if ($this->Google_mocker($request['receipt']) === true) {
                        $request['app_id'] = $client->id;
                        $request['subscription_start'] = date('Y-m-d');
                        $request['expire'] = date('Y-m-d', strtotime('+1 year'));
                        $purchase = Purchase::create($request->toArray());

                        $client->subscription_status = 1;
                        $client->save();
                        return response($purchase, 200);
                    } else {
                        $response = ["message" => 'Not verified by google'];
                        return response($response, 422);
                    }

                } elseif (strtolower($client->device_OS) == 'ios') {
                    if ($this->ios_mocker($request['receipt']) === true) {
                        $request['app_id'] = $client->id;
                        $request['subscription_start'] = date('Y-m-d H:i:s');
                        $request['expire'] = date('Y-m-d H:i:s', strtotime('+1 year'));
                        $purchase = Purchase::create($request->toArray());
                        $client->subscription_status = 1;
                        $client->save();
                        return response($purchase, 200);
                    } else {
                        $response = ["message" => 'Not verified by Apple'];
                        return response($response, 422);
                    }

                } else {
                    $response = ["message" => 'OS not supported'];
                    return response($response, 422);

                }
            } else {
                $response = ["message" => 'you are already subscribed'];
                return response($response, 405);
            }
        } else {
            $response = ["message" => 'please register application'];
            return response($response, 422);

        }
    }

    public function subscription_Check(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            $client = MobileApp::where('app_token', $token)->first();
            if ($client) {
                if ($client->subscription_status === 1) {
                    return 'You Are Subscribed';
                } else {
                    return 'You are Not Subscribed';
                }
            } else {
                $response = ["message" => 'UNAUTHORIZED'];
                return response($response, 401);

            }

        } else {
            return 'please insert token';
        }

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
