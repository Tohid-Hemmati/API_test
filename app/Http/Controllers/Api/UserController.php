<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $request['password'] = Hash::make($request['password']);
        $request['userToken'] = Hash::make(Str::random(10));
        $user = User::create($request->toArray());
        return response($user, 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:100',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = $request->bearerToken();
            if ((Hash::check($request->password, $user->password)) && ($token == $user->userToken)) {
                $response = ["message" => "logged in"];
                return response([$response], 200);
            } else {
                $response = ["message" => "Password or Token mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => "User does not exist"];
            return response([$response], 422);
        }
    }
}
