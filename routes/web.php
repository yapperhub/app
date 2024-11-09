<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');
Route::view('terms', 'terms')->name('terms');
Route::view('privacy', 'privacy')->name('privacy');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
Route::view('posts', 'posts.index')->middleware(['auth'])->name('posts');
Route::view('post/create', 'posts.create')->middleware(['auth'])->name('posts.create');

require __DIR__ . '/auth.php';
