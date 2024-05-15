<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CourseEventScheduleController;
use App\Http\Controllers\CourseEventsController;
use App\Http\Controllers\CourseRegisterController;
use App\Http\Controllers\CourseTypeController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ImageController;
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
Route::get('/sop', [ClientController::class, 'sop'])->name('client.sop');
Route::get('/structure-organization', [ClientController::class, 'structureOrganization'])->name('client.structureOrganization');
Route::get('/form-register', [ClientController::class, 'formView'])->name('client.form');
Route::get('/get-program-study', [ClientController::class, 'getProgramStudy'])->name('client.getProgramStudy');
Route::post('/form-register', [ClientController::class, 'saveRegistration'])->name('client.form.registration');

Route::group(['prefix' => 'admin'], function () {
  Route::get('/sign-in', [AuthController::class, 'index'])->name('admin.signIn');
  Route::post('/sign-in', [AuthController::class, 'authenticate'])->name('admin.signIn.auth');

  Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [AdminController::class, 'index'])->name('admin.home');

    Route::get('/edit-profile', [AdminController::class, 'editProfile'])->name('admin.editProfile');
    Route::put('/edit-profile', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');

    Route::group(['prefix' => 'data-events'], function () {
      Route::group(['prefix' => 'detail-registers'], function () {
        Route::get('/{eventId}', [EventController::class, 'detailRegisters'])->name('admin.data.detail.registers');
        Route::get('/{eventId}/create-register', [EventController::class, 'createRegister'])->name('admin.data.detail.registers.createRegister');
        Route::get('/{eventId}/export-excel', [EventController::class, 'exportToeicData'])->name('admin.data.detail.registers.exportToeicData');
        Route::post('/{eventId}/create-register', [EventController::class, 'saveRegister'])->name('admin.data.detail.registers.saveRegister');
        Route::get('/{eventId}/edit-register/{registerId}', [EventController::class, 'editRegister'])->name('admin.data.registers.editRegister');
        Route::put('/{eventId}/edit-register/{registerId}', [EventController::class, 'updateRegister'])->name('admin.data.updateRegister');
        Route::delete('/delete-register', [EventController::class, 'deleteRegister'])->name('admin.data.deleteRegister');
        Route::get('/{eventId}/data-register/{registerId}', [EventController::class, 'detailRegister'])->name('admin.data.registers.dataRegister');
        Route::get('/download-ktp/{filename}', [EventController::class, 'downloadKTP'])->name('admin.data.registers.downloadKTP');
        Route::get('/download-ktm/{filename}', [EventController::class, 'downloadKTM'])->name('admin.data.registers.downloadKTM');
        Route::get('/download-surat-pernyataan-nominasi-iisma/{filename}/{viewPdf}', [EventController::class, 'downloadSuratPernyataan'])->name('admin.data.registers.downloadSuratPernyataan');
        Route::get('/download-pasFoto/{filename}', [EventController::class, 'downloadPasFoto'])->name('admin.data.registers.downloadPasFoto');
      });

      Route::get('/', [EventController::class, 'index'])->name('admin.data.event');
      Route::get('/create', [EventController::class, 'createEvent'])->name('admin.data.createEvent');
      Route::post('/store', [EventController::class, 'storeEvent'])->name('admin.data.storeEvent');
      Route::get('/edit/{eventId}', [EventController::class, 'editEvent'])->name('admin.data.editEvent');
      Route::put('/edit/{eventId}', [EventController::class, 'updateEvent'])->name('admin.data.updateEvent');
      Route::delete('/delete', [EventController::class, 'deleteEvent'])->name('admin.data.deleteEvent');
    });

    Route::group(['prefix' => 'data-departements'], function () {
      Route::get('/', [DepartementController::class, 'index'])->name('admin.data.departements');
      Route::post('/create-departement', [DepartementController::class, 'storeDepartement'])->name('admin.data.departements.storeDepartement');
      Route::put('/update-departement', [DepartementController::class, 'updateDepartement'])->name('admin.data.departements.updateDepartement');
      Route::delete('/delete-departement', [DepartementController::class, 'deleteDepartement'])->name('admin.data.departements.deleteDepartement');

      Route::group(['prefix' => '{departementId}'], function () {
        Route::get('/data-program-study', [DepartementController::class, 'getProdyByDepartement'])->name('admin.data.programStudy');
        Route::post('/create-program-study', [DepartementController::class, 'storeProgramStudy'])->name('admin.data.departements.storeProgramStudy');
        Route::put('/update-program-study', [DepartementController::class, 'updateProgramStudy'])->name('admin.data.departements.updateProgramStudy');
        Route::delete('/delete-program-study', [DepartementController::class, 'deleteProgramStudy'])->name('admin.data.departements.deleteProgramStudy');
      });
    });

    Route::group(['prefix' => 'data-images'], function () {
      Route::get('/', [ImageController::class, 'index'])->name('admin.data.image');

      Route::post('/', [ImageController::class, 'storeImage'])->name('admin.data.image.create');
      Route::put('/', [ImageController::class, 'updateImage'])->name('admin.data.image.edit');
      Route::delete('/', [ImageController::class, 'deleteImage'])->name('admin.data.image.destroy');

      Route::get('/gallery-management', [ImageController::class, 'galleryManagement'])->name('admin.data.image.galleryManagement');

      Route::get('/structure-organization-management', [ImageController::class, 'StructureOrganizationManagement'])->name('admin.data.image.StructureOrganizationManagement');

      Route::get('/sop-toeic-management', [ImageController::class, 'sopToiecManagement'])->name('admin.data.image.sopToeicManagement');

      Route::get('/consult-management', [ImageController::class, 'sopConsultManagement'])->name('admin.data.image.sopConsultManagement');
    });

    Route::group(['prefix' => 'data-course-type'], function () {
      Route::get('/', [CourseTypeController::class, 'index'])->name('admin.data.courseType');
      Route::post('/create-courseType', [CourseTypeController::class, 'storeCourseType'])->name('admin.data.courseType.storeCourseType');
      Route::put('/update-courseType', [CourseTypeController::class, 'updateCourseType'])->name('admin.data.courseType.updateCourseType');
      Route::delete('/delete-courseType', [CourseTypeController::class, 'deleteCourseType'])->name('admin.data.courseType.deleteDepartement');
    });

    Route::group(['prefix' => 'data-course'], function () {
      Route::get('/', [CourseEventsController::class, 'index'])->name('admin.data-course.index');
      Route::post('/store', [CourseEventsController::class, 'store'])->name('admin.data-course.store');
      Route::put('/update', [CourseEventsController::class, 'update'])->name('admin.data-course.update');
      Route::delete('/delete', [CourseEventsController::class, 'delete'])->name('admin.data-course.delete');

      Route::get('/{courseEventId}/data-schedule', [CourseEventScheduleController::class, 'index'])->name('admin.data-course.data-schedule.index');
      Route::get('/{courseEventId}/data-schedule/create', [CourseEventScheduleController::class, 'create'])->name('admin.data-course.data-schedule.create');
      Route::post('/{courseEventId}/data-schedule/store', [CourseEventScheduleController::class, 'store'])->name('admin.data-course.data-schedule.store');
      Route::get('/{courseEventId}/data-schedule/edit/{courseEventScheduleId}', [CourseEventScheduleController::class, 'edit'])->name('admin.data-course.data-schedule.edit');
      Route::put('/{courseEventId}/data-schedule/edit/{courseEventScheduleId}', [CourseEventScheduleController::class, 'update'])->name('admin.data-course.data-schedule.update');
      Route::delete('/data-schedule/delete', [CourseEventScheduleController::class, 'delete'])->name('admin.data-course.data-schedule.delete');


      Route::get('/{courseEventId}/data-schedule/{courseEventScheduleId}/data-registers', [CourseRegisterController::class, 'index'])->name('admin.data-course.data-schedule.data-registers.index');
      Route::get('/{courseEventId}/data-schedule/{courseEventScheduleId}/data-registers/create', [CourseRegisterController::class, 'create'])->name('admin.data-course.data-schedule.data-registers.create');
      Route::post('/{courseEventId}/data-schedule/{courseEventScheduleId}/data-registers/store', [CourseRegisterController::class, 'store'])->name('admin.data-course.data-schedule.data-registers.store');
      Route::get('/{courseEventId}/data-schedule/{courseEventScheduleId}/data-registers/edit/{courseEventRegistrationsId}', [CourseRegisterController::class, 'edit'])->name('admin.data-course.data-schedule.data-registers.edit');
      Route::get('/{courseEventId}/data-schedule/{courseEventScheduleId}/data-registers/show/{courseEventRegistrationsId}', [CourseRegisterController::class, 'show'])->name('admin.data-course.data-schedule.data-registers.show');
      Route::put('/{courseEventId}/data-schedule/{courseEventScheduleId}/data-registers/update/{courseEventRegistrationsId}', [CourseRegisterController::class, 'update'])->name('admin.data-course.data-schedule.data-registers.update');
      Route::delete('/data-schedule/data-registers/delete', [CourseRegisterController::class, 'delete'])->name('admin.data-course.data-schedule.data-registers.delete');
    });
  });


  Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
});
