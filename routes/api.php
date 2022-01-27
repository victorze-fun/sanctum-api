<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // rutas auth
    Route::get('/user-profile', [UserController::class, 'userProfile']);
    Route::get('/logout', [UserController::class, 'logout']);

    // rutas blog
    Route::post('/create-blog', [BlogController::class, 'create']);
    Route::get('/list-blog', [BlogController::class, 'list']);
    Route::get('/show-blog/{id}', [BlogController::class, 'show']);
    Route::put('/update-blog/{id}', [BlogController::class, 'update']);
    Route::delete('/delete-blog/{id}', [BlogController::class, 'delete']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
