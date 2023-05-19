<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ApplicationController;

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
    return view('welcome');
});


Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
Route::get('/applications/historics/{symbol}', [ApplicationController::class, 'historics'])->name('applications.historics');

