<?php

use App\Http\Controllers\contactController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $productos = Product::all();
    return view('home',compact('productos'));
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/contacto', [ContactController::class, 'index'])->name('contact.index');
Route::post('/sendemail', [ContactController::class, 'enviarCorreo'])->name('send.email');
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/product-store', [ProductController::class, 'store'])->name('product.store');
    Route::post('/product-update', [ProductController::class, 'update'])->name('product.update');
    Route::post('/product-destroy', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::post('/change-status-user', [UserController::class, 'changeRol'])->name('change.rol');
    Route::post('/user-update', [UserController::class, 'update'])->name('user.update');
    Route::post('/user-destroy', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/store-material', [MaterialController::class, 'add'])->name('add.material');
    Route::post('/update-material', [MaterialController::class, 'update'])->name('material.update');
    Route::post('/destroy-material', [MaterialController::class, 'destroy'])->name('material.destroy');
});

require __DIR__.'/auth.php';
