<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/signin', [\App\Http\Controllers\Api\AuthController::class, 'signup']);

//cattegorie
Route::post('/cretecat', [\App\Http\Controllers\Api\CategorieController::class, 'create']);
Route::get('/getcategorie', [\App\Http\Controllers\Api\CategorieController::class, 'index']);
Route::delete('/deletecat/{id}', [\App\Http\Controllers\Api\CategorieController::class, 'destroy']);


//usergetall
Route::post('/getAllusers', [\App\Http\Controllers\Api\AuthController::class, 'indexx']);


//productroutes
Route::get('productsall', [\App\Http\Controllers\Api\ProductsController::class, 'index']); 
Route::get('products/{id}', [\App\Http\Controllers\Api\ProductsController::class, 'show']); 
Route::post('/createproduct', [\App\Http\Controllers\Api\ProductsController::class, 'store']);
Route::put('productsupdate/{id}', [\App\Http\Controllers\Api\ProductsController::class, 'update']);
Route::delete('productdelete/{id}', [\App\Http\Controllers\Api\ProductsController::class, 'destroy']);
Route::get('getproductbycat/{id}', [\App\Http\Controllers\Api\ProductsController::class, 'getproductbycat']);

//variation routees
Route::post('/createvarr', [\App\Http\Controllers\Api\VariationController::class, 'store']);
Route::get('/getvariation', [\App\Http\Controllers\Api\VariationController::class, 'index']); 
Route::get('variation/{id}', [\App\Http\Controllers\Api\VariationController::class, 'show']); 
Route::put('variationUpdate/{id}', [\App\Http\Controllers\Api\VariationController::class, 'update']);
Route::delete('variationdelete/{id}', [\App\Http\Controllers\Api\VariationController::class, 'destroy']);