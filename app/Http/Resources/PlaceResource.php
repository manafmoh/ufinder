<?php

namespace App\Http\Resources;

use App\Http\Resources\AdResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'  => $this->name,
            'pincode'  => $this->pincode,
            'id'  => $this->id,
            'slug'  => $this->slug,
            'path'  => $this->path,
            'statepath'  => $this->statepath,
            'ads'  => AdResource::collection($this->ads),
          //  'state'  => $this->state->name,
          //  'district'  => $this->district->name,
            'active'    =>$this->active,
            'created_at'    => $this->created_at->diffForHumans(),
            'updated_at'    => $this->updated_at->diffForHumans()
        ];
    }
}
