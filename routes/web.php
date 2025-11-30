<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

//----------------------------------POSTS----------------------------------//

//POSTS: Feed
Route::get('/', [PostController::class, 'posts'])
    ->name('posts.index')
    ->middleware('auth');

//POSTS: Create
Route::get('/posts/create', [PostController::class, 'create'])
    ->name('posts.create')
    ->middleware('auth');

//POSTS: Show
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show')
    ->middleware('auth');

//POSTS: Edit
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
    ->name('posts.edit')
    ->middleware('auth');

//POSTS: Delete
Route::get('/posts/{post}/delete', [PostController::class, 'destroy'])
    ->name('posts.delete')
    ->middleware('auth');

//POSTS: Store
Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store')
    ->middleware('auth');

//POSTS: Clap
Route::post('/posts/{post}/clap', [PostController::class, 'clap'])
    ->name('posts.clap')
    ->middleware('auth');


//----------------------------------USERS----------------------------------//

//USER: LOGIN
Route::get('/login', function () {
    return view('auth.login');})
    ->middleware('guest')
    ->name('login');

//USER: Posts
Route::get('/user/{user}/posts', [PostController::class, 'posts'])
    ->name('user.posts')
    ->middleware('auth');

//USERS: Details
Route::get('/user/{user}/details', [UserController::class, 'details'])
    ->name('user.details')
    ->middleware('auth');

//USERS: Update
Route::get('/user/{user}/update', [UserController::class, 'update'])
    ->name('user.update')
    ->middleware('auth');

//USERS: Store
Route::put('/user/{user}', [UserController::class, 'store'])
    ->name('users.store');
