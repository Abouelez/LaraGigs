<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use App\Models\Job;
use Illuminate\Http\Request;
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

Route::get('/', [JobController::class, 'index']);
Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth');
Route::post('/jobs', [JobController::class, 'store']);
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->middleware('auth');
Route::put('/jobs/{job}/edit', [JobController::class, 'update'])->middleware('auth');
Route::delete('/jobs/{job}/delete', [JobController::class, 'destroy'])->middleware('auth');
Route::get('jobs/manage', [JobController::class, 'manage'])->middleware('auth');
Route::get('/jobs/{job}', [JobController::class, 'show']);

Route::get('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/users', [UserController::class, 'store']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
