<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');
Route::view('terms', 'terms')->name('terms');
Route::view('privacy', 'privacy')->name('privacy');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

Route::view('posts', 'posts.index')->middleware(['auth'])->name('posts');
Route::view('post/create', 'posts.create')->middleware(['auth'])->name('posts.create');
Route::view('post/{post}/show', 'posts.show')->middleware(['auth'])->name('posts.show');
Route::view('post/{post}/edit/{platform}', 'posts.edit')->middleware(['auth'])->name('posts.edit');

Route::view('access/api', 'api.access')->middleware(['auth', 'password.confirm'])->name('api-access');

require __DIR__ . '/auth.php';
