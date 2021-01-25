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
            if (strtolower($client->device_OS) == 'android') {
                if ($this->Google_mocker($request['receipt']) === true) {
                    $request['app_id'] = $client->id;
                    $request['expire'] = date('Y-m-d', strtotime('+1 year'));
                    $purchase = Purchase::create($request->toArray());
                    return response($purchase, 200);
                }

            } elseif (strtolower($client->device_OS) == 'ios') {
                if ($this->ios_mocker($request['receipt']) === true) {
                    $request['app_id'] = $client->id;
                    $request['expire'] = date('Y-m-d', strtotime('+1 year'));
                    $purchase = Purchase::create($request->toArray());
                    return response($purchase, 200);
                }

            } else {
                $response = ["message" => 'OS not supported'];
                return response($response, 422);

            }
        } else {
            $response = ["message" => 'please register application'];
            return response($response, 422);

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
