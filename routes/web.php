<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
Route::get('/', [FormController::class, 'index'])->name('form.index');
Route::post('/form/post', [FormController::class, 'store'])->name('form.store');
Route::get('/form/review/{customer}', [FormController::class, 'review'])->name('form.review');
Route::post('/form/update/{customer}', [FormController::class, 'update'])->name('form.update');
