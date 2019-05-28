<?php

namespace App\Http\Controllers;

use App\Model\Ad;
use App\Model\Upload;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\AdResource;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show', 'upload']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AdResource::collection(Ad::latest()->get());
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
        //dd($request->all());
        //return  $request->image->getClientOriginalName();
        //$request['slug'] = str_slug($request->title); BOOT method used in Model/Ad.php
        //$ad = auth()->user()->ad()->create($request->all());
        //Ad::create($request->all());
        // AdResourse is used for getting PATH

        //'title','featured','amount','image','body','post_type','type','country','city','area','category_id'

        $ad =  new Ad;
        $ad->title = $request->title;
        $ad->user_id = auth()->id();
        $ad->featured = $request->featured;
        $ad->amount = $request->amount;
        $ad->body = $request->body;
        $ad->post_type = $request->post_type;
        $ad->type = $request->type;
        $ad->country = $request->country;
        $ad->city = $request->city;
        $ad->area = $request->area;
        $ad->category_id = $request->category_id;
        //Saving image on a location and save to DB
       // $ad->image = $request->image;
        if($request->hasFile('image')) {
            //$imagename = $request->image->getClientOriginalName();
            //$request->image->storeAs('public/storage', $imagename);
            $imageFile = $request->file('image');
            $name = time().$imageFile->getClientOriginalName();
            $filename = $imageFile->move(public_path("/storage"), $name);
            /*Storage::disk('local')->putFileAs(
                'public/storage/'.$filename,
                $imageFile,
                $filename
            ); */
        } else {
            $ad->image = '';
        }
        $ad->image = $filename;
        $ad->save();
        $adId = $ad->id;
        if($adId) {
            // Multiple Files Upload
            $uploadId = array();
            if ( $files =  $request->file('files')) {
            foreach ($request->file('files') as $key => $file) {
                $name = time() . $key . $file->getClientOriginalName();
                $filename = $file->move(public_path("/storage"), $name);
                $mUpload =  new Upload;
                $mUpload->ad_id = $adId;
                $mUpload->filepath = $name;
                $mUpload->save();
                //Upload Ids
                /*$uploadId[] = Upload::create(
                    ['ad_id' => $adId,
                    'filepath' => $name])->id; */
            }
            //return response()->json($uploadId, 200);
            }
        }
        
        return response(new AdResource($ad), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        return new AdResource($ad);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        $request->merge(['slug' => str_slug($request->title)]);
        $ad->update($request->all());
        return response('Updated', Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

}
