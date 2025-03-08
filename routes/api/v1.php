<?php

use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Route;

Route::get('posts', [PostController::class, 'index'])->middleware('auth:sanctum')->name('api.posts');
Route::get('posts/{post}', [PostController::class, 'show'])->middleware('auth:sanctum')->name('api.posts.show');
Route::post('posts', [PostController::class, 'store'])->middleware('auth:sanctum')->name('api.posts.store');
Route::put('posts/{post}', [PostController::class, 'update'])->middleware('auth:sanctum')->name('api.posts.update');
/*Route::post('posts/{id}/publish', [PostController::class, 'publish'])->middleware('auth:sanctum')->name('api.posts.publish');
Route::post('posts/{id}/unpublish', [PostController::class, 'unpublish'])->middleware('auth:sanctum')->name('api.posts.unpublish');*/
