<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->only(['create','store','allusers','lock','delete']);
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
            'password' => 'required|string',
            'address' => ['required', 'string', 'min:8'],
            'phone' => ['required','regex:/^\+?[0-9\s\-\(\)]+$/','min:10','max:20'],
            'role' =>['required','in:admin,user,vendor']
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        
        $user->role = $request->role;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('user.create')->with('success', 'User created successfully.');
    }
    
    public function allusers(){
        $users=User::all();
        return view('users.allusers',compact('users'));
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
            'image' => "nullable|mimes:jpg,png,jpeg|max:$img_size",
            'address' => ['required', 'string', 'min:8'],
            'phone' => ['required','regex:/^\+?[0-9\s\-\(\)]+$/','min:10','max:20'],
            
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        
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

    public function delete($id){
        $user=User::FindorFail($id);
        $user->delete();
        return redirect()->back()->with('deleted','Account Deleted successfully');
    }




    public function lock($id){
        $user = User::findOrFail($id);
        $user->is_locked = !$user->is_locked;      
        $user->save();
        return redirect()->back()->with('status', $user->is_locked ? 'Account locked.' : 'Account unlocked.');
    }

}
