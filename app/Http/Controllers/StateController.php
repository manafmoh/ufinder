<?php

namespace App\Http\Controllers;

use App\Model\State;
use Illuminate\Http\Request;
use App\Http\Resources\StateResource;
use Symfony\Component\HttpFoundation\Response;

class StateController extends Controller
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
    public function index()
    {
        return StateResource::collection(State::latest()->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $titleArr = preg_split('/\r\n|\r|\n/', $request->name);
        if(count($titleArr) ==0) return  response('Error on submitting!!', Response::HTTP_NOT_FOUND);
        foreach($titleArr as $title) {
            $state = new State();
            $state->name = trim($title);
            $state->slug = str_slug( $title);
            $state->save();
        }
        return response(new StateResource($state), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        return new StateResource($state);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        $state->update([
                'name' => $request->name,
                'slug'  => str_slug($request->name)
            ]);
        return response(new StateResource($state), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $state->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
