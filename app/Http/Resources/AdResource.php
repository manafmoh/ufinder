<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
            'title' => $this->title,
            'path'  => $this->path,
            'messages' => MessageResource::collection($this->message),
            'messages_count' => $this->message->count(),
            'slug'  => $this->slug,
            'body'  => $this->body,
            'category'  => $this->category->name,
            'user'  => $this->user->name,
            'user_id'  => $this->user->id,
            'uploads'   => UploadResource::collection($this->upload),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
