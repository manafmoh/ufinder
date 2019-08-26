<?php

namespace App\Http\Controllers;

use App\Model\Ad;
use App\Model\Upload;
use Illuminate\Http\Request;
use App\Http\Requests\AdRequest;
use App\Http\Resources\AdResource;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Model\Category;
use App\Model\Subcategory;

class AdController extends Controller
{
    public function __construct()
    {
        //$this->middleware('JWT', ['except' => ['index', 'show', 'upload', 'search']]);
    }

    /*protected function validator(AdRequest $request)
    {
        return Validator::make($request, [
            'title' => ['required', 'min:3', 'max:255'],
        ]);
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Ad $ad, Category $cat, Subcategory $subcat)
    {
        if(!empty($cat['id']) && !empty($subcat['id'])){
            $ads=Subcategory::find($subcat['id'])->ads;
            return AdResource::collection($ads);
        } else if(!empty($cat['id'])){
            $ads=Category::find($cat['id'])->ads;
            return AdResource::collection($ads);
        }
        return AdResource::collection(Ad::latest()->get());
    }

    public function search(Request $request)
    {
        if($search= $request['search']) {
            return AdResource::collection(Ad::where('title', 'like', '%' . $search . '%')->offset(0)->limit(15)->get());
        }
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
    public function store(AdRequest $request)
    {
       // dd($request->all());
        //return  $request->image->getClientOriginalName();
        //$request['slug'] = str_slug($request->title); BOOT method used in Model/Ad.php
        //$ad = auth()->user()->ad()->create($request->all());
        //Ad::create($request->all());
        // AdResourse is used for getting PATH

        //'title','featured','amount','image','body','post_type','type','country','city','area','category_id'
        $validatedData = $request->validated();
        //dd($validatedData);
        $ad =  new Ad;
        $ad->title = trim($request->title);
        $ad->user_id = auth()->id();
        $ad->featured = $request->has('featured');
        $ad->amount = $request->amount;
        $ad->body = $request->body;
        $ad->post_type = $request->post_type;
        $ad->type = $request->type;
        $ad->country = $request->country;
        //$ad->category_id = $validatedData['category_id'];
        $ad->category_id = $request->category_id;
        $ad->subcategory_id = $request->subcategory_id;
        $ad->state_id = $request->state_id;
        $ad->district_id = $request->district_id;
        $ad->place_id = $request->place_id;
        $ad->email = $request->email;
        $ad->mobile = $request->mobile;
        //Saving image on a location and save to DB
       // $ad->image = $request->image;
        /*if($request->hasFile('image')) {
            //$imagename = $request->image->getClientOriginalName();
            //$request->image->storeAs('public/storage', $imagename);
            $imageFile = $request->file('image');
            $name = time().$imageFile->getClientOriginalName();
            //$filename = $imageFile->move(public_path("/storage"), $name);
            Storage::disk('local')->putFileAs(
                'public/image',
                $imageFile,
                $name
            );
            $ad->image = $name;
        } else {
            $ad->image = '';
        }*/
        $ad->save();
        $adId = $ad->id;
        if($adId) {
            // Multiple Files Upload
            if ( $files =  $request->file('files')) {
            foreach ($files  as $key => $file) {
                if($file->getClientOriginalName()) {
                $name = time() . $key . $file->getClientOriginalName();
                $uploadImagePath = '/image/'.$name;

                // open an image file
                $file = Image::make($file);
                $file->fit(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });
                //$watermark = Image::make(Storage::get('public/watermark.png'));

                $publicPath = base_path('public');
                $watermark = Image::make($publicPath.'/watermark.png');

                //$watermark->widen(floor(($file->width() / 4) * 3));
                $watermark->widen(80);
                $file->insert($watermark, 'bottom-right', 10, 10);
                //Storage::put($uploadImagePath, (string) $file->encode());

                // SAVE AWS S3
                //
                $path = Storage::disk('s3')->put($uploadImagePath,  (string) $file->encode());

                //Save to DB
                $mUpload =  new Upload;
                $mUpload->ad_id = $adId;
                $mUpload->filepath = $name;
                $mUpload->save();

                //Upload Ids
                /*
                    $uploadId = array();
                    $uploadId[] = Upload::create(
                    ['ad_id' => $adId,
                    'filepath' => $name])->id; */
                }

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
