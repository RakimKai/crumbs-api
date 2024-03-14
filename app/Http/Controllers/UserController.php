<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\GroupsUsers;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use HttpResponses;
    
    public function logout(Request $request){ 
        $request->user()->currentAccessToken()->delete(); 
        return $this->success(null,
        'You have been successfully logged out',200);
    }

    public function get(){
        $user = Auth::user();
        return $this->success($user,'User successfully fetched',200);
    }

    public function getAll($groupId){
        $users = GroupsUsers::where('group_id',$groupId)->get();
        return $this->success($users,'Users successfully fetched',200);
    }
    
    public function update(Request $request){
        $userInDb = User::where('id',Auth::id())->first();
        if($request->new_password){
            if (!Hash::check($request->current_password, $userInDb->password)){
                return $this->error(null,'Current password is invalid',400);
            }
            $userInDb->password = Hash::make($request->new_password);
        }

        if($request->image){
        $fileName = $request->file('image')->getClientOriginalName();
        $path = url('/storage/images/' . $fileName);
        $request->file('image')->storeAs('images',$fileName,'public'); 
        $userInDb->image = $path;
        }
        $userInDb->update($request->except(['image']));

        return $this->success(['user'=>$userInDb],'User successfully modified',200);
    }
}
