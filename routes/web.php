<?php

use App\Models\Platform;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');
Route::view('terms', 'terms')->name('terms');
Route::view('privacy', 'privacy')->name('privacy');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
Route::view('access/api', 'api.access')->middleware(['auth', 'password.confirm'])->name('api-access');

Route::view('integrations', 'integrations.index')->middleware(['auth'])->name('integrations');
Route::get('integration/{platform}/show', function (Platform $platform) {
    return view('integrations.show', ['platform' => $platform]);
})->middleware(['auth'])->name('integrations.show');

require __DIR__ . '/posts.php';
require __DIR__ . '/auth.php';
