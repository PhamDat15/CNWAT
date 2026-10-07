<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes - Quản Lý Danh Bạ Contacts Laravel
|--------------------------------------------------------------------------
*/

Route::get('/', [ContactController::class, 'index'])->name('home');

// Export CSV danh bạ
Route::get('/contacts/export/csv', [ContactController::class, 'exportCsv'])->name('contacts.export');

// Resource Routes: index, create, store, show, edit, update, destroy
Route::resource('contacts', ContactController::class);
