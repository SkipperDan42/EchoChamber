<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

//----------------------------------POSTS----------------------------------//

//POSTS: Feed - Main Route
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
    ->middleware('auth');   // NOTE not access as used for Echoes too

//POSTS: Delete
Route::get('/posts/{post}/delete', [PostController::class, 'destroy'])
    ->name('posts.delete')
    ->middleware('auth', 'access');

//POSTS: Store
Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store')
    ->middleware('auth');

//POSTS: Clap
Route::post('/posts/{post}/clap', [PostController::class, 'clap'])
    ->name('posts.clap')
    ->middleware('auth');


//----------------------------------COMMENT----------------------------------//

//COMMENT: Create
Route::get('/comments/create', [CommentController::class, 'create'])
    ->name('comments.create')
    ->middleware('auth');

//COMMENT: Edit
Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])
    ->name('comments.edit')
    ->middleware('auth', 'access');

//COMMENT: Delete
Route::get('/comments/{comment}/delete', [CommentController::class, 'destroy'])
    ->name('comments.delete')
    ->middleware('auth', 'access');

//COMMENT: Store
Route::post('/comments', [CommentController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth');

//COMMENT: Clap
Route::post('/comments/{comment}/clap', [CommentController::class, 'clap'])
    ->name('comments.clap')
    ->middleware('auth');


//----------------------------------AUTH----------------------------------//

//USER: LOGIN
Route::get('/login', function () {
    return view('auth.login');})
    ->middleware('guest')
    ->name('login');


//----------------------------------ADMIN----------------------------------//

//ADMIN: Users
Route::get('/admin/index', [UserController::class, 'index'])
    ->name('admin.users')
    ->middleware('auth','admin');

//ADMIN: Stats
Route::get('/admin/stats', [UserController::class, 'all_user_stats'])
    ->name('admin.stats')
    ->middleware('auth','admin');


//----------------------------------USERS----------------------------------//

//USER: Posts
Route::get('/users/{user}/posts', [PostController::class, 'posts'])
    ->name('users.posts')
    ->middleware('auth');

//USER: Comments
Route::get('/users/{user}/comments', [CommentController::class, 'comments'])
    ->name('users.comments')
    ->middleware('auth');

//USERS: Details
Route::get('/users/{user}/details', [UserController::class, 'details'])
    ->name('users.details')
    ->middleware('auth');

//USER: Stats
Route::get('/users/{user}/stats', [UserController::class, 'user_stats'])
    ->name('users.stats')
    ->middleware('auth','access');

//USERS: Update
Route::get('/users/{user}/update', [UserController::class, 'update'])
    ->name('users.update')
    ->middleware('auth', 'access');

//USERS: Delete
Route::get('/users/{user}/delete', [UserController::class, 'destroy'])
    ->name('users.delete')
    ->middleware('auth', 'access');

//USERS: Store
Route::put('/users/{user}', [UserController::class, 'store'])
    ->name('users.store')
    ->middleware('auth', 'access');


