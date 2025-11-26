<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

//VIEW: Feed
Route::get('/', [PostController::class, 'feed'])
    ->name('posts.feed')->middleware('auth');

//VIEW: Profile
Route::get('/profile/{user}', [PostController::class, 'profile'])
    ->name('post.profile')->middleware('auth');

//LOGIN
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');


//CREATE: Post
Route::get('/posts/create', [PostController::class, 'create'])
    ->name('posts.create')->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store')->middleware('auth');

//EDIT: Post
Route::get('/posts/edit/{post}', [PostController::class, 'edit'])
    ->name('posts.edit')->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store')->middleware('auth');
