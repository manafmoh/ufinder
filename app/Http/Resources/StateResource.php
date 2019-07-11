<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
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
            'statepath'  => $this->statepath,
            'states' =>  DistrictResource::collection($this->district),
            'districtpath'  => $this->districtpath,
            'active'    =>$this->active,
            'district_count' => $this->district->count(),
            'created_at'    => $this->created_at->diffForHumans(),
            'updated_at'    => $this->updated_at->diffForHumans(),

        ];
    }
}
