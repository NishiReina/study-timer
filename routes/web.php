<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DiaryController;

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

Route::get('/', [DiaryController::class, 'index'])->name('index');
Route::post('/', [DiaryController::class, 'postSes'])->name('postSes');
Route::get('/add', [DiaryController::class, 'add'])->name('add');
Route::post('/create', [DiaryController::class, 'create'])->name('create');
Route::get('/show', [DiaryController::class, 'show'])->name('show');
Route::get('/list', [DiaryController::class, 'list'])->name('list');
Route::get('/detail', [DiaryController::class, 'detail'])->name('detail');
Route::get('/edit', [DiaryController::class, 'edit'])->name('edit');
Route::post('/update', [DiaryController::class, 'update'])->name('update');
Route::post('/delete', [DiaryController::class, 'delete'])->name('delete');
// Route::get('/verror', [TestController::class, 'verror']);