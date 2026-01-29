<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

// discovery route
use App\Http\Controllers\DiscoveryController;
Route::get('/discovery', [DiscoveryController::class, 'index'])->name('discovery');

// post routes
use App\Http\Controllers\PostController;
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth')->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->middleware('auth')->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth')->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');
Route::delete('/posts/{post}/media/{media}', [PostController::class, 'destroyMedia'])->middleware('auth')->name('posts.media.destroy');
Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->middleware('auth')->name('posts.comments.store');
Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->middleware('auth')->name('posts.like');
Route::post('/posts/{post}/favorite', [PostController::class, 'toggleFavorite'])->middleware('auth')->name('posts.favorite');

// profile routes
use App\Http\Controllers\ProfileController;

Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::post('/profile/edit', [ProfileController::class, 'updateProfile'])->middleware('auth')->name('profile.update');
Route::get('/profile/security', [ProfileController::class, 'security'])->middleware('auth')->name('profile.security');
Route::post('/profile/security/password', [ProfileController::class, 'updatePassword'])->middleware('auth')->name('profile.password');
Route::post('/profile/security/phone', [ProfileController::class, 'bindPhone'])->middleware('auth')->name('profile.phone');
