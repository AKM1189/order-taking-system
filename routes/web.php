<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrderTypeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/manager/dashboard', [AdminDashboard::class, 'index']);

Route::get('/', function(){
    return redirect('/login');
});

Auth::routes();
Route::get('/manager/user/create', [CustomLoginController::class, 'create'])->name('register')->middleware('role:Manager');
Route::put('/manager/user/create', [RegisterController::class, 'create']);
Route::get('/login', [CustomLoginController::class, 'showLogin'])->name('login')->middleware('guest');

// user
Route::get('/manager/user', [UserController::class, 'index']);
Route::get('/manager/user/update/{id}', [UserController::class, 'edit']);
Route::put('/manager/user/update/{id}', [UserController::class, 'update']);
Route::delete('/manager/user/delete/{id}', [UserController::class, 'destroy']);

Route::get('/manager/profile/{id}', [UserController::class, 'profile']);


// category
Route::get('/manager/category', [CategoriesController::class, 'index'])->name('category.index');
Route::get('/manager/category/update/{id}', [CategoriesController::class, 'edit']);
Route::get('/manager/category/create', [CategoriesController::class, 'create']);
Route::put('/manager/category/create', [CategoriesController::class, 'store']);
Route::put('/manager/category/update/{id}', [CategoriesController::class, 'update']);
Route::delete('/manager/category/delete/{id}', [CategoriesController::class, 'destroy']);

// role
Route::get('/manager/role', [RolesController::class, 'index'])->name('role.index');
Route::get('/manager/role/update/{id}', [RolesController::class, 'edit']);
Route::get('/manager/role/create', [RolesController::class, 'create']);
Route::put('/manager/role/create', [RolesController::class, 'store']);
Route::put('/manager/role/update/{id}', [RolesController::class, 'update']);
Route::delete('/manager/role/delete/{id}', [RolesController::class, 'destroy']);

// table
Route::get('/manager/table', [TablesController::class, 'index']);
Route::get('/manager/table/update/{id}', [TablesController::class, 'edit']);
Route::get('/manager/table/create', [TablesController::class, 'create']);
Route::put('/manager/table/create', [TablesController::class, 'store']);
Route::put('/manager/table/update/{id}', [TablesController::class, 'update']);
Route::delete('/manager/table/delete/{id}', [TablesController::class, 'destroy']);

// menu
Route::get('/manager/menu', [MenuController::class, 'index']);
Route::get('/manager/menu/update/{id}', [MenuController::class, 'edit']);
Route::get('/manager/menu/create', [MenuController::class, 'create']);
Route::put('/manager/menu/create', [MenuController::class, 'store']);
Route::put('/manager/menu/update/{id}', [MenuController::class, 'update']);
Route::delete('/manager/menu/delete/{id}', [MenuController::class, 'destroy']);

// raw materials
Route::get('/manager/material', [RawMaterialController::class, 'index']);
Route::get('/manager/material/update/{id}', [RawMaterialController::class, 'edit']);
Route::get('/manager/material/create', [RawMaterialController::class, 'create']);
Route::put('/manager/material/create', [RawMaterialController::class, 'store']);
Route::put('/manager/material/update/{id}', [RawMaterialController::class, 'update']);
Route::delete('/manager/material/delete/{id}', [RawMaterialController::class, 'destroy']);

// order type
Route::get('/manager/type', [OrderTypeController::class, 'index']);
Route::get('/manager/type/update/{id}', [OrderTypeController::class, 'edit']);
Route::get('/manager/type/create', [OrderTypeController::class, 'create']);
Route::put('/manager/type/create', [OrderTypeController::class, 'store']);
Route::put('/manager/type/update/{id}', [OrderTypeController::class, 'update']);
Route::delete('/manager/type/delete/{id}', [OrderTypeController::class, 'destroy']);


// Supplier
Route::get('/manager/supplier', [SupplierController::class, 'index']);
Route::get('/manager/supplier/update/{id}', [SupplierController::class, 'edit']);
Route::get('/manager/supplier/create', [SupplierController::class, 'create']);
Route::put('/manager/supplier/create', [SupplierController::class, 'store']);
Route::put('/manager/supplier/update/{id}', [SupplierController::class, 'update']);
Route::delete('/manager/supplier/delete/{id}', [SupplierController::class, 'destroy']);

// Purchase
Route::get('/manager/purchase', [PurchaseController::class, 'index']);
Route::get('/manager/purchase/update/{item}&{id}', [PurchaseController::class, 'edit']);
Route::get('/manager/purchase/create/{item}', [PurchaseController::class, 'create']);
Route::put('/manager/purchase/create/{item}', [PurchaseController::class, 'store']);
Route::put('/manager/purchase/update/{id}', [PurchaseController::class, 'update']);
Route::delete('/manager/purchase/delete/{id}', [PurchaseController::class, 'destroy']);
// Auth::routes();

Route::get('/manager/manufacture', [ManufactureController::class, 'index']);
Route::put('/manager/manufacture', [ManufactureController::class, 'manufacture']);
Route::get('/manager/unmanufacture', [ManufactureController::class, 'show']);
Route::put('/manager/unmanufacture', [ManufactureController::class, 'unmanufacture']);



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/waiter', [WaiterController::class, 'index'])->name('home')->middleware('role:Waiter');
Route::get('/waiter/order', [OrderController::class, 'showOrder']);
Route::put('/waiter/order', [OrderController::class, 'orderStatus']);
Route::get('/waiter/served-order', [WaiterController::class, 'servedOrder']);
Route::get('/waiter/today-orders', [WaiterController::class, 'todayOrders']);
Route::get('/waiter/order/{id}', [OrderController::class, 'detail']);
Route::get('/waiter/order/update/{id}', [OrderController::class, 'edit']);
Route::put('/waiter/order/update/{id}', [OrderController::class, 'update']);
Route::put('/waiter/order/{id}', [OrderController::class, 'changeStatus']);
Route::get('/waiter/order/payment/{id}', [OrderController::class, 'showPayment']);
Route::put('/waiter/order/payment/{id}', [OrderController::class, 'makePayment']);


Route::get('/waiter/order/create/ordertype={ordertype}&tableno={tableno}', [OrderController::class, 'index']);
Route::get('/waiter/order/create/ordertype={ordertype}', [OrderController::class, 'index']);
Route::put('/waiter/order/create/ordertype={ordertype}', [OrderController::class, 'store']);
Route::put('/waiter/order/create/ordertype={ordertype}&tableno={tableno}', [OrderController::class, 'store']);
Route::get('/waiter/profile', [WaiterController::class, 'profile']);
Route::put('/waiter/profile/{id}', [WaiterController::class, 'update']);

Route::get('/kitchen/order', [KitchenController::class, 'index']);
Route::get('/kitchen/cooked-order', [KitchenController::class, 'cookedOrders']);
Route::get('/kitchen/order/{id}', [KitchenController::class, 'detail']);
Route::put('/kitchen/order/{id}', [KitchenController::class, 'changeStatus']);
Route::get('/kitchen/menus', [KitchenController::class, 'menus']);
Route::get('/kitchen/manufacture/{id}', [KitchenController::class, 'showmanufacture']);
Route::get('/kitchen/unmanufacture/{id}', [KitchenController::class, 'showunmanufacture']);
Route::put('/kitchen/manufacture/{id}', [ManufactureController::class, 'manufacture']);
Route::put('/kitchen/unmanufacture/{id}', [ManufactureController::class, 'unmanufacture']);
Route::get('/kitchen/purchase', [KitchenController::class, 'purchaseIndex']);
Route::get('/kitchen/purchase/update/{item}&{id}', [KitchenController::class, 'purchaseEdit']);
Route::get('/kitchen/purchase/create/{item}', [KitchenController::class, 'purchaseCreate']);
Route::put('/kitchen/purchase/create/{item}', [KitchenController::class, 'purchaseStore']);
Route::put('/kitchen/purchase/update/{id}', [KitchenController::class, 'purchaseUpdate']);
Route::delete('/kitchen/purchase/delete/{id}', [KitchenController::class, 'purchaseDestroy']);
Route::get('/kitchen/profile', [KitchenController::class, 'profile']);
Route::put('/kitchen/profile/{id}', [KitchenController::class, 'update']);


Route::get('/manager/report/{type}', [ReportController::class, 'showReport']);
Route::get('/manager/report/purchase/{id}', [ReportController::class, 'purchaseDetail']);
Route::put('/manager/report/purchase', [ReportController::class, 'filter']);
Route::put('/manager/report/order', [ReportController::class, 'orderFilter']);
Route::get('/manager/report/order/{id}', [ReportController::class, 'orderDetail']);

