<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::get('/blog/{blog}/pdf', [PdfController::class, 'createPdf'])->name('blog.pdf');
