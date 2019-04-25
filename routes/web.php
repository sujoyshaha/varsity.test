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
     $data['login'] = 'post-student-login';
        return view('auth.login-admin', $data);
});

Auth::routes();

Route::get('admin/login', 'UserAuthController@getLogin')->name('admin-login');
Route::get('/login', 'UserAuthController@getLogin')->name('login');
Route::post('admin/login', 'UserAuthController@postLogin')->name('post-login-admin');
Route::get('student/login', 'UserAuthController@getLogin')->name('student-login');
Route::post('student/login', 'UserAuthController@postLogin')->name('post-student-login');

Route::get('/dashboard', 'HomeController@index')->name('dashboard');





//ADMIN STARTS HERE


Route::group(['prefix' => 'admin'], function () {
Route::get('/', 'DashboardController@adminHome')->name('admin-dashboard');
Route::get('user-profile', 'AdminController@userProfile')->name('user-profile');

// Route::get('change-pass', 'DashboardController@getPass')->name('change-pass');
Route::post('change-pass', 'AdminController@postPass')->name('post-pass');
Route::post('user-edit', 'AdminController@updateuserProfile')->name('update-user-profile');


Route::get('academic-years', 'AdminController@getAcademicYear')->name('academic-years');
Route::get('add-academic-year', 'AdminController@addAcademicYear')->name('add-academic-year');
Route::post('add-academic-year', 'AdminController@postAcademicYear')->name('post-academic-year');
Route::get('edit-academic-year/{id}', 'AdminController@editAcademicYear')->name('edit-academic-year');
Route::post('update-academic-year/{id}', 'AdminController@updateAcademicYear')->name('update-academic-year');


// Admin User
Route::get('allusers', 'AdminController@allUsers')->name('allusers');
Route::get('add-user', 'AdminController@addUser')->name('add-user');
Route::post('add-user', 'AdminController@postUser')->name('post-user');
Route::get('edit-user/{id}', 'AdminController@editUser')->name('edit-user');
Route::post('update-user/{id}', 'AdminController@updateUser')->name('update-user');



// Admin Stud
Route::get('students', 'AdminController@getStudent')->name('students');
Route::get('add-student', 'AdminController@addStudent')->name('add-student');
Route::post('post-student', 'AdminController@postStudent')->name('post-student');
Route::get('edit-student/{id}', 'AdminController@editStudent')->name('edit-student');
Route::post('update-student/{id}', 'AdminController@updateStudent')->name('update-student');


// departments-area


Route::get('departments', 'AdminController@getDepartment')->name('departments');
Route::get('add-department', 'AdminController@addDepartment')->name('add-department');
Route::post('add-department', 'AdminController@postDepartment')->name('post-department');
Route::get('edit-department/{id}', 'AdminController@editDepartment')->name('edit-department');
Route::post('update-department/{id}', 'AdminController@updateDepartment')->name('update-department');



Route::get('articles', 'AdminController@getArticle')->name('articles');
Route::post('add-article', 'AdminController@postArticle')->name('post-article');
Route::get('edit-article/{id}', 'AdminController@editArticle')->name('edit-article');
Route::post('update-article/{id}', 'AdminController@updateArticle')->name('update-article');
Route::get('article/{id}', 'AdminController@getSingleArticle')->name('single-adminarticle');

Route::post('article/{id}', 'AdminController@postComment')->name('post-comment');



/*
* Contribution Approval routes
*/


Route::post('approve-articles', 'AdminController@postApproveArticles')->name('approve-articles');
Route::get('approve-article/{id}', 'AdminController@getApproveArticle')->name('approve-article');







/*
* Reports routes
*/
Route::match(['get', 'post'], 'article-report', 'AdminController@getArticleReport')->name('article-report');
// Route::match(['get', 'post'], 'con-percentage', 'AdminController@getContributionPercentage')->name('con-percentage');
// Route::get('contributor-number', 'AdminController@getContributorNumberPage')->name('contributor-number');
// Route::post('contributor-number', 'AdminController@getContributorNumber')->name('post-contributor-number');
// Route::match(['get', 'post'], 'contributor-without-comment', 'AdminController@getContributorWithoutComment')->name('contributor-without-comment');







	// Route::get('approve-contribution/{id}', 'AdminController@getApproveContribution')->name('approve-contribution');



// Route::get('academic-years', 'AdminController@getAcademicYear')->name('academic-years');
// // Route::get('add-academic-year', 'AdminController@addAcademicYear')->name('add-academic-year');
// Route::post('add-academic-year', 'AdminController@postAcademicYear')->name('post-academic-year');
// Route::get('edit-academic-year/{id}', 'AdminController@editAcademicYear')->name('edit-academic-year');
// Route::post('edit-academic-year/{id}', 'AdminController@updateAcademicYear')->name('update-academic-year');

});



Route::group(['prefix' => 'student'], function() {


	Route::get('student-profile', 'AdminController@userProfile')->name('student-profile');

// Route::get('change-pass', 'DashboardController@getPass')->name('change-pass');
Route::post('stdchange-pass', 'AdminController@postPass')->name('stdpost-pass');
Route::post('stduser-edit', 'AdminController@updateuserProfile')->name('update-stduser-profile');


Route::match(['get', 'post'], 'articles', 'StudentController@getArticle')->name('studentarticles');

Route::get('articles/{year}', 'StudentController@getArticlesByYear')->name('studentarticles-year');

Route::get('add-article', 'StudentController@addArticle')->name('add-studentarticle');
Route::post('add-article', 'StudentController@postArticle')->name('post-studentarticle');


Route::get('edit-article/{id}', 'StudentController@editArticle')->name('edit-studentarticle');
Route::post('edit-article/{id}', 'StudentController@updateArticle')->name('update-stdarticle');


Route::get('article/{id}', 'StudentController@getSingleArticle')->name('single-stdarticle');

Route::post('article/{id}', 'StudentController@postComment')->name('post-studentcomment');

// Route::post('article/{id}', 'StudentController@addComment')->name('add-stdcomment');

});



Route::group(['prefix' => 'faculty'], function() {


Route::match(['get', 'post'], 'articles', 'FacultyController@getArticle')->name('facultyarticles');


Route::get('article/{id}', 'FacultyController@getSingleArticle')->name('single-facultyarticle');

});


Route::group(['prefix' => 'coordinator'], function() {


Route::match(['get', 'post'], 'articles', 'CoordinatorController@getArticle')->name('coordinatorarticles');


Route::get('article/{id}', 'CoordinatorController@getSingleArticle')->name('single-coordinatorarticle');

});


Route::group(['prefix' => 'manager'], function() {


Route::match(['get', 'post'], 'articles', 'ManagerController@getArticle')->name('managerarticles');


Route::get('article/{id}', 'ManagerController@getSingleArticle')->name('single-managerarticle');

});
