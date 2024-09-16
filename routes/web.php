<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

 

// Route::get('/dashboard', function () {
//     return view('admin.category_list');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [CategoryController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    
    
    Route::get('admin-page', function () {
        return view('admin.index');
    });
    Route::get('add_category',function () {
        return view('admin.add_category');
    });

    Route::get('list_category',function () {
        return view('admin.category_list');
    });
 // routes/web.
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/list', [CategoryController::class, 'show'])->name('category.show');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    
    Route::get('/product/list', [ProductController::class, 'show'])->name('product.show');
   
    Route::post('/add-product', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');



    Route::get('edit_category',[CategoryController::class,'edit_category'])->name('category.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
