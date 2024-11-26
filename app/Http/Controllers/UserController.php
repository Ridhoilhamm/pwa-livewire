<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\ViewName;

class UserController extends Controller
{

    public function user()
    {
        $users = User::get();

        return view('users.user', compact('users'));
    }

    public function create()
    {
        return view(('users.create'));
    }

    public function usersubmit(Request $request)
    {
        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = $request->password;
        $users->rolle = $request->rolle;
        $users->save();
        return redirect()->route('user');
    }
    public function update($id){
        $users = User::find($id);
        return view('users.update', compact('users'));
    }

    public function updatesubmit(Request $request, $id){
        $users = User::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = $request->password;
        $users->rolle = $request->rolle;
        $users->update();
        
        return redirect()->route('user');

    }

    public function delete($id){
        $users = User::find($id);
        $users->delete();
        return redirect()->route('user');

    }

}
