<?php

namespace App\Http\Controllers;

use App\Model\Place;
use App\Model\State;
use App\Model\District;
use Illuminate\Http\Request;
use App\Http\Resources\PlaceResource;
use App\Http\Resources\DistrictResource;
use Symfony\Component\HttpFoundation\Response;

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show', 'search']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(State $state, District $district)
    {
        return PlaceResource::collection($district->place);
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
    public function store(State $state, District $district, Request $request)
    {
        $place = new Place();
        $place->name = $request->name;
        $place->state_id = $state->id;
        $place->district_id = $district->id;
        $place->slug = str_slug($request->name);
        $place->save();
        return response(new DistrictResource($place), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(State $state, District $district, Place $place)
    {
        return new PlaceResource($place);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Place $place)
    { dd($place);
        $place->update([
            'name' => $request->name,
            'slug'  => str_slug($request->name)
        ]);
        return response(new PlaceResource($place), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $place->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
