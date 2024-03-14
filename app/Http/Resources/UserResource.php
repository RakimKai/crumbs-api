<?php

namespace App\Http\Resources;

use App\Models\UserNotifications;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class UserResource extends JsonResource
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
            'username'=>$this->username,
            'image'=>$this->image,
            'created_at'=>$this->created_at
        ];
    }
}
