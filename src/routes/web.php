<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExportController;

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

Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/thanks', [ContactController::class, 'store']);

Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth')->group(function() {
    Route::get('/admin', [AuthController::class, 'admin']);
});
Route::get('/search', [AuthController::class, 'search']);
Route::get('/reset', [AuthController::class, 'reset']);
Route::delete('/delete', [AuthController::class, 'destroy']);

Route::post('/export', [ExportController::class, 'export']);
