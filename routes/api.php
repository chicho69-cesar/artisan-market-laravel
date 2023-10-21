<?php

use App\Http\Controllers\SocialsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
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
// TODO: CRUD of products
// TODO: product categories
// TODO: product images

/* ORDERS */
// TODO: CRUD of orders
// TODO: secondary operations of orders

/* ADDRESSES */
// TODO: CRUD of addresses

/* SOCIALS */
Route::post(
  'socials/add-social',
  [SocialsController::class, 'store']
)->middleware('auth:api');

/* REVIEWS */
// TODO: CRUD of reviews

/* DASHBOARD */
// TODO: An endpoint for get the information for the dashboard
