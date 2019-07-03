<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'name'  => $this->name,
            'id'  => $this->id,
            'slug'  => $this->slug,
            'path'  => $this->path,
            'catpath'  => $this->catpath,
            'subcategories' =>  SubcategoryResource::collection($this->subCategories),
            'subcatpath'  => $this->subcatpath,
            'active'    =>$this->active,
            'created_at'    => $this->created_at->diffForHumans(),
            'updated_at'    => $this->updated_at->diffForHumans(),

        ];
    }
}
