<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LineEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $method;
    public $param;

    /**
     * LineEvent constructor.
     * @param $method
     * @param mixed ...$param
     */
    public function __construct($method, ...$param)
    {
        $this->method = $method;
        $this->param = $param;
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
