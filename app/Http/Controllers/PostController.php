<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use HttpResponses;
    
    public function store(CreatePostRequest $request) {
        $request->validated($request->all());

        

        $post = Post::create([
            'user_id'=>Auth::user()->id,
            'group_id'=>$request->group_id,
            'content'=>$request->content,
        ]);

        if($request->image){
            $fileName = $request->file('image')->getClientOriginalName();
            $path = url('/storage/images/' . $fileName);
            $request->file('image')->storeAs('images',$fileName,'public'); 
            $post->image = $path;
        }
        
        return $this->success(['post'=>new PostResource($post)],'Post successfully created',200);
    }
    public function get($id)
    {
        $post = Post::find($id);
        if($post) return $this->success(['post'=>new PostResource($post)],'Post successfully fetched',200);
        else return $this->error(null,"Post not found",404);
    }

    public function getAll($groupId)
    {
        $posts = Post::where('group_id', $groupId)->get();
        $postsResource = PostResource::collection($posts);
        return $this->success(['posts'=>($postsResource)],'Posts successfully fetched',200);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if($request->image){
            $fileName = $request->file('image')->getClientOriginalName();
            $path = url('/storage/images/' . $fileName);
            $request->file('image')->storeAs('images',$fileName,'public'); 
            $post->image = $path;
        }

        $post->update($request->except(['image']));
        
        return $this->success(['post'=>new PostResource($post)],'Post successfully modified',200);
    }

    public function delete($id)
    {
        $post = Post::find($id);
        $post->delete();
        return $this->success(null,'Post successfully deleted',200);
    }
}
