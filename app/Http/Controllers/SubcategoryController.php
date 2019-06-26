<?php

namespace App\Http\Controllers;

use App\Model\Subcategory;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Resources\SubcategoryResource;
use Symfony\Component\HttpFoundation\Response;

class SubcategoryController extends Controller
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
    public function index(Category $category)
    { 
        return SubcategoryResource::collection($category->subCategories);
    }
    public function search()
    { 
        return response('SEEEE', Response::HTTP_CREATED);
        
      
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
    public function store(Category $category, Request $request)
    {
        $subcategory = new Subcategory();
        $subcategory->name = $request->name;
        $subcategory->category_id = $category->id;
        $subcategory->slug = str_slug($request->name);
        $subcategory->save();
        return response(new SubcategoryResource($subcategory), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Subcategory $subcategory)
    {
        return new SubcategoryResource($subcategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category,Request $request, Subcategory $subcategory)
    {
        $subcategory->update([
            'name' => $request->name,
            'slug'  => str_slug($request->name)
        ]);
    return response(new SubcategoryResource($subcategory), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category,Subcategory $subcategory)
    {
        $subcategory->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
