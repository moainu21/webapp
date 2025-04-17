<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\ShowController;

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

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/create_form', [CreateController::class, 'create'])->name('create_form');
Route::post('/create_check', [CreateController::class, 'index'])->name('create_check');
Route::match(['get', 'post'], '/create-form', [CreateController::class, 'index'])->name('create.form');
Route::post('/store', [CreateController::class, 'store'])->name('store');
Route::match(['get', 'post'], '/show', [ShowController::class, 'showBySchoolYear'])->name('show');
Route::delete('/schedule/{schedule}', [CreateController::class, 'destroy'])->name('schedule.destroy');
Route::post('/show_schedule/{id}', [ShowController::class, 'show'])->name('show_schedule');
