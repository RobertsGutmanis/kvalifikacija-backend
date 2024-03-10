<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get("/user", [UserController::class, 'getUser']);
});

Route::post('/register', [UserController::class, "register"]);
Route::post('/login', [UserController::class, "login"]);
Route::get('/products', [ProductController::class, "index"]);
Route::post('/products', [ProductController::class, "store"]);
Route::get('/products/{id}', [ProductController::class, "show"]);
Route::get('/catalog/{category}', [ProductController::class, "categoryProducts"]);
Route::get('/search/{value}', [ProductController::class, "searchProduct"]);
Route::post('/product/specification', [ProductController::class, "addProductSpec"]);


Route::post('/wishlist/get', [WishlistController::class, "getWishlistProducts"]);
Route::post('/wishlist', [WishlistController::class, "storeWishlistProducts"]);
Route::post('/wishlist/delete', [WishlistController::class, "deleteWishlistProducts"]);
