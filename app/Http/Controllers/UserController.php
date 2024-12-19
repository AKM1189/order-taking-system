<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function __construct() {
        $this->middleware('role:Manager');
    }
    
    public function index() {
        if(request('search')){
            $users = User::where("name", "like", "%" . request('search') . "%")->get();
        }
        else{
            $users = User::all();
        }
        $roles = Role::all();
        $user = Auth::user();
        return view('manager.staff.user.user_index', compact('users', 'roles', 'user'));
    }

    public function edit($id) {
        $updateuser = User::findorfail($id);
        $roles = Role::all();
        $user = Auth::user();
        return view('manager.staff.user.user_edit', compact('updateuser', 'roles', 'user'));
    }

    public function profile($id) {
        $updateuser = User::findorfail($id);
        $roles = Role::all();
        $user = Auth::user();
        return view('manager.profile', compact('updateuser', 'roles', 'user'));
    }

    public function update(Request $request, $id){
        $user = User::findorfail($id);
        $user->name = request('name');
        $user->email = request('email');
        $user->role_id = request('role');
        if(request('password')){
        $user->password = Hash::make(request('password'));
        }
        $user->update();

        return redirect('/manager/user')->with('user_update_success', 'User updated successfully');
    }

    public function destroy($id){
        $user = User::findorfail($id);
        $user->delete();
        return redirect('/manager/user')->with('user_delete_success', 'User deleted successfully');
    }
}
