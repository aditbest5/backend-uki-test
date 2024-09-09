<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    "prefix"=>"auth",   
], function(){
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);
    Route::post("logout", [AuthController::class, "logout"])->middleware('auth');
    Route::post("role", [AuthController::class, "insert_role"]);
});

Route::group([
    "prefix"=> "user",
    'middleware' => 'auth.jwt',
], function(){
    Route::get("list", [AdminController::class, "index"]);
    Route::get("list/{id}", [AdminController::class, "show"]);
    Route::post("create", [AdminController::class, "create_user"])->middleware('admin');
    Route::patch("update/{id}", [AdminController::class, "update_user"])->middleware('admin');
    Route::delete("delete/{id}", [AdminController::class, "delete_user"])->middleware('admin');
});
Route::get("get-profile", [UserController::class, "show"])->middleware('auth.jwt');
Route::patch("update-profile", [UserController::class, "update"])->middleware('auth.jwt');
Route::group([
    "prefix"=> "currency",
    'middleware' => 'auth.jwt'
], function(){
    Route::post("fetch", [CurrencyController::class, "fetchCurrency"])->middleware('admin');
    Route::get("get-currency", [CurrencyController::class, "getCurrency"]);
});