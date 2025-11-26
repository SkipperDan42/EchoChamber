<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

//VIEW: Feed
Route::get('/', [PostController::class, 'posts'])
    ->name('posts.index')
    ->middleware('auth');

//VIEW: Profile
Route::get('/profile/{user}', [PostController::class, 'posts'])
    ->name('post.index')
    ->middleware('auth');

//LOGIN
Route::get('/login', function () {
    return view('auth.login');})
    ->middleware('guest')
    ->name('login');


//SHOW: Post
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show')
    ->middleware('auth');

//CREATE: Post
Route::get('/posts/create', [PostController::class, 'create'])
    ->name('posts.create')
    ->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store')
    ->middleware('auth');

//EDIT: Post
Route::get('/posts/edit/{post}', [PostController::class, 'edit'])
    ->name('posts.edit')
    ->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store')
    ->middleware('auth');

//CLAP: Post
Route::post('/posts/{post}/clap', [PostController::class, 'clap'])
    ->name('posts.clap')
    ->middleware('auth');
