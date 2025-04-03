<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreateController;

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
});

Route::get('/create_form_basic', [CreateController::class, 'create'])->name('create_form_basic');
Route::post('/create_check', [CreateController::class, 'index'])->name('create_check');
