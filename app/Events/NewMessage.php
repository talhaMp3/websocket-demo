<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    // public function broadcastOn()
    // {
    //     return new Channel('chat');
    // }


    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastWith()
    {
        $message = Message::latest()->first();
        return ['message' => $message->message];
    }
}