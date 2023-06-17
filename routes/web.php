<?php

use App\Http\Controllers\AuthController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['guest'])->group(function () {
    Route::get('register',[AuthController::class,'register'])->name('register');
    Route::post('register',[AuthController::class,'userRegister'])->name('register');
    Route::get('login',[AuthController::class,'login'])->name('login');
    Route::post('login',[AuthController::class,'userLogin'])->name('login');

});


Route::middleware(['auth'])->group(function () {
    Route::get('/home',[AuthController::class,'index'])->name('home');
    Route::get('logout',[AuthController::class,'logout'])->name('logout');
});


