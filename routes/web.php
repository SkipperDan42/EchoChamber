<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

//VIEW: PROJECTS
Route::get('/', [PostController::class, 'feed'])
    ->name('posts.feed');
