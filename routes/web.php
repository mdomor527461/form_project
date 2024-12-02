<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
Route::get('/', [FormController::class, 'index'])->name('form.index');
Route::post('/form/post', [FormController::class, 'store'])->name('form.store');

