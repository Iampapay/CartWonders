<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Admin\AdminController;

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

Route::get('/', [AdminController::class,'index']);

/////////////////////////////// Admin routes //////////////////////////////////

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {

    Route::get('/dashboard', [AdminController::class,'redirect'])->name('dashboard');

    Route::get('/category', [AdminController::class,'view_category']);

    Route::get('/fetch-category', [AdminController::class,'fetch_category']);

    Route::post('/add-category', [AdminController::class,'add_category']);

    Route::post('delete-category/{id}', [AdminController::class,'delete_category']);

    Route::get('/add-product', [AdminController::class,'view_product']);

    Route::post('/create-product', [AdminController::class,'create_product']);

    Route::get('/fetch-product', [AdminController::class,'fetch_product']);

    Route::get('/show-product', [AdminController::class,'show_product']);

    Route::get('edit-product/{id}', [AdminController::class,'edit_product']);

    Route::post('update-product/{id}', [AdminController::class,'update_product']);

    Route::post('delete-product/{id}', [AdminController::class,'delete_product']);

    Route::post('product-status/{id}', [AdminController::class,'product_status']);

    Route::get('/order', [AdminController::class,'show_order']);

    Route::post('/fetch-order', [AdminController::class,'fetch_Order']);
});


/////////////////////////////// user routes //////////////////////////////////

Route::get('/fetch_product_for_user', [HomeController::class,'fetch_product_for_user']);

Route::get('/product', [HomeController::class,'user_view_product']);

Route::get('/add_to_cart', [HomeController::class,'add_to_cart']);

Route::get('/cart', [HomeController::class,'view_cart']);

Route::get('/fetch_cart_item', [HomeController::class,'fetch_cart_item']);

Route::post('/update_cart_details', [HomeController::class,'update_cart_details']);

Route::post('remove_from_cart/{id}', [HomeController::class,'remove_from_cart']);

Route::get('/wishlist', [HomeController::class,'view_wishlist']);

Route::get('/add_to_wishlist', [HomeController::class,'add_to_wishlist']);

Route::get('/fetch_wishlist_item', [HomeController::class,'fetch_wishlist_item']);

Route::post('remove_from_wishlist/{id}', [HomeController::class,'remove_from_wishlist']);

Route::get('/count_wish_cart_item', [HomeController::class,'count_wish_cart_item']);

Route::get('/checkout', [HomeController::class,'view_checkout']);

Route::post('/get-address', [HomeController::class,'get_address']);

Route::post('/place-order', [HomeController::class,'placeOrder']);

Route::get('/contact', [HomeController::class,'view_contact']);

Route::get('/shop', [HomeController::class,'view_shop']);






