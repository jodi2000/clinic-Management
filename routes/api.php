<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login',[\App\http\Controllers\AuthController::class,'login']);
Route::post('register', [\App\http\Controllers\AuthController::class, 'register']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    
    Route::resource('files', 'FileController');
    Route::resource('users', 'UserController');
    Route::apiResource('groups','\App\http\Controllers\GroupController');
    Route::get('group/{groupId}/users', [\App\http\Controllers\GroupController::class, 'getGroupUsers']);
    Route::get('groups/{groupId}/files', [\App\http\Controllers\GroupController::class, 'getGroupFiles']);
    Route::post('groups/{groupId}/files', [\App\http\Controllers\FileController::class, 'sendFileToGroup']);
    Route::get('files/{group}/group',[\App\http\Controllers\FileController::class, 'indexByGroup']);

    Route::post('files/{file}/reserved', [\App\http\Controllers\FileController::class, 'reserveFile']);
    Route::post('files/{file}/free', [\App\http\Controllers\FileController::class, 'returnFile']);

    Route::get('user/groups', [\App\http\Controllers\UserController::class, 'indexByGroup']);
    Route::post('logout',[\App\http\Controllers\AuthController::class,'logout']);


});





