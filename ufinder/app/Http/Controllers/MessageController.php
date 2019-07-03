<?php

namespace App\Http\Controllers;

use App\Model\Ad;
use App\Model\Message;
use Illuminate\Http\Request;
use App\Http\Resources\MessageResource;
use Symfony\Component\HttpFoundation\Response;
use App\Notifications\NewMessageNotification;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Ad $ad)
    {
        return MessageResource::collection($ad->message);
       // return Message::latest()->get();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Ad $ad, Request $request)
    {
        $message = $ad->message()->create($request->all());
        //$message = Message::create($request->all());
        $user =  $message->user;
        if ($message->user_id !== $ad->user_id) {
            $user->notify(new NewMessageNotification($message));
        }
        return  response(['message' => new MessageResource($message)], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad, Message $message)
    {
        return new MessageResource($message);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Ad $ad, Request $request, Message $message)
    {
        $message->update([
            'body' => $request->body
        ]);

        return response('Updated', Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad, Message $message)
    {
        $message->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
