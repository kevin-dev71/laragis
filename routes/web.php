<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */
// all listing
Route::get('/', [ListingController::class, 'index']);

// show create form
Route::get('/listings/create', [
  ListingController::class,
  'create',
])->middleware('auth');

// Store listing data
Route::post('/listings', [ListingController::class, 'store'])->middleware(
  'auth'
);

// Manage Listings
Route::get('/listings/manage', [
  ListingController::class,
  'manage',
])->middleware('auth');

// show edit form
Route::get('/listings/{listing}/edit', [
  ListingController::class,
  'edit',
])->middleware('auth');

// Update Listing
Route::put('/listings/{listing}', [
  ListingController::class,
  'update',
])->middleware('auth');

// Delete Listing
Route::delete('/listings/{listing}', [
  ListingController::class,
  'destroy',
])->middleware('auth');

// single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// show register form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// create new user
Route::post('/users', [UserController::class, 'store']);

// Logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// show Login form
Route::get('/login', [UserController::class, 'login'])
  ->name('login')
  ->middleware('guest');

// show Login form
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// Authenticate user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
