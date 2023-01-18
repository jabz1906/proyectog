<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::controller(PageController::class)->group(function () {
    Route::get('form', 'form')->name('page.form')->middleware(['auth:sanctum', 'verified']);
    Route::get('question/{id}', 'question')->name('page.question')->middleware(['auth:sanctum', 'verified']);    
    Route::get('option/{id}', 'option')->name('page.option')->middleware(['auth:sanctum', 'verified']);
    Route::get('event', 'event')->name('page.event')->middleware(['auth:sanctum', 'verified']);
    Route::get('user', 'user')->name('page.user')->middleware(['auth:sanctum', 'verified']);
    Route::get('special/{id}', 'special')->name('page.special')->middleware(['auth:sanctum', 'verified']);
    Route::get('calendar', 'calendar')->name('page.calendar')->middleware(['auth:sanctum', 'verified']);
});