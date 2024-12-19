<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     * 
     * 
     */
    
    // public function redirectTo() {
    //     $role = Auth::user()->role;
    //         switch ($role->rolename) {
    //             case 'Manager':
    //                 return '/manager/dashboard';
    //                 break;
    //             case 'Waiter':
    //                 return '/waiter';
    //                 break;
    //             default:
    //                 return '/home';
    //                 break;
    //         }
    // }

    // protected $redirectTo = '/home';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {
        // return User::create([
        //     'name' => input('name'),
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        //     'role_id' => $data['role'],
        // ]);

        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = Hash::make(request('password'));
        $user->role_id = request('role');

        $users = User::all();
        foreach($users as $staff){
            if($staff->email == request('email')){
                return redirect('/manager/user')->with('user_add_duplicate', 'User already exists!');
            }
        }

        $user->save();

        return redirect('/manager/user')->with('user_add_success', 'User added successfully');
        
        }
    }
