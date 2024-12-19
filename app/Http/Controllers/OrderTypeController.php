<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderType;
use Illuminate\Support\Facades\Auth;

class OrderTypeController extends Controller
{
    public function __construct() {
        $this->middleware('role:Manager');
    }
    
    public function index()
    {
        if(request('search')){
            $types = OrderType::where("typename", "like", "%" . request('search') . "%")->get();
        }
        else{
            $types = OrderType::all();
        }
        $user = Auth::user();
        return view("manager.order.ordertype.type_index", ['types' => $types, 'user' => $user]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('manager.order.ordertype.type_create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'typename' => 'required'
        ]);

        $types = OrderType::all();
        foreach($types as $type){
            if($type->typename == request('typename')){
                return redirect('/manager/type')->with('type_add_duplicate', 'Order Type already exists!');
            }
        }

        $types = new OrderType();
        $types->typename = request('typename');

        $types->save();
        return redirect('/manager/type')->with('type_add_success', 'Order Type added successfully');
    }
    public function edit(Request $request, $id)
    {
        $type = OrderType::findorfail($id);
        $user = Auth::user();
        return view("manager.order.ordertype.type_edit", ['type' => $type, 'user' => $user]);
   }

    public function update(Request $request, $id){
        $type = OrderType::findorfail($id);
        $type->typename = request('typename');
        $type->update();

        return redirect('/manager/type')->with('type_update_success', 'Order Type updated successfully');
    }

    public function destroy($id){
        $type = OrderType::findorfail($id);
        // dd($type);
        if($type->order()->count()){
            return redirect('/manager/type')
                ->with('type_delete_fail', "Cannot delete! It is referenced in Order table");
        }
        $type->delete();
        return redirect('/manager/type')->with('type_delete_success', 'Order Type deleted successfully');
    }
}
