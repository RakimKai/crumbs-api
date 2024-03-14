<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupsUsers;
use App\Models\PendingRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestsController extends Controller
{
    use HttpResponses;

    public function accept($group_id,$user_id) {

        $pendingRequest = PendingRequest::where('group_id',$group_id)->where('user_id',$user_id)->first();
        
        if($pendingRequest==null){
            return $this->error(null,"Request wasn't found",404);
        }

        if(Group::where('admin_id',Auth::user()->id)->exists()){
            $newMember = GroupsUsers::create([
                'user_id'=>$pendingRequest->user_id,
                'group_id'=>$pendingRequest->group_id
            ]);
            $pendingRequest->delete();
            return $this->success($newMember,'User successfully accepted',200);
        }
        else {
            return $this->error(null,"You're not an admin",400);
        }
    }

    public function decline($group_id,$user_id) {

        $pendingRequest = PendingRequest::where('group_id',$group_id)->where('user_id',$user_id)->first();
        
        if($pendingRequest==null){
            return $this->error(null,"Request wasn't found",404);
        }

        if(Group::where('admin_id',Auth::user()->id)->exists()){
            $pendingRequest->delete();
            return $this->success(null,'User successfully declined',200);
        }
        else {
            return $this->error(null,"You're not an admin",400);
        }
    }
}
