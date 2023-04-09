<?php

use App\Http\Controllers\AdminDashboardController;
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




Route::middleware('auth')
    ->get('admin/api-performance', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');
Route::middleware('auth')
    ->get('admin/generate-api-token', [AdminDashboardController::class, 'token'])
    ->name('admin.api-token');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return to_route('admin.dashboard');
    })->name('dashboard');
    Route::get('/', function () {
        return to_route('admin.dashboard');
    })->name('home');
});
