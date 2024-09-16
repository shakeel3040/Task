<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
     });

    Route::post('login',[UserController::class,'loginUser']);
    Route::post('/register', [UserController::class, 'register']);


    Route::get('category_list',[CategoryController::class,'all_categories']);
    Route::get('product_list',[ProductController::class,'all_products']);

    Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[UserController::class,'userDetails']);
   
    Route::get('logout',[UserController::class,'logout']);
    
    });