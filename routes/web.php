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


Route::get('academic-years', 'AdminController@getAcademicYear')->name('academic-years');
Route::post('add-academic-year', 'AdminController@postAcademicYear')->name('post-academic-year');
Route::get('edit-academic-year/{id}', 'AdminController@editAcademicYear')->name('edit-academic-year');
Route::post('update-academic-year/{id}', 'AdminController@updateAcademicYear')->name('update-academic-year');






// departments-area


Route::get('departments', 'AdminController@getDepartment')->name('departments');
Route::post('add-department', 'AdminController@postDepartment')->name('post-department');
Route::get('edit-department/{id}', 'AdminController@editDepartment')->name('edit-department');
Route::post('update-department/{id}', 'AdminController@updateDepartment')->name('update-department');



Route::get('contributions', 'AdminController@getContribution')->name('contributions');
Route::post('add-contribution', 'AdminController@postContribution')->name('post-contribution');
Route::get('edit-contribution/{id}', 'AdminController@editContribution')->name('edit-contribution');
Route::post('update-contribution/{id}', 'AdminController@updateContribution')->name('update-contribution');



// Route::get('academic-years', 'AdminController@getAcademicYear')->name('academic-years');
// // Route::get('add-academic-year', 'AdminController@addAcademicYear')->name('add-academic-year');
// Route::post('add-academic-year', 'AdminController@postAcademicYear')->name('post-academic-year');
// Route::get('edit-academic-year/{id}', 'AdminController@editAcademicYear')->name('edit-academic-year');
// Route::post('edit-academic-year/{id}', 'AdminController@updateAcademicYear')->name('update-academic-year');

});



Route::group(['prefix' => 'student'], function() {


Route::match(['get', 'post'], 'contributions', 'StudentController@getContribution')->name('studentcontributions');
// Route::get('contributions/{year}', 'StudentController@getContributionsByYear')->name('stdcontributions-year');
// Route::post('add-contribution', 'StudentController@postContribution')->name('post-stdcontribution');
// Route::get('edit-contribution/{id}', 'StudentController@editContribution')->name('edit-stdcontribution');
// Route::post('edit-contribution/{id}', 'StudentController@updateContribution')->name('update-stdcontribution');


Route::get('contribution/{id}', 'StudentController@getSingleContribution')->name('single-stdcontribution');

// Route::post('contribution/{id}', 'StudentController@addComment')->name('add-stdcomment');

});
