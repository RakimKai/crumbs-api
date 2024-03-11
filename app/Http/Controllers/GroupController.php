<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    use HttpResponses;
    
    public function store(CreateGroupRequest $request) {
        $request->validated($request->all());
        $group = Group::create([
            'name'=>$request->name,
            'privacy'=>$request->privacy
        ]);
        return $this->success(['group'=>new GroupResource($group)],'Group successfully created',200);
    }

    public function get($id)
    {
        $group = Group::find($id);
        if($group){
            return $this->success(['group'=>new GroupResource($group)],'Group successfully fetched',200);
        }
        else return $this->error(null,"Group doesn't exist",404);
    }

    public function delete($id)
    {
        $group = Group::find($id);
        $group->delete();
        return $this->success(null,'Group successfully deleted',200);
    }
}
