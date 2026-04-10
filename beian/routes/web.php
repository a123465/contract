<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DiscoveryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContentReviewController;
use App\Http\Controllers\IdentityVerificationController;
use Illuminate\Http\Request;
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

Route::get('/membership', function () {
    $user = Auth::user();
    $membership = $user ? ($user->membership ?? null) : null;
    return view('membership.index', compact('user', 'membership'));
})->name('membership');

Route::post('/membership/subscribe', function (Request $request) {
    return back()->with('success', '会员订阅功能暂未开放。');
})->middleware('auth')->name('membership.subscribe');

Route::view('/about', 'about')->name('about');
Route::view('/membership-service-agreement', 'legal.membership-service-agreement')->name('membership.service');
Route::view('/community-guidelines', 'legal.community-guidelines')->name('community.guidelines');

Route::view('/privacy-policy', 'legal.privacy-policy')->name('privacy.policy');
Route::view('/user-agreement', 'legal.user-agreement')->name('user.agreement');

// search route (open to all authenticated users)
Route::get('/search', [DiscoveryController::class, 'search'])->middleware('auth')->name('search');

// discovery route
Route::get('/discovery', [DiscoveryController::class, 'index'])->name('discovery');
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth')->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->middleware('auth')->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth')->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');
Route::delete('/posts/{post}/media/{media}', [PostController::class, 'destroyMedia'])->middleware('auth')->name('posts.media.destroy');
Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->middleware('auth')->name('posts.like');
Route::post('/posts/{post}/favorite', [PostController::class, 'toggleFavorite'])->middleware('auth')->name('posts.favorite');

// profile routes
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::post('/profile/edit', [ProfileController::class, 'updateProfile'])->middleware('auth')->name('profile.update');
Route::get('/profile/security', [ProfileController::class, 'security'])->middleware('auth')->name('profile.security');
Route::post('/profile/security/password', [ProfileController::class, 'updatePassword'])->middleware('auth')->name('profile.password');
Route::post('/profile/security/phone', [ProfileController::class, 'bindPhone'])->middleware('auth')->name('profile.phone');


// Content review routes
Route::get('/admin/reviews', [ContentReviewController::class, 'index'])->middleware('auth')->name('reviews.index');
Route::get('/admin/reviews/history', [ContentReviewController::class, 'history'])->middleware('auth')->name('reviews.history');
Route::post('/reviews', [ContentReviewController::class, 'store'])->middleware('auth')->name('reviews.store');
Route::post('/reviews/{review}/review', [ContentReviewController::class, 'review'])->middleware('auth')->name('reviews.review');

// Identity verification (internal)
Route::get('/identity/status', [IdentityVerificationController::class, 'status'])->middleware('auth')->name('identity.status');
Route::post('/identity/submit', [IdentityVerificationController::class, 'submit'])->middleware('auth')->name('identity.submit');

// Moderator routes for identity review
Route::get('/identity/pending', [IdentityVerificationController::class, 'pending'])->middleware('auth')->name('identity.pending');
Route::post('/identity/{verification}/review', [IdentityVerificationController::class, 'review'])->middleware('auth')->name('identity.review');

