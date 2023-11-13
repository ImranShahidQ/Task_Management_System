<?php

use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes();

// Show All Tasks Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Create Tasks Route
Route::get('/create', [App\Http\Controllers\HomeController::class, 'create'])->name('create');
// Store Tasks Route
Route::post('/store', [App\Http\Controllers\HomeController::class, 'insert'])->name('store');
// Edit Tasks Route
Route::get('/{task}/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit');
// Update Tasks Route
Route::put('/{task}', [App\Http\Controllers\HomeController::class, 'update'])->name('update');
// Delete Tasks Route
Route::delete('/{task}', [App\Http\Controllers\HomeController::class, 'destroy'])->name('destroy');

Route::middleware(['auth','isAdmin'])->group(function(){
    // Route For Dashboard Display
    Route::get('/dashboard','Admin\AdminController@index');
    // Route For Tasks Display
    Route::get('tasks','Admin\AdminController@taskindex');
    // Route For Users Display
    Route::get('users','Admin\AdminController@userindex');
    // Route For Permanent Delete
    Route::delete('admin/tasks/{id}/permanent-delete', [App\Http\Controllers\Admin\AdminController::class, 'permanentDelete'])->name('admin.tasks.permanent-delete');
    // Route For Search Tasks
    Route::get('admin/tasks/search', [App\Http\Controllers\Admin\AdminController::class, 'search'])->name('admin.tasks.search');
});
