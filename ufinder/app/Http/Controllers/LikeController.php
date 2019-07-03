<?php

namespace App\Http\Controllers;

use App\Model\Like;
use App\Model\Message;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function LikeIt(Message $message)
    {
        /*$message->like()->create([
            'user_id' => 1
        ]); */
        $like = new Like();
        $like->message_id = $message->id;
        $like->user_id = auth()->id();
        $like->save();
        return response('Liked', Response::HTTP_CREATED);
    }

    public function UnLikeIt(Message $message)
    {
        $message->like()->where('user_id', auth()->id())->first()->delete();
    }



}
