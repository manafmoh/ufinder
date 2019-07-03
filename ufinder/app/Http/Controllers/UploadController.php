<?php

namespace App\Http\Controllers;

use App\Model\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $uploadId = array();
        if ( $files =  $request->file('file')) {
            foreach ($request->file('file') as $key => $file) {
                $name = time() . $key . $file->getClientOriginalName();
                $filename = $file->move(public_path("/storage"), $name);
                $uploadId[] = Upload::create([
                    'filepath' => $name])->id;
            }
            return response()->json($uploadId, 200);
        }
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    { //return response()->json(Storage::disk('public')->path("image/") . $upload->filepath, Response::HTTP_ACCEPTED);
        if (!(empty($upload))) {
            if(Storage::disk('public')->exists("image/".$upload->filepath)) {
                Storage::disk('public')->delete("image/".$upload->filepath);
                //return response()->json('File exist', Response::HTTP_ACCEPTED);
            }
            //Upload::where('id', $upload->id)->delete();
            $upload->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

    }
}
