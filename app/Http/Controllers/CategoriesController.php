<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function __construct() {
        $this->middleware('role:Manager');
    }
    
    public function index()
    {
        // $menu = DB::select('select * from menus where category_id = :id', ['id' => '1']);

        // dd($menu);
        if(request('search')){
            $categories = Category::where("categoryname", "like", "%" . request('search') . "%")->get();
        }
        else{
            $categories = Category::simplePaginate(10);
        }
        $user = Auth::user();
        return view("manager.menu.category.category_index", ['categories' => $categories, 'user' => $user]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('manager.menu.category.category_create', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoryname' => 'required',
        ]);

        $categories = Category::all();
        foreach($categories as $category){
            if($category->categoryname == request('categoryname')){
                return redirect('/manager/category')->with('category_add_duplicate', 'Category already exists!');
            }
        }

        $category = new Category();
        $category->categoryname = request('categoryname');

        $category->save();
        
        return redirect('/manager/category')->with('category_add_success', 'Category added successfully');
    }
    public function edit(Request $request, $id)
    {
        $category = Category::findorfail($id);
        $user = Auth::user();
        return view("manager.menu.category.category_edit", ['category' => $category, 'user' => $user]);
   }

    public function update(Request $request, $id){
        $category = Category::findorfail($id);
        $category->categoryname = request('categoryname');
        $category->update();

        return redirect('/manager/category')->with('category_update_success', 'Category updated successfully');
    }

    public function destroy($id){
        $category = Category::findorfail($id);
        if($category->menu()->count() > 0){
            return redirect('/manager/category')
            ->with('category_delete_fail', "Cannot delete! It is referenced in the menu table");
        }
        $category->delete();
        return redirect('/manager/category')->with('category_delete_success', 'Category deleted successfully');
    }
}
