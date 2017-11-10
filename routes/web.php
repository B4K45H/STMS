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

//licence
Route::get('/licence', 'LoginController@licence')->name('licence');
Route::get('/under-construction', 'LoginController@underConstruction')->name('under-construction');

Route::group(['middleware' => 'is.guest'], function() {
    Route::get('/', 'LoginController@publicHome')->name('public-home');
    //user validity expired
    Route::get('/user/expired', 'LoginController@userExpired')->name('user-expired');

    Route::get('/login', 'LoginController@login')->name('login');
    Route::post('/login/action', 'LoginController@loginAction')->name('login-action');
});
Route::group(['middleware' => 'auth.check'], function () {
    //common routes
    Route::get('/dashboard', 'LoginController@dashboard')->name('dashboard');
    Route::get('/my/profile', 'UserController@profileView')->name('user-profile');
    Route::get('/lockscreen', 'LoginController@lockscreen')->name('lockscreen');
    Route::get('/logout', 'LoginController@logout')->name('logout-action');

    //superadmin routes
    Route::group(['middleware' => ['user.role:0,,']], function () {
        Route::get('/user/register', 'UserController@register')->name('user-register');
        Route::post('/user/register/action', 'UserController@registerAction')->name('user-register-action');
        Route::get('/user/list', 'UserController@userList')->name('user-list');
    });

    //admin routes
    Route::group(['middleware' => ['user.role:1,,']], function () {
        //subject
        Route::get('/subject/register', 'SubjectController@register')->name('subject-register');
        Route::post('/subject/register/action', 'SubjectController@registerAction')->name('subject-register-action');
        Route::get('/subject/list', 'SubjectController@list')->name('subject-list');

        //teacher
        Route::get('/teacher/register', 'TeacherController@register')->name('teacher-register');
        Route::post('/teacher/register/action', 'TeacherController@registerAction')->name('teacher-register-action');
        Route::get('/teacher/list', 'TeacherController@list')->name('teacher-list');

        //class
        Route::get('/class/register', 'ClassRoomController@register')->name('class-room-register');
        Route::post('/class/register/action', 'ClassRoomController@registerAction')->name('class-room-register-action');
        Route::get('/class/list', 'ClassRoomController@list')->name('class-room-list');

        //timetable
        Route::get('/timetable/teacher', 'TimetableController@teacherLevel')->name('timetable-teacher');
        Route::get('/timetable/student', 'TimetableController@studentLevel')->name('timetable-student');
    });
});