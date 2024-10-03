<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);
        return response()->json($message, 201);
    }

    public function getMessages($receiverId)
    {
        $receiverId=1;

        $messages =   Message::where('sender_id', 1)->where('receiver_id', $receiverId)->get();
//        $messages = Message::where(function($query) use ($receiverId) {
//            $query->where('sender_id', auth()->id())->where('receiver_id', $receiverId);
//        })->orWhere(function($query) use ($receiverId) {
//            $query->where('receiver_id', auth()->id())->where('sender_id', $receiverId);
//        })->get();

        return response()->json($receiverId);
    }




    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
