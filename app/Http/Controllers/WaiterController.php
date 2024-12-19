<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Order;
use App\Models\OrderType;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class WaiterController extends Controller
{
    public function __construct() {
        $this->middleware('role:Waiter,Manager');
    }
    public function index()
    {
        $tables = Table::all();
        $user = Auth::user();
        return view('waiter.home', compact('tables', 'user'));
    }

    public function servedOrder() {
        $orders = DB::table('order')->where('orderstatus', 'Served')->get();
        $tables = Table::all();
        $users = User::all();
        $types = OrderType::all();
        $user = Auth::user();
        $orderLists = []; 
        foreach($orders as $item) {
            $order = Order::with('Menu')->findorfail($item->id);
            array_push($orderLists, $order);
        }
        return view('waiter.order.served_order', compact('orders', 'tables', 'users', 'user', 'types', 'orderLists'));
    }

    public function todayOrders() {
        $today = date('Y-m-d');
        $orders = Order::where('orderdate', $today)->get();
        $tables = Table::all();
        $users = User::all();
        $types = OrderType::all();
        $user = Auth::user();
        // dd($orders);
        return view('waiter.order.today_orders', compact('orders', 'tables', 'users', 'types', 'user'));
    }

    public function profile() {
        $roles = Role::all();
        $user = Auth::user();
        return view('waiter.profile', compact('roles', 'user'));
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

        return redirect('/waiter')->with('user_update_success', 'User updated successfully');
    }

}
