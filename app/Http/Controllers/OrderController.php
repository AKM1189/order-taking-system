<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Table;
use App\Models\OrderType;
use App\Models\User;
use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if(request('search')){
            $menus = Menu::where("menuname", "like", "%" . request('search') . "%")->get();
        }
        else{
            $menus = Menu::all();
        }
        $categories = Category::all();
        $tableno = $request->tableno;
        $ordertype = $request->ordertype;
        return view("manager.order.makeorder.order_create", compact('tableno', 'ordertype', 'categories', 'user', 'menus'));
    }

    public function showpickup($ordertype) {
        $user = Auth::user();
        if(request('search')){
            $menus = Menu::where("menuname", "like", "%" . request('search') . "%")->get();
        }
        else{
            $menus = Menu::all();
        }
        $categories = Category::all();
        $tableno='';

        return view("manager.order.makeorder.order_create", compact('tableno', 'ordertype', 'categories', 'user', 'menus'));
    }

    public function showOrder() {
        $orders = Order::whereIn('orderstatus', ['Cooking', 'Ready'])->get();
        $tables = Table::all();
        $users = User::all();
        $types = OrderType::all();
        $user = Auth::user();
        $orderLists = []; 
        foreach($orders as $item) {
            $order = Order::with('Menu')->findorfail($item->id);
            array_push($orderLists, $order);
        }
        return view('waiter.order.order_list', compact('orders', 'tables', 'users', 'user', 'types', 'orderLists'));
    }

    public function orderStatus(Request $request) {
        $order = Order::with('Menu')->findorfail($request->orderid);
        $menus = $order->menu;
        $order->orderstatus = 'Served';
        $order->update();
        $syncData = [];
        foreach($menus as $list){
            $syncData[$list->pivot->menuid] = [
                'menuid' => $list->pivot->menuid,
                'unit_quantity' => $list->pivot->unit_quantity,
                'subtotal' => $list->pivot->subtotal,
                'menu_status' => 'Served',
            ];
        } 
            $order->menu()->sync($syncData);
    }

    public function changeStatus(Request $request) {
        $order = Order::with('Menu')->findorfail($request->orderid);
        $syncData = [];
        $count = 0;
            foreach($request->menus as $list){
                $syncData[$list['menuid']] = [
                    'menuid' => $list['menuid'],
                    'unit_quantity' => $list['unit_quantity'],
                    'subtotal' => $list['subtotal'],
                    'menu_status' => $list['menu_status'],
                ];
                if($list['menu_status'] == 'Served') {
                    $count++;
                }
            } 
            $order->menu()->sync($syncData);
            if(count($request->menus) === $count) {
                $order->orderstatus = 'Served';
                $order->update();
            }

        return response()->json($request->menus);
    }
    
    public function create()
    {
        $categories = Category::all();
        $menus = Menu::all();
        return view('manager.order.makeorder.order_create', ['categories' => $categories, 'menus' => $menus]);
    }

    public function fetchcategories()
    {
        $categories = Category::all();
        $menus = Menu::all();
        return response()->json(['categories' => $categories, 'menus'=> $menus]);
    }

    public function store(Request $request)
    {
        $order = new Order();
        if(request('table_no')) {
            $table = DB::select("select * from tables where tablenumber = :tableno", ['tableno' => request('table_no')]);
            $order->table_id = $table[0]->id;
        }
        if(request('token')) {
            $order->order_token = request('token');
        }
        $user = Auth::user();
        $order->staff_id = $user->id;
        $order_type = DB::select('select * from order_types where typename = :name', ['name' => request('order_type')]);
        $order->type_id = $order_type[0]->id;
        $order->orderdate = Carbon::now()->toDateString();
        $order->ordertime = Carbon::now()->toTimeString();
        $order->subtotal = request('total');
        $order->grandtotal = request('grand-total');
        $order->discount = request('discount');
        $order->tax = request('tax');
        $order->orderstatus = 'Cooking';

        $order->save();
        if(request('table_no')){
            $tabledetail = Table::findorfail($table[0]->id);
            $tabledetail->status = 'Occupied';
            $tabledetail->update();
        }

        $item_list = request('hidden-items');
        if($item_list){
            $lists = json_decode($item_list, true);  
            
        foreach($lists as $list){
            $id = $list['id'];
            // $note = 
            $quantity = $list['quantity'];
            $subtotal = $list['subtotal'];
            $status = 'Cooking';
            $order->menu()->attach($id, ['unit_quantity' => $quantity, 'subtotal' => $subtotal, 'menu_status' => $status]);
        }
        return redirect('/waiter')->with('order_add_success', 'Order placed successfully');
    }
}
    public function edit(Request $request, $id)
    {
        $order = Order::with('Menu')->findorfail($id);;
        $categories = Category::all();
        $ordertype = DB::select("select * from order_types where id = :id", ['id' => $order->type_id]);
        $table = DB::select("select * from tables where id = :id", ['id' => $order->table_id]);
        $user = Auth::user();
        if(request('search')){
            $menus = Menu::where("menuname", "like", "%" . request('search') . "%")->get();
        }
        else{
            $menus = Menu::all();
        }
        
        return view("manager.order.makeorder.order_edit", ['order' => $order, 'ordertype' => $ordertype[0]->typename, 'tableno' => $table[0]->tablenumber, 'categories' => $categories, 'menus' => $menus, 'user' => $user]);
   
   
    }

    public function detail($id) 
    {
        $order = Order::with('Menu')->findorfail($id);;
        $categories = Category::all();
        $ordertype = DB::select("select * from order_types where id = :id", ['id' => $order->type_id]);
        $table = '';
        if($ordertype[0]->typename == "Dining Order") {
            $table = Table::where('id', $order->table_id)->first();
            // dd($table);
        }
        $user = Auth::user();
        $menus = Menu::all();
        return view('waiter.order.order_detail', ['order' => $order, 'type' => $ordertype[0], 'table' => $table, 'categories' => $categories, 'menus' => $menus, 'user' => $user]);
    }

    public function update(Request $request, $id){
        $order = Order::findorfail($id);
        if(request('table_no')) {
            $table = DB::select("select * from tables where tablenumber = :tableno", ['tableno' => request('table_no')]);
            $order->table_id = $table[0]->id;
        }
        if(request('token')) {
            $order->order_token = request('token');
        }
        $user = Auth::user();
        $order->staff_id = $user->id;
        $order_type = DB::select('select * from order_types where typename = :name', ['name' => request('order_type')]);
        $order->type_id = $order_type[0]->id;
        $order->orderdate = Carbon::now()->toDateString();
        $order->ordertime = Carbon::now()->toTimeString();
        $order->subtotal = request('total');
        $order->grandtotal = request('grand-total');
        $order->discount = request('discount');
        $order->tax = request('tax');
        $order->orderstatus = 'Cooking';

        $item_list = request('hidden-items');
        if($item_list){
            $lists = json_decode($item_list, true);  
            $syncData = [];
        foreach($lists as $list){
            $syncData[$list['id']] = [
                'unit_quantity' => $list['quantity'],
                'subtotal' => $list['subtotal'],
                'menu_status' => $list['status'],
            ];
            // $note =    
        }
            $order->menu()->sync($syncData);
        }
        $order->update();
        return redirect('/waiter/order')->with('order_update_success', 'Order updated successfully');

    }

    public function showPayment($id) {
        $order = Order::findorfail($id);
            $tableno = DB::table('tables')->where('id', $order->table_id)->value('tablenumber');
            $token = $order->order_token;

        // $tableno = $table->tablenumber;
        $user = Auth::user();
        return view('waiter.order.payment', compact('order', 'user', 'tableno', 'token'));
    }

    public function makePayment(Request $request, $id) {
        $order = Order::findorfail($id);
        $order->payment_type = request('payment-type');
        $order->paid_amount = request('paid');
        $order->change = request('change');
        $order->orderstatus = 'Paid';
        $order->update();
        if($order->table_id) {
            $table = Table::findorfail($order->table_id);
            $table->status = 'Available';
            $table->update();
        }
        return redirect('/waiter/served-order')->with('payment-success', 'Order paid successfully');
    }
}
