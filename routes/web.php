<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
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
Route::post('/form-pendaftaran', [ClientController::class, 'saveRegistration'])->name('admin.form.registration');

Route::group(['prefix' => 'admin'], function(){
  Route::get('/sign-in', [AuthController::class, 'index'])->name('admin.signIn');
  Route::post('/sign-in', [AuthController::class, 'authenticate'])->name('admin.signIn.auth');

  Route::group([ 'middleware' => ['auth']], function(){
    Route::get('/home', [AdminController::class, 'index'])->name('admin.home');

    Route::group(['prefix' => 'data-event'], function(){
      Route::get('/', [EventController::class, 'index'])->name('admin.data.event');
      Route::get('/create', [EventController::class, 'createEvent'])->name('admin.data.createEvent');
      Route::post('/store', [EventController::class, 'storeEvent'])->name('admin.data.store');
      Route::get('/edit/{eventId}', [EventController::class, 'editEvent'])->name('admin.data.editEvent');
      Route::post('/edit/{eventId}', [EventController::class, 'updateEvent'])->name('admin.data.updateEvent');
    });

  });
  

  Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
});