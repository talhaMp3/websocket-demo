<?php

namespace App\Events;

use App\Models\Bidding;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewBid implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $price;
    
    public function __construct($price)
    {
        $this->price = $price;
    }

 
    public function broadcastOn()
    {
        
      return  new Channel('Bidding');
     
    }
    public function broadcastWith()
    {
        $price = Bidding::latest()->first();
        // dd($price);
        return ['price' => $price->price];
    }
}
