<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

//VIEW: Feed
Route::get('/', [PostController::class, 'feed'])
    ->name('posts.feed')->middleware('auth');

//VIEW: Profile
Route::get('/profile/{user}', [PostController::class, 'profile'])
    ->name('post.profile');

//LOGIN
Route:: middleware(['auth' ])->group(function(){
    return view('posts.feed');
    })->name('login');
