<?php

use Illuminate\Support\Facades\Route;

Route::view('posts', 'posts.index')->middleware(['auth'])->name('posts');
Route::view('post/create', 'posts.create')->middleware(['auth'])->name('posts.create');
Route::view('post/{post}/show', 'posts.show')->middleware(['auth'])->name('posts.show');
Route::view('post/{post}/edit/{platform}', 'posts.edit')->middleware(['auth'])->name('posts.edit');
