<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RawMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RawMaterialController extends Controller
{
    public function __construct() {
        $this->middleware('role:Manager');
    }
    
    public function index()
    {
        if(request('search')){
            $materials = RawMaterial::where("itemname", "like", "%" . request('search') . "%")->get();
        }
        else{
            $materials = RawMaterial::simplePaginate(10);
        }
        $user = Auth::user();
        return view("manager.raw_material.material_index", ['materials' => $materials, 'user' => $user]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('manager.raw_material.material_create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'itemname' => 'required|string',
            'price' => 'required|min:0|max:15',
            'quantity' => 'required|integer',
            'unit' => 'required|string',
        ]);

        $materials = RawMaterial::all();
        foreach($materials as $material){
            if($material->itemname == request('itemname')){
                return redirect('/manager/material')->with('material_add_duplicate', 'Item already exists!');
            }
        }

        $material = new RawMaterial();
        $material->itemname = request('itemname');
        $material->price = request('price');
        $material->quantity = request('quantity');
        $material->unit = request('unit');

        $material->save();
        return redirect('/manager/material')->with('material_add_success', 'Item added successfully');
    }
    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $marterial = RawMaterial::findorfail($id);;
        return view("manager.raw_material.material_edit", ['material' => $marterial, 'user' => $user]);
   }

    public function update(Request $request, $id){
        $material = RawMaterial::findorfail($id);
        $material->itemname = request('itemname');
        $material->price = request('price');
        $material->quantity = request('quantity');
        $material->unit = request('unit');
        $material->update();

        return redirect('/manager/material')->with('material_update_success', 'Material updated successfully');
    }

    public function destroy($id){
        $material = RawMaterial::findorfail($id);
        if($material->menu()->count()){
            return redirect('/manager/material')
                ->with('material_delete_fail', "Cannot delete! It is referenced in User table");
        }
        $material->delete();
        return redirect('/manager/material')->with('material_delete_success', 'Material deleted successfully');
    }
}
