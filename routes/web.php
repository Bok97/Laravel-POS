<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function(){
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    //product
    Route::resource('products', ProductController::class);
    //customer
    Route::resource('customers', CustomerController::class);
    //orders
    Route::resource('orders', OrderController::class);
    //cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/addQty', [CartController::class, 'addQty']);
    Route::post('/cart/minusQty', [CartController::class, 'minusQty']);
    Route::post('/cart/changeQty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);

});