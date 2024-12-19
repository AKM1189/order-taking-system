<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Menu;
use App\Models\RawMaterial;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function __construct() {
        $this->middleware('role:Manager');
    }
      
    public function index()
    {
        if(request('search')){
            $purchases = Purchase::where("invoice_no", "like", "%" . request('search') . "%")->get();
        }
        else{
            $purchases = Purchase::all();
        }
        $user = Auth::user();
        return view("manager.purchase.purchase.purchase_index", ['purchases' => $purchases, 'user' => $user]);
    }

    public function create($item)
    {
        $suppliers = Supplier::all();
        $today = Carbon::now()->format('Y-m-d');
        $menus = Menu::all();
        $materials = RawMaterial::all();
        $user = Auth::user();
        if($item == 'menu'){
            return view('manager.purchase.purchase.purchase_create', ['suppliers' => $suppliers, 'date' => $today, 'items' => $menus, 'itemtype' => 'menu', 'user' => $user]);
        }
        else if($item == 'raw_material'){
            return view('manager.purchase.purchase.purchase_create', ['suppliers' => $suppliers, 'date' => $today, 'items' => $materials, 'itemtype' => 'raw_material', 'user' => $user]);
        }
    }

    public function store(Request $request, $item)
    {

        // $request->validate([
        //     // 'purchase_date' => 'required|date_format:Y-m-d',
        //     'invoice_no' => 'required',
        //     'description' => 'required',
        //     'total' => 'required',
        // ]);

        $purchases = Purchase::all();

        foreach($purchases as $purchase){
            if($purchase->invoice_no == request('invoice_no')){
                return redirect('/manager/purchase')->with('purchase_add_duplicate', 'Purchase already exists!');
            }
        }
        // dd(request('total'), request('balance'));

        $purchase = new Purchase();
        $purchase->purchase_date = request('purchasedate');
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
        return redirect('/manager/purchase')->with('purchase_add_success', 'Purchase added successfully');
    }
    public function edit(Request $request, $item, $id)
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
        return view("manager.purchase.purchase.purchase_edit", compact('purchase', 'suppliers', 'items', 'user'));
   }

    public function update(Request $request, $id){
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
        return redirect('/manager/purchase')->with('purchase_update_success', 'Purchase updated successfully');
    }

    public function destroy($id){
        $purchase = Purchase::findorfail($id);
        $purchase->delete();
        return redirect('/manager/purchase')->with('purchase_delete_success', 'Purchase deleted successfully');
    }
}
