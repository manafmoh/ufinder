<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
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
            'id'  => $this->id,
            'slug'  => $this->slug,
            'path'  => $this->path,
            'distictpath'  => $this->districtpath,
            'state'  => $this->state->name,
            'active'    =>$this->active,
            'created_at'    => $this->created_at->diffForHumans(),
            'updated_at'    => $this->updated_at->diffForHumans()
        ];
    }
}
