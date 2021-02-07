<?php

namespace App\Http\Controllers\Api;

use App\Models\CallBack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CallBackController extends Controller
{

    public function callBack(Request $request)
    {
      $callback=CallBack::create([
          'AppID'=>$request->AppID,
          'DeviceID'=>$request->DeviceID,
          'info'=>$request->info,
      ]);
      $response=[$callback->toArray()];

      return response($response,200);

    }


}
