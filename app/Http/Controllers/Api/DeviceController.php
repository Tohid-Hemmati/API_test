<?php

namespace App\Http\Controllers\Api;

use App\Models\Device;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function registerDevice(Request $request, Device $device)
    {

        $validator = Validator::make($request->all(), [
            'lang' => 'required|string',
            'OS' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $token = $request->bearerToken();
        $user = User::where('userToken', $token)->first();
        if ($user) {
            $request['device_token'] = Hash::make(Str::random(10));
            $request['uID'] = $user->id;
            $device = Device::create($request->toArray());
            return response($device, 200);
        } else {
            $response = ["message" => 'Wrong token or user didnt exist'];
            return response($response, 422);
        }


    }
}
