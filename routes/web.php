<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/users', [\App\http\Controllers\AdminController::class, 'getAllUsers']);
    Route::get('/users/{id}', [\App\http\Controllers\AdminController::class, 'getUser']);
    Route::post('/users', [\App\http\Controllers\AdminController::class, 'storeUser'])->middleware('transaction_middleware');
    Route::post('/users/{id}', [\App\http\Controllers\AdminController::class, 'updateUser'])->middleware('transaction_middleware');
    Route::delete('/users/{id}', [\App\http\Controllers\AdminController::class, 'deleteUser']);

    Route::get('/doctors', [\App\http\Controllers\AdminController::class, 'getAllDoctors']);
    Route::get('/doctors/{id}', [\App\http\Controllers\AdminController::class, 'getDoctor']);
    Route::post('/doctors', [\App\http\Controllers\AdminController::class, 'storeDoctor'])->middleware('transaction_middleware');
    Route::post('/doctors/{id}', [\App\http\Controllers\AdminController::class, 'updateDoctor'])->middleware('transaction_middleware');
    
    Route::get('/specializations', [\App\http\Controllers\AdminController::class, 'getAllSpecializations']);
    Route::get('/specializations/{id}', [\App\http\Controllers\AdminController::class, 'getSpecialization']);
    Route::post('/specializations', [\App\http\Controllers\AdminController::class, 'storeSpecialization'])->middleware('transaction_middleware');
    Route::post('/specializations/{id}', [\App\http\Controllers\AdminController::class, 'updateSpecialization'])->middleware('transaction_middleware');
    Route::delete('/specializations/{id}', [\App\http\Controllers\AdminController::class, 'deleteSpecialization']);

    Route::get('/appointments', [\App\http\Controllers\AdminController::class, 'getAllAppointments']);
    Route::get('/appointments/{userId}', [\App\http\Controllers\AdminController::class, 'getUserAppointments']);

    Route::get('/my-appointments', [\App\http\Controllers\UserController::class, 'getMyAppointments']);
    Route::post('/appointments', [\App\http\Controllers\UserController::class, 'storeAppointment'])->middleware('transaction_middleware');
    Route::put('/appointments/{id}', [\App\http\Controllers\UserController::class, 'cancelAppointment'])->middleware('transaction_middleware');

    Route::put('/appointments/{id}/status', [\App\http\Controllers\UserController::class, 'updateAppointmentStatus'])->middleware('transaction_middleware');

    Route::post('logout',[\App\http\Controllers\AuthController::class,'logout']);
    
});