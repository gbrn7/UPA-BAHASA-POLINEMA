<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
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


Route::get('/', [ClientController::class, 'index'])->name('client');
Route::get('/form-pendaftaran', [ClientController::class, 'formView'])->name('client.form');

Route::group(['prefix' => 'admin'], function(){
  Route::get('/sign-in', [AuthController::class, 'index'])->name('admin.signIn');
  Route::post('/sign-in', [AuthController::class, 'authenticate'])->name('admin.signIn.auth');

  Route::group([ 'middleware' => ['auth']], function(){
    Route::get('/', [AdminController::class, 'index'])->name('admin.home');
  });
  

  Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
});