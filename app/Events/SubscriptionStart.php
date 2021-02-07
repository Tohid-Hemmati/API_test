<?php

namespace App\Events;

use App\Models\MobileApp;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionStart
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $client;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MobileApp $client)
    {
        $this->client=$client;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
