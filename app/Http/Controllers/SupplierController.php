<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
class SupplierController extends Controller
{
    public function __construct() {
        $this->middleware('role:Manager');
    }
    
    public function index()
    {
        if(request('search')){
            $suppliers = Supplier::where("name", "like", "%" . request('search') . "%")->get();
        }
        else{
            $suppliers = Supplier::all();
        }
        $user = Auth::user();
        return view("manager.purchase.supplier.supplier_index", ['suppliers' => $suppliers, 'user' => $user]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('manager.purchase.supplier.supplier_create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        $suppliers = Supplier::all();
        foreach($suppliers as $supplier){
            if($supplier->name == request('name')){
                return redirect('/manager/supplier')->with('supplier_add_duplicate', 'Supplier already exists!');
            }
        }

        $supplier = new Supplier();
        $supplier->name = request('name');
        $supplier->phone = request('phone');
        $supplier->email = request('email');
        $supplier->address = request('address');

        $supplier->save();
        return redirect('/manager/supplier')->with('supplier_add_success', 'Supplier added successfully');
    }
    public function edit(Request $request, $id)
    {
        $supplier = Supplier::findorfail($id);
        $user = Auth::user();
        return view("manager.purchase.supplier.supplier_edit", ['supplier' => $supplier, 'user' => $user]);
   }

    public function update(Request $request, $id){
        $supplier = Supplier::findorfail($id);
        $supplier->name = request('name');
        $supplier->phone = request('phone');
        $supplier->email = request('email');
        $supplier->address = request('address');
        $supplier->update();

        return redirect('/manager/supplier')->with('supplier_update_success', 'Supplier updated successfully');
    }

    public function destroy($id){
        $supplier = Supplier::findorfail($id);
        if($supplier->purchase()->count()){
            return redirect('/manager/supplier')
                ->with('supplier_delete_fail', "Cannot delete! It is referenced in Purchase table");
        }
        $supplier->delete();
        return redirect('/manager/supplier')->with('supplier_delete_success', 'Supplier deleted successfully');
    }
}
