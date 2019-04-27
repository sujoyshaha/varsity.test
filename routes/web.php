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
Route::get('dashboard', 'AdminController@index')->name('dashboard');
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
// Route::get('edit-user/{id}', 'AdminController@editUser')->name('edit-user');
// Route::post('update-user/{id}', 'AdminController@updateUser')->name('update-user');



// Post Admin

Route::get('alladmin', 'AdminController@allAdmin')->name('alladmin');

Route::post('post-admin', 'AdminController@postAdmin')->name('post-admin');

Route::get('edit-admin/{id}', 'AdminController@editAdmin')->name('edit-admin');

Route::post('update-admin/{id}', 'AdminController@updateAdmin')->name('update-admin');


// Post Manager

Route::get('allmanager', 'AdminController@allManager')->name('allmanager');

Route::post('post-manager', 'AdminController@postManager')->name('post-manager');



// Post coordinator

Route::get('allcoordinator', 'AdminController@allCoordinator')->name('allcoordinator');

Route::post('post-coordinator', 'AdminController@postCoordinator')->name('post-coordinator');


// Post Students
Route::get('allstudent', 'AdminController@allStudent')->name('allstudent');
Route::get('add-student', 'AdminController@addStudent')->name('add-student');
Route::post('post-student', 'AdminController@postStudent')->name('post-student');
Route::get('edit-student/{id}', 'AdminController@editStudent')->name('edit-student');
Route::post('update-student/{id}', 'AdminController@updateStudent')->name('update-student');



// Post Faculty

Route::get('allfaculty', 'AdminController@allFaculty')->name('allfaculty');

Route::post('post-faculty', 'AdminController@postFaculty')->name('post-faculty');


// departments-area


Route::get('departments', 'AdminController@getDepartment')->name('departments');
Route::get('add-department', 'AdminController@addDepartment')->name('add-department');
Route::post('add-department', 'AdminController@postDepartment')->name('post-department');
Route::get('edit-department/{id}', 'AdminController@editDepartment')->name('edit-department');
Route::post('update-department/{id}', 'AdminController@updateDepartment')->name('update-department');



Route::get('articles', 'AdminController@getAdminArticles')->name('admin-articles');
Route::post('add-article', 'AdminController@postArticle')->name('post-article');
Route::get('edit-article/{id}', 'AdminController@editArticle')->name('edit-article');
Route::post('update-article/{id}', 'AdminController@updateArticle')->name('update-article');
Route::get('article/{id}', 'AdminController@getSingleArticle')->name('single-adminarticle');

Route::post('article/{id}', 'AdminController@postComment')->name('post-comment');

Route::get('delete-article/{id}', 'AdminController@deleteArticle')->name('delete-article');




/*
* Contribution Approval routes
*/


Route::post('approve-articles', 'AdminController@postApproveArticles')->name('approve-articles');
Route::get('approve-article/{id}', 'AdminController@getApproveArticle')->name('approve-article');







/*
* Reports routes
*/
Route::match(['get', 'post'], 'article-report', 'AdminController@getArticleReport')->name('article-report');

Route::get('percentage-of-articles', 'AdminController@getArticlePercentage')->name('percentage-of-articles');
Route::get('number-of-articles', 'AdminController@getArticleNumbers')->name('number-of-articles');



});



Route::group(['prefix' => 'student'], function() {


	Route::get('student-profile', 'StudentController@studentProfile')->name('student-profile');

// Route::get('change-pass', 'DashboardController@getPass')->name('change-pass');
Route::post('stdchange-pass', 'StudentController@stdpostPass')->name('stdpost-pass');
Route::post('stduser-edit', 'StudentController@stdupdateuserProfile')->name('update-stduser-profile');


Route::match(['get', 'post'], 'articles', 'StudentController@getArticle')->name('studentarticles');

Route::get('articles/{year}', 'StudentController@getArticlesByYear')->name('studentarticles-year');

Route::get('add-article', 'StudentController@addArticle')->name('add-studentarticle');
Route::post('add-article', 'StudentController@postArticle')->name('post-studentarticle');


Route::get('edit-article/{id}', 'StudentController@editArticle')->name('edit-studentarticle');
Route::post('edit-article/{id}', 'StudentController@updateArticle')->name('update-stdarticle');


Route::get('article/{id}', 'StudentController@getSingleArticle')->name('single-stdarticle');

Route::post('article/{id}', 'StudentController@postComment')->name('post-studentcomment');

Route::get('dashboard', 'StudentController@index')->name('student-dashboard');

});



Route::group(['prefix' => 'faculty'], function() {


Route::get('faculty-profile', 'FacultyController@facultyProfile')->name('faculty-profile');
Route::post('facuchange-pass', 'FacultyController@facupostPass')->name('facupost-pass');
Route::post('facuuser-edit', 'FacultyController@facuupdateuserProfile')->name('update-facuuser-profile');



// Route::match(['get', 'post'], 'articles', 'FacultyController@getArticle')->name('facu-articles');


Route::get('articles', 'FacultyController@getFacultyarticles')->name('facu-articles');




Route::get('article/{id}', 'FacultyController@getSingleArticle')->name('single-facuarticle');

Route::get('dashboard', 'FacultyController@index')->name('faculty-dashboard');



});


Route::group(['prefix' => 'coordinator'], function() {



Route::get('coordinator-profile', 'CoordinatorController@coordinatorProfile')->name('coordinator-profile');
Route::post('cordchange-pass', 'CoordinatorController@cordpostPass')->name('cordpost-pass');
Route::post('corduser-edit', 'CoordinatorController@cordupdateuserProfile')->name('update-corduser-profile');


// Route::match(['get', 'post'], 'articles', 'CoordinatorController@getArticle')->name('coordinatorarticles');

// Route::get('cord-articles', 'CoordinatorController@getCordarticle')->name('cord-articles');

Route::get('articles', 'CoordinatorController@getCordarticle')->name('cord-articles');


// Route::get('article/{id}', 'CoordinatorController@getSingleArticle')->name('single-coordinatorarticle');


Route::get('article/{id}', 'CoordinatorController@getSingleArticle')->name('single-cordarticle');

Route::post('article/{id}', 'CoordinatorController@postComment')->name('post-cord-comment');


Route::get('dashboard', 'CoordinatorController@index')->name('cord-dashboard');



/*
* Contribution Approval routes
*/

Route::post('approve-articles', 'CoordinatorController@postApproveArticles')->name('approve-cordarticles');
Route::get('approve-article/{id}', 'CoordinatorController@getApproveArticle')->name('approve-cordarticle');

});


Route::group(['prefix' => 'manager'], function() {


Route::get('manager-profile', 'ManagerController@managerProfile')->name('manager-profile');
Route::post('manachange-pass', 'ManagerController@manapostPass')->name('manapost-pass');
Route::post('manauser-edit', 'ManagerController@manaupdateuserProfile')->name('update-manauser-profile');


// Route::match(['get', 'post'], 'articles', 'ManagerController@getArticle')->name('managerarticles');


Route::get('articles', 'ManagerController@getManagerArticles')->name('manager-articles');


Route::get('article/{id}', 'ManagerController@getSingleArticle')->name('single-manaarticle');


Route::get('dashboard', 'ManagerController@index')->name('manager-dashboard');


});
