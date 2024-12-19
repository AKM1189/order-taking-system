<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Menu;
use App\Models\RawMaterial;
use App\Models\OrderType;
use App\Models\Table;
use App\Models\User;

class ReportController extends Controller
{
    public function showReport($type) {
        if($type == 'order') {
            if(request('search')){
                $orders = Order::where("id", "like", "%" . request('search') . "%")->get();
            }
            else{
                $orders = Order::simplePaginate(10);
            }
            $user = Auth::user();
            $types = OrderType::all();
            $tables = Table::all();
            $users = User::all();
            return view('manager.report.order', compact('orders', 'user', 'types', 'tables', 'users'));
        }
        else if($type == 'purchase') {
            if(request('search')){
                $purchases = Purchase::where("invoice_no", "like", "%" . request('search') . "%")->simplePaginate(10);
            }
            else{
                $purchases = Purchase::simplePaginate(10);
            }
            $user = Auth::user();
            return view('manager.report.purchase', compact('purchases', 'user'));
        }
    }

    public function purchaseDetail($id) {
        $purchase = Purchase::with('menu', 'rawMaterial')->findorfail($id);
        $supplier = Supplier::findorfail($purchase->supplier_id);
        
        $user = Auth::user();
        if($purchase->purchase_type == 'menu'){
            $items = Menu::all();
        }
        else{
            $items = RawMaterial::all();
        }
        return view("manager.report.purchase_detail", compact('purchase', 'supplier', 'items', 'user'));
    }

    public function filter() {
        $date = request('date');
        $type = request('type');

        if($date == '') {
            $purchases = Purchase::where(['purchase_type' => $type])->simplePaginate(10);
        }
        else if($type == '') {
            $purchases = Purchase::where(['purchase_date' => $date])->simplePaginate(10);
        }
        else {
            $purchases = Purchase::where(['purchase_date' => $date, 'purchase_type' => $type])->simplePaginate(10);
        }
        $user = Auth::user();
        
        return view('manager.report.purchase', compact('purchases', 'user'));
        // dd($date, $type);
    }

    public function orderFilter() {
        $date = request('date');
        $type = request('type');
        $table = request('table');
        // dd($table);
        $waiter = request('waiter');

        if(!$date && !$table && !$waiter) {
            $orders = Order::where(['type_id' => $type])->simplePaginate(10);
        }
        else if(!$date && !$table && !$type) {
            $orders = Order::where(['staff_id' => $waiter])->simplePaginate(10);
        }
        else if(!$date && !$waiter && !$type) {
            $orders = Order::where(['table_id' => $table])->simplePaginate(10);
        }
        else if(!$table && !$waiter && !$type) {
            $orders = Order::where(['orderdate' => $date])->simplePaginate(10);
        }
        else if(!$date && !$table) {
            $orders = Order::where(['type_id' => $type, 'staff_id' => $waiter])->simplePaginate(10);
        }
        else if(!$date && !$waiter) {
            $orders = Order::where(['type_id' => $type, 'table_id' => $table])->simplePaginate(10);
        }
        else if(!$date && !$type) {
            $orders = Order::where(['table_id' => $table, 'staff_id' => $waiter])->simplePaginate(10);
        }
        else if(!$table && !$waiter) {
            $orders = Order::where(['orderdate' => $date, 'type_id' => $type])->simplePaginate(10);
        }
        else if(!$table && !$type) {
            $orders = Order::where(['orderdate' => $date, 'staff_id' => $waiter])->simplePaginate(10);
        }
        else if(!$waiter && !$type) {
            $orders = Order::where(['orderdate' => $date, 'table_id' => $table])->simplePaginate(10);
        }
        else if(!$date) {
            $orders = Order::where(['type_id' => $type, 'table_id' => $table, 'staff_id' => $waiter])->simplePaginate(10);
        }
        else if(!$table) {
            $orders = Order::where(['orderdate' => $date, 'type_id' => $type, 'staff_id' => $waiter])->simplePaginate(10);
        }
        else if(!$waiter) {
            $orders = Order::where(['orderdate' => $date, 'type_id' => $type, 'table_id' => $table])->simplePaginate(10);
        }
        else if(!$type) {
            $orders = Order::where(['orderdate' => $date, 'table_id' => $table, 'staff_id' => $waiter])->simplePaginate(10);
        }
        else {
            $orders = Order::where(['orderdate' => $date, 'type_id' => $type, 'table_id' => $table, 'staff_id' => $waiter])->simplePaginate(10);
        }
        // dd($orders);
        $user = Auth::user();
        $types = OrderType::all();
        $tables = Table::all();
        $users = User::all();
        return view('manager.report.order', compact('orders', 'user', 'types', 'tables', 'users'));
    }

    public function orderDetail($id) {
        $order = Order::with('menu')->findorfail($id);
        // dd($order);
        $table = '';
        if($order->table_id){
            $table = Table::findorfail($order->table_id);
        }
        $waiter = User::findorfail($order->staff_id);
        $type = OrderType::findorfail($order->type_id);
        
        $user = Auth::user();
        $menus = Menu::all();
        return view("manager.report.order_detail", compact('user', 'order', 'table', 'waiter', 'type', 'menus'));
    }
}
