<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;

class TablesController extends Controller
{
    public function __construct() {
        $this->middleware('role:Manager');
    }
    
    public function index()
    {
        if(request('search')){
            $tables = Table::where("tablenumber", "like", "%" . request('search') . "%")->get();
        }
        else{
            $tables = Table::all();
        }
        $user = Auth::user();
        return view("manager.table.table_index", ['tables' => $tables, 'user' => $user]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('manager.table.table_create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tablenumber' => 'required',
            'capacity' => ['required', 'min:0', 'max:15'],
            'status' => 'nullable',
        ]);

        $tables = Table::all();
        foreach($tables as $table){
            if($table->tablenumber == request('tablenumber')){
                return redirect('/manager/table')->with('table_add_duplicate', 'Table already exists!');
            }
        }

        $table = new Table();
        $table->tablenumber = request('tablenumber');
        $table->capacity = request('capacity');
        $table->status = request('status');

        $table->save();
        return redirect('/manager/table')->with('table_add_success', 'Table added successfully');
    }
    public function edit(Request $request, $id)
    {
        $table = Table::findorfail($id);
        $user = Auth::user();
        return view("manager.table.table_edit", ['table' => $table, 'user' => $user]);
   }

    public function update(Request $request, $id){
        $table = Table::findorfail($id);
        $table->tablenumber = request('tablenumber');
        $table->capacity = request('capacity');
        $table->status = request('status');
        $table->update();

        return redirect('/manager/table')->with('table_update_success', 'Table updated successfully');
    }

    public function destroy($id){
        $table = Table::findorfail($id);
        if($table->order()->count() > 0){
            return redirect('/manager/table')
            ->with('table_delete_fail', "Cannot delete! It is referenced in the order table");
        }
        $table->delete();
        return redirect('/manager/table')->with('table_delete_success', 'Table deleted successfully');
    }
}
