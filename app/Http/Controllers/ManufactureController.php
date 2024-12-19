<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\RawMaterial;
use Illuminate\Support\Facades\Auth;

class ManufactureController extends Controller
{
    public function index() {
        $menus = Menu::all();
        // $materials = $menus->rawMaterial();
        $materials = RawMaterial::all();
        $menudetails = [];
        foreach($menus as $menu){
            $items = Menu::with('rawMaterial')->findorfail($menu->id);
            foreach($items->rawMaterial as $material){
                array_push($menudetails, $material->pivot);
            }
        }
        $user = Auth::user();
        return view('manager.manufacture.manufacture_list', compact('menus', 'menudetails', 'materials', 'user'));
    }

    public function manufacture(Request $request) {
        if($request->id) {
            $id = $request->id;
        }
        else{
            $id = request('menu');
        }
        $menu = Menu::with('rawMaterial')->findorfail($id);
        $menu->quantity += request('quantity');

        $materials = [];
        foreach($menu->rawMaterial as $item) {

            $material = RawMaterial::findorfail($item->id);
            $stock = $item->quantity;
            $unitQuantity = $item->pivot->quantity;
            $totalQuantity = $unitQuantity * request('quantity');
            if($stock - $totalQuantity < 0){
                if($request->id) {
                    return redirect('/kitchen/menus')->with('stock_unavailable', 'Purchase Ingredients First');
                
                }
                return redirect('/manager/manufacture')->with('stock_unavailable', 'Purchase Ingredients First');
            }

        }

        if($menu->quantity == 0) {
            $menu->status = 'stock out';
        }
        else if($menu->quantity < 10){
            $menu->status = 'low stock';
        }
        else{
            $menu->status = 'available';
        }
        $menu->update();
        
        foreach($menu->rawMaterial as $item) {
        $material = RawMaterial::findorfail($item->id);
        $unitQuantity = $item->pivot->quantity;
        $stock = $item->quantity;
        $totalQuantity = $unitQuantity * request('quantity');
        $material->quantity = $stock - $totalQuantity;
        $material->update();
        }

        if($request->id) {
            return redirect('/kitchen/menus')->with('manufacture_success', 'Menu manufactured successsfully');
        }
        else {
            return redirect('/manager/manufacture')->with('manufacture_success', 'Menu manufactured successfully');
        }
    }

    public function show() {
        $menus = Menu::all();
        $user = Auth::user();
        return view('manager.manufacture.unmanufacture', compact('menus', 'user'));
    }

    public function unmanufacture(Request $request) {
        if($request->id) {
            $id = $request->id;
        }
        else{
            $id = request('menu');
        }
        $menu = Menu::findorfail($id);
        $quantity = $menu->quantity;
        if($menu->quantity == 0){
            if($request->id) {
                return redirect('/kitchen/menus')->with('unmanufacture_fail', 'Menu already stocked out.');
            }
            else {
                return redirect('/manager/unmanufacture')->with('unmanufacture_fail', 'Menu already stocked out.');
            }
        }
        $menu->quantity -= request('quantity');
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

        foreach($menu->rawMaterial as $item) {
            $material = RawMaterial::findorfail($item->id);
            $stock = $item->quantity;
            $unitQuantity = $item->pivot->quantity;
            $stock = $item->quantity;
            $unitQuantity = $item->pivot->quantity;
            if($quantity >= request('quantity')){
                $totalQuantity = $unitQuantity * request('quantity');
            }
            else{
                $totalQuantity = $unitQuantity * $quantity;
            }
            $material->quantity = $stock + $totalQuantity;

            $material->update();
        }
        if($request->id) {
            return redirect('/kitchen/menus')->with('unmanufacture_success', 'Menu uncooked successsfully');
        }
        else {
        return redirect('/manager/unmanufacture')->with('unmanufacture_success', 'Menu unmanufactured successfully');
        }
    }
}
