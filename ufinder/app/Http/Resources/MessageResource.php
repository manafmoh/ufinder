<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'id'   => $this->id,
            'message'   => $this->body,
            'user'      => $this->user->name,
            'user_id'      => $this->user->id,
            'ad_slug'   => $this->ad->slug,
            'like_count' => $this->like->count(),
            'liked' => !!$this->like->where('user_id', auth()->id())->count(),
            'created_at'=> $this->created_at->diffForHumans()
        ];
    }
}