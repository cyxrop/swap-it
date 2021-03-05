<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::get('/user/logout', function () {
    Auth::logout();
    return redirect()->route('ad.list');
})->name('force-logout');


/**
 *  ADS ROUTES
 */

// DETAILS
Route::get('/ads/{id}', 'AdController@adDetails')
    ->name('ad.details')
    ->where('id', '[0-9]+');

// LIST
Route::get('/ads', 'AdController@showAds')
    ->name('ad.list');

// NEW AD - FORM
Route::get('/ads/create', function () {
    if (!Auth::check()) {
        return back()->withErrors('Please login to complete this action');
    }
    return view('ads.create');
})->name('ad.create.form');
// NEW AD - ACTION
Route::post('/ads/create', 'AdController@createNewInstance')
    ->name('ad.create');

// UPDATE AD - FORM
Route::get('/ads/update/{id}', 'AdController@update')
    ->where('id', '[0-9]+')
    ->name('ad.update')
    ->middleware('auth');
// UPDATE AD
Route::post('/ads/update/{id}', 'AdController@updateAction')
    ->where('id', '[0-9]+')
    ->name('ad.updateAction')
    ->middleware('auth');

/**
 *  PHOTO ROUTES
 */
Route::post('/photos/delete/{id}', 'PhotoController@deleteAction')
    ->where('id', '[0-9]+')
    ->name('photo.deleteAction')
    ->middleware('auth');;

/**
 *  COMMENT ROUTES
 */
/* New comment */
Route::post('/comments/create', 'CommentController@createAction')
    ->name('comment.createAction')
    ->middleware('auth');;
/* Delete comment */
Route::post('/comments/delete/{id}', 'CommentController@deleteAction')
    ->where('id', '[0-9]+')
    ->name('comment.deleteAction')
    ->middleware('auth');;

/**
 *  REGISTRATION ROUTES
 */
Route::get('/user/register', function () {
    return view('registration');
})->name('user-register');

Route::post('/user/register', function () {
    return view('registration');
})->name('user-register-result');

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/', function () {
//    return view('home');
//})->name('auth.signup.get');
