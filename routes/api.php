<?php

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\SocialsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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

/* USERS */
Route::post('users/sign-up', [UsersController::class, 'register']);
Route::post('users/sign-in', [UsersController::class, 'login']);
Route::post(
  'users/sign-out',
  [UsersController::class, 'logout']
)->middleware('auth:api');
Route::get('users/user-info/{id}', [UsersController::class, 'get_user_info_by_id']);
Route::put(
  'users/edit',
  [UsersController::class, 'edit_profile']
)->middleware('auth:api');
Route::patch(
  'users/follow-user',
  [UsersController::class, 'follow_user']
)->middleware('auth:api');
Route::patch(
  'users/unfollow-user',
  [UsersController::class, 'unfollow_user']
)->middleware('auth:api');
Route::get(
  'users/followers',
  [UsersController::class, 'get_followers']
)->middleware('auth:api');
Route::get(
  'users/followings',
  [UsersController::class, 'get_followings']
)->middleware('auth:api');
Route::post(
  'users/upload-profile-picture',
  [UsersController::class, 'upload_profile_picture']
)->middleware('auth:api');
// NOTE: See if we could do a recover password endpoint
Route::post(
  'users/send-message',
  [UsersController::class, 'send_message']
)->middleware('auth:api');
Route::get(
  'users/conversation/{user_conversation}',
  [UsersController::class, 'get_conversation_messages']
)->middleware('auth:api');

/* PRODUCTS */
Route::post(
  'products/add-product',
  [ProductsController::class, 'create']
)->middleware('auth:api');
Route::get('products/get-product/{id}', [ProductsController::class, 'get_product']);
Route::get('products/get-products', [ProductsController::class, 'get_products']);
Route::get('products/search-products', [ProductsController::class, 'search_products']);
Route::get(
  'products/seller-products',
  [ProductsController::class, 'get_seller_products']
)->middleware('auth:api');
Route::put(
  'products/update-product/{id}',
  [ProductsController::class, 'update_product']
)->middleware('auth:api');
Route::delete(
  'products/delete-product/{id}',
  [ProductsController::class, 'delete_product']
)->middleware('auth:api');
Route::post(
  'products/upload-image/{id}', // id of the product
  [ProductsController::class, 'upload_image']
)->middleware('auth:api');
Route::delete(
  'products/delete-image/{id}', // id of the image
  [ProductsController::class, 'delete_image']
)->middleware('auth:api');

/* ORDERS */
// TODO: CRUD of orders
Route::post(
  'orders/create-order',
  [OrdersController::class, 'create_order']
)->middleware('auth:api');
Route::get(
  'orders/get-order/{id}',
  [OrdersController::class, 'get_order']
)->middleware('auth:api');
Route::get(
  'orders/user-orders',
  [OrdersController::class, 'get_user_orders']
)->middleware('auth:api');
Route::patch(
  'orders/pay-order/{id}',
  [OrdersController::class, 'pay_order']
)->middleware('auth:api');
Route::patch(
  'orders/cancel-order/{id}',
  [OrdersController::class, 'cancel_order']
)->middleware('auth:api');
Route::get(
  'orders/seller-orders',
  [OrdersController::class, 'get_seller_orders']
)->middleware('auth:api');

/* ADDRESSES */
Route::post(
  'addresses/add-address',
  [AddressesController::class, 'create_address']
)->middleware('auth:api');
Route::put(
  'addresses/update-address/{id}',
  [AddressesController::class, 'update_address']
)->middleware('auth:api');

/* SOCIALS */
Route::post(
  'socials/add-social',
  [SocialsController::class, 'store']
)->middleware('auth:api');

/* REVIEWS */
Route::post(
  'reviews/add-review/{product_id}',
  [ReviewsController::class, 'create_review']
)->middleware('auth:api');
Route::get('reviews/get-review/{id}', [ReviewsController::class, 'get_review']);
Route::get('reviews/get-reviews/{product_id}', [ReviewsController::class, 'get_reviews']);
Route::put(
  'reviews/update-review/{id}',
  [ReviewsController::class, 'update_review']
)->middleware('auth:api');
Route::delete(
  'reviews/delete-review/{id}',
  [ReviewsController::class, 'delete_review']
)->middleware('auth:api');

/* DASHBOARD */
// TODO: An endpoint for get the information for the dashboard
