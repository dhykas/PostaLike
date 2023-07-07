<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($name){
        

        
        $data = User::where('name',$name)->first();
        if(!$data){
            return view('errors/404');
        }
        $id= $data->id;
        $post = Post::with('user')->withCount('like')->where('user_id',$id)->get();
        $count = Post::where('user_id', $id)->count();

        // dd($post[0]->like_count);
        // dd($count);
        
        if($data){
            return view('user',[
                'user' => $data,
                'post' => $post,
                'count' => $count,
                ]);
        }else{
            return view('partials/404');
        }
    }

    public function edit(){
        $user = Auth::user();
        // dd($user->cover);
        return view('profile',[
            'user' => $user
        ]);
    }

    public function edits(Request $req){
        $id = Auth::user()->id;
        $data = User::findOrFail($id); // Assuming you have the ID of the user you want to update

        $data->fill($req->except(['picture', 'cover']));
        
        if ($req->hasFile('picture')) {
            $pictureName = str_replace(' ', '_', $req->file('picture')->getClientOriginalName());
            $req->file('picture')->move('profilePic/', $pictureName); 
            $data->picture = $pictureName;
        }
        
        if ($req->hasFile('cover')) {
            $coverName = str_replace(' ', '_', $req->file('cover')->getClientOriginalName());
            $req->file('cover')->move('profilePic/', $coverName); 
            $data->cover = $coverName;
        }
        
        $data->save();
        
        return redirect('/acc/edit');

    }

    public function create(){
        $user = Auth::user();
        return view('create',[
            'user' => $user
        ]);
    }

    public function post(Request $req){
        if ($req->hasFile('image')) {
            $imageName = str_replace(' ', '_', $req->file('image')->getClientOriginalName());
            $req->file('image')->move('profilePic/', $imageName); 
        }
    
        $data = Post::create($req->all());
        if (isset($imageName)) {
            $data->image = $imageName;
        }
        $data->save();
    
        return redirect('/user/'. Auth::user()->name);
    }

    public function like($id){
        if(!Auth::check()){
            return redirect('/login');
        }
        $ids = Auth::user()->id;
        $like = Like::where('post_id',$id)->where('user_id', $ids);

        $check = Like::where('user_id', $ids)->where('post_id', $id)->exists();
        // dd($check);

        if($check){
            $like->delete();

        }else{
            Like::create([
                'user_id' => $ids,
                'post_id' => $id,

            ]);
        }
        return redirect()->back();
    }
    
}
