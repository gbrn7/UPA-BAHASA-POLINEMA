<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DepartementController;
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
Route::get('/form-register', [ClientController::class, 'formView'])->name('client.form');
Route::get('/get-program-study', [ClientController::class, 'getProgramStudy'])->name('client.getProgramStudy');
Route::post('/form-register', [ClientController::class, 'saveRegistration'])->name('client.form.registration');

Route::group(['prefix' => 'admin'], function(){
  Route::get('/sign-in', [AuthController::class, 'index'])->name('admin.signIn');
  Route::post('/sign-in', [AuthController::class, 'authenticate'])->name('admin.signIn.auth');

  Route::group([ 'middleware' => ['auth']], function(){
    Route::get('/home', [AdminController::class, 'index'])->name('admin.home');

    Route::group(['prefix' => 'data-events'], function(){
      Route::group(['prefix' => 'detail-registers'], function() {
        Route::get('/{eventId}', [EventController::class, 'detailRegisters'])->name('admin.data.detail.registers');
        Route::get('/{eventId}/create-register', [EventController::class, 'createRegister'])->name('admin.data.detail.registers.createRegister');
        Route::post('/{eventId}/create-register', [EventController::class, 'saveRegister'])->name('admin.data.detail.registers.saveRegister');
        Route::get('/{eventId}/edit-register/{registerId}', [EventController::class, 'editRegister'])->name('admin.data.registers.editRegister');
        Route::put('/{eventId}/edit-register/{registerId}', [EventController::class, 'updateRegister'])->name('admin.data.updateRegister');
        Route::delete('/delete-register', [EventController::class, 'deleteRegister'])->name('admin.data.deleteRegister');
        Route::get('/{eventId}/data-register/{registerId}', [EventController::class, 'detailRegister'])->name('admin.data.registers.dataRegister');
        Route::get('/donwload-ktp/{filename}', [EventController::class, 'downloadKTP'])->name('admin.data.registers.downloadKTP');
        Route::get('/donwload-ktm/{filename}', [EventController::class, 'downloadKTM'])->name('admin.data.registers.downloadKTM');
        Route::get('/donwload-surat-pernyataan-nominasi-iisma/{filename}/{viewPdf}', [EventController::class, 'downloadSuratPernyataan'])->name('admin.data.registers.downloadSuratPernyataan');
        Route::get('/donwload-pasFoto/{filename}', [EventController::class, 'downloadPasFoto'])->name('admin.data.registers.downloadPasFoto');
      });

      Route::get('/', [EventController::class, 'index'])->name('admin.data.event');
      Route::get('/create', [EventController::class, 'createEvent'])->name('admin.data.createEvent');
      Route::post('/store', [EventController::class, 'storeEvent'])->name('admin.data.storeEvent');
      Route::get('/edit/{eventId}', [EventController::class, 'editEvent'])->name('admin.data.editEvent');
      Route::put('/edit/{eventId}', [EventController::class, 'updateEvent'])->name('admin.data.updateEvent');
      Route::delete('/delete', [EventController::class, 'deleteEvent'])->name('admin.data.deleteEvent');
    });

    Route::group(['prefix' => 'data-departements'], function(){
      Route::get('/', [DepartementController::class, 'index'])->name('admin.data.departements');
      Route::post('/create-departement', [DepartementController::class, 'storeDepartement'])->name('admin.data.departements.storeDepartement');
      Route::put('/update-departement', [DepartementController::class, 'updateDepartement'])->name('admin.data.departements.updateDepartement');
      Route::delete('/delete-departement', [DepartementController::class, 'deleteDepartement'])->name('admin.data.departements.deleteDepartement');

      Route::group(['prefix' => '{departementId}'], function(){
        Route::get('/data-program-study', [DepartementController::class, 'getProdyByDepartement'])->name('admin.data.programStudy');
        Route::post('/create-program-study', [DepartementController::class, 'storeProgramStudy'])->name('admin.data.departements.storeProgramStudy');
        Route::put('/update-program-study', [DepartementController::class, 'updateProgramStudy'])->name('admin.data.departements.updateProgramStudy');
        Route::delete('/delete-program-study', [DepartementController::class, 'deleteProgramStudy'])->name('admin.data.departements.deleteProgramStudy');
      });
    });


  });
  

  Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
});