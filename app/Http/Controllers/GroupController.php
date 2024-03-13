<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\PendingRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    use HttpResponses;
    
    public function store(CreateGroupRequest $request) {
        $request->validated($request->all());
        $group = Group::create([
            'name'=>$request->name,
            'privacy'=>$request->privacy,
            'description'=>$request->description,
            'admin_id'=>Auth::user()->id
        ]);

        if($request->image){
            $fileName = $request->file('image')->getClientOriginalName();
            $path = url('/storage/images/' . $fileName);
            $request->file('image')->storeAs('images',$fileName,'public'); 
            $group->image = $path;
        }
        return $this->success(new GroupResource($group),'Group successfully created',200);
    }

    public function get($id)
    {
        $group = Group::find($id);
        if($group){
            return $this->success(new GroupResource($group),'Group successfully fetched',200);
        }
        else return $this->error(null,"Group doesn't exist",404);
    }

    public function getAll()
    {
        $groups = Group::all();
        $groups = GroupResource::collection($groups);
        return $this->success($groups,'Groups successfully fetched',200);
    }

    public function update(Request $request, $id)
    {
        $post = Group::find($id);

        if($request->image){
            $fileName = $request->file('image')->getClientOriginalName();
            $path = url('/storage/images/' . $fileName);
            $request->file('image')->storeAs('images',$fileName,'public'); 
            $post->image = $path;
        }

        $post->update($request->except(['image']));
        
        return $this->success(new GroupResource($post),'Group successfully modified',200);
    }

    public function delete($id)
    {
        $group = Group::find($id);
        $group->delete();
        return $this->success(null,'Group successfully deleted',200);
    }

    public function join($groupId)
    {
        $user = Auth::user();
        $group = Group::find($groupId);

        if (PendingRequest::where('group_id', $group->id)->where('user_id', $user->id)->exists()) {
            return $this->error(null,"User already has a pending request for this group.",400);
        }

        $pendingRequest = PendingRequest::create([
            'group_id'=>$group->id,
            'user_id'=>$user->id
        ]);
        return $this->success(['request'=>($pendingRequest)],'Join request sent successfully',200);
    }
}
