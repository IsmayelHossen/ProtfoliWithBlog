<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $from;
    public $to;
    public $read;
    public $created_at;
    public $updated_at;
    public $msg;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($msg, $from, $to, $read, $created_at, $updated_at)
    {
        $this->msg = $msg;
        $this->from = $from;
        $this->to = $to;
        $this->read = $read;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new private Channel('chat');
        return ['chat'];
    }
    public function broadcastAs()
    {
        return 'message';
    }
}
