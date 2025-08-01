<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->only(['create','store']);
    }

    public function myprofile(){
        $user_id=Auth::user()->id;
        $user=User::find($user_id);
        return view('users.myprofile',compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|string',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->is_admin = $request->has('is_admin') ? 1 : 0;
        $user->save();

        return redirect()->route('user.create')->with('success', 'User created successfully.');
    }

    public function edit()
    {
        $user_id=Auth::user()->id;
        $user=User::find($user_id);
        return view('users.edit',compact('user'));
    }

    public function update(Request $request){
        $img_size=5*1024;
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'image' => "nullable|mimes:jpg,png,jpeg|max:$img_size"
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email  ;
        
        if ($request->hasFile('image')) {
            $image_data=$request->file('image');
            $image_name = "AllClean" . '.' . rand(0,3000000) .'.' . time() . '.' . $image_data->extension();
            $location=public_path('assets/userimage/');
            $image_data->move($location,$image_name);
                
            if(!empty($user->image)&&$user->image !=='user_place-holder.jpg'){
                $old_path=$location . $user->image;
                if(file_exists($old_path)){
                    unlink($old_path);
                }
            }

            $user->image = $image_name;

        }
        
        $user->save();
        return redirect()->route('user.edit')->with('success', 'Your data has been updated successfully.');
    }
}
