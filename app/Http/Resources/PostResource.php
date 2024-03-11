<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
     public function toArray(Request $request): array
    {
        return [
            'id'=>(string)$this->id,
            'content' => $this->content,
            'image'=>$this->image,
            'created_at'=>$this->created_at,
            'user' => [
                'id'=>(string)$this->user_id,
                'name' => $this->user->name
            ],
            'group' => [
                'id'=>(string)$this->group_id,
                'name' => $this->group->name
            ]
        ];
    }
}
