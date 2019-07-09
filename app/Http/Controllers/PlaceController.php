<?php

namespace App\Http\Controllers;

use App\Model\Place;
use App\Model\State;
use App\Model\District;
use Illuminate\Http\Request;
use App\Http\Resources\PlaceResource;
use App\Http\Resources\DistrictResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

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
        $titleArr = preg_split('/\r\n|\r|\n/', $request->name);
        $pincodeArr = preg_split('/\r\n|\r|\n/', $request->pincode);
        if(count($titleArr) != count($pincodeArr)) return  response('Area and Pincode are not matching', Response::HTTP_NOT_FOUND);
        $i = 0;
        foreach($titleArr as $title) {
            $place = new Place();
            $place->name = trim($title);
            $place->pincode = trim($pincodeArr[$i++]);
        // $place->state_id = $state->id;
            $place->district_id = $district->id;
            $place->slug = str_slug($title);
            $place->save();
        }
        return response(new PlaceResource($place), Response::HTTP_CREATED);
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
    public function update(State $state, District $district, Request $request, Place $place)
    {
        $place->update([
            'name' => $request->name,
            'pincode' => $request->pincode,
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
    public function destroy(State $state, District $district, Place $place)
    {
        $place->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function search(Request $request) {
     //select places.name from places join districts on (districts.id = places.district_id) join states on (states.id = districts.state_id)

        //$where = "'1','=','1'";
        if($search= $request['search']) {
          //  $where = "'places.name', 'like', '%' . $search . '%'";
        }
        $places = DB::table('places')
            ->join('districts', 'districts.id', '=', 'places.district_id')
            ->join('states', 'states.id', '=', 'districts.state_id')
            ->select('places.name as place', 'places.pincode as pincode', 'districts.name as district', 'states.name as state', 'places.slug as place_slug', 'districts.slug as district_slug', 'states.slug as state_slug')
            ->where('places.name', 'like', '%' . $search . '%')
            ->offset(0)->limit(15)->get();
        return response($places , Response::HTTP_CREATED);


    }
}
