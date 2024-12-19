<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Menu;
use App\Models\OrderDetail;
use App\Models\Table;
use App\Models\OrderType;
use App\Models\Supplier;
use App\Models\RawMaterial;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KitchenController extends Controller
{
    public function __construct() {
        $this->middleware('role:Kitchen Staff,Manager');
    }

    public function index() {
        $orders = Order::where('orderstatus', ['Cooking'])->get();
        $orderDetails = OrderDetail::all();
        $tables = Table::all();
        $users = User::all();
        $types = OrderType::all();
        $user = Auth::user();
        return view('kitchenstaff.home', compact('orders', 'tables', 'users', 'orderDetails', 'types', 'user'));
    }

    public function detail($id) 
    {
        $order = Order::with('Menu')->findorfail($id);
        $categories = Category::all();
        $ordertype = DB::select("select * from order_types where id = :id", ['id' => $order->type_id]);
        $table = '';
        if($ordertype[0]->typename == 'Dining Order') {
            $table = Table::where('id', $order->table_id)->first();
        }
        $user = Auth::user();
        $menus = Menu::all();

        return view('kitchenstaff.detail', ['order' => $order, 'type' => $ordertype[0], 'table' => $table, 'categories' => $categories, 'menus' => $menus, 'user' => $user]);
    }

    public function changeStatus(Request $request) {
        $order = Order::with('Menu')->findorfail($request->orderid);
        $menuid = $request->menuid;
        $menu = Menu::findorfail($menuid);
        $status = 0;
        foreach($request->menus as $list){
            if($list['menuid'] == $menuid){
                if($menu->quantity - $list['unit_quantity'] < 0) {
                    $menu->quantity = 0; 
                }
                else {
                    $menu->quantity = $menu->quantity - $list['unit_quantity'];
                }
                if($menu->quantity < 0){
                    $menu->quantity = 0;
                }
                if($menu->quantity == 0) {
                    $menu->status = 'Stock out';
                }
                else if($menu->quantity < 20){
                    $menu->status = 'Low stock';
                }
                else{
                    $menu->status = 'Available';
                }
                $menu->update();
            }
            $syncData[$list['menuid']] = [
                'menuid' => $list['menuid'],
                'unit_quantity' => $list['unit_quantity'],
                'subtotal' => $list['subtotal'],
                'menu_status' => $list['menu_status'],
            ];
            $order->menu()->sync($syncData);
        } 
        foreach($syncData as $item) {
            if($item['menu_status'] == 'Ready') {
                $status++;
            }
        }
        if(count($syncData) == $status) {
            $order->orderstatus = 'Ready'; 
            $order->update();
        }
        return response()->json($request->menus);
    }

    public function menus() {
        if(request('search')){
            $menus = Menu::where("menuname", "like", "%" . request('search') . "%")->with('category')->get();
        }
        else{
            $menus = Menu::with('category')->get();
        }
        $categories = Category::all();
        $user = Auth::user();

        return view('kitchenstaff.menus', compact('menus', 'categories', 'user'));
    }

    public function showmanufacture(Request $request) {
        $menu = Menu::with('RawMaterial')->findorfail($request->id);
        $ingredients = $menu->rawMaterial;
        $user = Auth::user();
        return view('kitchenstaff.manufacture', compact('menu', 'ingredients', 'user'));
    }

    public function showunmanufacture(Request $request) {
        $menu = Menu::with('RawMaterial')->findorfail($request->id);
        $ingredients = $menu->rawMaterial;
        $user = Auth::user();
        return view('kitchenstaff.unmanufacture', compact('menu', 'ingredients', 'user'));
    }

    public function cookedOrders() {
        $orders = Order::whereIn('orderstatus', ['Served', 'Ready'])->get();
        // dd($orders);
        $orderDetails = OrderDetail::all();
        $tables = Table::all();
        $users = User::all();
        $types = OrderType::all();
        $user = Auth::user();
        return view('kitchenstaff.cooked_orders', compact('orders', 'tables', 'users', 'user', 'orderDetails', 'types'));
    }

    public function purchaseIndex() {
        if(request('search')){
            $purchases = Purchase::where("invoice_no", "like", "%" . request('search') . "%")->get();
        }
        else{
            $purchases = Purchase::all();
        }
        $user = Auth::user();
        return view("kitchenstaff.purchase.purchase_index", ['purchases' => $purchases, 'user' => $user]);
    }

    public function purchaseCreate($item)
    {
        $suppliers = Supplier::all();
        $today = Carbon::now()->format('m-d-Y');
        $menus = Menu::all();
        $materials = RawMaterial::all();
        $user = Auth::user();
        if($item == 'menu'){
            return view('kitchenstaff.purchase.purchase_create', ['suppliers' => $suppliers, 'date' => $today, 'items' => $menus, 'itemtype' => 'menu', 'user' => $user]);
        }
        else if($item == 'raw_material'){
            return view('kitchenstaff.purchase.purchase_create', ['suppliers' => $suppliers, 'date' => $today, 'items' => $materials, 'itemtype' => 'raw_material', 'user' => $user]);
        }
    }

    public function purchaseStore(Request $request, $item)
    {
        $purchases = Purchase::all();

        foreach($purchases as $purchase){
            if($purchase->invoice_no == request('invoice_no')){
                return redirect('/kitchen/purchase')->with('purchase_add_duplicate', 'Purchase already exists!');
            }
        }

        $purchase = new Purchase();
        $purchase->invoice_no = request('invoice_no');
        $purchase->purchase_type = request('purchase_type');
        $purchase->description = request('description');
        $purchase->total = request('total');
        $purchase->paid_amount = request('paid_amount');
        $purchase->balance = request('balance');
        $purchase->payment_type = request('payment_type');
        $purchase->supplier_id = request('supplier');

        $purchase->save();

        $item_list = request('hidden-items');
        if($item_list){
            $lists = json_decode($item_list, true);  
        foreach($lists as $list){
            $id = $list['id'];
            $quantity = $list['quantity'];
            $price = $list['price'];
            $subtotal = $list['subtotal'];

            if($item == 'menu'){
                $menu = Menu::findorfail($id);
                $purchase->menu()->attach($id, ['price' => $price, 'quantity' => $quantity, 'subtotal' => $subtotal]);
                $menu->price += $price;
                $menu->quantity += $quantity;

                if($menu->quantity == 0) {
                    $menu->status = 'stock out';
                }
                else if($menu->quantity < 20){
                    $menu->status = 'low stock';
                }
                else{
                    $menu->status = 'available';
                }
                $menu->update();
            }
            else if($item == 'raw_material'){
                $material = RawMaterial::findorfail($id);
                $purchase->rawMaterial()->attach($id, ['price' => $price, 'quantity' => $quantity, 'subtotal' => $subtotal]);
                $material->price = $price;
                $material->quantity += $quantity;
                $material->update();
                
            }
        }
        }
        return redirect('/kitchen/purchase')->with('purchase_add_success', 'Purchase added successfully');
    }
    public function purchaseEdit(Request $request, $item, $id)
    {
        $purchase = Purchase::with('menu', 'rawMaterial')->findorfail($id);
        $suppliers = Supplier::all();
        $user = Auth::user();
        if($item == 'menu'){
            $items = Menu::all();
        }
        else{
            $items = RawMaterial::all();
        }
        return view("kitchenstaff.purchase.purchase_edit", compact('purchase', 'suppliers', 'items', 'user'));
   }

    public function purchaseUpdate(Request $request, $id){
        $purchase = Purchase::findorfail($id);
        $purchase->invoice_no = request('invoice_no');
        $purchase->description = request('description');
        $purchase->total = request('total');
        $purchase->paid_amount = request('paid_amount');
        $purchase->balance = request('balance');
        $purchase->payment_type = request('payment_type');
        $purchase->supplier_id = request('supplier');

        $items = request('hidden-items');
        if($items){
            $lists = json_decode($items, true);  
            $syncData = [];
            foreach($lists as $list){
                $syncData[$list['id']] = [
                    'price' => $list['price'],
                    'quantity' => $list['quantity'],
                    'subtotal' => $list['subtotal'],
                ];
            
            if(request('purchase_type') == 'Menu Purchase'){
                $purchases = Purchase::with('menu')->findorfail($id);
                // dd($purchases);
                foreach($purchases->menu as $item){                
                    $menu = Menu::findorfail($list['id']);
                    // dd($item->pivot);      
                    if($item->pivot->menu_id == $list['id']){
                        $old_quantity = $item->pivot->quantity;
                        $menu->quantity = ($menu->quantity - $old_quantity) + $list['quantity'];
                        // dd($list['quantity']);
                        if($menu->quantity < 0){
                            $menu->quantity = 0;
                        }
                        if($menu->quantity == 0) {
                            $menu->status = 'stock out';
                        }
                        else if($menu->quantity < 20){
                            $menu->status = 'low stock';
                        }
                        else{
                            $menu->status = 'available';
                        }
                        $menu->update();
                    }
                }
                $purchase->menu()->sync($syncData);
            }
            else if(request('purchase_type') == "Raw Material Purchase"){
                $purchases = Purchase::with('rawMaterial')->findorfail($id);
                foreach($purchases->rawMaterial as $item){                
                    $material = RawMaterial::findorfail($list['id']);
                    if($item->pivot->material_id == $list['id']){
                        $old_quantity = $item->pivot->quantity;
                        $material->quantity = ($material->quantity - $old_quantity) + $list['quantity'];
                        $material->update();
                    }
                }
                $purchase->rawMaterial()->sync($syncData);
            }
        }
        }
        
        $purchase->update();
        return redirect('/kitchen/purchase')->with('purchase_update_success', 'Purchase updated successfully');
    }

    public function purchaseDestroy($id){
        $purchase = Purchase::findorfail($id);
        $purchase->delete();
        return redirect('/kitchen/purchase')->with('purchase_delete_success', 'Purchase deleted successfully');
    }

    public function profile() {
        $roles = Role::all();
        $user = Auth::user();
        return view('kitchenstaff.profile', compact('roles', 'user'));
    }

    public function update(Request $request, $id){
        $user = User::findorfail($id);
        $user->name = request('name');
        $user->email = request('email');
        if(request('password')){
        $user->password = Hash::make(request('password'));
        }
        $user->update();

        return redirect('/kitchen/order')->with('user_update_success', 'User updated successfully');
    }
}
