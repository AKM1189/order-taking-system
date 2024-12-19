<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderType;
use App\Models\Table;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminDashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Manager');
    }
    public function index() {
        $today = date('Y-m-d');
        $total = 0;
        $totalorders = DB::table('order')->where('orderdate', $today)->get();
        $orders = DB::table('order')->where('orderdate', $today)->simplePaginate(10);
        $purchases = Purchase::where('purchase_date', $today)->simplePaginate();
        $types = OrderType::all();
        $tables = Table::all();
        $users = User::all();
        $expense = 0;
        foreach($purchases as $purchase) {
            $expense += $purchase->total;
        }
        // $customers = Customer::all();
        // $reservations = Reservation::all();
        // dd($orders);
        foreach($orders as $order) {
            $total += $order->grandtotal;
        }
        // dd($total);
        $nooforder = count($totalorders);
        $user = Auth::user();
        $current = date('d-m-Y');
        return view('manager.dashboard', compact('user', 'nooforder', 'orders', 'purchases', 'total', 'current', 'expense', 'types', 'tables', 'users'));
    }
}
