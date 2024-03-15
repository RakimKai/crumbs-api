<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'created_at'=>$this->created_at,
            'description'=>$this->description,
            'members_count'=>$this->members_count,
            'image'=>$this->image,
            'privacy'=>$this->privacy,
            'admin' => [
                'id'=>$this->admin_id,
                'name' => $this->admin->name
            ],
        ];
    }
}
