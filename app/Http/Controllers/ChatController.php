<?php

namespace App\Http\Controllers;

use App\Events\NewBid;
use App\Models\Bidding;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    // public function index()
    // {
    //     return view('chat');
    // }

    // public function sendMessage(Request $request)
    // {
    //     $message = $request->input('message');
    //     broadcast(new NewMessage($message))->toOthers();
    //     return response()->json(['status' => 'Message Sent!']);
    // }

    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        $newMessage = new Message();
        $newMessage->message = $message;
        $newMessage->save();
        broadcast(new NewMessage($message))->toOthers();
        return response()->json(['status' => 'Message Sent!']);
    }

    function SetAuction(Request $request)
    {
        // dd('done');
        $price = $request->input('price');
        $newPrice = new Bidding();
        $newPrice->price = $price;
        $newPrice->save();
      broadcast(new NewBid($price))->toOthers();
        return response()->json(['status' => 'Message Sent!']);
    }


    public function getMessages()
    {
        $messages = Message::all();
        return view('chat', ['messages' => $messages]);
    }

    public function auction()
    {
        $messages = Bidding::all();
        return view('auction', ['messages' => $messages]);
    }
}
