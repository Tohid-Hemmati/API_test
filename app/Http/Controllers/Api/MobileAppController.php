<?php

namespace App\Http\Controllers\Api;

use App\Models\Device;
use App\Models\MobileApp;
use Illuminate\Http\Request;
use App\Http\Controllers\controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MobileAppController extends Controller
{

    public function appRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'in_app_purchase' => 'required|boolean',
            'app_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $token = $request->bearerToken();
        $device = Device::where('device_token', $token)->first();
        if ($device) {
            $request['client_token'] = Hash::make(Str::random(10));
            $request['device_id'] = $device->id;
            $request['device_OS'] = $device->OS;
            $request['register_time'] = date('Y-m-d H:i:s');
            $device = MobileApp::create($request->toArray());
            return response($device, 200);
        } else {
            $response = ["message" => 'Wrong token or Device does not exist'];
            return response($response, 422);
        }

    }


}
