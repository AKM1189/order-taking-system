<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class CustomLoginController extends Controller
{
    public function showLogin()
    {
        $hash = Hash::make('akm11111');
        $roles = Role::all();
        $user = Auth::user();
        return view('auth.login', compact('roles', 'hash', 'user'));
    }
    
    public function create()
    {
        $roles = Role::all();
        $user = Auth::user();
        return view('auth.register', ['roles' => $roles, 'user' => $user]);
    }
}
