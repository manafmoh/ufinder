<?php

namespace App\Http\Controllers;

use App\Model\State;
use App\Model\District;
use Illuminate\Http\Request;
use App\Http\Resources\DistrictResource;
use Symfony\Component\HttpFoundation\Response;

class DistrictController extends Controller
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
    public function index(State $state)
    {
        return DistrictResource::collection($state->district);
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
    public function store(State $state, Request $request)
    {
        $titleArr = preg_split('/\r\n|\r|\n/', $request->name);
        foreach($titleArr as $title) {
            $district = new District();
            $district->name = $title;
            $district->state_id = $state->id;
            $district->slug = str_slug($title);
            $district->save();
        }
        return response(new DistrictResource($district), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(State $state, District $district)
    {
        return new DistrictResource($district);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(State $state,Request $request, District $district)
    {
        $district->update([
            'name' => $request->name,
            'slug'  => str_slug($request->name)
        ]);
        return response(new DistrictResource($district), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state, District $district)
    {
        $district->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function search(Request $request)
    {
        if($search= $request['search']) {
            return response(District::where('name', 'like', '%' . $search . '%')->offset(0)->limit(15)->get(), Response::HTTP_CREATED);
        }
        return response(null, Response::HTTP_CREATED);


    }
}
