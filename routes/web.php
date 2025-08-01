<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;

// Public contact form

Route::view('/', 'contact')->name('contact');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/admin/messages/read/{id}', [ContactController::class, 'markAsRead'])->name('admin.messages.read');


// Admin messages panel
Route::get('/admin/messages', [ContactController::class, 'showMessages'])->name('admin.messages');

