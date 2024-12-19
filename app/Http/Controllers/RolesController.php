<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;


class RolesController extends Controller
{

    public function __construct() {
        $this->middleware('role:Manager');
    }
    
    public function index(Request $request)
    {
        $user = Auth::user();
        if(request('search')){
            $roles = Role::where("rolename", "like", "%" . request('search') . "%")->get();
        }
        elseif(request('column') && request('direction')){
            $column = $request->input('column',);
            $direction = $request->input('direction');
            $roles = Role::orderBy($column, $direction)->get();
        }
        else{
            $roles = Role::all();
            // for($i=0; $i<sizeof($roles); $i++){
            //     // var_dump($roles[$i]->rolename);
            // }
        }
        return view("manager.staff.role.role_index", ['roles' => $roles, 'user' => $user]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('manager.staff.role.role_create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rolename' => 'required'
        ]);

        $roles = Role::all();
        foreach($roles as $role){
            if($role->rolename == request('rolename')){
                return redirect('/manager/role')->with('role_add_duplicate', 'Role already exists!');
            }
        }

        $roles = new Role();
        $roles->rolename = request('rolename');

        $roles->save();
        return redirect('/manager/role')->with('role_add_success', 'Role added successfully');
    }
    public function edit(Request $request, $id)
    {
        $role = Role::findorfail($id);;
        return view("manager.staff.role.role_edit", ['role' => $role, ['user' => Auth::user()]]);
   }

    public function update(Request $request, $id){
        $role = Role::findorfail($id);
        $role->rolename = request('rolename');
        $role->update();

        return redirect('/manager/role')->with('role_update_success', 'Role updated successfully');
    }

    public function destroy($id){
        $role = Role::findorfail($id);
        if($role->user()->count()){
            return redirect('/manager/role')
                ->with('role_delete_fail', "Cannot delete! It is referenced in User table");
        }
        $role->delete();
        return redirect('/manager/role')->with('role_delete_success', 'Role deleted successfully');
    }
}
