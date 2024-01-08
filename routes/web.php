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
Route::get('/reports', [\App\http\Controllers\ReportController::class,'index'])->name('reports.index');
Route::get('/config/update', [\App\http\Controllers\Controller::class,'updateForm'])->name('config.update');
Route::post('/config/save', [\App\http\Controllers\Controller::class,'save'])->name('config.save');