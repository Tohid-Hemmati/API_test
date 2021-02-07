<?php

namespace App\Listeners;

use App\Events\SubscriptionStart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
//use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\True_;

class SubStartListener
{
//implements ShouldQueue
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SubscriptionStart  $event
     * @return void
     */
    public function handle(SubscriptionStart $event)
    {
        var_dump($event);
//        $client = new Client();
//        $response = Http::retry(3, 100)->post('http://127.0.0.1:8000/api/callBack', [
//            'AppID' => $event->client->id,
//            'DeviceID' => $event->client->device_id,
//            'info' => 'subscription started',
//        ]);
    }
}
