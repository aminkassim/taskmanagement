<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

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

// Auth
Route::post('/login', [AuthController::class, 'login']);

// users
Route::get('/users', [UserController::class, 'getListUsers']);
Route::post('/register', [UserController::class, 'addUser']);

// task 
Route::get('/task', [TaskController::class, 'getLisTask'])->middleware(['auth:sanctum', 'abilities:list-task']);
Route::post('/task', [TaskController::class, 'addTask'])->middleware(['auth:sanctum', 'abilities:add-task']);
Route::put('/task/{id}', [TaskController::class, 'updateTask'])->middleware(['auth:sanctum', 'abilities:update-task']);
Route::delete('/task/{id}', [TaskController::class, 'deleteTask'])->middleware(['auth:sanctum', 'abilities:delete-task']);



