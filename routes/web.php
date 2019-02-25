<?php

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

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');


Route::group(['prefix' => 'admin'], function () {
Route::get('/', 'DashboardController@adminHome')->name('admin-dashboard');
Route::get('user-profile', 'DashboardController@userProfile')->name('user-profile');

// Route::get('change-pass', 'DashboardController@getPass')->name('change-pass');
Route::post('change-pass', 'DashboardController@postPass')->name('post-pass');
Route::post('user-edit', 'DashboardController@updateuserProfile')->name('update-user');

});
