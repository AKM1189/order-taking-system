<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\RawMaterial;
use App\Models\RawMaterialDetail;
use App\Models\Category;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function __construct() {
        $this->middleware('role:Manager');
    }
    
    public function index(Request $request)
    {
        if(request('search')){
            $menus = Menu::where("menuname", "like", "%" . request('search') . "%")->with('category')->get();
        }
        else{
            $menus = Menu::with('category')->simplePaginate(10);
        }
        $user = Auth::user();
        $categories = Category::all();
        return view('manager.menu.item.item_index', ['menus' => $menus, 'categories' => $categories, 'user' => $user]);
    }

    public function create()
    {
        $categories = Category::all();
        $materials = RawMaterial::all();
        $user = Auth::user();
        return view('manager.menu.item.item_create', compact('categories', 'materials', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menuname' => 'required',
            'description' => 'required',
            'quantity' => 'required',
        ]);

        $menus = Menu::all();
        foreach($menus as $menu){
            if($menu->menuname == request('menuname')){
                return redirect('/manager/menu')->with('menu_add_duplicate', 'Menu already exists!');
            }
        }

        if (request('menuimage')) {
            $fileNameToStore = Helpers::photoUpload(request('menuimage'), 'menu_images');
        }
        else{
            $fileNameToStore = 'menu.jpg';
        }


        $menu = new Menu();
        $menu->menuname = request('menuname');
        $menu->description = request('description');
        $menu->quantity = request('quantity');
        $menu->price = request('price');
        $menu->menu_type = request('menu-type');
        $menu->cost = request('total');
        $menu->status = request('status');
        $menu->menuimage = $fileNameToStore;
        $menu->category_id = request('category');

        $menu->save();

        $items = request('hidden-items');
        if($items){
            $lists = json_decode($items, true);  
            foreach($lists as $list){
                $id = $list['id'];
                $quantity = $list['quantity'];
                $subtotal = $list['subtotal'];
                $menu->rawMaterial()->attach($id, ['quantity' => $quantity, 'subtotal' => $subtotal]);
            }
        }
        $category = Category::findorfail(request('category'));
        $category->itemquantity += 1;
        $category->update();
        return redirect('/manager/menu')->with('menu_add_success', 'Menu added successfully');
    }
    public function edit(Request $request, $id)
    {
        $menu = Menu::with('rawMaterial')->findorfail($id);
        $itemDetails = $menu->rawMaterial; 
        // dd($itemDetails[0]->pivot->subtotal);  
        $materials = RawMaterial::all();
        $categories = Category::all();
        $user = Auth::user();
        return view("manager.menu.item.item_edit", ['menu' => $menu, 'materials' => $materials, 'itemDetails' => $itemDetails, 'categories' => $categories, 'user' => $user]);
   }

    public function update(Request $request, $id){
        $menu = Menu::findorfail($id);

        if (request('menuimage')) {
            $this->deleteImage($menu);
            $fileNameToStore = Helpers::photoUpload(request('menuimage'), 'menu_images');
            $menu->menuimage = $fileNameToStore;        
        }          

        $menu->menuname = request('menuname');
        $menu->description = request('description');
        $menu->quantity = request('quantity');
        $menu->price = request('price');
        $menu->menu_type = request('menu-type');
        $menu->cost = request('total');
        $menu->status = request('status');
        $menu->category_id = request('category');
        
        $items = request('hidden-items');
        if($items){
            $lists = json_decode($items, true);  
            // dd($lists);
            $syncData = [];
            foreach($lists as $list){
                $syncData[$list['id']] = [
                    'quantity' => $list['quantity'],
                    'subtotal' => $list['subtotal'],
                ];
            }
            $menu->rawMaterial()->sync($syncData);
        }
        $menu->update();
        return redirect('/manager/menu')->with('menu_update_success', 'Menu updated successfully');
    }

    public function destroy($id){
      
        $menu = Menu::findorfail($id);
        $menu->rawMaterial()->detach();
        $path = '/storage/menu_images/'.$menu->menuimage;
        if(File::exists(public_path($path)) && $menu->menuimage !== 'menu.jpg'){
            File::delete(public_path($path));
        }
        $menu->rawMaterial()->detach();
        $menu->delete();

        $category = Category::findorfail($menu->category_id);
        $category->itemquantity -= 1;
        $category->update();
        return redirect('/manager/menu')->with('menu_delete_success', 'Menu deleted successfully');
    }

    public function deleteImage($menu){
        $path = '/storage/menu_images/'.$menu->menuimage;
        if(File::exists(public_path($path)) && $menu->menuimage !== 'menu.jpg'){
            File::delete(public_path($path));
        }
    }
}
