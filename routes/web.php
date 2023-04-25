<?php

use App\Http\Controllers\StudentsController;
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

Route::get('/',[StudentsController::class,('index')]);
Route::post('/store', [StudentsController::class, 'store'])->name('store');
Route::get('/fetch-all', [StudentsController::class, 'fetchall'])->name('fetchall');
Route::get('/edit', [StudentsController::class, 'edit'])->name('edit');
Route::post('/update', [StudentsController::class, 'update'])->name('update');
Route::delete('/delete', [StudentsController::class, ('delete')])->name('delete');